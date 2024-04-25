<?php

namespace Database\Seeders;

use App\Models\Retailer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RetailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Retailer::create([
            'business_name' => 'Acesys Solutions',
            'business_address' => '127 Bateman St, Salisbury, MD 21804, USA',
            'business_description' => 'Acesys Solutions is a software development company that specializes in web and mobile applications.',
            'firstname' => 'Fleming',
            'lastname' => 'Usiomah',
            'phone_number' => '+2348029563955',
            'email' => 'Fleming.paul@acesys.com.ng',
            'type_of_business' => 1,
            'business_hours_open' => 'Monday-Friday:11am-11pm',
            'business_hours_close' => 'Saturday-Sunday:9am-6pm',
            'city' => 'Salisbury',
            'state' => 'Maryland',
            'zip_code' => 21804,
            'web_url' => 'https://acesys.com.ng',
            'banner_image' => 'logo.png',
            'password' => Hash::make('verysafepassword'),
            'longitude' => '-75.6032633',
            'latitude' => '38.366853',
            'island' => null,
            'approval_status' => 'Approved',
            'approved_at' => now(),
            'from_mobile' => 0,
            'created_by' => 2,
            'modified_by' => 2,
        ]);
    }
}
