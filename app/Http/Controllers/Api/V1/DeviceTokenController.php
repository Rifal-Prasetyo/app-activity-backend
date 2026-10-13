<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DeviceTokenController extends Controller
{
    public function updateToken(Request $request): JsonResponse
    {
        $request->validate([
            'device_uuid' => 'required|string',
            'fcm_token' => 'required|string',
        ]);

        // Cari atau update perangkat berdasarkan UUID
        $device = Device::where('device_uuid', $request->device_uuid)->first();

        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device not found'
            ], 404);
        }

        $device->update([
            'fcm_token' => $request->fcm_token
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'FCM Token successfully updated'
        ]);
    }
}