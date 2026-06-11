<?php

namespace App\Services;

use Spatie\Activitylog\Models\Activity;

class ActivityLogger
{
    public static function log(string $description, $subject = null, array $properties = []): void
    {
        $log = activity()
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($description);

        if ($subject) {
            $log->subject()->associate($subject);
            $log->save();
        }
    }
}
