<?php

namespace App\Filament\Resources\Lessons\Schemas;

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
                Select::make('section_id')
                    ->relationship('section', 'title')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->url(),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('order')
                    ->required()
                    ->numeric(),
            ]);
    }
}
