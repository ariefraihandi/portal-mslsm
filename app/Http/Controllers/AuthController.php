<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login Portal',
            'subtitle' => 'MS Lhokseumawe',
            'meta_description' => 'Login to access the MS Lhokseumawe Portal.',
            'meta_keywords' => 'login, portal, MS Lhokseumawe'
        ];

        return view('auth.login', $data);
    }
   
    public function showRegisterForm()
    {
        $data = [
            'title' => 'Register Portal',
            'subtitle' => 'Portal MS Lhokseumawe',
            'meta_description' => 'Register to access the MS Lhokseumawe Portal.',
            'meta_keywords' => 'Register, portal, MS Lhokseumawe'
        ];

        return view('auth.register', $data);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        $user = new User();
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

}
