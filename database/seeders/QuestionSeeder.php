<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Materi;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = Instructor::firstOrCreate(
            ['name' => 'Instructor Example'],
            ['image' => null]
        );

        $category = Category::firstOrCreate(
            ['name' => 'Web Development'],
            ['description' => 'Kategori contoh untuk kursus web development.']
        );

        $course = Course::firstOrCreate(
            ['title' => 'Laravel Quiz Course'],
            [
                'instructor_id' => $instructor->id,
                'category_id' => $category->id,
                'description' => 'Kursus contoh untuk menampilkan quiz pretest dan posttest.',
            ]
        );

        $materi = Materi::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Pengantar Laravel'],
            [
                'content' => 'Materi pengantar Laravel yang membahas routing, controller, dan view.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 15,
                'order' => 1,
            ]
        );

        $this->seedQuestion(
            $course,
            $materi,
            'Apa fungsi route di Laravel?',
            10,
            [
                ['option_text' => 'Mengatur jalur URL ke controller atau closure', 'is_correct' => true],
                ['option_text' => 'Menyimpan data pengguna ke database', 'is_correct' => false],
                ['option_text' => 'Mengirim email notifikasi secara otomatis', 'is_correct' => false],
                ['option_text' => 'Menampilkan file CSS pada halaman', 'is_correct' => false],
            ]
        );

        $this->seedQuestion(
            $course,
            $materi,
            'Bagian mana di Laravel yang biasanya menangani logika bisnis?',
            10,
            [
                ['option_text' => 'Controller', 'is_correct' => true],
                ['option_text' => 'Blade view', 'is_correct' => false],
                ['option_text' => 'Public folder', 'is_correct' => false],
                ['option_text' => 'Routes file', 'is_correct' => false],
            ]
        );

        $this->seedQuestion(
            $course,
            $materi,
            'Apa yang dimaksud dengan "middleware" di Laravel?',
            10,
            [
                ['option_text' => 'Fungsi yang dijalankan sebelum atau sesudah request diproses', 'is_correct' => true],
                ['option_text' => 'Template untuk menampilkan data', 'is_correct' => false],
                ['option_text' => 'Sistem caching database', 'is_correct' => false],
                ['option_text' => 'Method untuk mengirim email', 'is_correct' => false],
            ]
        );

        $this->seedQuestion(
            $course,
            $materi,
            'Bagaimana cara menampilkan data dari controller ke view di Laravel?',
            10,
            [
                ['option_text' => 'Mengembalikan view() dengan data sebagai parameter', 'is_correct' => true],
                ['option_text' => 'Membuat file di public folder', 'is_correct' => false],
                ['option_text' => 'Menambahkan data di routes/web.php saja', 'is_correct' => false],
                ['option_text' => 'Mengirim data melalui JavaScript tanpa controller', 'is_correct' => false],
            ]
        );
    }

    private function seedQuestion(Course $course, Materi $materi, string $questionText, int $points, array $options): void
    {
        $question = Question::firstOrCreate(
            ['course_id' => $course->id, 'question' => $questionText],
            [
                'materi_id' => $materi->id,
                'type' => 'multiple_choice',
                'points' => $points,
            ]
        );

        $question->options()->delete();
        $question->options()->createMany($options);
    }
}
