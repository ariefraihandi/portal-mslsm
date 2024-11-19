<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\PemohonInformasi;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PemohonUbahStatus;

class SiramasakanController extends Controller
{
   
    public function index(Request $request)
    {
        $accessMenus = $request->get('accessMenus');
        $id = $request->session()->get('user_id');
        $user = User::with('detail')->find($id);
    
        // Get current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
    
        // Query data created in the current month
        $pemohonUbahStatusCurrentMonth = PemohonUbahStatus::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();
    
        $failedCount = PemohonUbahStatus::whereIn('status', [1, 2])->count();
    
        $successCount = PemohonUbahStatus::where('status', 4)->count();
    
        $data = [
            'title'                => 'Siramasakan',
            'subtitle'             => 'Portal MS Lhokseumawe',
            'sidebar'              => $accessMenus,
            'users'                => $user,
            'pemohonUbahStatuses'  => $pemohonUbahStatusCurrentMonth, // Send data created in the current month
            'failedCount'          => $failedCount, // Send count of failed processes (status = 2)
            'successCount'         => $successCount, // Send count of successful processes (status = 4)
        ];
    
        return view('Siramasakan.index', $data);
    }
    

    public function cetakUbahStatus(Request $request, $id)
    {        
        $pemohon = PemohonUbahStatus::where('id', $id)->first();
    
        if (!$pemohon) {
            return abort(404, 'Data not found');
        }
    
        $detailPermohonan = '';
        if ($pemohon->cheklist_ubah_status && $pemohon->cheklist_ubah_alamat) {
            $detailPermohonan = 'Perubahan Status & Alamat';
        } elseif ($pemohon->cheklist_ubah_status) {
            $detailPermohonan = 'Perubahan Status';
        } elseif ($pemohon->cheklist_ubah_alamat) {
            $detailPermohonan = 'Perubahan Alamat';
        } else {
            $detailPermohonan = 'No Data';
        }
    
        // Generate QR Code
        $urlToBarcodePemohon = route('barcodestatus.scan') . '?eSign=' . urlencode($pemohon->id_sign);
        $qrCodePemohon = base64_encode(QrCode::format('svg')
            ->size(70)
            ->errorCorrection('M')
            ->generate($urlToBarcodePemohon));
    
        $createdAtFormatted = \Carbon\Carbon::parse($pemohon->created_at)->translatedFormat('d F Y');
    
        $data = [
            'pemohon' => $pemohon,
            'detailPermohonan' => $detailPermohonan, // Add the request detail
            'qrCodePemohon' => $qrCodePemohon, // Add the QR code
            'createdAtFormatted' => $createdAtFormatted // Add the formatted creation date
        ];
    
        // Load the view and pass the data for PDF generation
        $pdf = PDF::loadView('Siramasakan.cetakRecipt', $data);
    
        // Return the PDF for download
        return $pdf->stream('receipt_ubahstatus_' . $pemohon->pemohon->nama . '.pdf'); // Optional: Add the applicant's name to the file name
    }

    public function updateStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:pemohon_ubahstatus,id',
            'status' => 'required|in:1,2,3,4,5',
            'catatan' => 'nullable|string|max:255'
        ]);

        // Find the Role 'produk'
        $roleId = Role::where('name', 'produk')->value('id');
        $user = User::where('role', $roleId)->first();

        // Find the Pemohon record
        $pemohon = PemohonUbahStatus::find($request->id);

  
  $pemohonDetail = PemohonInformasi::find($pemohon->id_pemohon);

        

        if ($pemohon) {
            // Save the new status and catatan (if applicable) to the database
            $pemohon->status = $request->status;

            if ($request->status == 2) {
                // If status is 'Gagal Proses', save the catatan
                $pemohon->catatan = $request->catatan;
            } else {
                // If not 'Gagal Proses', clear the catatan
                $pemohon->catatan = null;
            }

            // Save the updated Pemohon status to the database
            $pemohon->save();

            // Prepare the message content based on the status
            if ($request->status == 3) {
                // If status is 3, successful process
                $pengajuan = $request->has('ubah_alamat') ? 'Status & Alamat' : 'Status';
                $pesan = "Assalamualaikum,\n\n";
                $pesan .= "Permohonan Perubahan ($pengajuan) atas nama *{$pemohonDetail->nama}*, telah berhasil diproses.\n\n";
                $pesan .= "Tautan Aksi:\n";
                $pesan .= route('aplikasi.ptsp.produk');
            } elseif ($request->status == 2) {
                // If status is 2, failed process
                $pengajuan = $request->has('ubah_alamat') ? 'Status & Alamat' : 'Status';
                $pesan = "Assalamualaikum,\n\n";
                $pesan .= "Permohonan Perubahan ($pengajuan) atas nama, *{$pemohonDetail->nama}*, gagal diproses.\n\n";
                $pesan .= "Catatan: {$request->catatan}\n\n";
                $pesan .= "Tautan Aksi:\n";
                $pesan .= route('aplikasi.ptsp.produk');
            } else {
                // If status is not 2 or 3, just return without sending WhatsApp
                return redirect()->back()->with('error', 'Status tidak memerlukan pemberitahuan WhatsApp.');
            }

            // Send the WhatsApp message using the sendWhatsappMessageCapil method
            try {
                $this->sendWhatsappMessageCapil($user->whatsapp, $pesan);
                return redirect()->back()->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Permohonan Berhasil Diproses',
                    ],
                ]);
            } catch (Exception $e) {
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Failed to upload document and update status. ' . $e->getMessage(),
                    ],
                ]);
            }
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    protected function sendWhatsappMessageCapil($number, $pesan)
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
                'message' => $pesan,
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
            throw new Exception("Failed to send WhatsApp message");
        }
    }
    
    
}
