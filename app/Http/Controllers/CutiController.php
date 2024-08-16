<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CutiSisa;
use App\Models\CutiDetail;
use App\Models\UserDetail;
use App\Jobs\SendCutiNotifications;
use App\Models\UserDevice;
use App\Models\User;
use App\Models\Role;
use App\Models\Kehadiran;
use App\Models\Cuti;
use App\Models\Notification;
use App\Models\Sign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;
use DataTables;
use OneSignal;
use PDF;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;

class CutiController extends Controller
{    
    public function generateQrCodeWithLogo()
    {
        {
            return QrCode::generate(
                'Hello, World!',
            );
        }
    }

    public function showCutiSisa(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 

        $data = [
            'title'         => 'Sisa Cuti Pegawai',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];

        return view('Kepegawaian.cutiSisa', $data);
    }
  
    public function showCutiPermohonan(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 

        $data = [
            'title'         => 'Permohonan Cuti Pegawai',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];

        return view('Kepegawaian.permohonanCuti', $data);
    }

    public function showCutiDetailAtasanLangsung(Request $request)
    {  
        $message_id = $request->query('message_id');
        $type = $request->query('type');
        $cuti_id = $request->query('cuti_id');

        
        $id = $request->session()->get('user_id');
        $user = User::with('detail')->find($id); 

        $notification = null;
        $cutiDetail = null;

        // Jika message_id tersedia, ambil Notification berdasarkan message_id
        if ($message_id) {
            $notification = Notification::where('message_id', $message_id)->first();

            // Jika notification ditemukan, cek tipe dan perbarui is_read sesuai tipe
            if ($notification) {
                if ($type === 'whatsapp') {
                    $notification->is_read_wa = true;
                } elseif ($type === 'email') {
                    $notification->is_read_email = true;
                } elseif ($type === 'onesignal') {
                    $notification->is_read_onesignal = true;
                }

                $notification->save();

                // Ambil cuti_id dari data notifikasi jika ada
                $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                $cuti_id = $notificationData['cuti_id'] ?? $cuti_id; // gunakan cuti_id dari data jika ada
            }
        }

        // Jika cuti_id tersedia, ambil CutiDetail berdasarkan cuti_id
        if ($cuti_id) {
            $cutiDetail = CutiDetail::with(['cuti', 'atasan', 'atasanDua', 'userDetails'])->where('id', $cuti_id)->first();
        }
        $userName = $cutiDetail->userDetails->name;        

        $data = [
            'title'         => 'Detail Cuti Pegawai:',          
            'subtitle'      => 'Portal MS Lhokseumawe',            
            'users'         => $user,
            'userName'      => $userName,
            'cutiDetail'    => $cutiDetail,
            'message_id'    => $message_id,
            'type'          => $type,
            'notification'  => $notification
        ];
        
        // Mengirim data ke view 'Kepegawaian.detailCuti'
        return view('LandingPage.Kepegawaian.detailCutiForAtasan', $data);
    }
   
    public function showCutiDetailpejabat(Request $request)
    {  
        $message_id = $request->query('message_id');
        $type = $request->query('type');
        $cuti_id = $request->query('cuti_id');

        
        $id = $request->session()->get('user_id');
        $user = User::with('detail')->find($id); 

        $notification = null;
        $cutiDetail = null;

        // Jika message_id tersedia, ambil Notification berdasarkan message_id
        if ($message_id) {
            $notification = Notification::where('message_id', $message_id)->first();

            // Jika notification ditemukan, cek tipe dan perbarui is_read sesuai tipe
            if ($notification) {
                if ($type === 'whatsapp') {
                    $notification->is_read_wa = true;
                } elseif ($type === 'email') {
                    $notification->is_read_email = true;
                } elseif ($type === 'onesignal') {
                    $notification->is_read_onesignal = true;
                }

                $notification->save();

                // Ambil cuti_id dari data notifikasi jika ada
                $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                $cuti_id = $notificationData['cuti_id'] ?? $cuti_id; // gunakan cuti_id dari data jika ada
            }
        }

        // Jika cuti_id tersedia, ambil CutiDetail berdasarkan cuti_id
        if ($cuti_id) {
            $cutiDetail = CutiDetail::with(['cuti', 'atasan', 'atasanDua', 'userDetails'])->where('id', $cuti_id)->first();
        }
        $userName = $cutiDetail->userDetails->name;        

        $data = [
            'title'         => 'Detail Cuti Pegawai:',          
            'subtitle'      => 'Portal MS Lhokseumawe',            
            'users'         => $user,
            'userName'      => $userName,
            'cutiDetail'    => $cutiDetail,
            'message_id'    => $message_id,
            'type'          => $type,
            'notification'  => $notification
        ];
        
        // Mengirim data ke view 'Kepegawaian.detailCuti'
        return view('LandingPage.Kepegawaian.detailCutiForAtasan', $data);
    }
    
    public function showCutiDetailPenomoran(Request $request)
    {
        
        $message_id = $request->query('message_id');
        $type = $request->query('type');
        $cuti_id = $request->query('cuti_id');

        
        $id = $request->session()->get('user_id');
        $user = User::with('detail')->find($id); 

        $notification = null;
        $cutiDetail = null;

        // Jika message_id tersedia, ambil Notification berdasarkan message_id
        if ($message_id) {
            $notification = Notification::where('message_id', $message_id)->first();

            // Jika notification ditemukan, cek tipe dan perbarui is_read sesuai tipe
            if ($notification) {
                if ($type === 'whatsapp') {
                    $notification->is_read_wa = true;
                } elseif ($type === 'email') {
                    $notification->is_read_email = true;
                } elseif ($type === 'onesignal') {
                    $notification->is_read_onesignal = true;
                }

                $notification->save();

                // Ambil cuti_id dari data notifikasi jika ada
                $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                $cuti_id = $notificationData['cuti_id'] ?? $cuti_id; // gunakan cuti_id dari data jika ada
            }
        }

        // Jika cuti_id tersedia, ambil CutiDetail berdasarkan cuti_id
        if ($cuti_id) {
            $cutiDetail = CutiDetail::with(['cuti', 'atasan', 'atasanDua', 'userDetails'])->where('id', $cuti_id)->first();
        }
        $userName = $cutiDetail->userDetails->name;        

        $data = [
            'title'         => 'Detail Cuti Pegawai:',          
            'subtitle'      => 'Portal MS Lhokseumawe',            
            'users'         => $user,
            'userName'      => $userName,
            'cutiDetail'    => $cutiDetail,
            'message_id'    => $message_id,
            'type'          => $type,
            'notification'  => $notification
        ];
        
        // Mengirim data ke view 'Kepegawaian.detailCuti'
        return view('LandingPage.Kepegawaian.detailCutiForPenomoran', $data);
    }

