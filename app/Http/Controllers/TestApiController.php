<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestApiController extends Controller
{
    public function index()
    {
        // Pastikan ada satu device dummy di database untuk dites
        $device = Device::firstOrCreate(
            ['device_uuid' => 'tv-test-uuid-001'],
            ['name' => 'TV Kamar Utama', 'is_locked' => false]
        );

        return view('api-tester', compact('device'));
    }

    public function simulateSend(Request $request)
    {
        // Simulasi data JSON yang nanti dikirim oleh aplikasi Android TV
        $payload = [
            'device_uuid' => $request->device_uuid,
            'logs' => [
                [
                    'package_name' => 'com.google.android.youtube.tv',
                    'app_name' => 'YouTube TV',
                    'start_time' => now()->subMinutes(30)->toDateTimeString(),
                    'end_time' => now()->toDateTimeString(),
                    'duration_seconds' => 1800,
                ],
                [
                    'package_name' => 'com.netflix.ninja',
                    'app_name' => 'Netflix',
                    'start_time' => now()->subHours(2)->toDateTimeString(),
                    'end_time' => now()->subMinutes(90)->toDateTimeString(),
                    'duration_seconds' => 1800,
                ]
            ]
        ];

        // Hit endpoint API kita sendiri menggunakan Laravel HTTP Client
        $response = Http::post(url('/api/v1/activity-logs'), $payload);

        return back()->with([
            'status_code' => $response->status(),
            'response_body' => $response->json(),
            'payload_sent' => $payload
        ]);
    }
}