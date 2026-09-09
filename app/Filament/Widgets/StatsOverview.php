<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalArticles = Article::count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([$totalUsers]),

            Stat::make('Total Courses', number_format($totalCourses))
                ->description('Available courses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->chart([$totalCourses]),

            Stat::make('Total Enrollments', number_format($totalEnrollments))
                ->description("{$activeEnrollments} active")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->chart([$totalEnrollments]),

            Stat::make('Total Articles', number_format($totalArticles))
                ->description('Published articles')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([$totalArticles]),
        ];
    }
}
