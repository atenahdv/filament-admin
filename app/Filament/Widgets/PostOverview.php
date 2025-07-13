<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PostOverview extends BaseWidget
{

//     public static function canView(): bool
//    {
//     return Auth::user()?->hasRole('super_admin');
//    }

    protected function getStats(): array
    {
        return [
            Stat::make('📝 posts', Post::count()),
            Stat::make('📅 posts today', Post::whereDate('created_at', now())->count()),
            Stat::make('👥 number users', User::count()),
        ];
    }
}
