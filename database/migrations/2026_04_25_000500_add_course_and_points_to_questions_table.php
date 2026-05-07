<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table): void {
            if (! Schema::hasColumn('questions', 'course_id')) {
                $table->foreignId('course_id')->nullable()->after('id')->constrained('courses')->cascadeOnDelete();
            }

            if (! Schema::hasColumn('questions', 'points')) {
                $table->unsignedInteger('points')->default(10)->after('type');
            }
        });

        if (Schema::hasColumn('questions', 'materi_id') && Schema::hasColumn('questions', 'course_id')) {
            DB::statement('UPDATE questions q JOIN materis m ON m.id = q.materi_id SET q.course_id = m.course_id WHERE q.course_id IS NULL');
        }

        if (Schema::hasColumn('questions', 'type')) {
            DB::table('questions')->update(['type' => 'multiple_choice']);
        }

        Schema::table('questions', function (Blueprint $table): void {
            if (Schema::hasColumn('questions', 'course_id')) {
                $table->unsignedBigInteger('course_id')->nullable(false)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table): void {
            if (Schema::hasColumn('questions', 'points')) {
                $table->dropColumn('points');
            }

            if (Schema::hasColumn('questions', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }
        });
    }
};
