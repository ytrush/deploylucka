<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Course;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Section')
                    ->required()
                    ->placeholder('Contoh: Web Development')
                    ->maxLength(255),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->helperText('Urutan section di dashboard.'),
                Select::make('course_ids')
                    ->label('Courses dalam Section ini')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->options(fn () => Course::whereNull('section_id')
                        ->orWhere('section_id', request()->route('record'))
                        ->pluck('title', 'id'))
                    ->helperText('Pilih course yang ingin dimasukkan ke section ini.'),
            ]);
    }
}
