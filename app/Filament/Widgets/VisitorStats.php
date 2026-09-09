<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStats extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Unique visitors hari ini
        $visitorsToday = PageView::whereDate('created_at', today())
            ->distinct('ip_address')
            ->count('ip_address');

        // Total pageviews hari ini
        $pageviewsToday = PageView::whereDate('created_at', today())
            ->count();

        // Active now (5 menit terakhir)
        $activeNow = PageView::where('last_activity', '>=', now()->subMinutes(5))
            ->distinct('ip_address')
            ->count('ip_address');

        // Unique visitors minggu ini
        $visitorsWeek = PageView::where('created_at', '>=', now()->startOfWeek())
            ->distinct('ip_address')
            ->count('ip_address');

        return [
            Stat::make('Visitors Hari Ini', number_format($visitorsToday))
                ->description('Unique visitors')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart($this->getVisitorChart(7)),

            Stat::make('Pageviews Hari Ini', number_format($pageviewsToday))
                ->description('Total halaman dilihat')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Active Now', $activeNow)
                ->description('Online dalam 5 menit terakhir')
                ->descriptionIcon('heroicon-m-signal')
                ->color('danger'),

            Stat::make('Visitors Minggu Ini', number_format($visitorsWeek))
                ->description('Total minggu ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->chart($this->getVisitorChart(7)),
        ];
    }

    private function getVisitorChart(int $days): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[] = PageView::whereDate('created_at', $date)
                ->distinct('ip_address')
                ->count('ip_address');
        }

        return $data;
    }
}
