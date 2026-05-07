<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // attempt to drop existing foreign key to users
            try {
                $table->dropForeign(['instructor_id']);
            } catch (\Throwable $e) {
                // ignore if it does not exist
            }

            // attempt to drop the column, then recreate referencing instructors
            try {
                $table->dropColumn('instructor_id');
            } catch (\Throwable $e) {
                // ignore if missing
            }

            $table->foreignId('instructor_id')->nullable()->constrained('instructors')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Drop FK to instructors
            try {
                $table->dropForeign(['instructor_id']);
            } catch (\Throwable $e) {
            }

            try {
                $table->dropColumn('instructor_id');
            } catch (\Throwable $e) {
            }

            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
        });
    }
};
