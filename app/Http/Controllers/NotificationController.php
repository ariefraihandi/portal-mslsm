<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use App\Models\UserActivity;
use OneSignal;

class NotificationController extends Controller
{
    public function checkDivice(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        $existingDevice = UserDevice::where('device_token', $request->device_token)->first();

        if ($existingDevice) {
            return response()->json(['success' => true, 'player_id' => $existingDevice->id], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Device not found'], 404);
        }
    }

    public function storeDeviceToken(Request $request)
    {
        Log::info('storeDeviceToken called', ['request' => $request->all()]);

        $validated = $request->validate([
            'device_token' => 'required|string|unique:user_devices',
        ]);

        $agent = new Agent();
        $userAgent = $request->header('User-Agent');

        $browser = $agent->browser($userAgent);
        $browserVersion = $agent->version($browser, $userAgent);
        $platform = $agent->platform($userAgent);
        $platformVersion = $agent->version($platform, $userAgent);
        $device = $agent->device($userAgent);
        $isMobile = $agent->isMobile($userAgent);
        $isTablet = $agent->isTablet($userAgent);
        $isDesktop = $agent->isDesktop($userAgent);

        // Detecting device brand based on User-Agent
        $brand = 'Unknown';
        if (preg_match('/(iPhone|iPad|iPod)/i', $userAgent)) {
            $brand = 'Apple';
        } elseif (preg_match('/Samsung/i', $userAgent)) {
            $brand = 'Samsung';
        } elseif (preg_match('/Huawei/i', $userAgent)) {
            $brand = 'Huawei';
        } elseif (preg_match('/Dell/i', $userAgent)) {
            $brand = 'Dell';
        } elseif (preg_match('/HP/i', $userAgent)) {
            $brand = 'HP';
        } elseif (preg_match('/Lenovo/i', $userAgent)) {
            $brand = 'Lenovo';
        }

        $userDevice = UserDevice::create([
            'user_id' => auth()->id(),
            'device_token' => $request->device_token,
            'device_info' => json_encode([
                'browser' => $browser,
                'browser_version' => $browserVersion,
                'platform' => $platform,
                'platform_version' => $platformVersion,
                'device' => $device,
                'is_mobile' => $isMobile,
                'is_tablet' => $isTablet,
                'is_desktop' => $isDesktop,
                'brand' => $brand,
            ]),
            'browser' => $browser,
            'browser_version' => $browserVersion,
            'platform' => $platform,
            'platform_version' => $platformVersion,
            'device' => $device,
            'is_mobile' => $isMobile,
            'is_tablet' => $isTablet,
            'is_desktop' => $isDesktop,
            'brand' => $brand,
            'status' => 'active',
        ]);

        // Menambahkan aktivitas pengguna
        UserActivity::create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'activity' => 'Penambahan Perangkat',
            'description' => 'Perangkat ' . $device . ' berhasil ditambahkan',
            'device_info' => $request->header('User-Agent'),
        ]);

        Log::info('Device token stored successfully', ['userDevice' => $userDevice]);

        return response()->json(['success' => true], 201);
    }
}