<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();
            $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $table->text('teaching_subject')->nullable();
            $table->integer('first_term')->nullable();
            $table->integer('mid_term')->nullable();
            $table->integer('final_term')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';

        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
