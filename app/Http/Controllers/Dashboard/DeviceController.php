<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('dashboard/devices/index', [
            'devices' => Inertia::scroll(fn() => Device::paginate())
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, FcmService $fcmService)
    {
        //
        $validated = $request->validate([
            'is_locked' => 'required|boolean'
        ]);

        $device = Device::find($id);
        if (!$device) {
            return abort(404);
        }

        $device->update($validated);

        Inertia::flash('success', 'berhasil update status device');
        if ($device->fcm_token) {
            $fcmService->sendLockCommand($device->fcm_token, $device->is_locked);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
