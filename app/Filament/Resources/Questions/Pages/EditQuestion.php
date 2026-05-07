<?php

namespace App\Filament\Resources\Questions\Pages;

use App\Filament\Resources\Questions\QuestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    protected function beforeSave(): void
    {
        $this->validateOptions();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    private function validateOptions(): void
    {
        $options = collect($this->form->getState()['options'] ?? []);

        if ($options->count() < 2) {
            throw ValidationException::withMessages([
                'options' => 'Minimal harus ada 2 opsi jawaban.',
            ]);
        }

        $correctAnswers = $options
            ->filter(fn (array $option): bool => (bool) ($option['is_correct'] ?? false))
            ->count();

        if ($correctAnswers !== 1) {
            throw ValidationException::withMessages([
                'options' => 'Harus ada tepat 1 jawaban benar.',
            ]);
        }

        if ($options->contains(fn (array $option): bool => blank($option['option_text'] ?? null))) {
            throw ValidationException::withMessages([
                'options' => 'Semua opsi harus diisi.',
            ]);
        }
    }
}
