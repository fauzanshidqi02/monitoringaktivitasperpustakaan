<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                ->constrained('activities')
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('original_name');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('file_type')->nullable();
            $table->text('description')->nullable();

            $table->string('drive_file_id')->nullable()->unique();
            $table->text('drive_url')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['activity_id']);
            $table->index(['uploaded_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_files');
    }
};
