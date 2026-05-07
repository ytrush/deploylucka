<?php

namespace App\Filament\Resources\Questions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('materi.title')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('question')
                    ->searchable()
                    ->limit(80),
                TextColumn::make('points')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('options_count')
                    ->label('Jumlah Opsi')
                    ->counts('options')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('materi_id')
                    ->label('Materi')
                    ->relationship('materi', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}
