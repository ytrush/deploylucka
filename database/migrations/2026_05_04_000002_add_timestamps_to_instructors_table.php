<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('instructors')) {
            return;
        }

        Schema::table('instructors', function (Blueprint $table): void {
            if (! Schema::hasColumn('instructors', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('image');
            }

            if (! Schema::hasColumn('instructors', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('instructors')) {
            return;
        }

        Schema::table('instructors', function (Blueprint $table): void {
            if (Schema::hasColumn('instructors', 'updated_at')) {
                $table->dropColumn('updated_at');
            }

            if (Schema::hasColumn('instructors', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
};
