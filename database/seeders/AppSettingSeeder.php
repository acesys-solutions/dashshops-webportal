<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppSetting::create([
            'user_id' => 1,
            'push_notification' => 1,
            'location' => 1,
            'disable_caching' => 0,
        ]);

        AppSetting::create([
            'user_id' => 2,
            'push_notification' => 1,
            'location' => 1,
            'disable_caching' => 0,
        ]);
    }
}
