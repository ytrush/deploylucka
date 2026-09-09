<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages\CreateEnrollment;
use App\Filament\Resources\EnrollmentResource\Pages\EditEnrollment;
use App\Filament\Resources\EnrollmentResource\Pages\ListEnrollments;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationLabel = 'Enrollment';

    protected static ?string $pluralModelLabel = 'Enrollment';

    protected static ?string $modelLabel = 'Enrollment';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Eduweb';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(1),
                
                \Filament\Forms\Components\Select::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(1),
                
                \Filament\Forms\Components\Select::make('status')
                    ->options(Enrollment::getStatusOptions())
                    ->default(Enrollment::STATUS_ACTIVE)
                    ->required()
                    ->columnSpan(1),
                
                \Filament\Forms\Components\DateTimePicker::make('enrolled_at')
                    ->default(now())
                    ->required()
                    ->columnSpan(1),
                
                \Filament\Forms\Components\DateTimePicker::make('completed_at')
                    ->columnSpan(1),
                
                \Filament\Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpan('full'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                \Filament\Tables\Columns\TextColumn::make('course.title')
                    ->searchable()
                    ->sortable()
                    ->label('Course'),
                \Filament\Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => Enrollment::STATUS_ACTIVE,
                        'warning' => Enrollment::STATUS_PAUSED,
                        'info' => Enrollment::STATUS_COMPLETED,
                    ])
                    ->formatStateUsing(fn (string $state): string => Enrollment::getStatusOptions()[$state] ?? $state)
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('enrolled_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Enrolled At'),
                \Filament\Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Completed At'),
                \Filament\Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->tooltip(fn (Enrollment $record): ?string => $record->notes),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options(Enrollment::getStatusOptions()),
                \Filament\Tables\Filters\Filter::make('has_completed')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('completed_at'))
                    ->label('Completed Only'),
            ])
            ->defaultSort('enrolled_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'course']);
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
            'index' => ListEnrollments::route('/'),
            'create' => CreateEnrollment::route('/create'),
            'edit' => EditEnrollment::route('/{record}/edit'),
        ];
    }
}
