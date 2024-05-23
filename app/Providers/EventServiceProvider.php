<?php

namespace App\Providers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Observers\ExperienceObserver;
use App\Observers\ProjectObserver;
use App\Observers\SkillObserver;
use App\Observers\SocialLinkObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Experience::observe(ExperienceObserver::class);
        Project::observe(ProjectObserver::class);
        Skill::observe(SkillObserver::class);
        SocialLink::observe(SocialLinkObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
