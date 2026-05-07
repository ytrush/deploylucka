<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $actor = Auth::user();
        $targetRole = (string) ($data['role'] ?? User::ROLE_USER);

        if (
            $actor instanceof User
            && ! $actor->hasRole(User::ROLE_SUPER_ADMIN)
            && in_array($targetRole, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN], true)
        ) {
            throw ValidationException::withMessages([
                'role' => 'Hanya super admin yang boleh membuat akun admin baru.',
            ]);
        }

        return $data;
    }
}
