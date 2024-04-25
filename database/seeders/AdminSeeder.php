<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'business_name' => 'ritsConsulting',
            'business_address' => 'vegas, Nevada',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'city' => 'vegas',
            'state' => 'Nevada',
            'zip_code' => '901210',
            'email' => 'admin@admin.com',
            'phone_number' => '',
            'email_verified_at' => now(),
            'user_type' => 'Admin',
            'password' => Hash::make('verysafepassword'),
            'admin' => 1,
            'approved_at' => now(),
        ]);
    }
}
