<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('assignment_students', function (Blueprint $table) {
            $table->string('assignment_file_path');
            $table->string('assignment_student_comment');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_students', function (Blueprint $table) {
            Schema::dropIfExists('assigment_file_path');
            Schema::dropIfExists('assigment_description');
        });
    }
};
