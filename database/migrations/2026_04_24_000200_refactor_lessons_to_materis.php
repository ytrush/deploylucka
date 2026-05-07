<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function hasForeignKey(string $table, string $constraint): bool
    {
        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('lessons') && !Schema::hasTable('materis')) {
            Schema::rename('lessons', 'materis');
        }

        if (!Schema::hasTable('materis')) {
            return;
        }

        Schema::table('materis', function (Blueprint $table): void {
            if (!Schema::hasColumn('materis', 'course_id')) {
                $table->foreignId('course_id')->nullable()->after('id');
            }
        });

        if (Schema::hasColumn('materis', 'section_id')) {
            DB::table('materis')
                ->join('sections', 'sections.id', '=', 'materis.section_id')
                ->update(['materis.course_id' => DB::raw('sections.course_id')]);
        }

        Schema::table('materis', function (Blueprint $table): void {
            if (Schema::hasColumn('materis', 'course_id') && ! $this->hasForeignKey('materis', 'materis_course_id_foreign')) {
                $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
            }

            if (Schema::hasColumn('materis', 'section_id')) {
                if ($this->hasForeignKey('materis', 'materis_section_id_foreign')) {
                    $table->dropForeign(['section_id']);
                }

                if ($this->hasForeignKey('materis', 'lessons_section_id_foreign')) {
                    $table->dropForeign('lessons_section_id_foreign');
                }

                $table->dropColumn('section_id');
            }
        });

        if (Schema::hasTable('questions') && Schema::hasColumn('questions', 'lesson_id') && !Schema::hasColumn('questions', 'materi_id')) {
            Schema::table('questions', function (Blueprint $table): void {
                $table->foreignId('materi_id')->nullable()->after('id');
            });

            DB::table('questions')->update(['materi_id' => DB::raw('lesson_id')]);

            Schema::table('questions', function (Blueprint $table): void {
                if (! $this->hasForeignKey('questions', 'questions_materi_id_foreign')) {
                    $table->foreign('materi_id')->references('id')->on('materis')->cascadeOnDelete();
                }

                if ($this->hasForeignKey('questions', 'questions_lesson_id_foreign')) {
                    $table->dropForeign(['lesson_id']);
                }

                $table->dropColumn('lesson_id');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('questions') && Schema::hasColumn('questions', 'materi_id') && !Schema::hasColumn('questions', 'lesson_id')) {
            Schema::table('questions', function (Blueprint $table): void {
                $table->foreignId('lesson_id')->nullable()->after('id');
            });

            DB::table('questions')->update(['lesson_id' => DB::raw('materi_id')]);

            Schema::table('questions', function (Blueprint $table): void {
                $table->foreign('lesson_id')->references('id')->on('materis')->cascadeOnDelete();
                $table->dropForeign(['materi_id']);
                $table->dropColumn('materi_id');
            });
        }

        if (Schema::hasTable('materis')) {
            Schema::table('materis', function (Blueprint $table): void {
                if (Schema::hasColumn('materis', 'course_id')) {
                    $table->dropForeign(['course_id']);
                    $table->dropColumn('course_id');
                }
            });

            if (!Schema::hasTable('lessons')) {
                Schema::rename('materis', 'lessons');
            }
        }
    }
};
