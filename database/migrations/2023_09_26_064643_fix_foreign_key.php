<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subject_students', function (Blueprint $table) {
            $table->dropForeign(['subject_teacher_id']);
        });

        Schema::table('subject_students', function (Blueprint $table) {
            $table->foreign('subject_teacher_id')
                ->references('id')->on('subject_teachers')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
{

    Schema::table('subject_students', function (Blueprint $table) {
        $table->dropForeign(['subject_teacher_id']);
    });

    Schema::table('subject_students', function (Blueprint $table) {
        $table->foreign('subject_teacher_id')
              ->references('id')->on('subject_teachers')
              ->onDelete('cascade');
    });
}

};