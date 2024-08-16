<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Models\UserDevice;
use OneSignal;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResendNotifications extends Command
{
    protected $signature = 'notifications:resend';
    protected $description = 'Resend unread notifications via appropriate channels';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 1. Ambil semua notifikasi
        $notifications = Notification::orderBy('priority', 'desc')->orderBy('created_at', 'asc')->get();

        foreach ($notifications as $notification) {
            // Low Priority: Kirim sekali saja, jika sudah kirim WhatsApp, lanjutkan ke OneSignal, lalu ke email.
            if ($notification->priority == 'low') {
                $this->processLowPriority($notification);
            }

            // Medium Priority: Kirim hingga dua kali, jika semua metode sudah dikirim dan belum dibaca.
            if ($notification->priority == 'medium') {
                $this->processMediumPriority($notification);
            }

            // High Priority: Kirim terus menerus hingga dibaca di salah satu metode.
            if ($notification->priority == 'high') {
                $this->processHighPriority($notification);
            }
        }

        $this->info('Resend notifications command completed.');
    }

    private function processLowPriority($notification)
    {
        // Send WhatsApp notification if not sent yet
        if (!$notification->is_sent_wa) {
            $this->sendWhatsAppNotification($notification);
            $notification->update([
                'is_sent_wa' => true,
                'last_message_sent' => now()
            ]);
            $this->info("Low Priority - Sent via WhatsApp: Notification ID {$notification->id}");
        }
    
        // Send OneSignal notification if not sent yet
        if (!$notification->is_sent_onesignal) {
            $this->sendOneSignalNotification($notification);
            $notification->update([
                'is_sent_onesignal' => true,
                'last_message_sent' => now()
            ]);
            $this->info("Low Priority - Sent via OneSignal: Notification ID {$notification->id}");
        }
    
        // Send Email notification if not sent yet
        if (!$notification->is_sent_email) {
            $this->sendEmailNotification($notification);
            $notification->update([
                'is_sent_email' => true,
                'last_message_sent' => now()
            ]);
            $this->info("Low Priority - Sent via Email: Notification ID {$notification->id}");
        }
    }
    
    private function processMediumPriority($notification)
    {
        if ((!$notification->is_sent_wa || $notification->count_sent_wa < 2) && !$this->isAnyChannelRead($notification)) {
            $this->sendWhatsAppNotification($notification);
            $notification->update([
                'is_sent_wa' => true,
                'count_sent_wa' => $notification->count_sent_wa + 1,
                'last_message_sent' => now()
            ]);
            $this->info("Medium Priority - Sent via WhatsApp: Notification ID {$notification->id}");
        } elseif ((!$notification->is_sent_onesignal || $notification->count_sent_onesignal < 2) && !$this->isAnyChannelRead($notification)) {
            $this->sendOneSignalNotification($notification);
            $notification->update([
                'is_sent_onesignal' => true,
                'count_sent_onesignal' => $notification->count_sent_onesignal + 1,
                'last_message_sent' => now()
            ]);
            $this->info("Medium Priority - Sent via OneSignal: Notification ID {$notification->id}");
        } elseif ((!$notification->is_sent_email || $notification->count_sent_email < 2) && !$this->isAnyChannelRead($notification)) {
            $this->sendEmailNotification($notification);
            $notification->update([
                'is_sent_email' => true,
                'count_sent_email' => $notification->count_sent_email + 1,
                'last_message_sent' => now()
            ]);
            $this->info("Medium Priority - Sent via Email: Notification ID {$notification->id}");
        }
    }

    private function processHighPriority($notification)
    {
        // Kirim ulang terus menerus sampai dibaca di salah satu metode.
        if (!$this->isAnyChannelRead($notification)) {
            if ($notification->count_sent_wa <= $notification->count_sent_onesignal && $notification->count_sent_wa <= $notification->count_sent_email) {
                // Kirim WhatsApp jika belum dikirim sebanyak OneSignal dan Email
                $this->sendWhatsAppNotification($notification);
                $notification->update([
                    'is_sent_wa' => true,
                    'count_sent_wa' => $notification->count_sent_wa + 1,
                    'last_message_sent' => now()
                ]);
                $this->info("High Priority - Sent via WhatsApp: Notification ID {$notification->id}");
            } elseif ($notification->count_sent_onesignal <= $notification->count_sent_email) {
                // Kirim OneSignal jika belum dikirim sebanyak WhatsApp dan Email
                $this->sendOneSignalNotification($notification);
                $notification->update([
                    'is_sent_onesignal' => true,
                    'count_sent_onesignal' => $notification->count_sent_onesignal + 1,
                    'last_message_sent' => now()
                ]);
                $this->info("High Priority - Sent via OneSignal: Notification ID {$notification->id}");
            } else {
                // Kirim Email jika belum dikirim sebanyak WhatsApp dan OneSignal
                $this->sendEmailNotification($notification);
                $notification->update([
                    'is_sent_email' => true,
                    'count_sent_email' => $notification->count_sent_email + 1,
                    'last_message_sent' => now()
                ]);
                $this->info("High Priority - Sent via Email: Notification ID {$notification->id}");
            }
        }
    }


    private function sendWhatsAppNotification($notification)
    {
        $device_id = env('DEVICE_ID', 'somedefaultvalue');
        $number = $notification->whatsapp;
        
        // Tambahkan target URL ke dalam pesan
        $message = $notification->message . "\n\nTautan Aksi: " . $notification->target_url . "message_id=" . $notification->message_id . "&type=whatsapp";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.whacenter.com/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'device_id' => $device_id,
                'number' => $number,
                'message' => $message,
            ],
        ]);

        try {
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                $notification->update(['eror_wa' => $error_msg]);
                throw new Exception($error_msg);
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_status !== 200) {
                $error_msg = "Failed to send WhatsApp message";
                $notification->update(['eror_wa' => $error_msg]);
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response, true);

            if (!isset($response_data['status']) || $response_data['status'] !== true) {
                $error_msg = "Failed to send WhatsApp message: " . $response_data['message'];
                $notification->update(['eror_wa' => $error_msg]);
                throw new Exception($error_msg);
            }
        } catch (Exception $e) {
            // Tangkap error dan simpan ke database
            $notification->update(['eror_wa' => $e->getMessage()]);
            throw $e; // Rethrow exception to handle it outside
        } finally {
            curl_close($curl);
        }
    }

    private function sendOneSignalNotification($notification)
    {
        $deviceTokens = [$notification->onesignal];
        $url = $notification->target_url . "message_id=" . $notification->message_id . "&type=onesignal";

        $fields = [
            'app_id' => config('services.onesignal.app_id'),
            'include_player_ids' => $deviceTokens,
            'headings' => ['en' => 'Notifikasi Belum Di Baca'],
            'contents' => ['en' => $notification->message],
            'url' => $url,
            'chrome_web_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
            'small_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
            'large_icon' => 'https://portal.ms-lhokseumawe.go.id/assets/img/logo/logo.png',
        ];

        try {
            $response = OneSignal::sendNotificationCustom($fields);

            if ($response->getStatusCode() !== 200) {
                $error_msg = "Failed to send OneSignal notification";
                $notification->update(['eror_onesignal' => $error_msg]);
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response->getBody(), true);

            if (isset($response_data['errors'])) {
                $error_msg = "Failed to send OneSignal notification: " . json_encode($response_data['errors']);
                $notification->update(['eror_onesignal' => $error_msg]);
                throw new Exception($error_msg);
            }
        } catch (Exception $e) {
            $notification->update(['eror_onesignal' => $e->getMessage()]);
            throw $e;
        }
    }

    private function sendEmailNotification($notification)
    {
        $url = $notification->target_url . "?message_id=" . $notification->message_id . "&type=email";

        $data = [
            'emailMessage' => $notification->message,
            'url' => $url,
        ];

        try {
            Mail::send('emails.notification', $data, function ($message) use ($notification) {
                $message->to($notification->email)
                        ->subject('Unread Notification Reminder');
            });
        } catch (Exception $e) {
            // Menangkap dan menangani kesalahan
            $notification->update(['eror_email' => $e->getMessage()]);
            throw $e;
        }
    }

    private function sendEmergencyEmail($notification, $errorMessage)
    {
        $data = [
            'errorMessage' => $errorMessage,
        ];

        try {
            Mail::send('emails.emergency', $data, function ($message) {
                $message->to('raihandi93@gmail.com')
                        ->subject('Emergency: Notification Sending Failed');
            });

            if (Mail::failures()) {
                Log::error("Failed to send emergency email.");
            }
        } catch (Exception $e) {
            Log::error("Failed to send emergency email.", ['error' => $e->getMessage()]);
        }
    }

    private function isAnyChannelRead($notification)
    {
        return $notification->is_read_wa || $notification->is_read_onesignal || $notification->is_read_email;
    }
}
