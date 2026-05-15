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
        Schema::create('student_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('teacher_lesson_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('day_off_type')->default(3);
            $table->date('date');
            $table->date('ticket_date')->nullable();
            $table->time('start_time');
            $table->longText('note')->nullable();
            $table->longText('file')->nullable();
            $table->longText('file_link')->nullable();
            $table->tinyInteger('rate')->nullable();
            $table->tinyInteger('interaction')->nullable();
            $table->tinyInteger('listening')->nullable();
            $table->tinyInteger('communication')->nullable();
            $table->tinyInteger('pronunciation')->nullable();
            $table->tinyInteger('vocab_grammar')->nullable();
            $table->text('course_name');
            $table->enum('ticket_type', ['normal', 'special'])->nullable();
            $table->date('ticket_date');
            $table->dateTime('student_joined_at')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('teacher_lesson_id')->references('id')->on('teacher_lessons')->onDelete('cascade')->onUpdate('restrict');

            $table->index('admin_id');
            $table->index('teacher_lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_lessons', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['teacher_lesson_id']);
        });
        Schema::dropIfExists('student_lessons');
    }
};
