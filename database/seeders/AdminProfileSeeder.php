<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@mail.com')->first();
        Vendor::create([
            'user_id' => $user->id,
            'banner' => 'uploads/Admin2087525261.png',
            'phone' => '09090090090',
            'email' => 'admin@mail.com',
            'address' => 'An address',
            'description' => 'Random description',
        ]);
    }
}
