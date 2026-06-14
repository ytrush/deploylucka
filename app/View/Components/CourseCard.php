<?php

namespace App\View\Components;

use App\Models\Course;
use Illuminate\View\Component;
use Illuminate\View\View;

class CourseCard extends Component
{
    /**
     * The courses to display
     */
    public function __construct(
        public null|int $limit = null,
    ) {
    }

    /**
     * Get the courses to display
     */
    public function courses(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Course::query()
            ->with(['category', 'instructor', 'materis'])
            ->orderBy('id', 'desc');

        if ($this->limit) {
            $query->limit($this->limit);
        }

        return $query->get();
    }

    /**
     * Get the first materi video thumbnail for preview
     */
    public function getFirstVideoThumbnail(Course $course): ?string
    {
        $firstMateri = $course->materis->sortBy('order')->first();

        if (!$firstMateri || !$firstMateri->video_url) {
            return null;
        }

        $videoUrl = $firstMateri->video_url;

        // YouTube thumbnail
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtube\.com\/shorts\/|youtube\.com\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoUrl, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/mqdefault.jpg';
        }

        return null;
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('components.course-card', [
            'courses' => $this->courses(),
        ]);
    }
}