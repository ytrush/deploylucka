<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $actor = Auth::user();
        $targetRole = (string) ($data['role'] ?? $this->record->role ?? User::ROLE_USER);

        if (
            $actor instanceof User
            && ! $actor->hasRole(User::ROLE_SUPER_ADMIN)
            && in_array($targetRole, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN], true)
        ) {
            throw ValidationException::withMessages([
                'role' => 'Hanya super admin yang boleh menjadikan pengguna sebagai admin.',
            ]);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
