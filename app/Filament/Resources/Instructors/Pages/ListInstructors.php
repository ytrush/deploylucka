<?php

namespace App\Filament\Resources\Instructors\Pages;

use App\Filament\Resources\Instructors\InstructorResource;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Models\User;

class ListInstructors extends ListRecords
{
    protected static string $resource = InstructorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(function (): bool {
                    $user = Auth::user();
                    return $user instanceof User && $user->hasRole(User::ROLE_SUPER_ADMIN);
                }),
        ];
    }

    public function mount(): void
    {
        $user = Auth::user();
        if (! ($user instanceof User) || ! $user->hasRole(User::ROLE_SUPER_ADMIN)) {
            abort(403);
        }

        parent::mount();
    }
}
