<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'title' => 'Sửa buổi học đã đăng ký',
            'name' => 'updateStudentLesson',
            'guard_name' => 'admin',
            'module_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
