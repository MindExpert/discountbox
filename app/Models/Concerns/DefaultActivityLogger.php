<?php

namespace App\Models\Concerns;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait DefaultActivityLogger
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logUnguarded()
            ->logAll()
            ->useAttributeRawValues([
                'name',
                'description',
            ]);
    }
}
