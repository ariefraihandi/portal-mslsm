<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Models\WhatsappErrorNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
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
    
        if ($currentHour < 8 || $currentHour >= 18) {
        // if ($currentHour >= 18) {
            $this->info('Notification processing skipped outside of working hours.');
            return;
        }
            
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
                } elseif ($notification->priority == 'high') {
                    $this->processHighPriority($notification);
                }
                sleep(5); // Tunda 5 detik antar notifikasi
            }
        }
        
        $this->info('Notification processing completed.');
    }
    

    protected function processLowMediumPriority($notification)
    {
        $now = Carbon::now();
    
        // Cek apakah notifikasi sudah dibaca
        if (!$this->isRead($notification)) {
    
            // Cek apakah WhatsApp terkoneksi dan apakah belum dikirim via WA
            if ($this->checkNotificationStatus() && $notification->is_sent_wa == 0) {
                // Jika WhatsApp terkoneksi, coba kirim pesan WA
                try {
                    $this->sendWhatsAppNotification($notification);
                    // Jika berhasil, hentikan proses tanpa perlu mencoba OS atau Email
                    return;
                } catch (Exception $e) {
                    // Jika gagal, lanjutkan dengan OneSignal
                }
            }
    
            // Cek jika WA gagal atau tidak terkoneksi, dan belum dikirim via OneSignal
            if ($notification->is_sent_onesignal == 0) {
                try {
                    $this->sendOneSignalNotification($notification);
                    // Jika berhasil kirim OneSignal, hentikan proses tanpa mencoba Email
                    return;
                } catch (Exception $e) {
                    // Jika OneSignal gagal, lanjutkan ke Email
                }
            }
    
            // Jika WA dan OneSignal gagal, dan belum dikirim via Email
            if ($notification->is_sent_email == 0) {
                try {
                    $this->sendEmailNotification($notification);
                    // Email adalah upaya terakhir, tidak ada langkah lanjutan.
                } catch (Exception $e) {
                    // Jika Email juga gagal, tangani kesalahan sesuai kebutuhan
                }
            }
    
            // Semua metode telah dicoba, pastikan statusnya diperbarui dalam metode masing-masing
        }
    }
    

    protected function processHighPriority($notification)
    {
        $now = Carbon::now();
    
        // Cek apakah notifikasi sudah dibaca
        if (!$this->isRead($notification)) {
    
            // Cek apakah WhatsApp terkoneksi dan apakah belum dikirim via WA
            if ($this->checkNotificationStatus() && $notification->is_sent_wa == 0) {
                // Jika WhatsApp terkoneksi, coba kirim pesan WA
                try {
                    $this->sendWhatsAppNotification($notification);
                    // Jika berhasil, hentikan proses tanpa perlu mencoba OS atau Email
                    return;
                } catch (Exception $e) {
                    // Jika gagal, lanjutkan dengan OneSignal
                }
            }
    
            // Cek jika WA gagal atau tidak terkoneksi, dan belum dikirim via OneSignal
            if ($notification->is_sent_onesignal == 0) {
                try {
                    $this->sendOneSignalNotification($notification);
                    // Jika berhasil kirim OneSignal, hentikan proses tanpa mencoba Email
                    return;
                } catch (Exception $e) {
                    // Jika OneSignal gagal, lanjutkan ke Email
                }
            }
    
            // Jika WA dan OneSignal gagal, dan belum dikirim via Email
            if ($notification->is_sent_email == 0) {
                try {
                    $this->sendEmailNotification($notification);
                    // Email adalah upaya terakhir, tidak ada langkah lanjutan.
                } catch (Exception $e) {
                    // Jika Email juga gagal, tangani kesalahan sesuai kebutuhan
                }
            }
    
            // Semua metode telah dicoba, pastikan statusnya diperbarui dalam metode masing-masing
        }
    }
    
    
    private function sendWhatsAppNotification($notification)
    {
        // Pastikan nomor WhatsApp ada
        if (empty($notification->whatsapp)) {
            $notification->update(['error_wa' => 'WhatsApp number not available']);
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
                $notification->update(['error_wa' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_status !== 200) {
                $error_msg = "Failed to send WhatsApp message";
                $notification->update(['error_wa' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response, true);

            if (!isset($response_data['status']) || $response_data['status'] !== true) {
                $error_msg = "Failed to send WhatsApp message: " . $response_data['message'];
                $notification->update(['error_wa' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                throw new Exception($error_msg);
            }

            // Jika berhasil, update status, jumlah pengiriman, dan waktu pengiriman terakhir
            $notification->update([
                'is_sent_wa' => 1,
                'count_sent_wa' => $notification->count_sent_wa + 1,
                'last_message_sent' => now() // Update the last message sent timestamp
            ]);
        } catch (Exception $e) {
            $notification->update(['error_wa' => $e->getMessage()]);
            $this->sendEmergencyEmail($notification, $e->getMessage());
            throw $e;
        } finally {
            curl_close($curl);
        }
    }

    private function sendOneSignalNotification($notification)
    {
        if (empty($notification->onesignal)) {
            $notification->update(['error_onesignal' => 'OneSignal ID not available']);
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
                $notification->update(['error_onesignal' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                Log::error("OneSignal Error: HTTP Status Code: {$response->getStatusCode()}");
                throw new Exception($error_msg);
            }

            $response_data = json_decode($response->getBody(), true);

            if (isset($response_data['errors'])) {
                $error_msg = "Failed to send OneSignal notification: " . json_encode($response_data['errors']);
                $notification->update(['error_onesignal' => $error_msg]);
                $this->sendEmergencyEmail($notification, $error_msg);
                Log::error("OneSignal Error: " . json_encode($response_data['errors']));
                throw new Exception($error_msg);
            }

            // Jika berhasil, update status, jumlah pengiriman, dan waktu pengiriman terakhir
            $notification->update([
                'is_sent_onesignal' => 1,
                'count_sent_onesignal' => $notification->count_sent_onesignal + 1,
                'last_message_sent' => now() // Update the last message sent timestamp
            ]);
        } catch (Exception $e) {
            $notification->update(['error_onesignal' => $e->getMessage()]);
            $this->sendEmergencyEmail($notification, $e->getMessage());
            Log::error("Failed to send OneSignal notification.", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function sendEmailNotification($notification)
    {
        // Pastikan alamat email ada
        if (empty($notification->email)) {
            $notification->update(['error_email' => 'Email address not available']);
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

            // Jika berhasil, update status, jumlah pengiriman, dan waktu pengiriman terakhir
            $notification->update([
                'is_sent_email' => 1,
                'count_sent_email' => $notification->count_sent_email + 1,
                'last_message_sent' => now() // Update the last message sent timestamp
            ]);
        } catch (Exception $e) {
            $notification->update(['error_email' => $e->getMessage()]);
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

    protected function checkNotificationStatus()
    {
        try {
            $response = Http::get('https://app.whacenter.com/api/statusDevice', [
                'device_id' => env('DEVICE_ID', 'default_device_id'), // Ganti dengan device ID dari .env
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] === false) {
                    $error_msg = $responseData['message'] ?? 'Unknown error occurred';
                    $this->info('WhatsApp device error: ' . $error_msg);
                    $this->logAndSaveError('WhatsApp device error', $error_msg);
                    return false;
                }

                $deviceStatus = $responseData['data']['status'] ?? 'UNKNOWN';
                if ($deviceStatus !== 'CONNECTED') {
                    $error_msg = 'WhatsApp device is not connected. Status: ' . $deviceStatus;
                    $this->info($error_msg);
                    $this->logAndSaveError('WhatsApp device is not connected', $error_msg);
                    return false;
                }

                $this->info('WhatsApp device is connected.');
                return true;
            } else {
                $error_msg = "Failed to get device status. HTTP Status: " . $response->status();
                $this->info($error_msg);
                $this->logAndSaveError('HTTP Error', $error_msg);
                return false;
            }
        } catch (Exception $e) {
            $error_msg = 'Error occurred while checking device status: ' . $e->getMessage();
            $this->info($error_msg);
            $this->logAndSaveError('Exception', $error_msg);
            return false;
        }
    }

    protected function logAndSaveError($title, $message)
    {
        Log::error($title . ': ' . $message);

        // Periksa apakah error yang sama sudah ada di database hari ini
        $existingError = WhatsappErrorNotification::where('error_description', $message)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existingError) {
            // Jika error yang sama sudah tercatat hari ini, batalkan pengiriman email
            $this->info('Error has already been notified today, skipping email.');
        } else {
            // Simpan error ke dalam database
            $errorNotification = WhatsappErrorNotification::create([
                'error_description' => $message,
                'is_notified' => true,
                'created_at' => Carbon::now(),
            ]);

            // Setelah menyimpan, kirim email darurat dan perbarui is_notified jika berhasil
            $this->sendEmergencyEmail($errorNotification, $message);
        }
    }


}
