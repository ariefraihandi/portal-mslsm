<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Role;
use App\Models\EmailVerificationToken;
use App\Models\WhatsappVerificationToken;
use App\Mail\VerifyEmail;
use Exception;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login Portal',
            'subtitle' => 'MS Lhokseumawe',
            'meta_description' => 'Login to access the MS Lhokseumawe Portal.',
            'meta_keywords' => 'login, portal, MS Lhokseumawe'
        ];

        return view('Auth.login', $data);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email-username', 'password');
    
        // Cek apakah input adalah email atau username
        $loginField = filter_var($credentials['email-username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Buat array untuk kredensial berdasarkan input pengguna
        $credentialsToAttempt = [
            $loginField => $credentials['email-username'],
            'password' => $credentials['password']
        ];
    
        // Coba melakukan autentikasi
        if (Auth::attempt($credentialsToAttempt)) {
            // Periksa apakah akun pengguna telah diverifikasi melalui email
            $user = User::where($loginField, $credentials['email-username'])->first();
    
            if ($user && (!$user->email_verified_at || !$user->whatsapp_verified_at)) {
                // Buat pesan kesalahan berdasarkan kondisi yang belum diverifikasi
                $errorMessage = '';
                if (!$user->email_verified_at) {
                    $errorMessage .= 'Email belum diverifikasi. ';
                }
                if (!$user->whatsapp_verified_at) {
                    $errorMessage .= 'WhatsApp belum diverifikasi.';
                }
            
                $response = [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => trim($errorMessage),
                ];
                return redirect()->back()->with('response', $response);
            }
            
            
            // Ambil URL tujuan dari sesi atau default ke halaman profil
            $intendedUrl = Session::get('url.intended', route('user.account.detil'));
            
            // Bersihkan URL tujuan dari sesi
            Session::forget('url.intended');
    
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Anda berhasil login.',
            ];
            
            // Redirect ke URL yang disimpan di sesi atau ke halaman profil
            return redirect()->intended($intendedUrl)->with('response', $response);
        }
    
        // Autentikasi gagal, buat pesan kesalahan
        $errorMessage = 'Username/Email dan Password Salah';
    
        // Buat respons untuk SweetAlert
        $response = [
            'success' => false,
            'title' => 'Gagal',
            'message' => $errorMessage,
        ];
    
        // Kembalikan respons ke halaman login
        return redirect()->back()->with('response', $response);
    }

    public function showRegisterForm()
    {
        $data = [
            'title' => 'Register Portal',
            'subtitle' => 'Portal MS Lhokseumawe',
            'meta_description' => 'Register to access the MS Lhokseumawe Portal.',
            'meta_keywords' => 'Register, portal, MS Lhokseumawe'
        ];

        return view('Auth.register', $data);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        $blockedUsernames = ['slamet', 'slametriyadi'];
        $blockedEmails = ['slamet.riyadi7408@gmail.com'];
        $blockedWhatsapps = ['81286727408', '081286727408', '6281286727408'];

        // Cek apakah input terdapat dalam daftar yang diblokir
        if (in_array($request->input('username'), $blockedUsernames) || 
            in_array($request->input('email'), $blockedEmails) || 
            in_array($request->input('whatsapp'), $blockedWhatsapps)) {
            return redirect()->back(); // Redirect tanpa pesan apa-apa
        }

        try {
            // Start transaction
            DB::beginTransaction();
         

            // Create user
            $user = new User();
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->whatsapp = $request->input('whatsapp', 'default_whatsapp'); // default value
            $user->role = 1;
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Create user detail
            $userDetail = new UserDetail();
            $userDetail->user_id = $user->id;
            $userDetail->name = 'nama lengkap';
            // Add default values or from form
            $userDetail->jabatan = $request->input('jabatan', 'default_jabatan');
            $userDetail->nip = $request->input('nip', 'default_nip');
            $userDetail->whatsapp = $request->input('whatsapp', 'default_whatsapp');
            $userDetail->tlahir = $request->input('tlahir', 'default_tlahir');
            $userDetail->tglahir = $request->input('tglahir', 'default_value');
            $userDetail->kelamin = $request->input('kelamin', 'L');
            $userDetail->alamat = $request->input('alamat', 'default_alamat');
            $userDetail->instansi = $request->input('instansi', "Mahkamah Suar'iyah Lhokseumawe");
            $userDetail->iguser = $request->input('iguser', 'default_iguser');
            $userDetail->fbuser = $request->input('fbuser', 'default_fbuser');
            $userDetail->twuser = $request->input('twuser', 'default_twuser');
            $userDetail->ttuser = $request->input('ttuser', 'default_ttuser');
            $userDetail->lastmodified = now();
            $userDetail->posisi = $request->input('posisi', 'default_posisi');
            $userDetail->key = $request->input('key', 'default_key');
            $userDetail->save();

            // Generate email verification token
            $emailToken = Str::random(64);
            EmailVerificationToken::create([
                'user_id' => $user->id,
                'token' => $emailToken,
                'email' => $user->email,
                'expires_at' => now()->addHours(24),
            ]);

            // Generate WhatsApp verification token
            $whatsappToken = Str::random(64);
            WhatsappVerificationToken::create([
                'user_id' => $user->id,
                'token' => $whatsappToken,
                'whatsapp' => $user->whatsapp,
                'expires_at' => now()->addHours(24),
            ]);

            // Commit transaction
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
            
                // Rollback transaction
                DB::rollBack();
            
                // Tampilkan pesan error yang lebih spesifik
                $errorMessage = 'Email verification failed: ' . $e->getMessage();
                return back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Email Verification Failed',
                        'message' => $errorMessage,
                    ],
                ]);
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

            return redirect()->route('login.view')->with([
                'response' => [
                    'success' => $emailSuccess && $whatsappSuccess,
                    'title' => $emailSuccess && $whatsappSuccess ? 'Success' : 'Error',
                    'message' => $message,
                ],
            ]);

        } catch (Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // Log error
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

    public function verifyEmail(Request $request)
    {
        try {
            $uniqueId = $request->query('token');
            $decodedParams = base64_decode($uniqueId);
    
            // Mendekode string menjadi array asosiatif
            parse_str($decodedParams, $params);
    
            // Mendapatkan email dan token dari array
            $email = $params['email'] ?? null;
            $token = $params['token'] ?? null;

            // dd($decodedParams, $params);
    
            if (!$email || !$token) {
                throw new Exception('Token verifikasi email tidak valid.');
            }
    
            // Menggunakan transaksi untuk mengelola pengecualian secara keseluruhan
            DB::beginTransaction();
    
            // Mengambil token verifikasi
            $verificationToken = EmailVerificationToken::where('email', $email)
                ->where('token', $token)
                ->first();
    
            // Jika token tidak ditemukan atau sudah kadaluarsa
            if (!$verificationToken || $verificationToken->expires_at < now()) {
                throw new Exception('Token verifikasi email tidak valid atau sudah kadaluarsa.');
            }
    
            // Ubah status verifikasi email pada user
            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new Exception('User tidak ditemukan.');
            }
            $user->email_verified_at = now(); // Isi dengan waktu verifikasi email
            $user->save();
    
            // Hapus token verifikasi dari database
            EmailVerificationToken::where('email', $email)->delete();
    
            // Commit transaksi jika tidak ada pengecualian
            DB::commit();
    
            // Set response untuk pesan sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Akun anda berhasil terverifikasi. Silakan login.',
            ];
    
            // Redirect pengguna ke halaman login dengan pesan sukses
            return redirect()->route('login.view')->with('response', $response);
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollBack();
    
            // Set response untuk pesan kesalahan
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $e->getMessage(),
            ];
    
            // Redirect pengguna ke halaman login dengan pesan kesalahan
            return redirect()->route('login.view')->with('response', $response);
        }
    }
    

    public function verifyWhatsapp(Request $request)
    {
        try {
            $uniqueId = $request->query('verify');
            $decodedParams = base64_decode($uniqueId);

            // Mendekode string menjadi array asosiatif
            parse_str($decodedParams, $params);

            // Mendapatkan whatsapp dan token dari array
            $whatsapp = $params['whatsapp'];
            $token = $params['token'];

            // Menggunakan transaksi untuk mengelola pengecualian secara keseluruhan
            DB::beginTransaction();

            // Mengambil token verifikasi
            $verificationToken = WhatsappVerificationToken::where('whatsapp', $whatsapp)
                ->where('token', $token)
                ->first();

            // Jika token tidak ditemukan atau sudah kadaluarsa
            if (!$verificationToken || $verificationToken->expires_at < now()) {
                throw new Exception('Token verifikasi WhatsApp tidak valid atau sudah kadaluarsa.');
            }

            // Ubah status verifikasi WhatsApp pada user
            $user = User::where('whatsapp', $whatsapp)->first();
            if (!$user) {
                throw new Exception('User tidak ditemukan.');
            }
            $user->whatsapp_verified_at = now(); // Isi dengan waktu verifikasi WhatsApp
            $user->save();

            // Hapus token verifikasi dari database
            WhatsappVerificationToken::where('whatsapp', $whatsapp)->delete();

            // Commit transaksi jika tidak ada pengecualian
            DB::commit();

            // Set response untuk pesan sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'WhatsApp anda berhasil Terverifikasi. Silahkan Login',
            ];

            // Redirect pengguna ke halaman login dengan pesan sukses
            return redirect()->route('login.view')->with('response', $response);
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollBack();

            // Set response untuk pesan kesalahan
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $e->getMessage(),
            ];

            // Redirect pengguna ke halaman login dengan pesan kesalahan
            return redirect()->route('login.view')->with('response', $response);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth');
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
}
