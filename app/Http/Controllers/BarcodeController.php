<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sign;
use App\Models\User;
use App\Models\Role;
use App\Models\PemohonInformasi;
use App\Models\SignsUbahStatus;

class BarcodeController extends Controller
{
    /**
     * Handle the incoming request for scanning and get user details.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function getSignData(Request $request)
    {
        // Ambil eSign dari query parameter
        $eSign = $request->query('eSign');

        // Validasi input eSign untuk memastikan bahwa ID tidak kosong
        if (empty($eSign)) {
            return response()->json(['message' => 'Invalid eSign ID'], 400);
        }

        // Cari data berdasarkan eSign sebagai id di tabel Sign
        $signData = Sign::where('id', $eSign)->first();

        // Lihat data yang ditemukan
        if ($signData) {
            // Ambil data user berdasarkan user_id dari signData
            $user = User::with('detail')->find($signData->user_id);

            // Siapkan data untuk dikirim ke view
            $data = [
                'title'         => 'Detail Tanda Tangan Elektronik',
                'subtitle'      => 'Portal MS Lhokseumawe',
                'sidebar'       => 'Your Sidebar Data', // Ganti dengan data sidebar Anda
                'sign'          => $signData,  // Data eSign yang diambil
                'user'          => $user,      // Data user yang terkait
                'user_detail'   => $user->detail, // Detail user terkait
            ];

            // Kirim data ke view
            return view('LandingPage.Barcode.sign', $data);
        } else {
            // Jika sign tidak ditemukan, kembalikan respon dengan pesan error
            return response()->json(['message' => 'Sign data not found'], 404);
        }
    }
    
    public function getSIgnInformasi(Request $request)
    {
        $id = $request->query('eSign');

        if (empty($id)) {
            return response()->json(['message' => 'Invalid eSign ID'], 400);
        }

        // Cari data pemohon
        $pemohon = PemohonInformasi::where('id', $id)->first();

        if ($pemohon) {
            
            // Siapkan data untuk dikirim ke view
            $data = [
                'title'    => 'Penyetujuan Permohonan Informasi',
                'subtitle' => 'Portal MS Lhokseumawe',
                'pemohon'  => $pemohon,                
            ];

            // Kirim data ke view
            return view('LandingPage.Barcode.informasi', $data);
        } else {
            // Jika pemohon tidak ditemukan
            return response()->json(['message' => 'Pemohon not found'], 404);
        }
    }
    
    public function getSIgnPetugasInformasi(Request $request)
    {
        $role = Role::where('name', 'informasi')->first();

        if ($role) {
            // Ambil data user dengan role_id sesuai id role
            $users = User::where('role', $role->id)->get();

            // Validasi: Jika tidak ada user, alihkan ke 404
            if ($users->isEmpty()) {
                abort(404, 'User with role "informasi" not found.');
            }

            // Validasi: Jika lebih dari satu user, alihkan ke 404
            if ($users->count() > 1) {
                abort(404, 'More than one user found with role "informasi".');
            }

            // Jika hanya satu user, ambil user beserta detailnya
            $user = User::with('detail')->find($users->first()->id);
          
        } else {
            // Jika role tidak ditemukan
            abort(404, 'Role "informasi" not found.');
        }

        $id = $request->query('eSign');

        if (empty($id)) {
            return response()->json(['message' => 'Invalid eSign ID'], 400);
        }

        // Cari data pemohon
        $pemohon = PemohonInformasi::where('id', $id)->first();

        if ($pemohon) {
            
            // Siapkan data untuk dikirim ke view
            $data = [
                'title'    => 'Penyetujuan Permohonan Informasi',
                'subtitle' => 'Portal MS Lhokseumawe',
                'pemohon'  => $pemohon,                
                'user'  => $user,                
            ];

            return view('LandingPage.Barcode.petugasInformasi', $data);
        } else {
            // Jika pemohon tidak ditemukan
            return response()->json(['message' => 'Pemohon not found'], 404);
        }
    }

    
    public function getSignDataSiramasakan(Request $request)
    {
        // Ambil eSign dari query parameter
        $eSign = $request->query('eSign');

        // Validasi input eSign untuk memastikan bahwa ID tidak kosong
        if (empty($eSign)) {
            return response()->json(['message' => 'Invalid eSign ID'], 400);
        }

        // Cari data berdasarkan eSign sebagai id di tabel Sign
        $signData = SignsUbahStatus::where('id', $eSign)->first();

        // Lihat data yang ditemukan
        if ($signData) {
            // Ambil data user berdasarkan user_id dari signData
            $user = PemohonInformasi::find($signData->pemohon_id);

            // Siapkan data untuk dikirim ke view
            $data = [
                'title'         => 'Detail Tanda Tangan Elektronik',
                'subtitle'      => 'Portal MS Lhokseumawe',
                'sidebar'       => 'Your Sidebar Data', // Ganti dengan data sidebar Anda
                'sign'          => $signData,  // Data eSign yang diambil
                'user'          => $user,      // Data user yang terkait               
            ];

            // Kirim data ke view .blade
            return view('LandingPage.Barcode.signSiramasakan', $data);
        } else {
            // Jika sign tidak ditemukan, kembalikan respon dengan pesan error
            return response()->json(['message' => 'Sign data not found'], 404);
        }
    }
}
