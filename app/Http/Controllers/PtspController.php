<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perkara;
use App\Models\Role;
use App\Models\SyaratPerkara;
use App\Models\PemohonUbahStatus;
use App\Models\Feedback;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\SignsUbahStatus;
use App\Models\PemohonInformasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use PDF;
use DataTables;
use Exception;

class PtspController extends Controller
{    
    public function showInformasi(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 

        Carbon::setLocale('id');

        $bulan                          = Carbon::now()->translatedFormat('F');            
        $tahun                          = Carbon::now()->year;
        $bulanAngka                     = Carbon::now()->month;        
        $tahunBulanLalu                 = Carbon::now()->subMonth()->year;
        $bulanAngkaBulanLalu            = Carbon::now()->subMonth()->month;

        $jumlahPemohonBulanIni          = PemohonInformasi::whereYear('created_at', $tahun)
                                         ->whereMonth('created_at', $bulanAngka)
                                         ->count();

        $jumlahPemohonBulanLalu         = PemohonInformasi::whereYear('created_at', $tahunBulanLalu)
                                         ->whereMonth('created_at', $bulanAngkaBulanLalu)
                                         ->count();

        $jumlahUbahStatusBulanIni       = PemohonInformasi::whereYear('created_at', $tahun)
                                         ->whereMonth('created_at', $bulanAngka)
                                         ->where('ubah_status', 1)
                                         ->count();
                         
        $jumlahUbahStatusBulanLalu      = PemohonInformasi::whereYear('created_at', $tahunBulanLalu)
                                         ->whereMonth('created_at', $bulanAngkaBulanLalu)
                                         ->where('ubah_status', 1)
                                         ->count();

        $selisih                        = $jumlahPemohonBulanIni - $jumlahPemohonBulanLalu;
        $persentase                     = $jumlahPemohonBulanLalu > 0 ? round(($selisih / $jumlahPemohonBulanLalu) * 100, 1) : ($jumlahPemohonBulanIni > 0 ? 100 : 0);
        $selisihUbahStatus              = $jumlahUbahStatusBulanIni - $jumlahUbahStatusBulanLalu;
        $persentaseUbahStatus           = $jumlahUbahStatusBulanLalu > 0 ? round(($selisihUbahStatus / $jumlahUbahStatusBulanLalu) * 100, 1) : ($jumlahUbahStatusBulanIni > 0 ? 100 : 0);
                                     
        $data = [
            'title'                     => 'Informasi',
            'subtitle'                  => 'Portal MS Lhokseumawe',
            'sidebar'                   => $accessMenus,
            'users'                     => $user,
            'bulan'                     => $bulan,
            'jumlahPemohonBulanIni'     => $jumlahPemohonBulanIni,
            'selisih'                   => $selisih,
            'persentase'                => $persentase,
            'jumlahUbahStatusBulanIni'  => $jumlahUbahStatusBulanIni,
            'selisihUbahStatus'         => $selisihUbahStatus,
            'persentaseUbahStatus'      => $persentaseUbahStatus,
        ];
 
        return view('Ptsp.informasi', $data);
    }
   
    public function showProduk(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 
 
        $data = [
            'title'         => 'Produk',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];
 
        return view('Ptsp.produk', $data);
    }
  
    public function showKritis(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 
 
        $data = [
            'title'         => 'Kritis',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];
 
        return view('Ptsp.kritis', $data);
    }

    public function show(Request $request)
    {
        // Ambil parameter 'perkara' dari query string
        $perkaraId = $request->query('perkara');
        // Validasi jika diperlukan
        if (!$perkaraId) {
            return redirect()->back()->with('error', 'Parameter perkara tidak ditemukan.');
        }

        $perkara = Perkara::find($perkaraId);

        if (!$perkara) {
            return redirect()->back()->with('error', 'Data perkara tidak ditemukan.');
        }

        $syarat = SyaratPerkara::where('id_perkara', $perkaraId)->get();
        $data = [
            'title'         => 'Syarat',
            'subtitle'      => 'Portal MS Lhokseumawe',               
            'syarat'      => $syarat,               
            'perkara'      => $perkara,               
        ];
        
        return view('LandingPage.PTSP.syarat', $data);
    }

    public function layananMandiri()
    {
        $data = [
            'title'         => 'S-3 (Self Service System)',
            'subtitle'      => 'Portal MS Lhokseumawe',               
        ];
        
        return view('LandingPage.PTSP.layananMandiri', $data);
    }
    
    public function kirtis()
    {
        $data = [
            'title'         => 'KRITIS (Kritik & Saran Otomatis)',
            'subtitle'      => 'Portal MS Lhokseumawe',               
        ];
        
        return view('LandingPage.PTSP.kritis', $data);
    }

