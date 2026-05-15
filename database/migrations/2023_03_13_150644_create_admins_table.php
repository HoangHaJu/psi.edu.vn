<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->char('username', 100)->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->char('phone', 20)->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('remaining_leave_requests')->default(10);
            $table->integer('gender')->nullable();
            $table->text('avatar')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->string('link')->nullable();
            $table->text('video')->nullable();
            $table->text('country')->nullable();
            $table->text('national_flag')->nullable();
            $table->text('audio')->nullable();
            $table->text('education_level')->nullable();
            $table->text('token_active_account')->nullable();
            $table->text('token_get_password')->nullable();
            $table->integer('is_active')->default(1);
            $table->enum('current_type_ticket', ['none', 'normal', 'special'])->default('none');
            $table->tinyInteger('display')->default(0);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('admins')->insert([
            'username' => 'admin',
            'fullname' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_active' => '1',
            'avatar' => config('custom.images.avatarUser'),
            'password' => bcrypt('1'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('admins')->insert([
            'username' => 'student',
            'fullname' => 'Student',
            'email' => 'student@gmail.com',
            'is_active' => '1',
            'avatar' => config('custom.images.avatarUser'),
            'password' => bcrypt('1'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('admins')->insert([
            'username' => 'teacher',
            'fullname' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'is_active' => '1',
            'avatar' => config('custom.images.avatarUser'),
            'password' => bcrypt('1'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
