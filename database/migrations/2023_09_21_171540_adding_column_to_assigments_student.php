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
            $table->string('assigment_file_path');  // Assuming you want to add a string column
        });
        Schema::table('assignment_students', function (Blueprint $table) {
            $table->string('assigment_description');  // Assuming you want to add a string column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_students', function (Blueprint $table) {
            //
        });
    }
};
