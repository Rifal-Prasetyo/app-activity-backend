<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    //
    protected $fillable = ['device_uuid', 'name', 'is_locked'];

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function rule(): HasOne
    {
        return $this->hasOne(DeviceRule::class);
    }
}
