<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEnrollments extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $heading = 'Latest Enrollments';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Enrollment::query()
                    ->with(['user', 'course'])
                    ->latest('enrolled_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'warning',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'paused' => 'Ditangguhkan',
                        'completed' => 'Selesai',
                        default => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Enrolled At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Completed At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),
            ])
            ->defaultSort('enrolled_at', 'desc')
            ->paginated([5, 10, 25]);
    }
}
