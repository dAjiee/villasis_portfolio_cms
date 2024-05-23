<?php

namespace App\Observers;

use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

class SkillObserver
{
    /**
     * Handle the Skill "created" event.
     */
    public function created(Skill $skill): void
    {
        //
    }

    /**
     * Handle the Skill "updated" event.
     */
    public function updated(Skill $skill): void
    {
        if ($skill->isDirty('image_url')) {
            Storage::disk('s3')->delete($skill->getOriginal('image_url'));
        }
    }

    /**
     * Handle the Skill "deleted" event.
     */
    public function deleted(Skill $skill): void
    {
        if (! is_null($skill->image_url)) {
            Storage::disk('s3')->delete($skill->image_url);
        }
    }

    /**
     * Handle the Skill "restored" event.
     */
    public function restored(Skill $skill): void
    {
        //
    }

    /**
     * Handle the Skill "force deleted" event.
     */
    public function forceDeleted(Skill $skill): void
    {
        //
    }
}
