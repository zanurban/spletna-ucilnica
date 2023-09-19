<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subject_teacher_id');
            $table->string('assignment_title');
            $table->text('assignment_description')->nullable();
            $table->string('material_file_path')->nullable();
            $table->date('completion_date');
            $table->timestamps();

            $table->foreign('subject_teacher_id')->references('id')->on('subject_teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
