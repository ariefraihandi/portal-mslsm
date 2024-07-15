<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guestbook;
use Illuminate\Support\Facades\Storage;
use Exception;

class GuestBookController extends Controller
{
    public function showBukuTamu()
    {
        $data = [
            'title' => 'Buku Tamu',
            'subtitle' => 'Portal MS Lhokseumawe',
            'meta_description' => 'Halaman Buku Tamu MS Lhokseumawe Portal.',
            'meta_keywords' => 'buku tamu, portal, MS Lhokseumawe'
        ];
     
        return view('LandingPage.bukuTamu', $data);
     
    }

    public function submit(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'satker' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'ditemui' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'required|string',
        ]);

        try {
            // Proses unggah gambar
            $imagePath = $request->file('image')->store('guestbook_images', 'public');
            $imageName = basename($imagePath);

            // Simpan data ke database
            Guestbook::create([
                'name' => $request->name,
                'pekerjaan' => $request->pekerjaan,
                'satker' => $request->satker,
                'tujuan' => $request->tujuan,
                'ditemui' => $request->ditemui,
                'image' => $imageName,
                'signature' => $request->signature,
            ]);

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Data buku tamu berhasil disimpan.',
                ],
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                ],
            ]);
        }
    }
}
