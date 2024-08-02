<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserActivity;
use App\Models\Atasan;
use App\Models\Kehadiran;
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
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $roles              = Role::all();
        $user               = User::with('detail')->find($id); 
        $userDetails        = UserDetail::all();
        $totalData          = $userDetails->count();      
        $atasans            = UserDetail::join('jabatan', 'users_detail.jabatan', '=', 'jabatan.name')
                            ->where('users_detail.jabatan', '!=', 'PPNPN')
                            ->orderBy('jabatan.id', 'asc')
                            ->select('users_detail.*', 'jabatan.name as jabatan_name')
                            ->get();

        // Menghitung jumlah data dengan posisi tertentu
        $hakimCount = $userDetails->where('posisi', 'HAKIM')->count();
        $pegawaiCount = $userDetails->where('posisi', 'PEGAWAI')->count();
        $cakimCount = $userDetails->where('posisi', 'CAKIM')->count();
        $cpnsCount = $userDetails->where('posisi', 'CPNS')->count();
        $ppnpnCount = $userDetails->where('posisi', 'PPNPN')->count();
        $magangCount = $userDetails->where('posisi', 'MAGANG')->count();

        $hakimCakimCount = $hakimCount + $cakimCount;
        $pegawaiCpnsCount = $pegawaiCount + $cpnsCount;
    
        // Menghitung persentase
        $hakimCakimPercentage = $totalData > 0 ? ($hakimCakimCount / $totalData) * 100 : 0;
        $pegawaiCpnsPercentage = $totalData > 0 ? ($pegawaiCpnsCount / $totalData) * 100 : 0;
        $ppnpnPercentage = $totalData > 0 ? ($ppnpnCount / $totalData) * 100 : 0;
        $magangPercentage = $totalData > 0 ? ($magangCount / $totalData) * 100 : 0;

        $data = [
            'title' => 'Pegawai',
            'subtitle' => 'Portal MS Lhokseumawe',
            'users'         => $user,
            'sidebar' => $accessMenus,
            'atasans' => $atasans,
            'roles' => $roles, 
            'totalData' => $totalData,        
            'hakimCount' => $hakimCount,
            'pegawaiCount' => $pegawaiCount,
            'cakimCount' => $cakimCount,
            'cpnsCount' => $cpnsCount,
            'ppnpnCount' => $ppnpnCount,
            'magangCount' => $magangCount,
            'hakimCakimPercentage' => $hakimCakimPercentage,
            'pegawaiCpnsPercentage' => $pegawaiCpnsPercentage,
            'ppnpnPercentage' => $ppnpnPercentage,
            'magangPercentage' => $magangPercentage,
            'hakimCakimCount' => $hakimCakimCount,
            'pegawaiCpnsCount' => $pegawaiCpnsCount,
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
    
    public function destroyPegawai(Request $request)
    {
        $id = $request->query('id');

        if ($id) {
            $pegawai = UserDetail::where('user_id', $id)->first();

            if ($pegawai) {
                $pegawaiName = $pegawai->name;

                // Hapus dari tabel UserDetail
                $pegawai->delete();

                // Hapus dari tabel User
                User::where('id', $id)->delete();

                // Hapus dari tabel WhatsappVerificationToken
                WhatsappVerificationToken::where('user_id', $id)->delete();

                // Hapus dari tabel EmailVerificationToken
                EmailVerificationToken::where('user_id', $id)->delete();

                // Hapus dari tabel UserActivity
                UserActivity::where('user_id', $id)->delete();

                return redirect()->back()->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Pegawai ' . $pegawaiName . ' berhasil dihapus'
                    ],
                ]);
            } else {
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Pegawai tidak ditemukan'
                    ],
                ]);
            }
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'ID pegawai tidak diberikan'
                ],
            ]);
        }
    }

    public function saveAtasan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'atasan_type' => 'required|in:atasan1,atasan2',
            'atasan_id' => 'required',
        ]);

        // Cek apakah user_id tidak sama dengan atasan_id
        if ($request->user_id == $request->atasan_id) {
            return response()->json(['message' => 'Pegawai Tidak Boleh Sama Dengan Atasan'], 422);
        }

        // Cek apakah entri untuk user_id sudah ada
        $atasan = Atasan::where('user_id', $request->user_id)->first();

        if ($atasan) {
            // Jika entri sudah ada, update kolom yang sesuai
            if ($request->atasan_type == 'atasan1') {
                $atasan->atasan_id = $request->atasan_id;
            } else {
                $atasan->atasan_dua_id = $request->atasan_id;
            }
            $atasan->save();
        } else {
            // Jika entri belum ada, buat entri baru
            $data = [
                'user_id' => $request->user_id,
                'atasan_id' => $request->atasan_type == 'atasan1' ? $request->atasan_id : null,
                'atasan_dua_id' => $request->atasan_type == 'atasan2' ? $request->atasan_id : null,
            ];
            Atasan::create($data);
        }

        // Ambil nama pengguna berdasarkan user_id
        $userName = UserDetail::find($request->user_id)->name;

        return response()->json(['message' => 'Atasan updated successfully', 'userName' => $userName]);
    }

    public function updateAwalKerja(Request $request)
    {
        $request->validate([
            'awal_kerja' => 'required|date',
        ]);

        $id = $request->session()->get('user_id');
        $userDetail = UserDetail::where('user_id', $id)->first();

        if ($userDetail) {
            $userDetail->awal_kerja = Carbon::parse($request->input('awal_kerja'));
            $userDetail->save();

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil Mengubah Tanggal Awal Kerja',
                    'message' => 'Tanggal awal bekerja berhasil diperbarui.',
                ],
            ]);
        }

        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal Mengubah Tanggal Awal Kerja',
                'message' => 'Gagal memperbarui tanggal awal bekerja.',
            ],
        ]);
    }

    //getData
        public function pegawaiGetData(Request $request)
        {
            if ($request->ajax()) {
                $today = Carbon::today()->toDateString();
                $data = UserDetail::select([
                    'users_detail.id', 'users_detail.user_id', 'users_detail.name', 
                    'users_detail.image', 'jabatan.name as jabatan', 'users_detail.nip', 
                    'users_detail.whatsapp', 'users_detail.posisi', 'users_detail.created_at', 
                    'atasans.atasan_id', 'atasans.atasan_dua_id', 'users.email'
                ])
                ->join('jabatan', 'users_detail.jabatan', '=', 'jabatan.name')
                ->leftJoin('atasans', 'users_detail.user_id', '=', 'atasans.user_id')
                ->leftJoin('users', 'users_detail.user_id', '=', 'users.id')
                ->orderBy('jabatan.id', 'asc')
                ->get();
        
                return Datatables::of($data)
                    ->addColumn('pegawai', function ($user) {
                        $userImage = $user->image ? asset('assets/img/avatars/' . $user->image) : asset('assets/img/avatars/default-image.jpg');
                        $userName = $user->name ?? 'Unknown User';
                        $userNip = $user->nip ?? 'Unknown NIP';
                        $userSince = Carbon::parse($user->created_at)->format('d F Y');
        
                        $output = '
                            <div class="d-flex align-items-center">
                                <img src="' . $userImage . '" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <span class="fw-bold">' . e($userName) . '</span>';
        
                        if ($userNip !== 'default_nip') {
                            $output .= '<small class="text-muted d-block">' . e($userNip) . '</small>';
                        }
        
                        $output .= '<small class="text-muted d-block">Since: ' . $userSince . '</small>
                                </div>
                            </div>';
        
                        return $output;
                    })
                    ->addColumn('atasan', function ($user) {
                        // Inisialisasi variabel nama atasan
                        $atasan1 = null;
                        $atasan2 = null;
                    
                        // Cek apakah atasan_id tidak sama dengan 10000
                        if ($user->atasan_id != 10000) {
                            $atasan1 = UserDetail::find($user->atasan_id)->name ?? null;
                        }
                    
                        // Cek apakah atasan_dua_id tidak sama dengan 10000
                        if ($user->atasan_dua_id != 10000) {
                            $atasan2 = UserDetail::find($user->atasan_dua_id)->name ?? null;
                        }
                    
                        $output = '';
                    
                        // Hanya tambahkan Atasan 1 jika valid
                        if ($atasan1 || $user->atasan_id != 10000) {
                            $output .= '<strong>Atasan 1:<br></strong> ';
                            if ($atasan1) {
                                $output .= e($atasan1) . ' | <i class="fa fa-edit" style="cursor:pointer;" onclick="showSelectAtasanModal(' . $user->user_id . ', \'atasan1\', \'' . e($user->name) . '\')"></i><br>';
                            } else {
                                // Tombol hanya ditampilkan jika atasan_id bukan 10000 dan tidak ada nama atasan
                                $output .= '<button type="button" class="btn btn-primary btn-sm" onclick="showSelectAtasanModal(' . $user->user_id . ', \'atasan1\', \'' . e($user->name) . '\')">Pilih Atasan</button><br><br>';
                            }
                        }
                    
                        // Hanya tambahkan Atasan 2 jika valid
                        if ($atasan2 || $user->atasan_dua_id != 10000) {
                            $output .= '<strong>Atasan 2:<br></strong> ';
                            if ($atasan2) {
                                $output .= e($atasan2) . ' | <i class="fa fa-edit" style="cursor:pointer;" onclick="showSelectAtasanModal(' . $user->user_id . ', \'atasan2\', \'' . e($user->name) . '\')"></i><br>';
                            } else {
                                // Tombol hanya ditampilkan jika atasan_dua_id bukan 10000 dan tidak ada nama atasan
                                $output .= '<button type="button" class="btn btn-primary btn-sm" onclick="showSelectAtasanModal(' . $user->user_id . ', \'atasan2\', \'' . e($user->name) . '\')">Pilih Atasan</button>';
                            }
                        }
                    
                        return $output;
                    })
                    
                    ->addColumn('kontak', function ($user) {
                        $whatsapp = $user->whatsapp ? e($user->whatsapp) : 'Tidak ada';
                        $email = $user->email ? e($user->email) : 'Tidak ada';
        
                        return '<strong>WA:</strong><br>' . $whatsapp . '<br><strong>Email:</strong><br> ' . $email;
                    })
                    ->addColumn('no', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('jabatan', function ($user) {
                        $jabatan = '<strong>' . e($user->jabatan) . '</strong>';
                        if (($user->jabatan) !== 'PPNPN') {
                            $jabatan .= '<br>(' . e($user->posisi) . ')';
                        }
                        return $jabatan;
                    })
                    ->addColumn('status', function ($user) use ($today) {
                        $kehadiran = Kehadiran::where('user_id', $user->user_id)
                            ->where('tgl_awal', '<=', $today)
                            ->where('tgl_akhir', '>=', $today)
                            ->first();
                        
                        if ($kehadiran) {
                            $status = '<span class="badge bg-danger">Tidak Hadir</span>';
                        } else {
                            $status = '<span class="badge bg-success">Hadir</span>';
                        }
        
                        $status .= ' | <i class="fa fa-edit" style="cursor:pointer;" onclick="showEditKehadiranModal(' . $user->user_id . ', \'' . e($user->name) . '\')"></i>';
        
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $deleteUrl = route('pegawai.destroy', ['id' => $row->user_id]);
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                        $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="showDeleteConfirmation(\'' . $deleteUrl . '\', \'Apakah Anda yakin ingin menghapus item ini?\')"><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['pegawai', 'atasan', 'action', 'kontak', 'jabatan', 'status'])
                    ->make(true);
            }
        }
    //!getData
    
}
