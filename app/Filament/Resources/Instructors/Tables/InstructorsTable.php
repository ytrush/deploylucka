<?php

namespace App\Filament\Resources\Instructors\Tables;

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
            TextColumn::make('created_at')->label('Dibuat')->date()->sortable(),
        ])
        ->defaultSort('created_at', 'desc');
    }
}
