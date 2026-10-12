<?php

use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Device::where('device_uuid', 'tv-test-uuid-001')->exists())
            return;

        Device::create([
            "device_uuid" => "tv-test-uuid-001",
            "name" => "TV Kamar Utama",
            "is_locked" => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_device_data');
    }
};
