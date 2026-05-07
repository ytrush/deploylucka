<?php

namespace App\Filament\Resources\Questions\Pages;

use App\Filament\Resources\Questions\QuestionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function beforeCreate(): void
    {
        $this->validateOptions();
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
