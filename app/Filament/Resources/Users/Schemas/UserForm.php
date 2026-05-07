<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('role')
                    ->label('Peran')
                    ->required()
                    ->default(User::ROLE_USER)
                    ->options([
                        User::ROLE_USER => 'Pengguna',
                        User::ROLE_ADMIN => 'Admin',
                        User::ROLE_SUPER_ADMIN => 'Super Admin',
                    ])
                    ->disableOptionWhen(function (string $value): bool {
                        $authUser = Auth::user();

                        if (! $authUser instanceof User) {
                            return true;
                        }

                        if ($authUser->hasRole(User::ROLE_SUPER_ADMIN)) {
                            return false;
                        }

                        return in_array($value, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN], true);
                    }),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state): bool => filled($state)),
            ]);
    }
}
