<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'approved_by')) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->after('assigned_to')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('activities', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('activities', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }

            if (Schema::hasColumn('activities', 'approved_at')) {
                $table->dropColumn('approved_at');
            }

            if (Schema::hasColumn('activities', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};
