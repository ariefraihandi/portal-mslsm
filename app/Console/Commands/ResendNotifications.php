<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Exception;
use Carbon\Carbon;
use OneSignal;
use Illuminate\Support\Facades\Log;

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
        // Dapatkan waktu saat ini
        $currentHour = Carbon::now()->format('H');
    
        // Jika jam di luar jam kerja (08:00 - 18:00), hentikan proses
        if ($currentHour < 0 || $currentHour >= 18) {
            $this->info('Notification processing skipped outside of working hours.');
            return;
        }
    
        // Ambil semua notifikasi yang belum dibaca di salah satu channel
        $notifications = Notification::where(function ($query) {
            $query->where('is_read_wa', 0)
                ->orWhere('is_read_email', 0)
                ->orWhere('is_read_onesignal', 0);
        })
        ->orderBy('priority', 'desc')
        ->orderBy('created_at', 'asc')
        ->get();
    
        foreach ($notifications as $notification) {
            if ($notification->whatsapp || $notification->email || $notification->onesignal) {
                if (in_array($notification->priority, ['low', 'medium'])) {
                    $this->processLowMediumPriority($notification);
                    sleep(5); // Tunda 5 detik antar notifikasi
                } elseif ($notification->priority == 'high') {
                    $this->processHighPriority($notification);
                    sleep(5); // Tunda 5 detik antar notifikasi
                }
            }
        }
    
        $this->info('Notification processing completed.');
    }
    

    protected function processLowMediumPriority($notification)
    {            
        // Jika last_message_sent null, kirim WhatsApp terlebih dahulu
        if (is_null($notification->last_message_sent)) {
            $now = Carbon::now();
        
            if (!is_null($notification->whatsapp)) {
                $this->sendWhatsAppNotification($notification);
            }
        
            // Cek apakah email tersedia, jika ada kirim Email
            if (!is_null($notification->email)) {
                $this->sendEmailNotification($notification);
            }
        
            // Update waktu pengiriman terakhir setelah pengiriman pesan
            $notification->update(['last_message_sent' => $now]);
        } else {
            // Cek apakah pesan belum dibaca di semua kanal
            if (!$this->isRead($notification)) {
                $now = Carbon::now();
                $lastMessageSent = $notification->last_message_sent;
                
                // Konversi waktu sekarang dan waktu `last_message_sent` ke timestamp (detik sejak epoch)
                $nowTimestamp = $now->getTimestamp();
                $lastMessageTimestamp = $lastMessageSent->getTimestamp();
                
                // Hitung selisih waktu dalam detik
                $timeDifferenceInSeconds = $nowTimestamp - $lastMessageTimestamp;
                    
                // Konversi selisih waktu ke menit
                $timeDifferenceInMinutes = $timeDifferenceInSeconds / 60;                

                // Jika waktu yang telah berlalu lebih dari 1 menit
                if ($timeDifferenceInMinutes >= 1) {
                    if ($notification->is_sent_wa == 1 && $notification->is_sent_onesignal == 0 && $notification->is_sent_email == 0) {
                        // Kirim OneSignal jika WA sudah dikirim tetapi OneSignal belum
                        $this->sendOneSignalNotification($notification);
                        $notification->update(['is_sent_onesignal' => 1, 'last_message_sent' => $now]);
                    } elseif ($notification->is_sent_wa == 1 && $notification->is_sent_onesignal == 1 && $notification->is_sent_email == 0) {
                        // Kirim Email jika WA dan OneSignal sudah dikirim tetapi Email belum
                        $this->sendEmailNotification($notification);
                        $notification->update(['is_sent_email' => 1, 'last_message_sent' => $now]);
                    }
                }
            }
        }
    }
    
    protected function processHighPriority($notification)
    {            
        if (is_null($notification->last_message_sent)) {
            $now = Carbon::now();
        
            if (!is_null($notification->whatsapp)) {
                $this->sendWhatsAppNotification($notification);
            }
            
            if (!is_null($notification->email)) {
                $this->sendEmailNotification($notification);
            }
        
            $notification->update(['last_message_sent' => $now]);
        } else {
            // Cek apakah pesan belum dibaca di semua kanal
            if (!$this->isRead($notification)) {
                $now = Carbon::now();
                $lastMessageSent = $notification->last_message_sent;
                
                // Konversi waktu sekarang dan waktu `last_message_sent` ke timestamp (detik sejak epoch)
                $nowTimestamp = $now->getTimestamp();
                $lastMessageTimestamp = $lastMessageSent->getTimestamp();
                
                // Hitung selisih waktu dalam detik
                $timeDifferenceInSeconds = $nowTimestamp - $lastMessageTimestamp;
                    
                // Konversi selisih waktu ke menit
                $timeDifferenceInMinutes = $timeDifferenceInSeconds / 60;                

                // Jika waktu yang telah berlalu lebih dari 1 menit
                if ($timeDifferenceInMinutes >= 1) {
                    if ($notification->is_sent_wa == 1 && $notification->is_sent_onesignal == 0 && $notification->is_sent_email == 0) {
                        // Kirim OneSignal jika WA sudah dikirim tetapi OneSignal belum
                        $this->sendOneSignalNotification($notification);
                        $notification->update(['is_sent_onesignal' => 1, 'last_message_sent' => $now]);
                    } elseif ($notification->is_sent_wa == 1 && $notification->is_sent_onesignal == 1 && $notification->is_sent_email == 0) {
                        // Kirim Email jika WA dan OneSignal sudah dikirim tetapi Email belum
                        $this->sendEmailNotification($notification);
                        $notification->update(['is_sent_email' => 1, 'last_message_sent' => $now]);
                    }
                }
            }
        }
    }
    

    
    private function sendWhatsAppNotification($notification)
    {
        // Pastikan nomor WhatsApp ada
        if (empty($notification->whatsapp)) {
            $notification->update(['eror_wa' => 'WhatsApp number not available']);
            return;
        }

        $device_id = env('DEVICE_ID', 'somedefaultvalue');
        $number = $notification->whatsapp;
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
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_status !== 200) {
                $error_msg = "Failed to send WhatsApp message";
                $notification->update(['eror_wa' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response, true);

            if (!isset($response_data['status']) || $response_data['status'] !== true) {
                $error_msg = "Failed to send WhatsApp message: " . $response_data['message'];
                $notification->update(['eror_wa' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            // Jika berhasil, update status dan jumlah pengiriman
            $notification->update([
                'is_sent_wa' => 1,
                'count_sent_wa' => $notification->count_sent_wa + 1
            ]);
        } catch (Exception $e) {
            $notification->update(['eror_wa' => $e->getMessage()]);
            $this->sendEmergencyEmail($notification, $e->getMessage());
            throw $e;
        } finally {
            curl_close($curl);
        }
    }

    private function sendOneSignalNotification($notification)
    {
        if (empty($notification->onesignal)) {
            $notification->update(['eror_onesignal' => 'OneSignal ID not available']);
            return;
        }

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
                $this->sendEmergencyEmail($notification, $error_msg);
                Log::error("OneSignal Error: HTTP Status Code: {$response->getStatusCode()}");
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response->getBody(), true);

            if (isset($response_data['errors'])) {
                $error_msg = "Failed to send OneSignal notification: " . json_encode($response_data['errors']);
                $notification->update(['eror_onesignal' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                Log::error("OneSignal Error: " . json_encode($response_data['errors']));
                throw new Exception($error_msg);
            }

            // Jika berhasil, update status dan jumlah pengiriman
            $notification->update([
                'is_sent_onesignal' => 1,
                'count_sent_onesignal' => $notification->count_sent_onesignal + 1
            ]);
        } catch (Exception $e) {
            $notification->update(['eror_onesignal' => $e->getMessage()]);
            $this->sendEmergencyEmail($notification, $e->getMessage());
            Log::error("Failed to send OneSignal notification.", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function sendEmailNotification($notification)
    {
        // Pastikan alamat email ada
        if (empty($notification->email)) {
            $notification->update(['eror_email' => 'Email address not available']);
            return;
        }

        $url = $notification->target_url . "message_id=" . $notification->message_id . "&type=email";

        $data = [
            'emailMessage' => $notification->message,
            'url' => $url,
        ];

        try {
            Mail::send('Emails.notification', $data, function ($message) use ($notification) {
                $message->to($notification->email)
                    ->subject('Unread Notification Reminder');
            });

            // Jika berhasil, update status dan jumlah pengiriman
            $notification->update([
                'is_sent_email' => 1,
                'count_sent_email' => $notification->count_sent_email + 1
            ]);
        } catch (Exception $e) {
            $notification->update(['eror_email' => $e->getMessage()]);
            $this->sendEmergencyEmail($notification, $e->getMessage());
            throw $e;
        }
    }

    private function sendEmergencyEmail($notification, $errorMessage)
    {
        $data = [
            'errorMessage' => $errorMessage,
            'notification' => $notification,
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

    protected function isRead($notification)
    {
        return $notification->is_read_wa && $notification->is_read_onesignal && $notification->is_read_email;
    }
}
