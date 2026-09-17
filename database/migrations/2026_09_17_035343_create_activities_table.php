<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('module_id')
                ->constrained('modules')
                ->restrictOnDelete();

            $table->foreignId('activity_category_id')
                ->nullable()
                ->constrained('activity_categories')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->date('activity_date');

            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();

            $table->string('status')->default('draft');
            $table->string('input_source')->default('manual');

            $table->boolean('evidence_required')->default(false);
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['activity_date', 'status']);
            $table->index(['module_id', 'activity_date']);
            $table->index(['input_source']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
