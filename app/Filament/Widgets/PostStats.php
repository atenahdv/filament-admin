<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostStats extends ChartWidget
{
    protected static ?string $heading = 'Posts in last 7 days';

    // public static function canView(): bool
    // {
    // return Auth::user()?->hasRole('super_admin');
    // }
    
    protected function getData(): array
    {
        $labels = [];
        $data = [];

        foreach (range(6, 0) as $i) {
            $day = now()->subDays($i)->format('Y-m-d');
            $labels[] = $day;
            $data[] = Post::whereDate('created_at', $day)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Posts',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; 
    }
}
