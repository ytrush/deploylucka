<?php

namespace App\Filament\Resources\Instructors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InstructorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama')->required()->maxLength(255),
            FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->directory('instructors')
                ->disk('public')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth('1024')
                ->imageResizeTargetHeight('1024')
                ->imagePreviewHeight('220')
                ->preserveFilenames()
                ->maxSize(2048),
        ]);
    }
}
