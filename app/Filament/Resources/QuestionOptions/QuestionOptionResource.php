<?php

namespace App\Filament\Resources\QuestionOptions;

use App\Filament\Resources\QuestionOptions\Pages\CreateQuestionOption;
use App\Filament\Resources\QuestionOptions\Pages\EditQuestionOption;
use App\Filament\Resources\QuestionOptions\Pages\ListQuestionOptions;
use App\Filament\Resources\QuestionOptions\Schemas\QuestionOptionForm;
use App\Filament\Resources\QuestionOptions\Tables\QuestionOptionsTable;
use App\Models\QuestionOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'Opsi Soal';

    protected static ?string $pluralModelLabel = 'Opsi Soal';

    protected static ?string $modelLabel = 'Opsi';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Eduweb';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return QuestionOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionOptionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'question:id,question',
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionOptions::route('/'),
            'create' => CreateQuestionOption::route('/create'),
            'edit' => EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
