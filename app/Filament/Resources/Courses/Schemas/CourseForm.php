<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('instructor_id')
                    ->label('Instruktur')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Pilih instruktur')
                    ->helperText('Pilih instruktur untuk course ini.')
                    ->rules(['exists:instructors,id'])
                    ->relationship(
                        name: 'instructor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query->orderBy('name'),
                    ),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih kategori')
                    ->rules(['exists:categories,id']),
                TextInput::make('title')
                    ->label('Judul Course')
                    ->required()
                    ->placeholder('Contoh: Laravel dari Nol')
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(5)
                    ->placeholder('Tuliskan ringkasan course secara singkat dan jelas.')
                    ->columnSpanFull(),
            ]);
    }
}
