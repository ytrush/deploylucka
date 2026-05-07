<?php

namespace App\Filament\Resources\Lessons\Schemas;

use App\Models\Materi;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LessonForm
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

                        $nextOrder = (int) (Materi::query()->where('course_id', $state)->max('order') ?? 0) + 1;
                        $set('order', $nextOrder);
                    })
                    ->placeholder('Pilih course')
                    ->rules(['exists:courses,id']),
                TextInput::make('title')
                    ->label('Judul Materi')
                    ->required()
                    ->placeholder('Contoh: Instalasi dan Setup')
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Konten Materi')
                    ->required()
                    ->rows(6)
                    ->placeholder('Isi penjelasan materi di sini...')
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->label('URL Video (Opsional)')
                    ->url()
                    ->placeholder('https://...')
                    ->maxLength(2048),
                TextInput::make('duration')
                    ->label('Durasi (menit)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
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
