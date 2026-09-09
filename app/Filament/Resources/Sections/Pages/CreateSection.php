<?php

namespace App\Filament\Resources\Sections\Pages;

use App\Filament\Resources\Sections\SectionResource;
use App\Models\Course;
use Filament\Resources\Pages\CreateRecord;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->courseIds = $data['course_ids'] ?? [];
        unset($data['course_ids']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->courseIds)) {
            Course::whereIn('id', $this->courseIds)->update(['section_id' => $this->record->id]);
        }
    }
}
