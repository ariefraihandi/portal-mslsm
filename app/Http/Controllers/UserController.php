<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Session;
use App\Models\UserActivity;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public function showAccount(Request $request)
    {
        $accessMenus = $request->get('accessMenus');
        $id = $request->session()->get('user_id');
        $user = User::with('detail')->find($id); // Mengambil user beserta detailnya
        $sessions = Session::where('user_id', $id)->get();

        $data = [
            'title' => 'Profile',
            'subtitle' => 'Portal MS Lhokseumawe',
            'sidebar' => $accessMenus,
            'users' => $user,
            'sessions' => $sessions,
        ];

        return view('Account.detil', $data);
    }
   
    public function showActivity(Request $request)
    {
        $accessMenus        = $request->get('accessMenus');
        $id                 = $request->session()->get('user_id');
        $user               = User::with('detail')->find($id); // Mengambil user beserta detailnya
        $sessions           = Session::where('user_id', $id)->orderBy('last_activity', 'desc')->take(3)->get();
        $activities         = UserActivity::where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();

        foreach ($sessions as $session) {
            $session->deviceIcon = $this->getDeviceIcon($session->user_agent);
            $session->browserIcon = $this->getBrowserIcon($session->user_agent);
        }

        foreach ($activities as $activity) {
            $activity->deviceIcon = $this->getDeviceIcon($activity->device_info);
            $activity->browserIcon = $this->getBrowserIcon($activity->device_info);
        }

        $data = [
            'title' => 'Activity',
            'subtitle' => 'Portal MS Lhokseumawe',
            'sidebar' => $accessMenus,
            'users' => $user,
            'sessions' => $sessions,
            'activities' => $activities,
        ];

        return view('Account.activity', $data);
    }


    //Editing
        public function uploadAvatar(Request $request)
        {
            // Validasi file
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            ]);
        
            if ($validator->fails()) {
                return redirect()->route('user.account.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal Merubah Avatar',
                        'message' => 'Avatar tidak sesuai',
                    ],
                ]);
            }
        
            if ($request->hasFile('avatar')) {
                $user = Auth::user();
                $oldImage = $user->detail->image; // Ambil nama gambar lama dari kolom image di UserDetail
        
                if ($oldImage !== 'default.webp') {
                    // Hapus gambar lama jika bukan default.webp
                    if (file_exists(public_path('assets/img/avatars/' . $oldImage))) {
                        unlink(public_path('assets/img/avatars/' . $oldImage));
                    }
                }
        
                $file = $request->file('avatar');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';
        
                $file->move('temp', $imageName);
        
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read('temp/' . $imageName);
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
                $encodedImage->save(public_path('assets/img/avatars/'. $newName));     
        
                // Hapus gambar sementara
                unlink('temp/' . $imageName);
        
                // Update kolom image di tabel user_detail
                $user->detail->update(['image' => $newName]);

                UserActivity::create([
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'activity' => 'Gambar Profil Diubah',
                    'description' => 'Pengguna mengubah gambar profil.',
                    'device_info' => $request->header('User-Agent'),
                ]);
        
                return redirect()->route('user.account.detil')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Avatar diubah',
                    ],
                ]);
            }
        
            return redirect()->route('user.account.detil')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal Merubah Avatar',
                    'message' => 'Gagal mengunggah avatar',
                ],
            ]);
        }
    
        public function accountUpdate(Request $request)
        {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'multiStepsName' => 'required|string|max:255',
                'multiStepsUsername' => 'required|string|max:255|unique:users,username,' . Auth::id(),
                'multiStepsEmail' => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'whatsapp' => 'nullable|string|max:15',
                'gender' => 'required|string|in:L,P',
                'dob' => 'required|date',
                'tlahir' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'instansi' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'posisi' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Validation Error',
                        'message' => $validator->errors()->first(),
                    ],
                ]);
            }
    
            DB::beginTransaction();
    
            try {
                // Ambil user yang sedang login
                $user = Auth::user();
    
                // Update data di tabel users
                $user->update([
                    'username' => $request->input('multiStepsUsername'),
                    'email' => $request->input('multiStepsEmail'),
                    'whatsapp' => $request->input('whatsapp'),
                ]);
    
                // Update data di tabel users_detail
                $user->detail()->update([
                    'name' => $request->input('multiStepsName'),
                    'kelamin' => $request->input('gender'),
                    'tglahir' => $request->input('dob'),
                    'tlahir' => $request->input('tlahir'),
                    'alamat' => $request->input('alamat'),
                    'instansi' => $request->input('instansi'),
                    'jabatan' => $request->input('jabatan'),
                    'posisi' => $request->input('posisi'),
                ]);

                
                UserActivity::create([
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'activity' => 'Detail Profil Diubah',
                    'description' => 'Pengguna mengubah detail profil.',
                    'device_info' => $request->header('User-Agent'),
                ]);
    
                DB::commit();
    
                return redirect()->back()->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Detail User Berhasil Diperbarui',
                    ],
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
    
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Update Failed',
                        'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
                    ],
                ]);
            }
        }
    //!Editing

     private function getDeviceIcon($userAgent)
    {
        $mobileDevices = ['Android', 'webOS', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 'IEMobile', 'Opera Mini'];
        foreach ($mobileDevices as $device) {
            if (strpos($userAgent, $device) !== false) {
                return 'bx bxs-devices'; // Mobile icon
            }
        }
        return 'bx bx-laptop'; // Desktop icon
    }

    private function getBrowserIcon($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) {
            return 'bx bxl-firefox';
        } elseif (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
            return 'bx bxl-chrome';
        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
            return 'bx bxl-apple';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            return 'bx bxl-edge';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'bx bxl-edge';
        } else {
            return 'bx bx-question-mark'; // Unknown browser icon
        }
    }
}
