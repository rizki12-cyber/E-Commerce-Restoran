<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Dapur Kaysan', 'group' => 'general', 'type' => 'string'],
            ['key' => 'app_tagline', 'value' => 'Masakan Rumahan dengan Rasa Bintang Lima', 'group' => 'general', 'type' => 'string'],
            ['key' => 'contact_phone', 'value' => '081234567890', 'group' => 'general', 'type' => 'string'],
            ['key' => 'contact_email', 'value' => 'hello@dapurkaysan.test', 'group' => 'general', 'type' => 'string'],
            ['key' => 'primary_color', 'value' => '#B76535', 'group' => 'theme', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            StoreSetting::create($setting);
        }
    }
}