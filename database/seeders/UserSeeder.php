<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => "Daiana",
            'email' => 'daiana@admin.com',
            'password' => Hash::make('123456789'),
            'is_admin' => 1,
            'email_verified_at' => now(),
            'phone_number' => '123456',
            'otp' => 1
        ]);
    }
}