    public function submitCutiTahunan(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi permintaan
            $request->validate([
                'id_pegawai' => 'required|exists:users_detail,user_id',
                'code' => 'required|string|max:255',
                'alcut' => 'required|string',
                'ataslang' => 'required|exists:users,id',
                'id_pimpinan' => 'required|exists:users,id',
                'tglawal' => 'required|date',
                'tglakhir' => 'required|date',
                'alamat' => 'required|string|max:255',
            ]);

            // Ambil data pegawai dari model UserDetail berdasarkan id_pegawai
            $pegawai        = UserDetail::where('user_id', $request->id_pegawai)->first();
            $sisaCuti       = CutiSisa::where('user_id', $request->id_pegawai)->first();
            // dd($sisaCuti);

            if (!$pegawai) {
                throw new \Exception("Data pegawai tidak ditemukan.");
            }

            $signMessage = "Saya yang bernama, " . $pegawai->name . " dengan ini menyatakan telah menandatangani permohonan cuti ini menggunakan metode tanda tangan elektronik.";

            // Simpan data tanda tangan
            $sign = Sign::create([
                'user_id' => $request->id_pegawai,
                'message' => $signMessage,
            ]);

            // Simpan data cuti dengan ID sign yang baru saja dibuat
            $cuti = CutiDetail::create([
                'user_id' => $request->id_pegawai,
                'atasan_id' => $request->ataslang,
                'atasan_dua_id' => $request->id_pimpinan,
                'jenis' => $request->code,
                'alasan' => $request->alcut,
                'tglawal' => $request->tglawal,
                'tglakhir' => $request->tglakhir,
                'alamat' => $request->alamat,
                'status' => '1', 
                'cuti_n' => $sisaCuti->cuti_n, 
                'cuti_nsatu' => $sisaCuti->cuti_nsatu, 
                'cuti_ndua' => $sisaCuti->cuti_ndua, 
                'id_sign' => $sign->id,
            ]);

            // Ambil data atasan dan pegawai dari model User dan UserDetail
            $atasan = User::with('detail', 'devices')->find($cuti->atasan_id);
            $user = User::with('detail', 'devices')->find($cuti->user_id);

            if (!$atasan || !$user) {
                throw new \Exception("Data atasan atau pegawai tidak ditemukan.");
            }

            // Generate UUID untuk notifikasi
            $messageIdAtasan = (string) Str::uuid();
            $messageIdPegawai = (string) Str::uuid();

            // Target URL untuk OneSignal dan WhatsApp
            $urlOneSignalAtasan = route('kepegawaian.cuti.atasan') . "?";
            $urlOneSignalPegawai = route('user.account.cuti') . "?";           

            // Pesan untuk atasan dan pegawai
            $messageAtasan = "Assalamu'alaikum Bapak/Ibu {$atasan->detail->name},\n\n" .
                            "Permohonan cuti atas nama *{$pegawai->name}* telah diajukan.\n\n" .
                            "Jenis Cuti: {$cuti->jenis}\n" .
                            "Dari: *{$cuti->tglawal}*\n" .
                            "Sampai: *{$cuti->tglakhir}*\n" .
                            "Alasan: {$cuti->alasan}\n\n";

            $messagePegawai = "Assalamu'alaikum {$pegawai->name},\n\n" .
                            "Permohonan cuti Anda telah berhasil diajukan.\n\n" .
                            "Jenis Cuti: {$cuti->jenis}\n" .
                            "Dari: *{$cuti->tglawal}*\n" .
                            "Sampai: *{$cuti->tglakhir}*\n" .
                            "Alasan: {$cuti->alasan}\n\n";

            // Simpan notifikasi untuk atasan
            $notificationAtasan = Notification::create([
                'message_id' => $messageIdAtasan,
                'user_id' => $cuti->atasan_id,
                'message' => $messageAtasan,
                'type' => $cuti->jenis,
                'data' => [
                    'cuti_id' => $cuti->id,
                    'user_id' => $cuti->user_id,
                    'atasan_id' => $cuti->atasan_id,
                ],
                'whatsapp' => $atasan->detail->whatsapp,
                'is_sent_wa' => false,
                'eror_wa' => '',
                'onesignal' => $atasan->devices->pluck('device_token')->first(),
                'eror_onesignal' => '',
                'email' => $atasan->email,
                'is_sent_email' => false,
                'eror_email' => '',
                'priority' => 'High',
                'created_by' => $cuti->user_id,
                'target_url' => $urlOneSignalAtasan,
            ]);

            // Simpan notifikasi untuk pegawai
            $notificationPegawai = Notification::create([
                'message_id' => $messageIdPegawai,
                'user_id' => $cuti->user_id,
                'message' => $messagePegawai,
                'type' => $cuti->jenis,
                'data' => [
                    'cuti_id' => $cuti->id,
                    'user_id' => $cuti->user_id,
                    'atasan_id' => $cuti->atasan_id,
                ],
                'whatsapp' => $user->detail->whatsapp,
                'is_sent_wa' => false,
                'eror_wa' => '',
                'onesignal' => $user->devices->pluck('device_token')->first(),
                'eror_onesignal' => '',
                'email' => $user->email,
                'is_sent_email' => false,
                'eror_email' => '',
                'priority' => 'low',
                'created_by' => $cuti->user_id,
                'target_url' => $urlOneSignalPegawai,
            ]);

            DB::commit();

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Cuti berhasil diajukan.',
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika terjadi error

            // Redirect ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
            ]);
        }
    }
  
    
    //Action Cuti
        public function cutiApprove(Request $request)
        {
            DB::beginTransaction();
        
            try {
                // Validasi data dari request
                $validatedData  = $request->validate([
                    'name'      => 'required|string|max:255',
                    'jenisCuti' => 'required|string|max:255',
                    'tglAwal'   => 'required|date',
                    'tglAkhir'  => 'required|date',
                    'alasan'    => 'required|string|max:255',
                    'id'        => 'required'
                ]);
        
                $tglAwal        = $validatedData['tglAwal'];
                $tglAkhir       = $validatedData['tglAkhir'];
        
                $jumlahHariCuti = $this->hitungHariCuti($tglAwal, $tglAkhir);
                $cutiDetail     = CutiDetail::find($validatedData['id']);
                
                if (!$cutiDetail) {
                    return response()->json(['error' => 'Data not found'], 404);
                }
        
                // Mengambil data user yang mengajukan cuti dan atasannya
                $user = User::with(['detail', 'devices'])->find($cutiDetail->user_id);
                $atasan = User::with(['detail', 'devices'])->find($cutiDetail->atasan_id);
                $atasanDua = User::with(['detail', 'devices'])->find($cutiDetail->atasan_dua_id);
        
                if (!$user || !$atasan) {
                    return response()->json(['error' => 'User or Atasan not found'], 404);
                }
                    
                if ($cutiDetail->atasan_id == $cutiDetail->atasan_dua_id) {
                    if ($cutiDetail->status == 1){
                        $cutiDetail->status = 9;
                        $cutiDetail->save();

                     // Tanda tangan untuk atasan pertama
                        $signMessageAtasan = "Surat Permohonan Cuti Atas Nama " . $user->detail->name . " Telah Disetujui Oleh Atasan Pertama.";
                        $signAtasan = Sign::create([
                            'user_id' => $atasan->id,
                            'message' => $signMessageAtasan,
                        ]);

                        // Tanda tangan untuk atasan kedua
                        $signMessageAtasanDua = "Surat Permohonan Cuti Atas Nama " . $user->detail->name . " Telah Disetujui Oleh Pejabat Yang Berwenang Memberikan Cuti.";
                        $signAtasanDua = Sign::create([
                            'user_id' => $atasanDua->id,
                            'message' => $signMessageAtasanDua,
                        ]);

                        // Menyimpan ID tanda tangan pada cutiDetail
                        $cutiDetail->id_sign_atasan = $signAtasan->id;
                        $cutiDetail->id_sign_atasan_dua = $signAtasanDua->id;
                        $cutiDetail->save();

                        // Sisa Cuti Update
                            $sisaCuti = CutiSisa::where('user_id', $user->id)->first();
                                    
                            $remainingLeave = $jumlahHariCuti;
                
                            if ($sisaCuti->cuti_ndua >= $remainingLeave) {
                                $sisaCuti->cuti_ndua -= $remainingLeave;
                            } else {
                                $remainingLeave -= $sisaCuti->cuti_ndua;
                                $sisaCuti->cuti_ndua = 0;
                
                                if ($sisaCuti->cuti_nsatu >= $remainingLeave) {
                                    $sisaCuti->cuti_nsatu -= $remainingLeave;
                                } else {
                                    $remainingLeave -= $sisaCuti->cuti_nsatu;
                                    $sisaCuti->cuti_nsatu = 0;
                
                                    if ($sisaCuti->cuti_n >= $remainingLeave) {
                                        $sisaCuti->cuti_n -= $remainingLeave;
                                    } else {
                                        return response()->json(['error' => 'Insufficient leave balance'], 400);
                                    }
                                }
                            }
                
                            $sisaCuti->save();
                        //! Sisa Cuti Update

                        $sapaanUser = $user->detail->kelamin == 'P' ? 'Ibu' : 'Bapak';
                        $messageIdPegawai = (string) Str::uuid();
                        $urlOneSignalPegawai = route('user.account.cuti') . "?";
                        
                        $pesanUser = "Assalamualaikum $sapaanUser " . $user->detail->name . ",\n\n";
                        $pesanUser .= "Status: Cuti Anda sudah disetujui oleh atasan, menunggu penomoran surat.";
            
                        Notification::create([
                            'message_id' => $messageIdPegawai,
                            'user_id' => $user->id,
                            'message' => $pesanUser,
                            'type' => $cutiDetail->jenis,
                            'data' => [
                                'cuti_id' => $cutiDetail->id,
                                'user_id' => $cutiDetail->user_id,
                                'atasan_id' => $cutiDetail->atasan_id,
                            ],
                            'whatsapp' => $user->detail->whatsapp,
                            'is_sent_wa' => false,
                            'eror_wa' => '',
                            'onesignal' => optional($user->devices)->pluck('device_token')->first(),
                            'eror_onesignal' => '',
                            'email' => $user->email,
                            'is_sent_email' => false,
                            'eror_email' => '',
                            'priority' => 'low',
                            'created_by' => $cutiDetail->user_id,
                            'target_url' => $urlOneSignalPegawai,
                        ]);

                        Kehadiran::create([
                            'user_id'    => $user->id,
                            'tgl_awal'   => $cutiDetail->tglawal,
                            'tgl_akhir'  => $cutiDetail->tglakhir,
                            'jenis'      => $cutiDetail->jenis,
                            'keterangan' => $cutiDetail->alasan,
                        ]);

                        $usersWithAdminRole = User::admin()->with(['detail', 'devices'])->get();
            
                        foreach ($usersWithAdminRole as $adminUser) {
                            $sapaanAdmin = $adminUser->detail->kelamin == 'P' ? 'Ibu' : 'Bapak';
                            $pesan = "Assalamualaikum $sapaanAdmin *" . $adminUser->detail->name . "*\n\n";
                            $pesan .= "Cuti Atas Nama *" . $user->detail->name . "* Menunggu Penomoran Surat.\n\n";
                    
                            $messageIdAdministrator = (string) Str::uuid();
                            $urlOneSignaladministrasi = route('kepegawaian.cuti.penomoran') . "?";
                            $email = User::find($adminUser->id)->email ?? '';
                    
                            Notification::create([
                                'message_id' => $messageIdAdministrator,
                                'user_id' => $adminUser->id,
                                'message' => $pesan,
                                'type' => $cutiDetail->jenis,
                                'data' => [
                                    'cuti_id' => $cutiDetail->id,
                                    'user_id' => $cutiDetail->user_id,
                                    'atasan_id' => $cutiDetail->atasan_id,
                                ],
                                'whatsapp' => $adminUser->detail->whatsapp,
                                'is_sent_wa' => false,
                                'eror_wa' => '',
                                'onesignal' => optional($adminUser->devices)->pluck('device_token')->first(),
                                'eror_onesignal' => '',
                                'email' => $email,
                                'is_sent_email' => false,
                                'eror_email' => '',
                                'priority' => 'high',
                                'created_by' => $cutiDetail->user_id,
                                'target_url' => $urlOneSignaladministrasi,
                            ]);
                        }
            
                    } else if ($cutiDetail->status == 2){
                        throw new \Exception('Cuti Sudah Pernah Disetujui');
                    } else {
                        throw new \Exception('Cuti Sudah Pernah Disetujui');
                    }
                } else {
                    // Update Cuti Detail Status
                        $cutiDetail->status = 9;
                        $cutiDetail->save();
                    //! Update Cuti Detail Status
              
                    // Sign Create & Update Cuti Detail
                        $signMessageAtasanDua = "Surat Permohonan Cuti Atas Nama " . $user->detail->name . " Telah Disetujui Oleh Pejabat Yang Berwenang Memberikan Cuti.";
                        $signAtasanDua = Sign::create([
                            'user_id' => $atasanDua->id,
                            'message' => $signMessageAtasanDua,
                        ]);
                        
                        $cutiDetail->id_sign_atasan_dua = $signAtasanDua->id;
                        $cutiDetail->save();
                    //! Sign Create & Update Cuti Detail
                    
                     // Sisa Cuti Update
                        $sisaCuti = CutiSisa::where('user_id', $user->id)->first();
                                    
                        $remainingLeave = $jumlahHariCuti;
            
                        if ($sisaCuti->cuti_ndua >= $remainingLeave) {
                            $sisaCuti->cuti_ndua -= $remainingLeave;
                        } else {
                            $remainingLeave -= $sisaCuti->cuti_ndua;
                            $sisaCuti->cuti_ndua = 0;
            
                            if ($sisaCuti->cuti_nsatu >= $remainingLeave) {
                                $sisaCuti->cuti_nsatu -= $remainingLeave;
                            } else {
                                $remainingLeave -= $sisaCuti->cuti_nsatu;
                                $sisaCuti->cuti_nsatu = 0;
            
                                if ($sisaCuti->cuti_n >= $remainingLeave) {
                                    $sisaCuti->cuti_n -= $remainingLeave;
                                } else {
                                    return response()->json(['error' => 'Insufficient leave balance'], 400);
                                }
                            }
                        }
            
                        $sisaCuti->save();
                    //! Sisa Cuti Update

                    //Create Message For User
                        $sapaanUser = $user->detail->kelamin == 'P' ? 'Ibu' : 'Bapak';
                        $messageIdPegawai = (string) Str::uuid();
                        $urlOneSignalPegawai = route('user.account.cuti') . "?";
                        
                        $pesanUser = "Assalamualaikum $sapaanUser " . $user->detail->name . ",\n\n";
                        $pesanUser .= "Status: Cuti Anda sudah disetujui oleh atasan, menunggu penomoran surat.";
        
                        Notification::create([
                            'message_id' => $messageIdPegawai,
                            'user_id' => $user->id,
                            'message' => $pesanUser,
                            'type' => $cutiDetail->jenis,
                            'data' => [
                                'cuti_id' => $cutiDetail->id,
                                'user_id' => $cutiDetail->user_id,
                                'atasan_id' => $cutiDetail->atasan_id,
                            ],
                            'whatsapp' => $user->detail->whatsapp,
                            'is_sent_wa' => false,
                            'eror_wa' => '',
                            'onesignal' => optional($user->devices)->pluck('device_token')->first(),
                            'eror_onesignal' => '',
                            'email' => $user->email,
                            'is_sent_email' => false,
                            'eror_email' => '',
                            'priority' => 'low',
                            'created_by' => $cutiDetail->user_id,
                            'target_url' => $urlOneSignalPegawai,
                        ]);
                    //!Create Message For User
                    
                    //Update Kehadiran
                        Kehadiran::create([
                            'user_id'    => $user->id,
                            'tgl_awal'   => $cutiDetail->tglawal,
                            'tgl_akhir'  => $cutiDetail->tglakhir,
                            'jenis'      => $cutiDetail->jenis,
                            'keterangan' => $cutiDetail->alasan,
                        ]);
                    //!Update Kehadiran

                    //Create Message For Administrasi                       
                        $usersWithAdminRole = User::admin()->with(['detail', 'devices'])->get();
            
                        foreach ($usersWithAdminRole as $adminUser) {
                            $sapaanAdmin = $adminUser->detail->kelamin == 'P' ? 'Ibu' : 'Bapak';
                            $pesan = "Assalamualaikum $sapaanAdmin *" . $adminUser->detail->name . "*\n\n";
                            $pesan .= "Cuti Atas Nama *" . $user->detail->name . "* Menunggu Penomoran Surat.\n\n";
                    
                            $messageIdAdministrator = (string) Str::uuid();
                            $urlOneSignaladministrasi = route('kepegawaian.cuti.penomoran') . "?";
                            $email = User::find($adminUser->id)->email ?? '';
                    
                            Notification::create([
                                'message_id' => $messageIdAdministrator,
                                'user_id' => $adminUser->id,
                                'message' => $pesan,
                                'type' => $cutiDetail->jenis,
                                'data' => [
                                    'cuti_id' => $cutiDetail->id,
                                    'user_id' => $cutiDetail->user_id,
                                    'atasan_id' => $cutiDetail->atasan_id,
                                ],
                                'whatsapp' => $adminUser->detail->whatsapp,
                                'is_sent_wa' => false,
                                'eror_wa' => '',
                                'onesignal' => optional($adminUser->devices)->pluck('device_token')->first(),
                                'eror_onesignal' => '',
                                'email' => $email,
                                'is_sent_email' => false,
                                'eror_email' => '',
                                'priority' => 'high',
                                'created_by' => $cutiDetail->user_id,
                                'target_url' => $urlOneSignaladministrasi,
                            ]);
                        }
                    //!Create Message For Administrasi
                }
        
                DB::commit();

                return redirect()->back()->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Cuti disetujui.',
                    ],
                ]);
        
            } catch (\Exception $e) {
                DB::rollback();
        
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    ],
                ]);
            }
        }   
        
        public function penomoranStore(Request $request)
        {
            
            $validated = $request->validate([
                'id' => 'required|exists:cuti_detail,id',  // Validate ID exists in cuti_detail
                'nomorSurat' => 'required|string'  // Validate nomorSurat is a string
            ]);

            // Start a database transaction
            DB::beginTransaction();

            try {
                // Fetch the CutiDetail based on the provided ID
                $cutiDetail = CutiDetail::find($request->id);

                // Check if CutiDetail was found
                if (!$cutiDetail) {
                    return response()->json(['error' => 'Data not found.'], 404);
                }

                // Update the no_surat field in CutiDetail
                $cutiDetail->no_surat = $request->nomorSurat;
                $cutiDetail->status = 10;
                $cutiDetail->save();

                // Fetch the user associated with the CutiDetail
                $user = User::find($cutiDetail->user_id);

                // Check if User was found
                if (!$user) {
                    return response()->json(['error' => 'User not found.'], 404);
                }

                // Create the notification message
                $sapaanUser = $user->detail->kelamin == 'P' ? 'Ibu' : 'Bapak';
                $messageIdPegawai = (string) Str::uuid();
                $urlOneSignalPegawai = route('user.account.cuti') . "?";
                
                $pesanUser = "Assalamualaikum $sapaanUser " . $user->detail->name . ",\n\n";
                $pesanUser .= "Status: Cuti Anda sudah diberikan nomor surat: " . $request->nomorSurat . ".\n\n";                
                $pesanUser .= "Selamat melaksanakan Cuti, Semoga Kita Semua Selalu Dalam Lindungan Allah SWT.\n\n";                
                $pesanUser .= "-Salam Hangat, *Dek Linda*";                

                // Create the notification
                Notification::create([
                    'message_id' => $messageIdPegawai,
                    'user_id' => $user->id,
                    'message' => $pesanUser,
                    'type' => $cutiDetail->jenis,
                    'data' => [
                        'cuti_id' => $cutiDetail->id,
                        'user_id' => $cutiDetail->user_id,
                        'atasan_id' => $cutiDetail->atasan_id,
                    ],
                    'whatsapp' => $user->detail->whatsapp,
                    'is_sent_wa' => false,
                    'eror_wa' => '',
                    'onesignal' => optional($user->devices)->pluck('device_token')->first(),
                    'eror_onesignal' => '',
                    'email' => $user->email,
                    'is_sent_email' => false,
                    'eror_email' => '',
                    'priority' => 'high',
                    'created_by' => $cutiDetail->user_id,
                    'target_url' => $urlOneSignalPegawai,
                ]);

                // Commit the transaction
                DB::commit();

                return redirect()->back()->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Penomoran Berhasil.',
                    ],
                ]);
                

            } catch (\Exception $e) {
                // Rollback the transaction
                DB::rollBack();

                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    ],
                ]);
            }
        }
    //!Action Cuti

    //Cetak Cuti
        public function cetakCuti($id)
        {
            $cutiDetail = CutiDetail::with(['userDetails', 'atasan', 'cuti', 'atasanDua'])->findOrFail($id);
        
            if ($cutiDetail) {
                $userDetails = $cutiDetail->userDetails;
        
                $userJabatan = $userDetails->jabatan;
                $userInstansi = $userDetails->instansi;
        
                if ($userJabatan === 'PPNPN') {    
                    $formattedDate = $cutiDetail->created_at? Carbon::parse($cutiDetail->created_at)->translatedFormat('d F Y'): 'N/A';
                    $tglAwal = $cutiDetail->tglawal;
                    $tglAkhir = $cutiDetail->tglakhir;

                    if ($tglAwal !== 'N/A') {
                        $tglAwalFormatted = (new \DateTime($tglAwal))->format('d-m-Y');
                    } else {
                        $tglAwalFormatted = 'N/A';
                    }
                    
                    if ($tglAkhir !== 'N/A') {
                        $tglAkhirFormatted = (new \DateTime($tglAkhir))->format('d-m-Y');
                    } else {
                        $tglAkhirFormatted = 'N/A';
                    }

                    $jumlahHariCuti = $this->hitungHariCuti($tglAwal, $tglAkhir);
                    $jumlahHariCutiTerbilang = $this->terbilang($jumlahHariCuti);
                    
                   $urlToBarcodeUser =route('barcode.scan') . '?eSign=' . urlencode($cutiDetail->id_sign);
                   $urlToBarcodeKPA = route('barcode.scan') . '?eSign=' . urlencode($cutiDetail->id_sign_atasan_dua);

                   $qrCodePpnpn = base64_encode(QrCode::format('svg')
                                                ->size(70)
                                                ->errorCorrection('M')
                                                ->generate($urlToBarcodeUser));
                  
                    $qrCodeKPA = base64_encode(QrCode::format('svg')
                                                ->size(70)
                                                ->errorCorrection('M')
                                                ->generate($urlToBarcodeKPA));
                   
                    $data = [
                        'name' => $cutiDetail->userDetails->name ?? 'N/A',
                        'nip' => $cutiDetail->userDetails->nip ?? 'N/A',
                        'jabatan' => $cutiDetail->userDetails->jabatan ?? 'N/A',
                        'alasan' => $cutiDetail->alasan ?? '-',
                        'bulan' => $cutiDetail->userDetails->bulan ?? 'N/A',
                        'instansi' => "Mahkamah Syar'iyah Lhokseumawe",
                        'no_surat' => $cutiDetail->userDetails->no_surat ?? 'N/A',
                        'jumlahHariCuti' => $jumlahHariCuti ?? 'N/A',
                        'cutiTerbilang' => $jumlahHariCutiTerbilang ?? 'N/A',
                        'jenis' => $cutiDetail->jenis ?? 'N/A',
                        'jumlahhari' => $cutiDetail->jumlahhari ?? 'N/A',
                        'tglawal' => $tglAwalFormatted,
                        'tglakhir' => $tglAkhirFormatted,
                        'cuti_n' => $cutiDetail->cuti_n ?? 'N/A',
                        'alamat' => $cutiDetail->alamat ?? 'N/A',
                        'sisan' => $cutiDetail->sisan ?? 'N/A',
                        'alamat' => $cutiDetail->alamat ?? 'N/A',
                        'whatsapp' => $cutiDetail->userDetails->whatsapp ?? 'N/A',
                        'statuspim' => $cutiDetail->statuspim ?? 'N/A',
                        'kettas' => $cutiDetail->kettas ?? 'N/A',
                        'jappim' => $cutiDetail->jappim ?? 'N/A',
                        'nippim' => $cutiDetail->atasanDua->nip ?? 'N/A',
                        'namepim' => $cutiDetail->atasanDua->name ?? 'N/A',
                        'namepim2' => $cutiDetail->namepim2 ?? 'N/A',
                        'nippim2' => $cutiDetail->nippim2 ?? 'N/A',
                        'created_at' => $formattedDate ?? 'N/A',
                        'qrCodePpnpn' => $qrCodePpnpn,
                        'qrCodeKPA' => $qrCodeKPA,
                    ];
        
                    $pdf = PDF::loadView('Kepegawaian.Pdf.cutiPpnpn', compact('data'));
                    return $pdf->stream('cuti_pimpinan.pdf');
                } elseif ($cutiDetail->atasan_id == $cutiDetail->atasan_dua_id) {
                    $formattedDate              = $cutiDetail->created_at? Carbon::parse($cutiDetail->created_at)->translatedFormat('d F Y'): 'N/A';
                    $tglAwal                    = $cutiDetail->tglawal;
                    $tglAkhir                   = $cutiDetail->tglakhir;

                    if ($tglAwal !== 'N/A') {
                        $tglAwalFormatted       = (new \DateTime($tglAwal))->format('d-m-Y');
                    } else {
                        $tglAwalFormatted       = 'N/A';
                    }
                    
                    if ($tglAkhir !== 'N/A') {
                        $tglAkhirFormatted      = (new \DateTime($tglAkhir))->format('d-m-Y');
                    } else {
                        $tglAkhirFormatted      = 'N/A';
                    }

                    $jumlahHariCuti             = $this->hitungHariCuti($tglAwal, $tglAkhir);
                    $jumlahHariCutiTerbilang    = $this->terbilang($jumlahHariCuti);

                    //Hitung Masa Kerja
                    $nip = $cutiDetail->userDetails->nip ?? 'N/A';
                    $awalKerja = $cutiDetail->userDetails->awal_kerja ?? null;
                
                    // Menghitung lama bekerja berdasarkan awal kerja atau NIP
                        if (is_null($awalKerja) && $nip == 'default_nip') {
                            $lamaBekerja = null;
                            $tanggalAwalKerja = null;
                        } else {
                            if ($awalKerja) {
                                $tanggalPengangkatanCarbon = Carbon::parse($awalKerja, 'Asia/Jakarta');
                            } else {
                                // Jika tidak ada awal kerja, hitung berdasarkan NIP
                                $tanggalPengangkatan = substr($nip, 8, 6);
                                $tahunPengangkatan = substr($tanggalPengangkatan, 0, 4);
                                $bulanPengangkatan = substr($tanggalPengangkatan, 4, 2);
                                $tanggalPengangkatanCarbon = Carbon::createFromDate($tahunPengangkatan, $bulanPengangkatan, 1, 'Asia/Jakarta');
                            }
                    
                            $tanggalHariIni = Carbon::now('Asia/Jakarta');
                            $lamaBekerja = $tanggalPengangkatanCarbon->diff($tanggalHariIni);
                            $tanggalAwalKerja = $tanggalPengangkatanCarbon->format('d-m-Y'); // Format dd-mm-yyyy
                        }
                                          
                        if ($lamaBekerja) {
                            $formattedLamaBekerja = $lamaBekerja->y . ' Tahun ' . $lamaBekerja->m . ' Bulan';
                        } else {
                            $formattedLamaBekerja = 'N/A';
                        }
                    //!Hitung Masa Kerja
                    
                   $urlToBarcodePegawai =route('barcode.scan') . '?eSign=' . urlencode($cutiDetail->id_sign);
                   $urlToBarcodePejabat = route('barcode.scan') . '?eSign=' . urlencode($cutiDetail->id_sign_atasan_dua);

                   $qrCodePegawai = base64_encode(QrCode::format('svg')
                                                ->size(70)
                                                ->errorCorrection('M')
                                                ->generate($urlToBarcodePegawai));
                  
                    $qrCodePejabat = base64_encode(QrCode::format('svg')
                                                ->size(70)
                                                ->errorCorrection('M')
                                                ->generate($urlToBarcodePejabat));
                   
                    $data = [
                        'no_surat' => $cutiDetail->no_surat ?? 'N/A',
                        'name' => $cutiDetail->userDetails->name ?? 'N/A',
                        'nip' => $cutiDetail->userDetails->nip ?? 'N/A',
                        'jabatan' => $cutiDetail->userDetails->jabatan ?? 'N/A',
                        'alasan' => $cutiDetail->alasan ?? '-',
                        'bulan' => $cutiDetail->userDetails->bulan ?? 'N/A',
                        'instansi' => "Mahkamah Syar'iyah Lhokseumawe",
                        'jumlahHariCuti' => $jumlahHariCuti ?? 'N/A',
                        'cutiTerbilang' => $jumlahHariCutiTerbilang ?? 'N/A',
                        'jenis' => $cutiDetail->jenis ?? 'N/A',
                        'jumlahhari' => $cutiDetail->jumlahhari ?? 'N/A',
                        'tglawal' => $tglAwalFormatted,
                        'tglakhir' => $tglAkhirFormatted,
                        'cuti_n' => $cutiDetail->cuti_n ?? 'N/A',
                        'cuti_nsatu' => $cutiDetail->cuti_nsatu ?? 'N/A',
                        'cuti_ndua' => $cutiDetail->cuti_ndua ?? 'N/A',
                        'alamat' => $cutiDetail->alamat ?? 'N/A',
                        'status' => $cutiDetail->status ?? 'N/A',
                        'alamat' => $cutiDetail->alamat ?? 'N/A',
                        'whatsapp' => $cutiDetail->userDetails->whatsapp ?? 'N/A',

                        'nippim' => $cutiDetail->atasanDua->nip ?? 'N/A',
                        'namepim' => $cutiDetail->atasanDua->name ?? 'N/A',
                        'jabatanpim' => $cutiDetail->atasanDua->jabatan ?? 'N/A',
                        'lamaBekerja' => $formattedLamaBekerja,
                        'nippim2' => $cutiDetail->nippim2 ?? 'N/A',
                        'created_at' => $formattedDate ?? 'N/A',
                        'qrCodePegawai' => $qrCodePegawai,
                        'qrCodePejabat' => $qrCodePejabat,
                    ];
        
                    $pdf = PDF::loadView('Kepegawaian.Pdf.cutiSatu', compact('data'));
                    return $pdf->stream('cuti_pimpinan.pdf');
                } elseif ($userInstansi !== '1') {
                    echo 'b';
                } else {
                    $data = [
                        'nama' => $cutiDetail->userDetails->name ?? 'N/A',
                        'nip' => $cutiDetail->userDetails->nip ?? 'N/A',
                        'jabatan' => $cutiDetail->userDetails->jabatan ?? 'N/A',
                        'tahun' => $cutiDetail->userDetails->tahun ?? 'N/A',
                        'bulan' => $cutiDetail->userDetails->bulan ?? 'N/A',
                        'instansi' => $cutiDetail->userDetails->instansi ?? 'N/A',
                        'jenis' => $cutiDetail->cuti->name ?? 'N/A',
                        'jumlahhari' => $cutiDetail->jumlahhari ?? 'N/A',
                        'tglawal' => $cutiDetail->tglawal ?? 'N/A',
                        'tglakhir' => $cutiDetail->tglakhir ?? 'N/A',
                        'sisan2' => $cutiDetail->sisan2 ?? 'N/A',
                        'sisan1' => $cutiDetail->sisan1 ?? 'N/A',
                        'sisan' => $cutiDetail->sisan ?? 'N/A',
                        'alamat' => $cutiDetail->alamat ?? 'N/A',
                        'whatsapp' => $cutiDetail->whatsapp ?? 'N/A',
                        'statuspim' => $cutiDetail->statuspim ?? 'N/A',
                        'kettas' => $cutiDetail->kettas ?? 'N/A',
                        'jappim' => $cutiDetail->jappim ?? 'N/A',
                        'nippim' => $cutiDetail->nippim ?? 'N/A',
                        'namepim' => $cutiDetail->namepim ?? 'N/A',
                        'namepim2' => $cutiDetail->namepim2 ?? 'N/A',
                        'nippim2' => $cutiDetail->nippim2 ?? 'N/A'
                    ];
        
                    $pdf = PDF::loadView('Kepegawaian.Pdf.cutiPimpinan', compact('data'));
                    return $pdf->stream('cuti_pimpinan.pdf');
                }
        
            }
        
            
        }
        // return $pdf->download('cuti_pimpinan.pdf');
    //!Cetak Cuti
    
    public function editCutiSisa(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users_detail,user_id',
            'cuti_n1' => 'required|integer|min:0',
            'cuti_n2' => 'required|integer|min:0',
            'cuti_n3' => 'required|integer|min:0',
            'cuti_sakit' => 'required|integer|min:0',
            'cap' => 'required|integer|min:0',
            'cuti_besar' => 'required|integer|min:0',
            'cuti_melahirkan' => 'required|integer|min:0',
        ]);

        $cutiSisa = CutiSisa::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'cuti_n' => $request->cuti_n1,
                'cuti_nsatu' => $request->cuti_n2,
                'cuti_ndua' => $request->cuti_n3,
                'cuti_s' => $request->cuti_sakit,
                'cuti_ap' => $request->cap,
                'cuti_b' => $request->cuti_besar,
                'cuti_m' => $request->cuti_melahirkan,
            ]
        );

        $userName = UserDetail::where('user_id', $request->user_id)->value('name');

        return response()->json(['message' => 'Sisa cuti berhasil diperbarui', 'userName' => $userName]);
    }

    public function sisaCutigetData(Request $request)
    {
        if ($request->ajax()) {
            static $counter = 0;
            $counter = 0;

            $data = UserDetail::select([
                'users_detail.id',
                'users_detail.user_id',
                'users_detail.name',
                'users_detail.image',
                'users_detail.jabatan',
            ])
            ->join('jabatan', 'users_detail.jabatan', '=', 'jabatan.name')
            ->with(['cutiSisa'])
            ->orderBy('jabatan.id', 'asc') // Mengurutkan berdasarkan jabatan.id
            ->get();

            return Datatables::of($data)
                ->addColumn('no', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('pegawai', function ($user) {
                    $userImage = $user->image ? asset('assets/img/avatars/' . $user->image) : asset('assets/img/avatars/default-image.jpg');
                    $userName = $user->name ?? 'Unknown User';
                    $userJabatan = $user->jabatan ?? 'Unknown Position';

                    $output = '
                        <div class="d-flex align-items-center">
                            <img src="' . $userImage . '" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <span class="fw-bold">' . e($userName) . '</span>
                                <small class="text-muted d-block">' . e($userJabatan) . '</small>
                            </div>
                        </div>';

                    return $output;
                })
                ->addColumn('cutinsatu', function ($user) {
                    return $user->cutiSisa->cuti_n ?? 0;
                })
                ->addColumn('cutindua', function ($user) {
                    return $user->cutiSisa->cuti_nsatu ?? 0;
                })
                ->addColumn('cutintiga', function ($user) {
                    return $user->cutiSisa->cuti_ndua ?? 0;
                })
                ->addColumn('cs', function ($user) {
                    return $user->cutiSisa->cuti_s ?? 0;
                })
                ->addColumn('cap', function ($user) {
                    return $user->cutiSisa->cuti_ap ?? 0;
                })
                ->addColumn('cb', function ($user) {
                    return $user->cutiSisa->cuti_b ?? 0;
                })
                ->addColumn('cm', function ($user) {
                    return $user->cutiSisa->cuti_m ?? 0;
                })
                ->addColumn('action', function ($user) {
                    return '<i class="fas fa-edit" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#sisaCutiModal" 
                    data-id="' . $user->user_id . '" 
                    data-name="' . e($user->name) . '"
                    data-cutinsatu="' . ($user->cutiSisa->cuti_n ?? 0) . '"
                    data-cutindua="' . ($user->cutiSisa->cuti_nsatu ?? 0) . '"
                    data-cutintiga="' . ($user->cutiSisa->cuti_ndua ?? 0) . '"
                    data-cs="' . ($user->cutiSisa->cuti_s ?? 0) . '"
                    data-cap="' . ($user->cutiSisa->cuti_ap ?? 0) . '"
                    data-cb="' . ($user->cutiSisa->cuti_b ?? 0) . '"
                    data-cm="' . ($user->cutiSisa->cuti_m ?? 0) . '"></i>';
                })
                ->rawColumns(['pegawai', 'action'])
                ->make(true);
        }
    }

    public function permohonanCutigetData(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $userId = $user->id;   
            $roleId = $user->role;       
            $roleName = Role::where('id', $roleId)->value('name');

            $query = CutiDetail::with(['userDetails', 'atasan', 'cuti', 'atasanDua']);

            if ($roleName === 'kepegawaian') {
                // Ambil semua data cuti untuk user dengan role kepegawaian
                $data = $query->whereIn('status', [1, 2, 9, 10])->get();
            } elseif ($roleName === 'administrasi') {
                // Ambil semua data cuti dengan status 9 untuk user dengan role administrasi
                $data = $query->where('status', 9)->get();
            } else {
                // Ambil data berdasarkan atasan_id atau atasan_dua_id
                if ($query->where('atasan_id', $userId)->exists()) {
                    $data = $query
                        ->where('status', 1)
                        ->where('atasan_id', $userId)
                        ->get();
                } else {              
                    $data = $query
                        ->where('status', 2)
                        ->where('atasan_dua_id', $userId)
                        ->get();
                }
            }

            $counter = 0;
            return DataTables::of($data)
                ->addColumn('no', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('user_name', function($row){
                    return $row->userDetails->name ?? 'N/A';
                })
                ->addColumn('atasan_name', function($row) {
                    // Define atasanName with proper HTML tag
                    $atasanName = '<strong>Atasan:</strong> ' . ($row->atasan->name ?? 'N/A');
                    
                    // Check if atasan_dua_id is set and different from user_id
                    if ($row->atasan_dua_id && $row->atasan_dua_id != $row->user_id) {
                        // Define atasanDuaName with proper HTML tag
                        $atasanDuaName = '<strong>Atasan Dua:</strong> ' . ($row->atasanDua->name ?? 'N/A');
                        // Concatenate atasanName and atasanDuaName with a line break
                        return $atasanName . '<br>' . $atasanDuaName;
                    }
                
                    // Return only atasanName if no atasanDua is present
                    return $atasanName;
                })
                // ->addColumn('no_surat', function($row){
                //     return $row->cuti->no_surat ?? 'N/A';
                // })
                ->addColumn('jenis', function($row){
                    return $row->cuti->name ?? 'N/A';
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        return '<span class="badge bg-info">Menunggu Persetujuan<br><br>Atasan Langsung</span>';
                    }
                    if ($row->status == 2) {
                        return '<span class="badge bg-info">Menunggu Persetujuan<br><br>Pejabat Yang Berwenang</span>';
                    }
                    if ($row->status == 9) {
                        return '<span class="badge bg-dark">Menunggu Penomoran<br><br>Surat</span>';
                    }
                    if ($row->status == 10) {
                        return '<span class="badge bg-success">Cuti Disetujui</span>';
                    }
                    // Return other status if necessary
                    return '<span class="badge bg-secondary">Status Lain</span>';
                })
                ->addColumn('action', function($row){
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm mb-2" 
                    //             data-id="'.$row->id.'"
                    //             data-jenis="'.$row->cuti->name.'"
                    //             data-user_name="'.$row->userDetails->name.'"
                    //             data-alasan="'.$row->alasan.'"
                    //             data-tglawal="'.$row->tglawal.'"
                    //             data-tglakhir="'.$row->tglakhir.'"
                    //             >Action</a>';
                    // $btn .= '<a href="'.route('kepegawaian.cuti.detail', ['cuti_id' => $row->id]).'" class="btn btn-warning btn-sm">Detail</a>';

                    $user = Auth::user();
                    $roleId = $user->role;       
                    $roleName = Role::where('id', $roleId)->value('name');
                    if ($roleName === 'kepegawaian') {                       
                        $btn = '<a href="' . route('cetakCuti', ['id' => $row->id]) . '" target="_blank" class="btn btn-info btn-sm">Download</a>';
                    }elseif ($roleName === 'administrasi'){
                        $btn = '<a href="javascript:void(0)" class="nomor btn btn-warning btn-sm mb-2" 
                                    data-id="'.$row->id.'"
                                    data-jenis="'.$row->cuti->name.'"
                                    data-user_name="'.$row->userDetails->name.'"
                                    data-alasan="'.$row->alasan.'"
                                    data-tglawal="'.$row->tglawal.'"
                                    data-tglakhir="'.$row->tglakhir.'"
                                    >Penomoran</a>';
                    } else {                  
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm mb-2" 
                                    data-id="'.$row->id.'"
                                    data-jenis="'.$row->cuti->name.'"
                                    data-user_name="'.$row->userDetails->name.'"
                                    data-alasan="'.$row->alasan.'"
                                    data-tglawal="'.$row->tglawal.'"
                                    data-tglakhir="'.$row->tglakhir.'"
                                    >Action</a>';
                        $btn .= '<a href="'.route('kepegawaian.cuti.detail', ['cuti_id' => $row->id]).'" class="btn btn-warning btn-sm">Detail</a>';
                    }
                
                    return $btn;
                })
                ->rawColumns(['status', 'atasan_name', 'action'])
                ->make(true);
        }
    }
    
    public function daftarCutigetData(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::id();
            $data = CutiDetail::with(['userDetails', 'atasan', 'atasanDua'])
                    ->where('user_id', $userId)
                    ->get();
            // dd($data);
                
            $counter = 0;
            return DataTables::of($data)
                ->addColumn('no', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('user_name', function($row){
                    return $row->userDetails->name ?? 'N/A';
                })
                ->addColumn('atasan_name', function($row) {
                    // Define atasanName with proper HTML tag
                    $atasanName = '<strong>Atasan:</strong> ' . ($row->atasan->name ?? 'N/A');
                    
                    // Check if atasan_dua_id is set and different from user_id
                    if ($row->atasan_dua_id && $row->atasan_dua_id != $row->user_id) {
                        // Define atasanDuaName with proper HTML tag
                        $atasanDuaName = '<strong>Atasan Dua:</strong> ' . ($row->atasanDua->name ?? 'N/A');
                        // Concatenate atasanName and atasanDuaName with a line break
                        return $atasanName . '<br>' . $atasanDuaName;
                    }
                
                    // Return only atasanName if no atasanDua is present
                    return $atasanName;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        return '<span class="badge bg-info">Menunggu Persetujuan<br><br>Atasan Langsung</span>';
                    }
                    if ($row->status == 9) {
                        return '<span class="badge bg-dark">Menunggu Penomoran<br><br>Surat</span>';
                    }
                    if ($row->status == 10) {
                        return '<span class="badge bg-success">Cuti Disetujui</span>';
                    }
                    // Return other status if necessary
                    return '<span class="badge bg-secondary">Status Lain</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mb-2" 
                            data-id="'.$row->id.'"
                            data-jenis="'.$row->jenis.'"
                            data-user_name="'.$row->userDetails->name.'"
                            data-alasan="'.$row->alasan.'"
                            data-tglawal="'.$row->tglawal.'"
                            data-tglakhir="'.$row->tglakhir.'"
                            >Perubahan</a>';
                
                    // Cek status, jika sesuai maka munculkan tombol download
                    if($row->status == 10) {
                        $btn .= '<a href="'.route('cetakCuti', $row->id).'" class="btn btn-warning btn-sm" target="_blank">Unduh</a>';
                    }
                
                    return $btn;
                })
                
                ->rawColumns(['status', 'atasan_name', 'action'])
                ->make(true);
        }
    }

    private function hitungHariCuti($tglAwal, $tglAkhir)
    {
        // Convert the start and end dates to DateTime objects
        $startDate = new \DateTime($tglAwal);
        $endDate = new \DateTime($tglAkhir);
    
        // Validate the date range
        if ($startDate > $endDate) {
            return "Tanggal awal tidak boleh lebih besar dari tanggal akhir.";
        }
    
        $totalHari = 0;
        $hariCuti = []; // Array to store the leave days
        $currentDate = clone $startDate;
    
        // Loop through each day in the date range
        while ($currentDate <= $endDate) {
            $dayOfWeek = $currentDate->format('w');
            if ($dayOfWeek != 6 && $dayOfWeek != 0) { // Exclude Saturdays (6) and Sundays (0)
                $hariCuti[] = $currentDate->format('Y-m-d'); // Store the leave day
                $totalHari++;
            }
            $currentDate->modify('+1 day');
        }
    
        // Get the national holidays for the years covered in the date range
        $currentYear = $startDate->format('Y');
        $hariLibur = [];
        while ($currentYear <= $endDate->format('Y')) {
            $hariLiburTahun = $this->getNationalHolidays($currentYear);
            $hariLibur = array_merge($hariLibur, $hariLiburTahun);
            $currentYear++;
        }
    
        // Filter out holidays that fall within the leave period
        $hariLiburDalamRentang = array_filter($hariLibur, function ($libur) use ($startDate, $endDate) {
            $tanggalLibur = new \DateTime($libur['holiday_date']);
            return $tanggalLibur >= $startDate && $tanggalLibur <= $endDate;
        });
    
        // Calculate the total number of holidays within the range
        $jumlahHariLibur = count($hariLiburDalamRentang);
    
        // Calculate the total leave days after excluding holidays
        $jumlahHariCuti = $totalHari - $jumlahHariLibur;
    
        return $jumlahHariCuti;
    }
    
    private function getNationalHolidays($year)
    {
        $url = "https://api-harilibur.vercel.app/api?year={$year}";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    private function terbilang($number)
    {
        $words = [
            0 => '',
            1 => 'Satu',
            2 => 'Dua',
            3 => 'Tiga',
            4 => 'Empat',
            5 => 'Lima',
            6 => 'Enam',
            7 => 'Tujuh',
            8 => 'Delapan',
            9 => 'Sembilan',
            10 => 'Sepuluh',
            11 => 'Sebelas'
        ];

        if ($number < 12) {
            return $words[$number];
        } elseif ($number < 20) {
            return $this->terbilang($number - 10) . ' Belas';
        } elseif ($number < 100) {
            return $this->terbilang((int)($number / 10)) . ' Puluh ' . $this->terbilang($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . $this->terbilang($number - 100);
        } elseif ($number < 1000) {
            return $this->terbilang((int)($number / 100)) . ' Ratus ' . $this->terbilang($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . $this->terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return $this->terbilang((int)($number / 1000)) . ' Ribu ' . $this->terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return $this->terbilang((int)($number / 1000000)) . ' Juta ' . $this->terbilang($number % 1000000);
        }

        return $number; // Default to returning the number if it's too large to handle
    }   
}
