<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use HasFactory, LogsActivity, CausesActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                        ->logOnlyDirty()
                        ->logOnly(['*'])
                        ->useLogName('Permission')
                        ->dontSubmitEmptyLogs()
                        ->dontLogIfAttributesChangedOnly(['updated_at'])
                        ;
    }
}
