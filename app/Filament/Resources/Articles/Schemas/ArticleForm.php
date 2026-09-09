<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Textarea::make('excerpt')
                    ->nullable()
                    ->rows(3)
                    ->maxLength(500),
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Gambar Artikel')
                    ->nullable()
                    ->image()
                    ->disk('public')
                    ->directory('articles')
                    ->preserveFilenames()
                    ->imagePreviewHeight('220')
                    ->maxSize(2048)
                    ->helperText('Unggah gambar untuk artikel ini.'),
                Toggle::make('is_published')
                    ->label('Publish')
                    ->default(false)
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $set('published_at', now());
                        } else {
                            $set('published_at', null);
                        }
                    }),
                DatePicker::make('published_at')
                    ->label('Published At')
                    ->nullable()
                    ->visible(fn($get) => $get('is_published')),
            ]);
    }
}
