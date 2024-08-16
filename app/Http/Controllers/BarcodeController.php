<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    /**
     * Handle the incoming request for scanning.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function scan(Request $request)
    {
        // Get the 'eSign' query parameter from the URL
        $eSign = $request->query('eSign');

        // You can now use $eSign to display data or perform actions
        return view('scan', ['eSign' => $eSign]);
    }
}
