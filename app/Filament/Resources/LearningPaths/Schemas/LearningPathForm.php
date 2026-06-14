<?php

namespace App\Filament\Resources\LearningPaths\Schemas;

use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LearningPathForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Roadmap')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(4)
                ->maxLength(650),

            MultiSelect::make('courses')
                ->label('Course')
                ->relationship('courses', 'title')
                ->searchable()
                ->preload()
                ->helperText('Pilih course yang termasuk dalam learning path.'),
        ]);
    }
}
