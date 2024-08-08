<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CutiSisa;
use App\Models\CutiDetail;
use App\Models\UserDetail;
use App\Models\UserDevice;
use App\Models\User;
use App\Models\Cuti;
use App\Models\Notification;
use App\Models\Sign;
use Illuminate\Support\Facades\Auth;
use Exception;
use DataTables;
use OneSignal;
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

    public function showCutiDetail(Request $request)
    {
        // Ambil parameter dari query string
        $message_id = $request->query('message_id');
        $type = $request->query('type');

        // Dump and die the message_id and type
        dd($message_id, $type);

        // Jika Anda ingin melakukan hal lain setelah dd, Anda bisa menambahkannya di sini
        // Misalnya mengambil detail notifikasi dari database dan menampilkan view
        // $notification = Notification::where('message_id', $message_id)->firstOrFail();
        // return view('cuti.detail', compact('notification', 'type'));
    }

    public function submitCutiTahunan(Request $request)
    {
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
    
        // Ambil data cuti sisa dari tabel cuti_sisa berdasarkan user_id
        $cutiSisa = CutiSisa::where('user_id', $request->id_pegawai)->first();
    
        if (!$cutiSisa) {
            return redirect()->back()->with('error', 'Data cuti sisa tidak ditemukan.');
        }
    
        // Simpan data cuti
        $cuti = CutiDetail::create([
            'user_id' => $request->id_pegawai,
            'atasan_id' => $request->ataslang,
            'atasan_dua_id' => $request->id_pimpinan,
            'jenis' => $request->code,
            'alasan' => $request->alcut,
            'tglawal' => $request->tglawal,
            'tglakhir' => $request->tglakhir,
            'alamat' => $request->alamat,
            'status' => '1', // Atur status awal
            'cuti_n' => $cutiSisa->cuti_n,
            'cuti_nsatu' => $cutiSisa->cuti_nsatu,
            'cuti_ndua' => $cutiSisa->cuti_ndua,
        ]);
    
        // Ambil data atasan dari tabel users
        $atasan = UserDetail::where('user_id', $request->ataslang)->first();
        $pegawai = UserDetail::where('user_id', $request->id_pegawai)->first();
    
        if (!$atasan) {
            return redirect()->back()->with('error', 'Data atasan tidak ditemukan.');
        }
    
        // Tentukan sapaan berdasarkan jenis kelamin
        $sapaan = $atasan->kelamin == 'L' ? 'Bapak' : 'Ibu';
    
        // Ambil nama cuti dari tabel cuti
        $cutiInfo = Cuti::where('code', $request->code)->first();
        $namaCuti = $cutiInfo ? $cutiInfo->name : $request->code;
    
        // Generate notification message
        $message = "Assalamu'alaikum $sapaan {$atasan->name},\n\n" .
                "Permohonan cuti atas nama *{$pegawai->name}* telah diajukan.\n\n" .
                "Jenis Cuti: $namaCuti\n" .
                "Dari: *{$request->tglawal}*\n" .
                "Sampai: *{$request->tglakhir}*\n" .
                "Alasan: {$request->alcut}\n\n";
    
        // Create notification
        $notification = Notification::create([
            'user_id' => $atasan->user_id,
            'message' => $message,
            'type' => $request->code,
            'data' => [
                'cuti_id' => $cuti->id,
                'user_id' => $request->id_pegawai,
                'atasan_id' => $request->ataslang,
            ],
            'whatsapp' => 'unsent',
            'onesignal' => 'unsent',
            'email' => 'unsent',
            'is_sent_wa' => false,
            'eror_wa' => '',
            'is_sent_onesignal' => false,
            'eror_onesignal' => '',
            'is_sent_email' => false,
            'eror_email' => '',
            'priority' => 'High',
            'created_by' => $request->id_pegawai,
        ]);
    
        // Generate URLs with query string
        $url = url('/kepegawaian/cuti/detail');
        $urlWa = $url . '?message_id=' . $notification->message_id . '&type=wa';
        $urlOneSignal = $url . '?message_id=' . $notification->message_id . '&type=onesignal';
        $urlEmail = $url . '?message_id=' . $notification->message_id . '&type=email';
    
        // Append URLs to message
        $messageWa = $message . "Url Action: *$urlWa*";
        $messageOneSignal = $message . "Url Action: *$urlOneSignal*";
        $messageEmail = $message . "Url Action: *$urlEmail*";
    
        try {
            // Send WhatsApp notification
            $this->sendWhatsAppNotification($atasan->whatsapp, $atasan->name, $messageWa);
            $notification->update(['is_sent_wa' => true, 'whatsapp' => $atasan->whatsapp, 'eror_wa' => '']);
        } catch (Exception $waException) {
            $notification->update(['eror_wa' => $waException->getMessage(), 'whatsapp' => 'unsent']);
    
            try {
                // Send OneSignal notification
                $deviceTokens = UserDevice::where('user_id', $atasan->user_id)->pluck('device_token')->toArray();
                if (!empty($deviceTokens)) {
                    $this->sendOneSignalNotification($deviceTokens, $messageOneSignal, $urlOneSignal);
                    $notification->update(['is_sent_onesignal' => true, 'eror_onesignal' => '']);
                } else {
                    throw new Exception("Device tokens not found");
                }
            } catch (Exception $oneSignalException) {
                $notification->update(['eror_onesignal' => $oneSignalException->getMessage()]);
    
                try {
                    // Send email notification
                    \Mail::to($atasan->email)->send(new CutiNotificationMail($messageEmail));
                    $notification->update(['is_sent_email' => true, 'eror_email' => '']);
                } catch (Exception $emailException) {
                    $notification->update(['eror_email' => $emailException->getMessage()]);
                    return redirect()->back()->with('error', 'Permohonan cuti berhasil diajukan, namun gagal mengirim notifikasi.');
                }
            }
        }
    
        return redirect()->back()->with('success', 'Permohonan cuti berhasil diajukan dan notifikasi telah dikirim.');
    }

    private function sendWhatsAppNotification($number, $name, $message)
    {
        $device_id = env('DEVICE_ID', 'somedefaultvalue');

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
            throw new Exception("Failed to send WhatsApp message: " . $response_data['message']);
        }
    }

   private function sendOneSignalNotification($deviceTokens, $message, $url)
{
    $fields = [
        'app_id' => config('services.onesignal.app_id'),
        'include_player_ids' => $deviceTokens,
        'headings' => ['en' => 'Permohonan Cuti'],
        'contents' => ['en' => $message],
        'url' => $url, // Gunakan URL yang dihasilkan di sini
        'chrome_web_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
        'small_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
        'large_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
    ];

    $response = OneSignal::sendNotificationCustom($fields);

    if ($response->getStatusCode() !== 200) {
        throw new Exception("Failed to send OneSignal notification");
    }

    $response_data = json_decode($response->getBody(), true);

    if (isset($response_data['errors'])) {
        throw new Exception("Failed to send OneSignal notification: " . json_encode($response_data['errors']));
    }
}


    
    //Action Cuti
        public function cutiApprove(Request $request)
        {
            // Validasi data form
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'jenisCuti' => 'required|string|max:255',
                'tglAwal' => 'required|date',
                'tglAkhir' => 'required|date',
                'alasan' => 'required|string|max:255',
                'id' => 'required|integer'
            ]);

            // Temukan data cuti berdasarkan ID
            $cutiDetail = CutiDetail::findOrFail($validatedData['id']);

            // Ambil data user_id, atasan_id, atasan_dua_id, dan status
            $cutiData = [
                'user_id' => $cutiDetail->user_id,
                'atasan_id' => $cutiDetail->atasan_id,
                'atasan_dua_id' => $cutiDetail->atasan_dua_id,
                'status' => $cutiDetail->status,
            ];

            // Tampilkan data menggunakan dd()
            // dd($cutiData);

            // Logika untuk menentukan respon
            if ($cutiData['user_id'] == 1 && $cutiData['atasan_dua_id'] == 1) {
                return response()->json(['message' => 'Tidak Ada Atasan 2']);
            } else {
                return response()->json(['message' => 'Ada atasan 2']);
            }

            if ($cutiData['status'] == 1) {
                return response()->json(['message' => 'Menunggu izin atasan selanjutnya']);
            }

            // Jika tidak ada kondisi yang terpenuhi, kembalikan data
            return response()->json($cutiData);

            // Update data cuti
            // $cutiDetail->status = 'approved';
            // $cutiDetail->save();

            // Berikan respons kembali ke pengguna
            // return redirect()->back()->with('success', 'Permohonan cuti telah disetujui.');
        }
    //!Action Cuti
    


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
            $userId = Auth::id(); // Mendapatkan ID user yang sedang sign in
            $data = CutiDetail::with(['userDetails', 'atasan', 'atasanDua'])
                ->where('atasan_id', $userId)
                ->orWhere('atasan_dua_id', $userId)
                ->where('atasan_dua_id', '!=', $userId) 
                ->get();
                
            $counter = 0;
            return DataTables::of($data)
                ->addColumn('no', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('user_name', function($row){
                    return $row->userDetails->name ?? 'N/A';
                })
                ->addColumn('atasan_name', function($row){
                    return $row->atasan->name ?? 'N/A';
                })
                ->addColumn('atasan_dua_name', function($row) {
                    if ($row->atasan_dua_id == $row->user_id) {
                        return '';
                    }
                    return $row->atasanDua->name ?? 'N/A';
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        return '<span class="badge bg-info">Menunggu Persetujuan<br><br>Atasan Langsung</span>';
                    }
                    // Return other status if necessary
                    return '<span class="badge bg-secondary">Status Lain</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" 
                            data-id="'.$row->id.'"
                            data-jenis="'.$row->jenis.'"
                            data-user_name="'.$row->userDetails->name.'"
                            data-alasan="'.$row->alasan.'"
                            data-tglawal="'.$row->tglawal.'"
                            data-tglakhir="'.$row->tglakhir.'"
                            >Action</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
}