    public function storeKirtis(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'whatsapp' => 'required|string|max:15',
            'email'    => 'required|email|max:255',
            'kritik'   => 'nullable|string',
            'saran'    => 'nullable|string',
            'image'    => 'nullable|image|max:10048',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah identitas ingin disembunyikan
            if ($request->has('hide_identity')) {
                $nama = 'Anonim';
                $whatsapp = substr($request->whatsapp, 0, 4) . '********'; 
                $email = substr($request->email, 0, 3) . '********' . strstr($request->email, '@');
            } else {
                $nama = $request->nama;
                $whatsapp = $request->whatsapp;
                $email = $request->email;
            }

            $imageName = null;

            // Proses upload gambar jika ada
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';

                // Pindahkan gambar sementara ke folder temp
                $file->move(public_path('temp'), $imageName);

                // Menggunakan Intervention Image untuk mengonversi ke format WebP
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read(public_path('temp/' . $imageName));

                // Encode gambar ke format WebP dengan kualitas 65
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));

                // Simpan gambar ke direktori target
                $encodedImage->save(public_path('assets/img/feedbacks/' . $newName));

                // Hapus gambar sementara
                File::delete(public_path('temp/' . $imageName));

                // Set nama file gambar baru
                $imageName = $newName;
            }

            // Simpan data ke database
            Feedback::create([
                'nama'     => $nama,
                'whatsapp' => $whatsapp,
                'email'    => $email,
                'kritik'   => $request->kritik,
                'saran'    => $request->saran,
                'image'    => $imageName, // Simpan nama file saja
            ]);

            // Commit transaksi jika semua proses sukses
            DB::commit();

            // Kirim pesan WhatsApp setelah transaksi berhasil
            $pesan = "*KRITIS*\n\nNama: {$request->nama}\nWhatsApp: {$request->whatsapp}\nEmail: {$request->email}\nKritik: {$request->kritik}\nSaran: {$request->saran}";
            $this->sendWhatsappMessageCapil('081263838956', $pesan);

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title'   => 'Success',
                    'message' => 'Kritik dan saran berhasil dikirim',
                ],
            ]);
        } catch (Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title'   => 'Error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function deleteFeedback(Request $request)
    {
        // Mendapatkan ID dari URL
        $id = $request->get('id');

        // Cari feedback berdasarkan UUID yang diterima
        $feedback = Feedback::where('id', $id)->first();

        // Periksa apakah feedback ditemukan
        if (!$feedback) {
            // Jika feedback tidak ditemukan, redirect dengan pesan error
            return redirect()->back()->with('response', [
                'success' => false,
                'title' => 'Gagal!',
                'message' => 'Feedback tidak ditemukan.'
            ]);
        }

        // Mendapatkan nama file gambar yang terkait
        $imageName = $feedback->image;

        // Lokasi direktori file gambar
        $imagePath = public_path('assets/img/feedbacks/' . $imageName);

        // Hapus file gambar jika ada dan file tersebut eksis
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Hapus feedback dari database
        $feedback->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('response', [
            'success' => true,
            'title' => 'Berhasil!',
            'message' => 'Feedback berhasil dihapus.'
        ]);
    }

    public function permohonanStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|integer',
            'whatsapp' => 'required|string',
            'jenis_permohonan' => 'required|string|in:Gugatan,Permohonan',
            'pendidikan' => 'required|integer',
            'NIK' => 'required|string|unique:pemohon_informasi,NIK',
            'umur' => 'required|integer|min:1',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'nullable',
            'jenis_perkara_gugatan' => 'nullable',
            'jenis_perkara_permohonan' => 'nullable',
            'rincian_informasi' => 'nullable|string',
            'tujuan_penggunaan' => 'nullable|string',
        ]);
    
        try {
            $response = Http::get('https://app.whacenter.com/api/statusDevice', [
                'device_id' => env('DEVICE_ID', 'default_device_id'),
            ]);
    
            if (!$response->successful() || !$response->json()['status']) {
                $deviceStatus = $response->json()['data']['status'] ?? 'UNKNOWN';
                $errorMsg = $deviceStatus === 'UNKNOWN' ? 'Tidak dapat memeriksa status perangkat' : "Status perangkat: $deviceStatus";
    
                return response()->json([
                    'success' => false,
                    'message' => 'Sistem Notifikasi Otomasi Sedang dalam gangguan. Harap memberikan persyaratan secara manual. ' . $errorMsg,
                ], 500);
            }
    
            $deviceStatus = $response->json()['data']['status'];
            if ($deviceStatus !== 'CONNECTED') {
                return response()->json([
                    'success' => false,
                    'message' => 'Sistem Notifikasi Otomasi Sedang dalam gangguan. Harap memberikan persyaratan secara manual. Status perangkat: ' . $deviceStatus,
                ], 500);
            }

            $pemohon = PemohonInformasi::create([
                'nama' => $validatedData['nama'],
                'alamat' => $validatedData['alamat'],
                'pekerjaan_id' => $validatedData['pekerjaan'],
                'whatsapp' => $validatedData['whatsapp'],
                'whatsapp_connected' => $request->has('whatsapp_connected'),
                'email' => $validatedData['email'] ?? '-',
                'jenis_permohonan' => $validatedData['jenis_permohonan'],
                'jenis_perkara_gugatan' => $validatedData['jenis_permohonan'] === 'Gugatan' ? $validatedData['jenis_perkara_gugatan'] : null,
                'jenis_perkara_permohonan' => $validatedData['jenis_permohonan'] === 'Permohonan' ? $validatedData['jenis_perkara_permohonan'] : null,
                'rincian_informasi' => $validatedData['rincian_informasi'] ?? null,
                'tujuan_penggunaan' => $validatedData['tujuan_penggunaan'] ?? null,
                'ubah_status' => $request->has('ubah_status') ? '1' : null,
                'pendidikan' => $validatedData['pendidikan'],
                'NIK' => $validatedData['NIK'],
                'umur' => $validatedData['umur'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
            ]);
    
            $jenis_perkara_uuid = $validatedData['jenis_permohonan'] === 'Gugatan' ? $pemohon->jenis_perkara_gugatan : $pemohon->jenis_perkara_permohonan;
            $perkara = Perkara::find($jenis_perkara_uuid);
    
            if (!$perkara) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis perkara tidak ditemukan.',
                ], 404);
            }
    
            if ($request->has('whatsapp_connected')) {
                $this->sendWhatsappMessage($pemohon->whatsapp, $pemohon->nama, $perkara->id, $pemohon->jenis_kelamin);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil disimpan dan pesan WhatsApp berhasil dikirim.',
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function pemohonEdit(Request $request)
    {
        try {
            // Ambil data pemohon yang sudah ada berdasarkan ID
            $pemohon = PemohonInformasi::find($request->input('editId'));
    
            // Jika tidak ditemukan, kembalikan response error
            if (!$pemohon) {
                return redirect()->back()->with('response', [
                    'success' => false,
                    'title' => 'Gagal!',
                    'message' => 'Pemohon tidak ditemukan!'
                ]);
            }
    
            // Ambil data yang dikirimkan dari form (request)
            $validatedData = $request->only([
                'EditNama', 'editNIK', 'editUmur', 'EditAlamat', 'EditPekerjaan', 
                'editPendidikan', 'jenis_kelamin_edit', 'EditWhatsapp', 'EditEmail', 
                'ubah_status_edit', 'rincian_informasi_edit', 'tujuan_penggunaan_edit'
            ]);
    
            // Bandingkan dan hanya update yang berubah
            if ($pemohon->nama != $validatedData['EditNama']) {
                $pemohon->nama = $validatedData['EditNama'];
            }
            if ($pemohon->NIK != $validatedData['editNIK']) {
                $pemohon->NIK = $validatedData['editNIK'];
            }
            if ($pemohon->umur != $validatedData['editUmur']) {
                $pemohon->umur = $validatedData['editUmur'];
            }
            if ($pemohon->alamat != $validatedData['EditAlamat']) {
                $pemohon->alamat = $validatedData['EditAlamat'];
            }
            if ($pemohon->pekerjaan_id != $validatedData['EditPekerjaan']) {
                $pemohon->pekerjaan_id = $validatedData['EditPekerjaan'];
            }
            if ($pemohon->pendidikan != $validatedData['editPendidikan']) {
                $pemohon->pendidikan = $validatedData['editPendidikan'];
            }
            if ($pemohon->jenis_kelamin != $validatedData['jenis_kelamin_edit']) {
                $pemohon->jenis_kelamin = $validatedData['jenis_kelamin_edit'];
            }
            if ($pemohon->whatsapp != $validatedData['EditWhatsapp']) {
                $pemohon->whatsapp = $validatedData['EditWhatsapp'];
            }
            if ($pemohon->email != $validatedData['EditEmail']) {
                $pemohon->email = $validatedData['EditEmail'];
            }
            if ($pemohon->rincian_informasi != $validatedData['rincian_informasi_edit']) {
                $pemohon->rincian_informasi = $validatedData['rincian_informasi_edit'];
            }
            if ($pemohon->tujuan_penggunaan != $validatedData['tujuan_penggunaan_edit']) {
                $pemohon->tujuan_penggunaan = $validatedData['tujuan_penggunaan_edit'];
            }
    
            // Cek dan update status jika ada perubahan
            if ($pemohon->ubah_status != $request->has('ubah_status_edit')) {
                $pemohon->ubah_status = $request->has('ubah_status_edit') ? '1' : null;
            }
    
            // Simpan perubahan
            $pemohon->save();
    
            // Jika berhasil, kembalikan response sukses
            return redirect()->back()->with('response', [
                'success' => true,
                'title' => 'Berhasil!',
                'message' => 'Data Pemohon Berhasil Di Perbaharui.'
            ]);
        } catch (\Exception $e) {
            // Tangani jika ada error dan kembalikan response error
            return redirect()->back()->with('response', [
                'success' => false,
                'title' => 'Gagal!',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function deletePemohon(Request $request)
    {
        // Retrieve the 'id' from the query string
        $id = $request->query('id');

        // Find the pemohon record by its ID
        $pemohon = PemohonInformasi::find($id);

        if ($pemohon) {
            // Delete the record
            $pemohon->delete();
            
            // Return a response with success, title, and message
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Pemohon berhasil dihapus',
                ],
            ]);
        }

        // If the record wasn't found, return an error response
        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Error',
                'message' => 'Pemohon tidak ditemukan',
            ],
        ]);
    }

    public function uploadDocument(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Cari role ID berdasarkan nama 'DUKCAPIL'
            $roleId = Role::where('name', 'DUKCAPIL')->value('id');
    
            $user = User::where('role', $roleId)->first();
    
            if ($user) {                
                $pemohon = PemohonInformasi::find($request->input('pemohon_id'));

                if ($pemohon) {
                    $pengajuan = $request->has('ubah_alamat') ? 'Status & Alamat' : 'Status';
    
                    // Buat pesan
                    $pesan = "Assalamualaikum,\n\n";
                    $pesan .= "Pengajuan Perubahan ($pengajuan)\n";
                    $pesan .= "Atas nama, $pemohon->nama.\n\n";
                    $pesan .= "Tautan Aksi:\n";
                    $pesan .= route('aplikasi.siramasakan');
    
                    $this->sendWhatsappMessageCapil($user->whatsapp, $pesan);
    
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pemohon tidak ditemukan.',
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna dengan role DUKCAPIL tidak ditemukan.',
                ], 404);
            }
    
            $request->validate([
                'pemohon_id' => 'required|exists:pemohon_informasi,id',
                'upload_option' => 'required|in:manual,url',
                'document' => 'nullable|file|mimes:pdf|max:5120',
                'external_url' => 'nullable|url',
                'status_awal' => 'nullable|string|max:255',
                'status_baru' => 'nullable|string|max:255',
                'jalan_awal' => 'nullable|string|max:255',
                'jalan_baru' => 'nullable|string|max:255',
                'rt_rw_awal' => 'nullable|string|max:255',
                'rt_rw_baru' => 'nullable|string|max:255',
                'kel_des_awal' => 'nullable|string|max:255',
                'kel_des_baru' => 'nullable|string|max:255',
                'kec_awal' => 'nullable|string|max:255',
                'kec_baru' => 'nullable|string|max:255',
                'kab_kota_awal' => 'nullable|string|max:255',
                'kab_kota_baru' => 'nullable|string|max:255',
                'provinsi_awal' => 'nullable|string|max:255',
                'provinsi_baru' => 'nullable|string|max:255',
            ]);
    
            $url_document = null;

            if ($request->input('upload_option') === 'manual' && $request->hasFile('document')) {
                $document = $request->file('document');
                $filename = time() . '-' . $document->getClientOriginalName();
                $document->move(public_path('documents'), $filename);
                                
                $url_document = url('/') . '/documents/' . $filename;
            }
            
            if ($request->input('upload_option') === 'url') {
                $url_document = $request->input('external_url');
            }
    
            // Buat pesan tanda tangan
            $signMessage = "Saya yang bernama, " . $pemohon->nama . " dengan ini menyatakan telah mengajukan perubahan " . $pengajuan . " pada data Kependudukan Saya di Dinas Kependudukan dan Pencatatan Sipil Kota Lhokseumawe.";
    
            // Simpan pesan di tabel sign dengan user_id dari pemohon_id
            $sign = SignsUbahStatus::create([
                'pemohon_id' => $request->input('pemohon_id'), // Ambil pemohon_id sebagai user_id
                'message' => $signMessage,
            ]);
    
            PemohonUbahStatus::create([
                'id' => Str::uuid(),
                'id_pemohon' => $request->input('pemohon_id'),
                'cheklist_ubah_status' => $request->has('ubah_status'),
                'cheklist_ubah_alamat' => $request->has('ubah_alamat'),
                'url_document' => $url_document,
                'status' => 1,
                'status_awal' => $request->input('status_awal'),
                'status_baru' => $request->input('status_baru'),
                'jalan_awal' => $request->input('jalan_awal'),
                'jalan_baru' => $request->input('jalan_baru'),
                'rt_rw_awal' => $request->input('rt_rw_awal'),
                'rt_rw_baru' => $request->input('rt_rw_baru'),
                'kel_des_awal' => $request->input('kel_des_awal'),
                'kel_des_baru' => $request->input('kel_des_baru'),
                'kec_awal' => $request->input('kec_awal'),
                'kec_baru' => $request->input('kec_baru'),
                'kab_kota_awal' => $request->input('kab_kota_awal'),
                'kab_kota_baru' => $request->input('kab_kota_baru'),
                'provinsi_awal' => $request->input('provinsi_awal'),
                'provinsi_baru' => $request->input('provinsi_baru'),
                'catatan' => null,
                'id_sign' => $sign->id,
            ]);
    
            DB::commit();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Document uploaded and status updated successfully',
                ],
            ]);
        } catch (\Exception $e) {
            // Jika ada error, lakukan rollback
            DB::rollBack();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Failed to upload document and update status. ' . $e->getMessage(),
                ],
            ]);
        }
    }
    
    public function tambahSyarat(Request $request)
    {
        $idPerkara = $request->query('data');
        
        // Cari data perkara berdasarkan id
        $perkara = Perkara::find($idPerkara);
        
        if (!$perkara) {
            return redirect()->back()->with('error', 'Perkara tidak ditemukan.');
        }
        
        // Ambil data syarat berdasarkan id_perkara
        $syaratPerkara = SyaratPerkara::where('id_perkara', $idPerkara)->get();

        $data = [
            'title'         => 'Tambah Syarat',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'perkara'       => $perkara,
            'syaratPerkara' => $syaratPerkara // Pass syaratPerkara ke view
        ];
        
        // Tampilkan view dengan data perkara dan syarat
        return view('LandingPage.PTSP.tambahSyarat', $data);
    }

    public function storeSyarat(Request $request)
    {
        try {
            // Validasi input dari form
            $validated = $request->validate([
                'name_syarat' => 'required|string|max:255',
                'discretion_syarat' => 'required|string',
                'url_syarat' => 'required',
                'id_perkara' => 'required|exists:perkara,id'
            ]);
    
            // Cari jumlah syarat yang sudah ada untuk id_perkara yang sama
            $lastUrutan = SyaratPerkara::where('id_perkara', $validated['id_perkara'])
                            ->max('urutan'); // Mendapatkan urutan terbesar untuk id_perkara tertentu
    
            // Set urutan baru, jika belum ada syarat, mulai dari 1
            $newUrutan = $lastUrutan ? $lastUrutan + 1 : 1;
    
            // Simpan data syarat ke database
            SyaratPerkara::create([
                'name_syarat' => $validated['name_syarat'],
                'discretion_syarat' => $validated['discretion_syarat'],
                'url_syarat' => $validated['url_syarat'],
                'id_perkara' => $validated['id_perkara'],
                'urutan' => $newUrutan,
            ]);
    
            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Syarat berhasil disimpan',
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kembalikan JSON dengan pesan kesalahan
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Jika ada exception lain, kembalikan dengan pesan error
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Terjadi kesalahan saat menyimpan syarat',
                ],
            ]);
        }
    }

    public function updateSyarat(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'id' => 'required|exists:syarat_perkara,id',  // Validasi id syarat
            'name_syarat' => 'required|string|max:255',
            'discretion_syarat' => 'required|string',
            'url_syarat' => 'required',
        ]);

        // Cari syarat berdasarkan ID
        $syarat = SyaratPerkara::findOrFail($validated['id']);

        // Update data syarat
        $syarat->update([
            'name_syarat' => $validated['name_syarat'],
            'discretion_syarat' => $validated['discretion_syarat'],
            'url_syarat' => $validated['url_syarat'],
        ]);

        // Redirect back dengan pesan sukses
        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Success',
                'message' => 'Berhasil Diubah',
            ],
        ]);
    }

    public function destroySyarat(Request $request)
    {
        // Ambil ID dari query string
        $id = $request->query('id');
        // Cari syarat berdasarkan ID
        $syarat = SyaratPerkara::findOrFail($id);

        // Hapus syarat
        $syarat->delete();

        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Success',
                'message' => 'Berhasil Diubah',
            ],
        ]);
    }

    public function moveUp($id)
    {
        // Ambil data syarat yang dipilih berdasarkan ID
        $syarat = SyaratPerkara::find($id);
        
        if ($syarat && $syarat->urutan > 1) {
            // Cari syarat dengan urutan satu nomor lebih kecil
            $syaratAbove = SyaratPerkara::where('urutan', $syarat->urutan - 1)->first();
            
            if ($syaratAbove) {
                // Tukar urutan
                $syaratAbove->urutan += 1;
                $syarat->urutan -= 1;
                
                $syaratAbove->save();
                $syarat->save();
            } else {
                // Jika tidak ada elemen di atasnya, cukup kurangi urutan
                $syarat->urutan -= 1;
                $syarat->save();
            }
            
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Syarat moved up successfully',
                ],
            ]);
        }

        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Error',
                'message' => 'Failed to move syarat up',
            ],
        ]);
    }

    public function moveDown($id)
    {
        // Ambil data syarat yang dipilih berdasarkan ID
        $syarat = SyaratPerkara::find($id);
        
        if ($syarat) {
            // Cari syarat dengan urutan satu nomor lebih besar
            $syaratBelow = SyaratPerkara::where('urutan', $syarat->urutan + 1)->first();
            
            if ($syaratBelow) {
                // Tukar urutan
                $syaratBelow->urutan -= 1;
                $syarat->urutan += 1;
                
                $syaratBelow->save();
                $syarat->save();
            } else {
                // Jika tidak ada elemen di bawahnya, cukup tambah urutan
                $syarat->urutan += 1;
                $syarat->save();
            }
            
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Syarat moved down successfully',
                ],
            ]);
        }
    
        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Error',
                'message' => 'Failed to move syarat down',
            ],
        ]);
    }    
    
    public function perkaraStore(Request $request)
    {
        // Validasi data
        $request->validate([
            'perkara_name' => 'required|string|max:255',
            'perkara_jenis' => 'required|string'
        ]);

        // Simpan data ke database
        Perkara::create([
            'perkara_name' => $request->perkara_name,
            'perkara_jenis' => $request->perkara_jenis
        ]);

        return response()->json(['success' => 'Perkara berhasil ditambahkan!']);
    }

    public function updatePerkara(Request $request, $id)
    {
        $request->validate([
            'perkara_name' => 'required|string|max:255',
            'perkara_jenis' => 'required|string|max:255',
        ]);

        // Cari data perkara berdasarkan ID
        $perkara = Perkara::findOrFail($id);

        // Update data
        $perkara->update([
            'perkara_name' => $request->perkara_name,
            'perkara_jenis' => $request->perkara_jenis
        ]);

        return response()->json(['success' => 'Perkara berhasil diupdate!']);
    }

    public function deletePerkara(Request $request)
    {
        // Tangkap ID dari query string
        $id = $request->query('id');

        // Ambil data perkara berdasarkan ID
        $perkara = Perkara::find($id);

        // Jika perkara ditemukan, ambil data syarat perkara terkait
        if ($perkara) {
            $syaratPerkara = SyaratPerkara::where('id_perkara', $id)->get();

            // Proses penghapusan atau tindakan lain yang diperlukan
            // Misalnya, Anda bisa menghapus semua syarat terkait dan perkara
            $syaratPerkara->each(function($syarat) {
                $syarat->delete();
            });

            // Hapus perkara setelah syarat-syaratnya dihapus
            $perkara->delete();

            // Kembalikan respons sukses
            return response()->json(['success' => true, 'message' => 'Perkara dan syarat terkait telah dihapus.']);
        } else {
            // Jika perkara tidak ditemukan, kembalikan respons gagal
            return response()->json(['success' => false, 'message' => 'Perkara tidak ditemukan.']);
        }
    }

    public function getPerkaraData()
    {
        // Ambil data perkara
        $perkara = Perkara::select(['id', 'perkara_name', 'perkara_jenis']);
        
        return DataTables::of($perkara)
            ->addColumn('syarat', function($row) {
                // Hitung jumlah syarat manual berdasarkan id_perkara
                $jumlahSyarat = SyaratPerkara::where('id_perkara', $row->id)->count();
                return $jumlahSyarat; // Mengembalikan jumlah syarat untuk ditampilkan di kolom
            })
            ->addColumn('action', function($row) {
                return '
                    <a href="#" class="edit-btn" data-id="'.$row->id.'" data-name="'.$row->perkara_name.'" data-jenis="'.$row->perkara_jenis.'" title="Edit">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    <a href="#" class="delete-btn text-danger" data-url="/delete/perkara?id='.$row->id.'" title="Delete">
                        <i class="bx bx-trash"></i>
                    </a>
                    <a href="'.route('tambah.syarat', ['data' => $row->id]).'" class="tambah-syarat-btn text-success" title="Tambah Syarat">
                        <i class="bx bx-plus-circle"></i>
                    </a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getJenisPerkara(Request $request)
    {
        // Ambil data berdasarkan tipe perkara (Gugatan atau Permohonan)
        $jenisPerkara = Perkara::select('id', 'perkara_name')
            ->where('perkara_jenis', $request->tipe)
            ->get();

        // Mengembalikan data dalam format JSON
        return response()->json($jenisPerkara);
    }   

    public function getPemohonInformasiData(Request $request)
    {
        if ($request->ajax()) {
            $data = PemohonInformasi::query()
                ->select([
                    'id', 'nama', 'whatsapp', 'jenis_perkara_gugatan', 
                    'jenis_perkara_permohonan', 'pekerjaan_id', 
                    'pendidikan', 'email', 'NIK', 'alamat', 'ubah_status'
                ])
                ->orderBy('created_at', 'desc'); 
    
            if ($search = $request->input('search.value')) {
                $data->where(function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%$search%")
                          ->orWhere('whatsapp', 'LIKE', "%$search%")
                          ->orWhere('email', 'LIKE', "%$search%")
                          ->orWhere('NIK', 'LIKE', "%$search%");
                });
            }
    
            return DataTables::of($data)
                ->addColumn('pemohon', function ($row) {                    
                    return $row->nama . '<br>' .
                        $row->whatsapp . '<br>' .
                        ($row->email ? $row->email . '<br>' : '') .
                        $row->NIK;
                })
                ->addColumn('detail', function ($row) {
                    $pekerjaan = Pekerjaan::find($row->pekerjaan_id);
                    $pendidikan = Pendidikan::find($row->pendidikan);
                    $nama_pekerjaan = $pekerjaan ? $pekerjaan->nama_pekerjaan : '-';
                    $nama_pendidikan = $pendidikan ? $pendidikan->name : '-';
                
                    return 'Pekerjaan: ' . $nama_pekerjaan . '<br>' .
                           'Pendidikan: ' . $nama_pendidikan . '<br>' .
                           'Alamat: ' . $row->alamat;
                })       
                ->addColumn('perkara', function ($row) {
                    // Ambil nama perkara berdasarkan jenis perkara
                    $perkara_id = $row->jenis_perkara_gugatan ?? $row->jenis_perkara_permohonan;
                    $perkara = Perkara::find($perkara_id);
                    $perkara_name = $perkara ? $perkara->perkara_name : '-';
    
                    return $perkara_name;
                })         
                ->addColumn('actions', function ($row) {
                    // Tambahkan aksi download, edit, dan delete
                    return '                      
                       <a href="' . route('cetak.permohonan', $row->id) . '" target="_blank" class="btn btn-success btn-sm">
                            <i class="bx bx-download"></i>
                        </a><br><br>
                         <button type="button" class="btn btn-warning btn-sm" onclick="showModal(' . $row->id . ')">
                            <i class="bx bx-edit"></i>
                        </button><br><br> 
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row->id . ')">
                            <i class="bx bx-trash"></i>
                        </button>                     
                    ';
                })               
                ->rawColumns(['pemohon', 'perkara', 'detail', 'actions'])
                ->make(true);
        }
    }
    
    public function getPemohonInfo($id)
    {
        // Ambil data pemohon dengan relasi pekerjaan
        $pemohon = PemohonInformasi::with('pekerjaan')->find($id);

        // Ambil semua opsi pekerjaan dan pendidikan
        $pekerjaanOptions = Pekerjaan::all();
        $pendidikanOptions = Pendidikan::all(); // Ambil data pendidikan

        // Kirim data dalam format JSON
        return response()->json([
            'pemohon' => $pemohon,
            'pekerjaanOptions' => $pekerjaanOptions,
            'pendidikanOptions' => $pendidikanOptions // Tambahkan opsi pendidikan
        ]);
    }

    public function getPerkaraNameById($id)
    {
        $perkara = Perkara::find($id);
        if ($perkara) {
            return response()->json($perkara);
        }
        return response()->json(['perkara_name' => 'Nama perkara tidak ditemukan'], 404);
    }
    
    public function getPemohonUbahDataData(Request $request)
    {
        if ($request->ajax()) {
            $data = PemohonInformasi::whereNotNull('ubah_status')
                                    ->where('ubah_status', 1)
                                    ->select([
                                        'id', 'nama', 'whatsapp', 'jenis_perkara_gugatan', 
                                        'jenis_perkara_permohonan', 'pekerjaan_id', 'pendidikan', 
                                        'email', 'NIK', 'alamat', 'ubah_status'
                                    ])->orderBy('created_at', 'desc'); 
    
            return DataTables::of($data)
                ->addColumn('pemohon', function ($row) {
                    // Combine 'nama', 'whatsapp', 'email', and 'NIK' in one column
                    return $row->nama . '<br>' . 
                           $row->whatsapp . '<br>' . 
                           ($row->email ? $row->email . '<br>' : '') . 
                           $row->NIK;
                })
                ->addColumn('perkara', function ($row) {
                    $perkara_id = $row->jenis_perkara_gugatan ?? $row->jenis_perkara_permohonan;
    
                    // Fetch the corresponding 'perkara_name' from the Perkara model
                    $perkara = Perkara::find($perkara_id);
                    return $perkara ? $perkara->perkara_name : '-';
                })
                ->addColumn('status', function ($row) {
                    $ubahStatus = PemohonUbahStatus::where('id_pemohon', $row->id)->first();
                
                    if ($ubahStatus) {
                        // Cek status dan tampilkan badge yang sesuai
                        switch ($ubahStatus->status) {
                            case '1':
                                // Status: Sedang diproses
                                return '<span class="badge bg-primary">Sedang Diproses</span>';
                            case '2':
                                // Status: Gagal Proses, tampilkan juga catatan jika ada
                                return '<span class="badge bg-danger">Gagal Proses</span><br>' . ($ubahStatus->catatan ?? '');
                            case '3':
                                // Status: Selesai Proses tapi belum diambil
                                return '<span class="badge bg-warning">Selesai Proses<br><br>Belum Ambil</span>';
                            case '4':
                                // Status: SUCCESS
                                return '<span class="badge bg-success">SUCCESS</span>';
                            case '5':
                                // Status: Gagal Proses, tampilkan juga catatan jika ada
                                return '<span class="badge bg-danger">Diabatalkan</span><br>' . ($ubahStatus->catatan ?? '');
                            default:
                                // Jika status tidak dikenal atau kosong
                                return '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                        }
                    }
                
                    // Jika belum ada data ubah status
                    return '<span class="badge bg-info">Belum Diproses</span>';
                })
                ->addColumn('actions', function ($row) {
                    $ubahStatus = PemohonUbahStatus::where('id_pemohon', $row->id)->first();
                    
                    $actions = '';
                
                    // Tampilkan tombol "Upload" jika belum ada data ubah status
                    if (!$ubahStatus || $ubahStatus->status == '2') {
                        $actions .= '
                            <button type="button" class="btn btn-warning btn-sm mb-3" onclick="openUploadModal(' . $row->id . ')">
                                <i class="bx bx-upload"></i>
                            </button>
                        ';
                    }
                
                    if ($ubahStatus && $ubahStatus->status == '1') {
                        $actions .= '
                            <button type="button" class="btn btn-danger btn-sm mb-3" onclick="cancelSubmission(' . $row->id . ')">
                                <i class="bx bx-x"></i>
                            </button>
                        ';
                    }
                
                    return $actions;
                })
                
                ->rawColumns(['pemohon', 'perkara', 'status', 'actions'])
                ->make(true);
        }
    }

    public function batalkanPengajuan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pemohon_ubahstatus,id_pemohon',
            'reason' => 'required|string|max:255',
        ]);

        // Ambil data berdasarkan ID
        $pemohonStatus = PemohonUbahStatus::where('id_pemohon', $request->id)->first();

        if ($pemohonStatus) {
            // Update status dan catatan
            $pemohonStatus->status = 5;
            $pemohonStatus->catatan = $request->reason;
            $pemohonStatus->save();

            // Cari pengguna DUKCAPIL
            $roleId = Role::where('name', 'DUKCAPIL')->value('id');
            $user = User::where('role', $roleId)->first();

            if ($user) {
                // Ambil data pemohon untuk pesan
                $pemohon = PemohonInformasi::find($request->id);

                // Format pesan WhatsApp
                $pesan = "Assalamualaikum,\n\n";
                $pesan .= "Pengajuan Perubahan Identitas telah DIBATALKAN.\n";
                $pesan .= "Atas nama: {$pemohon->nama}.\n";
                $pesan .= "Alasan pembatalan: {$request->reason}.\n\n";
                $pesan .= "Tautan Aksi:\n";
                $pesan .= route('aplikasi.siramasakan');

                // Kirim pesan WhatsApp
                $this->sendWhatsappMessageCapil($user->whatsapp, $pesan);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui menjadi dibatalkan dan pesan telah dikirim ke DUKCAPIL.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data pemohon tidak ditemukan.',
            ]);
        }
    }

    public function kritirData(Request $request)
    {
        if ($request->ajax()) {
            $data = Feedback::all(); // Ambil semua data feedback
            return DataTables::of($data)
                ->addColumn('actions', function($row) {
                    return '
                    <button type="button" class="btn btn-danger btn-sm mb-3" onclick="confirmDelete(\'' . $row->id . '\')">
                        <i class="bx bx-trash"></i> Hapus
                    </button>
                ';
                
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('feedback.index'); // Ganti dengan view yang sesuai
    }

    public function cetakPermohonanInformasi(Request $request, $id)
    {               
        $pemohon = PemohonInformasi::with('pekerjaan')->findOrFail($id);
    
        if (!$pemohon) {
            return abort(404, 'Data not found');
        }       
    
        // Generate QR Code
        $urlToBarcodePemohon = route('barcode.scan.informasi') . '?eSign=' . urlencode($pemohon->id);
        $qrCodePemohon = base64_encode(QrCode::format('svg')
            ->size(70)
            ->errorCorrection('M')
            ->generate($urlToBarcodePemohon));
        
        $urlToBarcodePetugas = route('barcode.scan.petugas.info') . '?eSign=' . urlencode($pemohon->id);
        $qrCodePetugas = base64_encode(QrCode::format('svg')
            ->size(70)
            ->errorCorrection('M')
            ->generate($urlToBarcodePetugas));
    
        $createdAtFormatted = \Carbon\Carbon::parse($pemohon->created_at)->translatedFormat('d F Y');
    
        $data = [
            'pemohon' => $pemohon,            
            'qrCodePemohon' => $qrCodePemohon,
            'qrCodePetugas' => $qrCodePetugas,
            'createdAtFormatted' => $createdAtFormatted 
        ];
            
        $pdf = PDF::loadView('Ptsp.cetakInformasi', $data);
    
        // Return the PDF for download
        return $pdf->stream('Bukti Pengajuan Permohonan Informasi Atas Nama ' . $pemohon->nama . '.pdf');
    }
    
    
    protected function sendWhatsappMessage($number, $name, $jenis_perkara_uuid, $jenis_kelamin)
    {
        $device_id = env('DEVICE_ID', 'somedefaultvalue');
        
        // Fetch the perkara details using the UUID
        $perkara = Perkara::where('id', $jenis_perkara_uuid)->first();

        if (!$perkara) {
            throw new Exception("Perkara not found");
        }

        // Generate the URL for the requirements using the UUID of the perkara
        $syaratUrl = url('syarat') . '?perkara=' . $perkara->id;

        // Determine salutation based on gender
        $salutation = $jenis_kelamin === 'Perempuan' ? 'ibu' : 'bapak';

        // Customize the message
        $message = "Assalamualaikum, {$salutation} *{$name}*\n\n";
        $message .= "Berikut adalah syarat yang harus dilengkapi untuk mendaftarkan perkara: *{$perkara->perkara_name}*.\n\n";
        $message .= "Persyaratan dapat diakses melalui tautan berikut:\n\n";
        $message .= "{$syaratUrl}\n\n";
        $message .= "*WhatsApp ini hanya bersifat notifikasi.*\n";
        $message .= "Jika ada pertanyaan lebih lanjut, {$salutation} bisa menghubungi nomor berikut:\n";
        $message .= "📞 wa.me/6281263838956 (Linda, MS Lhokseumawe)";

        // Build the CURL request
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
            throw new Exception("Failed to send WhatsApp message");
        }
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
