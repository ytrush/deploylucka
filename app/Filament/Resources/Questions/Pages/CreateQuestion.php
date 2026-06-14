<?php

namespace App\Filament\Resources\Questions\Pages;

use App\Filament\Resources\Questions\QuestionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function beforeCreate(): void
    {
        try {
            $this->validateOptions();
        } catch (ValidationException $e) {
            Log::warning('Question create validation failed', ['state' => $this->form->getState(), 'error' => $e->getMessage()]);
            if (method_exists($this, 'notify')) {
                $this->notify('danger', $e->getMessage());
            }
            throw $e;
        }
    }

    private function validateOptions(): void
    {
        $formState = $this->form->getRawState();
        $options = collect($formState['options'] ?? []);

        if ($options->count() < 2) {
            throw ValidationException::withMessages([
                'options' => 'Minimal harus ada 2 opsi jawaban.',
            ]);
        }

        $correctAnswers = $options
            ->filter(fn(array $option): bool => (bool) ($option['is_correct'] ?? false))
            ->count();

        if ($correctAnswers !== 1) {
            throw ValidationException::withMessages([
                'options' => 'Harus ada tepat 1 jawaban benar.',
            ]);
        }

        if ($options->contains(fn(array $option): bool => blank($option['option_text'] ?? null))) {
            throw ValidationException::withMessages([
                'options' => 'Semua opsi harus diisi.',
            ]);
        }
    }
}
