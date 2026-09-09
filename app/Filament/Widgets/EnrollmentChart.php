<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;

class EnrollmentChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Enrollments (Last 12 Months)';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i));
        }

        $labels = $months->map(fn ($date) => $date->format('M Y'))->toArray();

        $enrollmentData = $months->map(function ($date) {
            return Enrollment::whereYear('enrolled_at', $date->year)
                ->whereMonth('enrolled_at', $date->month)
                ->count();
        })->toArray();

        $completedData = $months->map(function ($date) {
            return Enrollment::where('status', 'completed')
                ->whereYear('completed_at', $date->year)
                ->whereMonth('completed_at', $date->month)
                ->count();
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => $enrollmentData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Completed',
                    'data' => $completedData,
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
