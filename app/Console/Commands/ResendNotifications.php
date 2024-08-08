<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Models\UserDevice;
use OneSignal;
use Exception;
use Illuminate\Support\Facades\Log;

class ResendNotifications extends Command
{
    protected $signature = 'notifications:resend';
    protected $description = 'Resend unread WhatsApp notifications via OneSignal';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Query for notifications that were sent via WhatsApp but not read
        $notifications = Notification::where('is_sent_wa', true)
                                     ->where('is_read_wa', false)
                                     ->where('is_sent_onesignal', false)
                                     ->get();

        foreach ($notifications as $notification) {
            try {
                // Get the user's device tokens
                $deviceTokens = UserDevice::where('user_id', $notification->user_id)->pluck('device_token')->toArray();
                
                if (!empty($deviceTokens)) {
                    $this->sendOneSignalNotification($deviceTokens, $notification->message, $notification->message_id);
                    $notification->update(['is_sent_onesignal' => true, 'eror_onesignal' => '']);
                    $this->info("Notification ID {$notification->id} resent via OneSignal.");
                } else {
                    throw new Exception("Device tokens not found for user ID {$notification->user_id}");
                }
            } catch (Exception $e) {
                Log::error("Failed to resend notification ID {$notification->id} via OneSignal", ['error' => $e->getMessage()]);
                $notification->update(['eror_onesignal' => $e->getMessage()]);
                $this->error("Failed to resend notification ID {$notification->id} via OneSignal.");
            }
        }

        $this->info('Resend notifications command completed.');
    }

    private function sendOneSignalNotification($deviceTokens, $message, $messageId)
    {
        // Construct the URL with message_id and type
        // $url = route('kepegawaian.cuti.detail', ['message_id' => $messageId, 'type' => 'onesignal']);
        $url = route('kepegawaian.cuti.detail') . "?message_id={$messageId}&type=onesignal";
        $fields = [
            'app_id' => config('services.onesignal.app_id'),
            'include_player_ids' => $deviceTokens,
            'headings' => ['en' => 'Unread Notification Reminder'],
            'contents' => ['en' => $message],
            'url' => $url, // Set the URL to the detailed cuti page
            'chrome_web_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
            'small_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
            'large_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
        ];

        $response = OneSignal::sendNotificationCustom($fields);

        if ($response->getStatusCode() !== 200) {
            throw new Exception("Failed to send OneSignal notification");
        }

        $response_data = json_decode($response->getBody(), true);

        if (isset($response_data['errors'])) {
            throw new Exception("Failed to send OneSignal notification: " . json_encode($response_data['errors']));
        }
    }
}
