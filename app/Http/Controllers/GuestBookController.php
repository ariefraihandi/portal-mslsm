<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guestbook;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Str;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'satker' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'ditemui' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max for initial upload
            'signature' => 'required|string',
        ]);

        try {
            // Proses unggah gambar
            $file           = $request->file('image');
            $imageName      = time() . '.' . $file->getClientOriginalExtension();
            $newName        = Str::random(12) . '.webp';

            $file->move('temp', $imageName);

            $imgManager     = new ImageManager(new Driver());
            $imageTemp      = $imgManager->read('temp/' . $imageName);
            $encodedImage   = $imageTemp->encode(new WebpEncoder(quality: 65));             
            $encodedImage->save(public_path('storage/guestbook_images/'. $newName));     

            unlink('temp/' . $imageName);
          
            Guestbook::create([
                'name'          => $request->name,
                'pekerjaan'     => $request->pekerjaan,
                'satker'        => $request->satker,
                'tujuan'        => $request->tujuan,
                'ditemui'       => $request->ditemui,
                'image'         => $newName,
                'signature'     => $request->signature,
            ]);

            return redirect()->back()->with([
                'response'      => [
                    'success'   => true,
                    'title'     => 'Success',
                    'message'   => 'Data buku tamu berhasil disimpan.',
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
