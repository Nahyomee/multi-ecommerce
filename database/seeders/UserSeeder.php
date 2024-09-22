<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@mail.com',
                'role' => 'user',
                'status' => 'active',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Vendor',
                'username' => 'vendor',
                'email' => 'vendor@mail.com',
                'role' => 'vendor',
                'status' => 'active',
                'password' => Hash::make('12345678')
            ],
        ]);
    }
}
