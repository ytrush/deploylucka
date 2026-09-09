<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

class VisitorChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Visitor Trend (7 Hari Terakhir)';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $days = 7;
        $labels = [];
        $visitorsData = [];
        $pageviewsData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');

            // Unique visitors
            $visitorsData[] = PageView::whereDate('created_at', $date)
                ->distinct('ip_address')
                ->count('ip_address');

            // Total pageviews
            $pageviewsData[] = PageView::whereDate('created_at', $date)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Unique Visitors',
                    'data' => $visitorsData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Pageviews',
                    'data' => $pageviewsData,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
