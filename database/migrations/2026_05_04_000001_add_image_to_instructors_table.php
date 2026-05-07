<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('instructors') && ! Schema::hasColumn('instructors', 'image')) {
            Schema::table('instructors', function (Blueprint $table): void {
                $table->string('image')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('instructors') && Schema::hasColumn('instructors', 'image')) {
            Schema::table('instructors', function (Blueprint $table): void {
                $table->dropColumn('image');
            });
        }
    }
};
