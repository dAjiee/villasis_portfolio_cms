<?php

namespace App\Filament\Widgets;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Social Links', SocialLink::count()),
            Stat::make('Skills', Skill::count()),
            Stat::make('Experiences', Experience::count()),
            Stat::make('Projects', Project::count()),
        ];
    }
}
