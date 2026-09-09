<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CoursesByCategoryChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Courses by Category';

    protected function getData(): array
    {
        $categories = Category::withCount('courses')
            ->orderByDesc('courses_count')
            ->get();

        $colors = [
            '#3b82f6',
            '#ef4444',
            '#22c55e',
            '#f59e0b',
            '#8b5cf6',
            '#ec4899',
            '#06b6d4',
            '#f97316',
            '#14b8a6',
            '#6366f1',
        ];

        return [
            'datasets' => [
                [
                    'data' => $categories->pluck('courses_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $categories->count()),
                ],
            ],
            'labels' => $categories->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
