<?php

namespace App\Filament\Resources\QuestionOptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question_id')
                    ->relationship('question', 'question')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->rules(['exists:questions,id']),
                Textarea::make('option_text')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_correct')
                    ->default(false)
                    ->required(),
            ]);
    }
}
