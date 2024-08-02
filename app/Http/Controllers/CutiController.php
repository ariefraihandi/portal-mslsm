<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CutiSisa;
use App\Models\UserDetail;
use App\Models\User;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CutiController extends Controller
{
    public function showCutiSisa(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); 

        $data = [
            'title'         => 'Sisa Cuti Pegawai',
            'subtitle'      => 'Portal MS Lhokseumawe',
            'sidebar'       => $accessMenus,
            'users'         => $user,
        ];

        return view('Kepegawaian.cutiSisa', $data);
    }

    public function editCutiSisa(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users_detail,user_id',
            'cuti_n1' => 'required|integer|min:0',
            'cuti_n2' => 'required|integer|min:0',
            'cuti_n3' => 'required|integer|min:0',
            'cuti_sakit' => 'required|integer|min:0',
            'cap' => 'required|integer|min:0',
            'cuti_besar' => 'required|integer|min:0',
            'cuti_melahirkan' => 'required|integer|min:0',
        ]);

        $cutiSisa = CutiSisa::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'cuti_n' => $request->cuti_n1,
                'cuti_nsatu' => $request->cuti_n2,
                'cuti_ndua' => $request->cuti_n3,
                'cuti_s' => $request->cuti_sakit,
                'cuti_ap' => $request->cap,
                'cuti_b' => $request->cuti_besar,
                'cuti_m' => $request->cuti_melahirkan,
            ]
        );

        $userName = UserDetail::where('user_id', $request->user_id)->value('name');

        return response()->json(['message' => 'Sisa cuti berhasil diperbarui', 'userName' => $userName]);
    }

    public function sisaCutigetData(Request $request)
    {
        if ($request->ajax()) {
            static $counter = 0;
            $counter = 0; // Reset counter setiap kali permintaan AJAX dilakukan

            $data = UserDetail::select([
                'users_detail.id',
                'users_detail.user_id',
                'users_detail.name',
                'users_detail.image',
                'users_detail.jabatan',
            ])
            ->join('jabatan', 'users_detail.jabatan', '=', 'jabatan.name')
            ->with(['cutiSisa'])
            ->orderBy('jabatan.id', 'asc') // Mengurutkan berdasarkan jabatan.id
            ->get();

            return Datatables::of($data)
                ->addColumn('no', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('pegawai', function ($user) {
                    $userImage = $user->image ? asset('assets/img/avatars/' . $user->image) : asset('assets/img/avatars/default-image.jpg');
                    $userName = $user->name ?? 'Unknown User';
                    $userJabatan = $user->jabatan ?? 'Unknown Position';

                    $output = '
                        <div class="d-flex align-items-center">
                            <img src="' . $userImage . '" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <span class="fw-bold">' . e($userName) . '</span>
                                <small class="text-muted d-block">' . e($userJabatan) . '</small>
                            </div>
                        </div>';

                    return $output;
                })
                ->addColumn('cutinsatu', function ($user) {
                    return $user->cutiSisa->cuti_n ?? 0;
                })
                ->addColumn('cutindua', function ($user) {
                    return $user->cutiSisa->cuti_nsatu ?? 0;
                })
                ->addColumn('cutintiga', function ($user) {
                    return $user->cutiSisa->cuti_ndua ?? 0;
                })
                ->addColumn('cs', function ($user) {
                    return $user->cutiSisa->cuti_s ?? 0;
                })
                ->addColumn('cap', function ($user) {
                    return $user->cutiSisa->cuti_ap ?? 0;
                })
                ->addColumn('cb', function ($user) {
                    return $user->cutiSisa->cuti_b ?? 0;
                })
                ->addColumn('cm', function ($user) {
                    return $user->cutiSisa->cuti_m ?? 0;
                })
                ->addColumn('action', function ($user) {
                    return '<i class="fas fa-edit" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#sisaCutiModal" 
                    data-id="' . $user->user_id . '" 
                    data-name="' . e($user->name) . '"
                    data-cutinsatu="' . ($user->cutiSisa->cuti_n ?? 0) . '"
                    data-cutindua="' . ($user->cutiSisa->cuti_nsatu ?? 0) . '"
                    data-cutintiga="' . ($user->cutiSisa->cuti_ndua ?? 0) . '"
                    data-cs="' . ($user->cutiSisa->cuti_s ?? 0) . '"
                    data-cap="' . ($user->cutiSisa->cuti_ap ?? 0) . '"
                    data-cb="' . ($user->cutiSisa->cuti_b ?? 0) . '"
                    data-cm="' . ($user->cutiSisa->cuti_m ?? 0) . '"></i>';
                })
                ->rawColumns(['pegawai', 'action'])
                ->make(true);
        }
    }

    
}
