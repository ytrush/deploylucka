<?php

namespace App\Filament\Resources\Instructors\Pages;

use App\Filament\Resources\Instructors\InstructorResource;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;

class EditInstructor extends EditRecord
{
    protected static string $resource = InstructorResource::class;

    public function mount(string|int $record): void
    {
        $user = Auth::user();
        if (! ($user instanceof \App\Models\User) || ! $user->hasRole(\App\Models\User::ROLE_SUPER_ADMIN)) {
            abort(403);
        }

        parent::mount($record);
    }
}
