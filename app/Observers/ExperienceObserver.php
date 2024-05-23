<?php

namespace App\Observers;

use App\Models\Experience;
use Illuminate\Support\Facades\Storage;

class ExperienceObserver
{
    /**
     * Handle the Experience "created" event.
     */
    public function created(Experience $experience): void
    {
        //
    }

    /**
     * Handle the Experience "updated" event.
     */
    public function updated(Experience $experience): void
    {
        if ($experience->isDirty('icon_url')) {
            Storage::disk('s3')->delete($experience->getOriginal('icon_url'));
        }
    }

    /**
     * Handle the Experience "deleted" event.
     */
    public function deleted(Experience $experience): void
    {
        if (! is_null($experience->icon_url)) {
            Storage::disk('s3')->delete($experience->icon_url);
        }
    }

    /**
     * Handle the Experience "restored" event.
     */
    public function restored(Experience $experience): void
    {
        //
    }

    /**
     * Handle the Experience "force deleted" event.
     */
    public function forceDeleted(Experience $experience): void
    {
        //
    }
}
