<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public function sendLockCommand(string $fcmToken, bool $isLocked): bool
    {
        // CATATAN: Untuk production, disarankan menggunakan Google Auth Service Account 
        // untuk menghasilkan Bearer Token. Tapi untuk tahap development lokal, 
        // kita bisa gunakan Firebase Server Key lama atau HTTP v1 API.

        // Di sini kita contohkan menggunakan struktur payload data message FCM:
        $projectId = config('services.fcm.project_id', 'your-firebase-project-id');
        $serverKey = config('services.fcm.server_key', 'your-server-key');

        // Menggunakan FCM Legacy / HTTP v1 (Contoh menggunakan Server Key standar)
        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
                    'to' => $fcmToken,
                    'data' => [
                        'action' => $isLocked ? 'LOCK_DEVICE' : 'UNLOCK_DEVICE',
                        'timestamp' => now()->timestamp,
                    ],
                    'priority' => 'high'
                ]);

        if ($response->successful()) {
            Log::info("FCM Berhasil dikirim! Status Lock: " . ($isLocked ? 'LOCK' : 'UNLOCK'));
            return true;
        }

        Log::error("Gagal mengirim FCM: " . $response->body());
        return false;
    }
}