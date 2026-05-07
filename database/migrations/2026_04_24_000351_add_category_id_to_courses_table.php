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
        Schema::table('courses', function (Blueprint $table): void {
            if (!Schema::hasColumn('courses', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('instructor_id')->constrained('categories')->nullOnDelete();
            }
        });

        if (Schema::hasColumn('courses', 'category')) {
            $names = DB::table('courses')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category');

            foreach ($names as $name) {
                DB::table('categories')->updateOrInsert(
                    ['name' => $name],
                    ['description' => null]
                );
            }

            DB::statement('UPDATE courses c JOIN categories cat ON cat.name = c.category SET c.category_id = cat.id WHERE c.category IS NOT NULL AND c.category <> ""');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            if (Schema::hasColumn('courses', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};
