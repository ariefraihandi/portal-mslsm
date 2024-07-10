<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Maintenance',
            'subtitle' => 'Portal MS Lhokseumawe',
            'meta_description' => 'Portal MS Lhokseumawe is currently under maintenance. Please check back later.',
            'meta_keywords' => 'maintenance, portal, MS Lhokseumawe, under maintenance'
        ];
        
        
        return view('Maintenance.maintenance', $data);
    }
}
