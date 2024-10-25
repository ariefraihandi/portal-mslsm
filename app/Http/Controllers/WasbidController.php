<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wasbid; 
use App\Models\User;
use App\Models\WasbidTindak;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class WasbidController extends Controller
{

    public function showWasbid(Request $request)
    {
        $accessMenus = $request->get('accessMenus');
        $id          = $request->session()->get('user_id');
        $user        = User::with('detail')->find($id); 

        // Dapatkan tanggal saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Menghitung triwulan berdasarkan bulan saat ini
        $currentQuarter = ceil($currentMonth / 3);

        // Mengambil data Wasbid berdasarkan triwulan tahun berjalan dan sorting berdasarkan tanggal terbaru
        $wasbidTriwulan = Wasbid::whereYear('tgl', $currentYear)
            ->whereRaw('QUARTER(tgl) = ?', [$currentQuarter])
            ->orderBy('created_at', 'desc')
            ->get();

        // Periksa apakah id_wasbid ada di tabel wasbid_tindak
        $wasbidIdsInTindak = WasbidTindak::pluck('id_wasbid')->toArray();

        $data = [
            'title'         => 'Temuan',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
            'wasbidTriwulan' => $wasbidTriwulan,
            'wasbidIdsInTindak' => $wasbidIdsInTindak, // Array of wasbid IDs that exist in wasbid_tindak
        ];

        return view('Wasbid.temuan', $data);
    }


    // Menyimpan data baru
    public function storeWasbid(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'bidang' => 'required|string|max:255',
            'subbidang' => 'required|string|max:255',
            'tajuk' => 'required|string|max:255',
            'kondisi' => 'required|string',
            'kriteria' => 'required|string',
            'sebab' => 'required|string',
            'akibat' => 'required|string',
            'rekomendasi' => 'required|string',
            'penangung' => 'required|string',
            'image' => 'required|file',
        ]);

        // Upload gambar menggunakan Intervention Image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $newName = Str::random(12) . '.webp';

            // Pindahkan gambar sementara ke folder temp
            $file->move(public_path('temp'), $imageName);

            // Buat instance ImageManager dan encode gambar
            $imgManager = new ImageManager(new Driver());

            $eviden = $imgManager->read('temp/' . $imageName);
          
            $encodedImage = $eviden->encode(new WebpEncoder(quality: 45));

            // Simpan gambar yang sudah di-encode ke folder pengawasan
            $encodedImage->save(public_path('assets/img/pengawasan/' . $newName));

            // Hapus gambar sementara dari folder temp
            File::delete(public_path('temp/' . $imageName));
        }    

        // Menyimpan data ke database
        Wasbid::create([
            'tgl' => $request->tgl,
            'bidang' => $request->bidang,
            'subbidang' => $request->subbidang,
            'tajuk' => $request->tajuk,
            'kondisi' => $request->kondisi,
            'kriteria' => $request->kriteria,
            'sebab' => $request->sebab,
            'pengawas' => $request->pengawas,
            'akibat' => $request->akibat,
            'rekomendasi' => $request->rekomendasi,
            'penanggung' => $request->penangung,
            'eviden' => $newName,
        ]);

        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Temuan Berhasil Dilaporkan.',
            ],
        ]); 
    }
    
    public function editWasbid(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'id' => 'required|exists:wasbid,id', // Validasi bahwa ID ada dalam database
            'tanggal_pengawasan' => 'required|date',
            'bidang' => 'required|string',
            'subbidang' => 'required|string',
            'tajuk' => 'required|string',
            'kondisi' => 'required|string',
            'kriteria' => 'required|string',
            'sebab' => 'required|string',
            'akibat' => 'required|string',
            'rekomendasi' => 'required|string',
            'pengawas' => 'required|string',
            'penanggung' => 'required|in:1,2|string',
        ]);
    
        try {
            // Cari record Wasbid berdasarkan ID dan update
            $wasbid = Wasbid::findOrFail($request->id); // Menemukan record atau gagal jika tidak ada
    
            // Update dengan mass assignment
            $wasbid->update([
                'tgl' => $request->tanggal_pengawasan,
                'bidang' => $request->bidang,
                'subbidang' => $request->subbidang,
                'tajuk' => $request->tajuk,
                'kondisi' => $request->kondisi,
                'kriteria' => $request->kriteria,
                'sebab' => $request->sebab,
                'akibat' => $request->akibat,
                'rekomendasi' => $request->rekomendasi,
                'pengawas' => $request->pengawas,
                'penanggung' => $request->penanggung,
            ]);
    
            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Temuan Berhasil Diperbaharui.',
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tangkap jika Model tidak ditemukan
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Data tidak ditemukan: ' . $e->getMessage(),
                ],
            ]);
        } catch (\Exception $e) {
            // Tangkap jika terjadi exception umum
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
                ],
            ]);
        }
    }
    
    public function editEviden(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:wasbid,id', // Memastikan ID valid
            'eviden_new' => 'nullable|file', // Validasi file tanpa batasan tipe dan ukuran, untuk satu file
        ]);
    
        try {
            // Cari data wasbid berdasarkan ID
            $wasbid = Wasbid::findOrFail($request->id);
    
            // Cek jika ada file baru yang diupload
            if ($request->hasFile('eviden_new')) {
                // Hapus eviden lama (jika ada) dari folder pengawasan
                if ($wasbid->eviden) {
                    $oldFilePath = public_path('assets/img/pengawasan/' . $wasbid->eviden);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath); // Hapus file lama
                    }
                }
    
                // Proses gambar baru
                $file = $request->file('eviden_new');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';
    
                // Pindahkan gambar sementara ke folder temp
                $file->move(public_path('temp'), $imageName);
    
                try {
                    $imgManager = new ImageManager(new Driver());

                    $eviden = $imgManager->read('temp/' . $imageName);
                
                    $encodedImage = $eviden->encode(new WebpEncoder(quality: 45));

                    // Simpan gambar yang sudah di-encode ke folder pengawasan
                    $encodedImage->save(public_path('assets/img/pengawasan/' . $newName));

                    $wasbid->eviden = $newName;                    
                    File::delete(public_path('temp/' . $imageName));
    
                    // Update eviden di database dengan nama file baru
    
                    // Hapus gambar sementara dari folder temp
                    File::delete(public_path('temp/' . $imageName));
    
                } catch (\Exception $imageException) {
                    // Tangkap kesalahan terkait pengolahan gambar dan beri feedback ke view
                    return redirect()->back()->with([
                        'response' => [
                            'success' => false,
                            'title' => 'Gagal',
                            'message' => 'Kesalahan saat mengonversi atau menyimpan gambar: ' . $imageException->getMessage(),
                        ],
                    ]);
                }
            }
    
            // Simpan perubahan
            $wasbid->save();
    
            // Kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Eviden berhasil diperbarui.',
                ],
            ]);
        } catch (\Exception $e) {
            // Tangani error umum dan beri feedback ke view
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan saat memperbarui eviden: ' . $e->getMessage(),
                ],
            ]);
        }
    }
    
    

    // Menghapus data
    public function destroy(Wasbid $wasbid)
    {
        $wasbid->delete();
        return redirect()->route('wasbid.index')->with('success', 'Wasbid berhasil dihapus');
    }
}
