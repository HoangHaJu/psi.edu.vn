<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_off', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('student_lesson_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('student_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('student_lesson_id')->references('id')->on('student_lessons')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_off');
    }
};
