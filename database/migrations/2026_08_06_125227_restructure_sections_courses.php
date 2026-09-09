<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah section_id ke courses (nullable dulu)
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable()->after('id');
        });

        // 2. Map courses ke sections berdasarkan data existing
        // Section 5 (CSS) → Course 8 (CSS Dasar)
        DB::table('courses')->where('id', 8)->update(['section_id' => 5]);
        // Section 6 (HTML Bab 1) → Course 7 (HTML Dasar)
        DB::table('courses')->where('id', 7)->update(['section_id' => 6]);
        // Section 7 (HTML Bab 1) → Course 11 (HTML5)
        DB::table('courses')->where('id', 11)->update(['section_id' => 7]);

        // 3. Tambah foreign key untuk section_id di courses
        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')->nullOnDelete();
        });

        // 4. Hapus course_id dari sections
        Schema::table('sections', function (Blueprint $table) {
            if (DB::getSchemaBuilder()->hasColumn('sections', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }
        });
    }

    public function down(): void
    {
        // 1. Kembalikan course_id ke sections
        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
        });

        // 2. Map kembali berdasarkan section_id
        DB::table('courses')
            ->whereNotNull('section_id')
            ->each(function ($course) {
                DB::table('sections')
                    ->where('id', $course->section_id)
                    ->update(['course_id' => $course->id]);
            });

        // 3. Hapus section_id dari courses
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
    }
};
