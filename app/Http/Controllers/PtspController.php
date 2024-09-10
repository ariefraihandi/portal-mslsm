<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perkara;
use App\Models\SyaratPerkara;
use App\Models\PemohonInformasi;
use DataTables;

class PtspController extends Controller
{    
    public function index(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 
 
        $data = [
            'title'         => 'Informasi',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];
 
        return view('Ptsp.informasi', $data);
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
            'title'         => 'Layanan Mandiri',
            'subtitle'      => 'Portal MS Lhokseumawe',               
        ];
        
        return view('LandingPage.PTSP.layananMandiri', $data);
    }

    public function permohonanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|integer',
            'whatsapp' => 'required|string',
            'jenis_permohonan' => 'required|string',
            'pendidikan' => 'required|integer',
            'NIK' => 'required|string|unique:pemohon_informasi,NIK',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);
    
        try {
            // Create the pemohon record
            $pemohon = PemohonInformasi::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'pekerjaan_id' => $request->pekerjaan,
                'whatsapp' => $request->whatsapp,
                'whatsapp_connected' => $request->has('whatsapp_connected'),
                'email' => $request->email,
                'jenis_permohonan' => $request->jenis_permohonan,
                'jenis_perkara_gugatan' => $request->jenis_permohonan === 'Gugatan' ? $request->jenis_perkara_gugatan : null,
                'jenis_perkara_permohonan' => $request->jenis_permohonan === 'Permohonan' ? $request->jenis_perkara_permohonan : null,
                'rincian_informasi' => $request->input('rincian_informasi'),
                'tujuan_penggunaan' => $request->input('tujuan_penggunaan'),
                'ubah_status' => $request->has('ubah_status') ? '1' : null,
                'pendidikan' => $request->pendidikan,
                'NIK' => $request->NIK,
                'umur' => $request->umur,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);
    
            // Determine which perkara UUID to use
            $jenis_perkara_uuid = $request->jenis_permohonan === 'Gugatan' ? $pemohon->jenis_perkara_gugatan : $pemohon->jenis_perkara_permohonan;
    
            // Fetch the perkara details using the UUID
            $perkara = Perkara::where('id', $jenis_perkara_uuid)->first();
    
            if (!$perkara) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perkara tidak ditemukan.',
                ], 404);
            }
    
            if ($request->has('whatsapp_connected')) {
                // Send WhatsApp message with the correct perkara information
                $this->sendWhatsappMessage($pemohon->whatsapp, $pemohon->nama, $perkara->id, $pemohon->jenis_kelamin);
            }
    
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil disimpan dan pesan WhatsApp berhasil dikirim.',
            ]);
    
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
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
            $data = PemohonInformasi::select(['id', 'nama', 'NIK', 'alamat', 'ubah_status']);
            return DataTables::of($data)
                ->addColumn('actions', function ($row) {
                    // Customize your action buttons here
                    return '<a href="" class="btn btn-primary btn-sm">View</a>';
                })
                ->addColumn('download', function ($row) {
                    // Customize your download button here
                    return '<a href="" class="btn btn-success btn-sm">Download</a>';
                })
                ->editColumn('ubah_status', function ($row) {
                    // Show the status, could be as a label or status text
                    return $row->ubah_status ? 'Aktif' : 'Tidak Aktif';
                })
                ->rawColumns(['actions', 'download'])
                ->make(true);
        }
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
        $message .= "Berikut adalah syarat yang harus dilengkapi untuk mendaftarkan perkara: {$perkara->perkara_name}.\n\n";
        $message .= "Persyaratan dapat diakses melalui tautan berikut:\n\n {$syaratUrl}";

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
}
