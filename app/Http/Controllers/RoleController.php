<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function showRole(Request $request)
    {
        // $accessMenus        = $request->get('accessMenus');          
        $roles              = Role::where('id', '!=', 1)->with('users')->get();
        $menus              = Menu::all();
        $subMenus           = MenuSub::all();
        $childMenus         = MenuSubChild::all();

        $data = [
            'title'         => 'Role Access',
            'subtitle'      => 'Bilik Hukum',
            'roles'         => $roles,
            'sidebar'       => $accessMenus,
            'menus'         => $menus,
            'subMenus'      => $subMenus,
            'childMenus'    => $childMenus,
        ];
        
        return view('Role.roleAccess', $data);
    }
}
