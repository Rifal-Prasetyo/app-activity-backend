<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreActivityLogRequest;
use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends Controller
{
    //
    public function store(StoreActivityLogRequest $request): JsonResponse
    {
        // Cari perangkat berdasarkan UUID, buat otomatis jika belum terdaftar (opsional)
        $device = Device::where('device_uuid', $request->device_uuid)->firstOrFail();

        $logsData = [];
        foreach ($request->logs as $log) {
            $logsData[] = [
                'device_id' => $device->id,
                'package_name' => $log['package_name'],
                'app_name' => $log['app_name'] ?? null,
                'start_time' => $log['start_time'],
                'end_time' => $log['end_time'] ?? null,
                'duration_seconds' => $log['duration_seconds'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Lakukan bulk insert agar performa tetap ngebut walau log menumpuk
        ActivityLog::insert($logsData);

        return response()->json([
            'status' => 'success',
            'message' => 'Logs synchronized successfully.',
            'count' => count($logsData)
        ], 201);
    }
}
