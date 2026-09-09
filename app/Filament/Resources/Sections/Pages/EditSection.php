<?php

namespace App\Filament\Resources\Sections\Pages;

use App\Filament\Resources\Sections\SectionResource;
use App\Models\Course;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSection extends EditRecord
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['course_ids'] = Course::where('section_id', $this->record->id)
            ->pluck('id')
            ->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->courseIds = $data['course_ids'] ?? [];
        unset($data['course_ids']);

        return $data;
    }

    protected function afterSave(): void
    {
        $newCourseIds = $this->courseIds ?? [];
        $sectionId = $this->record->id;

        // Hapus section_id dari courses yang tidak dipilih lagi
        Course::where('section_id', $sectionId)
            ->whereNotIn('id', $newCourseIds)
            ->update(['section_id' => null]);

        // Assign courses yang dipilih
        if (!empty($newCourseIds)) {
            Course::whereIn('id', $newCourseIds)->update(['section_id' => $sectionId]);
        }
    }
}
