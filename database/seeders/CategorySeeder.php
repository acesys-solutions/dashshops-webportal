<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Food & Drinks',
                'badge' => '1701660679.png',
                'banner_image' => '1701660903.jpg',
                'created_at' => '2023-11-09 21:15:37',
                'updated_at' => '2023-12-04 02:46:03'
            ],
            [
                'name' => 'Electronics',
                'badge' => '1701661252.png',
                'banner_image' => '1701661252.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-04 02:40:52'
            ],
            [
                'name' => 'Health & Beauty',
                'badge' => '1701661526.png',
                'banner_image' => '1703174695.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:04:55'
            ],
            [
                'name' => 'Events',
                'badge' => '1701661340.png',
                'banner_image' => '1703174847.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:07:27'
            ],
            [
                'name' => 'Sports & Fitness',
                'badge' => '1701661324.png',
                'banner_image' => '1703175110.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:11:50'
            ],
            [
                'name' => 'Home & Garden',
                'badge' => '1701661367.png',
                'banner_image' => '1703176916.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:41:56'
            ],
            [
                'name' => 'Gifts & Flowers',
                'badge' => '1701661405.png',
                'banner_image' => '1703175678.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:21:18'
            ],
            [
                'name' => 'Pet Supplies',
                'badge' => '1701661426.png',
                'banner_image' => '1703176582.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:36:22'
            ],
            [
                'name' => 'Toys & Games',
                'badge' => '1701661439.png',
                'banner_image' => '1703176237.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:30:37'
            ],
            [
                'name' => 'Baby & Kids',
                'badge' => '1702442179.png',
                'banner_image' => '1703616313.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-26 18:45:13'
            ],
            [
                'name' => 'Office Supplies',
                'badge' => '1701661389.png',
                'banner_image' => '1703176171.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:29:31'
            ],
            [
                'name' => 'Auto & Tires',
                'badge' => '1701661473.png',
                'banner_image' => '1703176620.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:37:00'
            ],
            [
                'name' => 'RETAIL',
                'badge' => '1704077883.jpg',
                'banner_image' => '1704077909.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2024-01-01 02:58:29'
            ],
            [
                'name' => 'Clothing',
                'badge' => '1701661540.png',
                'banner_image' => '1703176286.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:31:26'
            ],
            [
                'name' => 'Travel',
                'badge' => '1701661505.png',
                'banner_image' => '1703176683.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:38:03'
            ],
            [
                'name' => 'Outdoor Activities',
                'badge' => '1701661641.png',
                'banner_image' => '1703615557.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-26 18:33:00'
            ],
            [
                'name' => 'Bath & Body',
                'badge' => '1701661590.png',
                'banner_image' => '1703176307.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:31:47'
            ],
            [
                'name' => 'Accessories',
                'badge' => '1701661606.png',
                'banner_image' => '1703175886.jpg',
                'created_at' => '2023-12-04 02:25:26',
                'updated_at' => '2023-12-21 16:24:46'
            ]
        ];

        Category::insert($categories);
    }
}
