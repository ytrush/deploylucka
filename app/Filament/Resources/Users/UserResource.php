<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Eduweb';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $authUser = Auth::user();

        if ($authUser instanceof User && ! $authUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            $query->where('role', '!=', User::ROLE_SUPER_ADMIN)
                ->where('role', '!=', '3');
        }

        return $query;
    }

    public static function canViewAny(): bool
    {
        $authUser = Auth::user();

        return $authUser instanceof User
            && $authUser->hasAnyRole([User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN, '2', '3']);
    }

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User || ! $record instanceof User) {
            return false;
        }

        if ($authUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            return true;
        }

        return ! $record->hasRole(User::ROLE_SUPER_ADMIN);
    }

    public static function canDelete(Model $record): bool
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User || ! $record instanceof User) {
            return false;
        }

        if (! $authUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            return false;
        }

        return $authUser->id !== $record->id;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
