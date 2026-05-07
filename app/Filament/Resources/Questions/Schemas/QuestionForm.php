<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
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
                    ->afterStateUpdated(fn ($set) => $set('materi_id', null))
                    ->placeholder('Pilih course')
                    ->rules(['exists:courses,id']),
                Select::make('materi_id')
                    ->relationship(
                        name: 'materi',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn ($query, $get) => $query
                            ->when(
                                filled($get('course_id')),
                                fn ($q) => $q->where('course_id', $get('course_id')),
                            )
                    )
                    ->label('Materi (Opsional)')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Boleh dikosongkan')
                    ->rules(['exists:materis,id']),
                Textarea::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->rows(4)
                    ->placeholder('Contoh: Apa fungsi route middleware di Laravel?')
                    ->columnSpanFull(),
                TextInput::make('points')
                    ->label('Nilai Soal')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->suffix('poin')
                    ->default(10),
                Hidden::make('type')
                    ->default('multiple_choice')
                    ->dehydrated(true),
                Repeater::make('options')
                    ->relationship()
                    ->label('Pilihan Jawaban')
                    ->defaultItems(4)
                    ->minItems(2)
                    ->maxItems(6)
                    ->addActionLabel('Tambah Opsi')
                    ->collapsible()
                    ->schema([
                        TextInput::make('option_text')
                            ->label('Opsi')
                            ->required()
                            ->placeholder('Tulis teks opsi jawaban')
                            ->maxLength(255),
                        Toggle::make('is_correct')
                            ->label('Jawaban Benar')
                            ->inline(false)
                            ->default(false),
                    ])
                    ->columnSpanFull()
                    ->helperText('Tandai tepat satu opsi sebagai jawaban benar supaya penilaian tidak membingungkan.'),
            ]);
    }
}
