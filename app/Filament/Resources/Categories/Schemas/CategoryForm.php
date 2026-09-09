<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),
                FileUpload::make('image')
                    ->label('Gambar Kategori')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('1024')
                    ->imageResizeTargetHeight('1024')
                    ->imagePreviewHeight('220')
                    ->preserveFilenames()
                    ->maxSize(2048)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}
