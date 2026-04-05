<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['sometimes', 'integer', 'exists:courses,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'order' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
