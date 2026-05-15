<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Setting\SettingTypeInput;
use App\Enums\Setting\SettingGroup;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'setting_key' => 'favicon',
                'setting_name' => 'Favicon:',
                'plain_value' => 'assets/images/default-avatar.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'logo',
                'setting_name' => 'Logo:',
                'plain_value' => 'assets/images/default-avatar.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'hotline',
                'setting_name' => 'Hotline',
                'plain_value' => '0359777777',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'zalo',
                'setting_name' => 'Zalo',
                'plain_value' => 'https://www.facebook.com/mevivu',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'tiktok',
                'setting_name' => 'Tiktok',
                'plain_value' => 'https://www.tiktok.com/@psienglish',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'youtube',
                'setting_name' => 'Youtube',
                'plain_value' => 'https://youtube.com/@psienglish',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'instagram',
                'setting_name' => 'Instagram',
                'plain_value' => 'https://www.instagram.com/tienganhpsi',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'facebook',
                'setting_name' => 'Facebook',
                'plain_value' => 'https://www.facebook.com/TiengAnhPSI',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
        ]);
        DB::table('settings')->insert([
            [
                'setting_key' => 'payment_info',
                'setting_name' => 'Thông tin chuyển khoản',
                'plain_value' => '<p><strong>NGUYỄN PH&Uacute;C NH&Acirc;N - ACB - PGD AN DONG </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 194500879</strong></p>

<p>----------------</p>

<p><strong>NGUYỄN PH&Uacute;C NH&Acirc;N - Dong A Bank - Q10 </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 0109527645 </strong></p>

<p>------------------</p>

<p><strong>NGUYEN PHUC NHAN - Vietcombank - CN Ph&uacute; Thọ </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 0421000488622 </strong></p>

<p>------------------</p>

<p><strong>NGUYEN PHUC NHAN - Sacombank - PGD HOA HAO </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 060200565455 </strong></p>

<p>------------------</p>

<p><strong>NGUYEN PHUC NHAN - Agribank - CN Ly Thuong Kiet </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 1603205538619 </strong></p>

<p>------------------</p>

<p><strong>NGUYEN PHUC NHAN - OCB- CN Cho Lon </strong></p>

<p><strong>SỐ T&Agrave;I KHOẢN: 0017100006209007</strong></p>',
                'type_input' => SettingTypeInput::Ckeditor,
                'group' => 1
            ],
        ]);
    }
}
