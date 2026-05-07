<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('courses') && Schema::hasColumn('courses', 'level')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->dropColumn('level');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courses') && ! Schema::hasColumn('courses', 'level')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->string('level')->nullable()->after('description');
            });
        }
    }
};
