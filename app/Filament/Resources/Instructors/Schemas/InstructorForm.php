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
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255)
                ->helperText('Email ini akan tampil untuk siswa yang ingin menghubungi instruktur.'),
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
