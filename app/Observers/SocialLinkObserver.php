<?php

namespace App\Observers;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Storage;

class SocialLinkObserver
{
    /**
     * Handle the SocialLink "created" event.
     */
    public function created(SocialLink $socialLink): void
    {
        //
    }

    /**
     * Handle the SocialLink "updated" event.
     */
    public function updated(SocialLink $socialLink): void
    {
        if ($socialLink->isDirty('icon_url')) {
            Storage::disk('s3')->delete($socialLink->getOriginal('icon_url'));
        }
    }

    /**
     * Handle the SocialLink "deleted" event.
     */
    public function deleted(SocialLink $socialLink): void
    {
        if (! is_null($socialLink->icon_url)) {
            Storage::disk('s3')->delete($socialLink->icon_url);
        }
    }

    /**
     * Handle the SocialLink "restored" event.
     */
    public function restored(SocialLink $socialLink): void
    {
        //
    }

    /**
     * Handle the SocialLink "force deleted" event.
     */
    public function forceDeleted(SocialLink $socialLink): void
    {
        //
    }
}
