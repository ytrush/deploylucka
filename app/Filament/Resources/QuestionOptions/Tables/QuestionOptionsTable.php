<?php

namespace App\Filament\Resources\QuestionOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question.question')
                    ->searchable()
                    ->limit(70),
                TextColumn::make('option_text')
                    ->searchable()
                    ->limit(60),
                IconColumn::make('is_correct')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('question_id')
                    ->label('Soal')
                    ->relationship('question', 'question')
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
