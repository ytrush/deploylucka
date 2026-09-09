<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('instructors') && ! Schema::hasColumn('instructors', 'email')) {
            Schema::table('instructors', function (Blueprint $table): void {
                $table->string('email')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('instructors') && Schema::hasColumn('instructors', 'email')) {
            Schema::table('instructors', function (Blueprint $table): void {
                $table->dropColumn('email');
            });
        }
    }
};
