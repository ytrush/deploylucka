<?php

namespace App\Filament\Resources\Instructors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstructorsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('image')
                ->label('Gambar')
                ->disk('public')
                ->square()
                ->imageSize(56)
                ->checkFileExistence(false)
                ->defaultImageUrl(asset('images/instructor-placeholder.svg')),
            TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable()->toggleable(),
            TextColumn::make('created_at')->label('Dibuat')->date()->sortable(),
        ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
