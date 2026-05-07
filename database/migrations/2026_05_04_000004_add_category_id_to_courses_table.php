<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('courses') && ! Schema::hasColumn('courses', 'category_id')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->foreignId('category_id')
                    ->after('instructor_id')
                    ->constrained('categories')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courses') && Schema::hasColumn('courses', 'category_id')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('category_id');
            });
        }
    }
};
