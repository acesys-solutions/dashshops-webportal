<?php

namespace Database\Seeders;

use App\Models\Ads;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = [
            [
                'image' => '1704139954.jpg',
                'url' => 'https://bankstips.com/gtbank-sort-code-for-lagos-state/',
                'total_clicks' => 10,
                'start_date' => '2024-01-02 00:00:01',
                'end_date' => '2024-02-28 23:59:59',
                'created_by' => 2,
                'modified_by' => 2,
                'created_at' => '2024-01-01 20:12:34',
                'updated_at' => '2024-01-27 10:38:09'
            ],
            [
                'image' => '1706200815.jpg',
                'url' => 'https://www.pinterest.com/',
                'total_clicks' => 16,
                'start_date' => '2024-01-22 00:00:01',
                'end_date' => '2024-02-29 23:59:59',
                'created_by' => 2,
                'modified_by' => 2,
                'created_at' => '2024-01-25 16:40:15',
                'updated_at' => '2024-01-27 10:40:20'
            ],
            [
                'image' => '1706200845.jpg',
                'url' => 'https://www.pinterest.com/',
                'total_clicks' => 10,
                'start_date' => '2024-01-18 00:00:01',
                'end_date' => '2024-02-29 23:59:59',
                'created_by' => 2,
                'modified_by' => 2,
                'created_at' => '2024-01-25 16:40:45',
                'updated_at' => '2024-01-27 10:39:15'
            ],
            [
                'image' => '1706200890.jpg',
                'url' => 'https://www.pinterest.com/',
                'total_clicks' => 16,
                'start_date' => '2024-01-16 00:00:01',
                'end_date' => '2024-02-29 23:59:59',
                'created_by' => 2,
                'modified_by' => 2,
                'created_at' => '2024-01-25 16:41:30',
                'updated_at' => '2024-01-27 10:39:34'
            ],
        ];

        foreach ($ads as $ad) {
            Ads::create($ad);
        }
    }
}
