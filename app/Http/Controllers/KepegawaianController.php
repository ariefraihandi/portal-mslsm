<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserActivity;
use App\Models\WhatsappVerificationToken;
use App\Models\EmailVerificationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use Exception;
use DataTables;
use Carbon\Carbon;

class KepegawaianController extends Controller
{
    public function showPegawaiList(Request $request)
    {
        $accessMenus = $request->get('accessMenus');
        $id = $request->session()->get('user_id');
        $roles = Role::all();

        $data = [
            'title' => 'Pegawai',
            'subtitle' => 'Portal MS Lhokseumawe',
            'sidebar' => $accessMenus,
            'roles' => $roles, 
          
        ];

        return view('Kepegawaian.pegawaiList', $data);
    }

    public function pegawaiAdd(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'nullable|string|max:255',
            'jabatan' => 'required|string',
            'nip' => 'required|string|max:255',
            'tlahir' => 'required|string|max:255',
            'tglahir' => 'required|date',
            'kelamin' => 'required|string|in:L,P',
            'alamat' => 'required|string',
            'instansi' => 'required|string',
            'posisi' => 'required|string',
            'role' => 'required|integer|exists:roles,id',
        ]);

        $blockedUsernames = ['slamet', 'slametriyadi'];
        $blockedEmails = ['slamet.riyadi7408@gmail.com'];
        $blockedWhatsapps = ['81286727408', '081286727408', '6281286727408'];

        if (in_array($request->input('username'), $blockedUsernames) || 
            in_array($request->input('email'), $blockedEmails) || 
            in_array($request->input('whatsapp'), $blockedWhatsapps)) {
            return redirect()->back(); 
        }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->whatsapp = $request->input('whatsapp', 'default_whatsapp');
            $user->role = $request->input('role');
            $user->password = Hash::make('123456'); // Hash manual untuk password "123456"
            $user->save(); // Simpan user terlebih dahulu

            $userDetail = new UserDetail();
            $userDetail->user_id = $user->id;
            $userDetail->name = $request->input('nama_lengkap');
            $userDetail->jabatan = $request->input('jabatan');
            $userDetail->image = 'default.jpeg';
            $userDetail->nip = $request->input('nip');
            $userDetail->whatsapp = $request->input('whatsapp', 'default_whatsapp');
            $userDetail->tlahir = $request->input('tlahir');
            $userDetail->tglahir = $request->input('tglahir');
            $userDetail->kelamin = $request->input('kelamin');
            $userDetail->alamat = $request->input('alamat');
            $userDetail->instansi = $request->input('instansi');
            $userDetail->posisi = $request->input('posisi');
            $userDetail->lastmodified = now();
            $userDetail->save();

            $emailToken = Str::random(64);
            $emailVerificationToken = new EmailVerificationToken([
                'user_id' => $user->id,
                'token' => $emailToken,
                'email' => $user->email,
                'expires_at' => now()->addHours(24),
            ]);
            $emailVerificationToken->save();

            $whatsappToken = Str::random(64);
            $whatsappVerificationToken = new WhatsappVerificationToken([
                'user_id' => $user->id,
                'token' => $whatsappToken,
                'whatsapp' => $user->whatsapp,
                'expires_at' => now()->addHours(24),
            ]);
            $whatsappVerificationToken->save();

            $userActivity = new UserActivity([
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'activity' => 'Penambahan Pegawai',
                'description' => 'Pegawai ' . $request->input('nama_lengkap') . ' ditambahkan',
                'device_info' => $request->header('User-Agent'),
            ]);
            $userActivity->save();

            DB::commit();

            // Send email verification notification
            $emailSuccess = false;
            $whatsappSuccess = false;

            try {
                $email = $request->input('email');
                $name = $request->input('username');
                $encryptedParams = base64_encode("email=$email&token=$emailToken");
                $url = route('email.verify', ['token' => $encryptedParams]);
          
                Mail::to($email)->send(new VerifyEmail($name, $url));
                $emailSuccess = true;
            } catch (Exception $e) {
                // Tangani kesalahan jika gagal mengirim email
                $emailSuccess = false;
                Log::error('Email verification failed: ' . $e->getMessage());
            }
            
            // Send WhatsApp verification notification using curl
            try {
                $whatsappSuccess = $this->sendWhatsAppNotification($user->whatsapp, $user->username, $whatsappToken);
            } catch (Exception $e) {
                // Log WhatsApp sending failure
                Log::error('WhatsApp verification notification failed: ' . $e->getMessage());
            }

            // Prepare response message
            $message = 'Verification messages sent successfully to email and WhatsApp.';
            if ($emailSuccess && !$whatsappSuccess) {
                $message = 'Verification message sent to email, but failed to send to WhatsApp.';
            } elseif (!$emailSuccess && $whatsappSuccess) {
                $message = 'Verification message sent to WhatsApp, but failed to send to email.';
            } elseif (!$emailSuccess && !$whatsappSuccess) {
                $message = 'Failed to send verification messages to both email and WhatsApp.';
            }

            return redirect()->back()->with([
                'response' => [
                    'success' => $emailSuccess && $whatsappSuccess,
                    'title' => $emailSuccess && $whatsappSuccess ? 'Success' : 'Error',
                    'message' => $message,
                ],
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Registration failed: ' . $e->getMessage());
            return back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Registration Failed',
                    'message' => $e->getMessage(),
                ],
            ]);
        }
    }

    private function sendWhatsAppNotification($number, $name, $token)
    {
        $device_id = env('DEVICE_ID', 'somedefaultvalue');
        $url = route('whatsapp.verify'); // replace with your actual route
        $encryptedParams = base64_encode("whatsapp=$number&token=$token");
        $verificationUrl = $url . '?verify=' . $encryptedParams;
        $message = "Halo {$name},\n\nSilahkan verifikasi akun portal anda menggunakan tautan berikut:\n\n" . $verificationUrl;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.whacenter.com/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'device_id' => $device_id,
                'number' => $number,
                'message' => $message,
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception($error_msg);
        }

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_status !== 200) {
            throw new Exception("Failed to send WhatsApp message");
        }

        $response_data = json_decode($response, true);

        if (isset($response_data['status']) && $response_data['status'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public function pegawaiGetData(Request $request)
    {
        if ($request->ajax()) {
            $data = UserDetail::select(['id', 'name', 'image', 'jabatan', 'nip', 'whatsapp', 'posisi', 'created_at']);
            return Datatables::of($data)
                ->addColumn('pegawai', function ($user) {
                    $userImage = $user->image ? asset('assets/img/avatars/' . $user->image) : asset('assets/img/avatars/default-image.jpg');
                    $userName = $user->name ?? 'Unknown User';
                    $userNip = $user->nip ?? 'Unknown NIP';
                    $userSince = Carbon::parse($user->created_at)->format('d F Y');
                
                    // Format output
                    $output = '
                        <div class="d-flex align-items-center">
                            <img src="' . $userImage . '" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <span class="fw-bold">' . e($userName) . '</span>
                                <small class="text-muted d-block">' . e($userNip) . '</small>
                                <small class="text-muted d-block">Since: ' . $userSince . '</small>
                            </div>
                        </div>';
                
                    return $output;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                
                ->rawColumns(['pegawai', 'action'])
                ->make(true);
        }
    }
}