<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->label('Course')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($set, $state): void {
                        if (! filled($state)) {
                            return;
                        }

                        $nextOrder = (int) (Section::query()->where('course_id', $state)->max('order') ?? 0) + 1;
                        $set('order', $nextOrder);
                    })
                    ->placeholder('Pilih course')
                    ->rules(['exists:courses,id']),
                TextInput::make('title')
                    ->label('Judul Bagian')
                    ->required()
                    ->placeholder('Contoh: Pengenalan Laravel')
                    ->maxLength(255),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->helperText('Urutan diisi otomatis saat course dipilih, tapi tetap bisa diubah.'),
            ]);
    }
}
