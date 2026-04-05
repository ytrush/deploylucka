<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'section_id' => ['sometimes', 'integer', 'exists:sections,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'duration' => ['sometimes', 'integer', 'min:0'],
            'order' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
