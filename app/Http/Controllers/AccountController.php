<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function showAccountDetil()
    {
        $data = [
            'title' => 'Profile User',
            'subtitle' => 'Portal MS Lhokseumawe',
            'meta_description' => 'Halaman Profil User.',
            'meta_keywords' => 'Account, portal, MS Lhokseumawe'
        ];

        return view('auth.login', $data);
    }
}
