<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class DeviceSyncController extends Controller
{
    public function checkStatus(string $uuid): JsonResponse
    {
        // Cari device berdasarkan UUID, buat otomatis jika belum ada (opsional)
        $device = Device::with('rule')->where('device_uuid', $uuid)->first();

        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'device_uuid' => $device->device_uuid,
                'name' => $device->name,
                'is_locked' => (bool) $device->is_locked, // Status kunci jarak jauh (true/false)
                'rules' => [
                    'daily_time_limit_minutes' => $device->rule->daily_time_limit_minutes ?? 120,
                    'blocked_packages' => $device->rule->blocked_packages ?? [],
                ]
            ]
        ]);
    }
}