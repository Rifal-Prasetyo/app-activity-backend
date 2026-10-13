<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FcmService
{
    public function sendLockCommand(string $fcmToken, bool$isLocked): bool
    {
        try {
            // 1. Dapatkan Access Token Google menggunakan Service Account JSON file
            // Pastikan file JSON firebase credentials sudah kamu taruh di storage Laravel (misal: app/firebase/service-account.json)
            $accessToken =$this->getGoogleAccessToken();

            if (!$accessToken) {
                Log::error("Gagal mendapatkan Google Access Token untuk FCM.");
                return false;
            }

            // Ganti dengan Project ID Firebase milikmu (bisa dilihat di Project Settings Firebase Console)
            $projectId = config('services.fcm.project_id', 'your-firebase-project-id');

            // Endpoint resmi FCM HTTP v1 API yang baru
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            // Format payload FCM HTTP v1 API
            $payload = [
                'message' => [
                    'token' => $fcmToken,
                    'data' => [
                        'action' => $isLocked ? 'LOCK_DEVICE' : 'UNLOCK_DEVICE',
                        'timestamp' => (string) now()->timestamp,
                    ],
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post($url,$payload);

            if ($response->successful()) {
                Log::info("FCM HTTP v1 Berhasil dikirim! Status Lock: " . ($isLocked ? 'LOCK' : 'UNLOCK'));
                return true;
            }

            Log::error("Gagal mengirim FCM v1: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Exception saat kirim FCM: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper untuk generate OAuth2 Access Token dari Google Service Account JSON
     */
    private function getGoogleAccessToken(): ?string
    {
        // Cara paling mudah di Laravel tanpa install package tambahan yang berat
        // adalah menggunakan Google Client Library (`google/apiclient`),
        // atau membaca file JSON kredensial secara manual.

        // *Saran Praktis:* Jika ingin instan tanpa repot OAuth2 token untuk tahap testing lokal,
        // kamu bisa mendownload package resmi: composer require google/apiclient

        try {
            $client = new \Google_Client();
            // Simpan file JSON dari Project Settings > Service Accounts Firebase ke storage/app/firebase-key.json
            $client->setAuthConfig(storage_path('app/firebase-key.json'));$client->addScope('https://www.googleapis.com/auth/firebase.messaging');

            $token =$client->fetchAccessTokenWithAssertion();
            return $token['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error("Gagal parse Google Auth: " . $e->getMessage());
            return null;
        }
    }
}
