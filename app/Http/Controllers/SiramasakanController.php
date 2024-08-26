<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SiramasakanController extends Controller
{
   
   public function index(Request $request)
   {
       $accessMenus        = $request->get('accessMenus');
       $id                 = $request->session()->get('user_id');
       $user               = User::with('detail')->find($id); 

       $data = [
           'title'         => 'Siramasakan',
           'subtitle'      => 'Portal MS Lhokseumawe',
           'sidebar'       => $accessMenus,
           'users'         => $user,
       ];

       return view('Siramasakan.index', $data);
   }

}
