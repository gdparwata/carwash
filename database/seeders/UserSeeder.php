<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password yang sama untuk semua user dummy
        $defaultPassword = Hash::make('123456');
        
        // 1 Owner
        User::factory()->create([
            'name' => 'Owner CarWash',
            'email' => 'owner@carwash.com',
            'role' => 'owner',
            'password' => $defaultPassword,
        ]);
        
        // 2 Admin
        User::factory()->create([
            'name' => 'Admin 1',
            'email' => 'admin1@carwash.com',
            'role' => 'admin',
            'password' => $defaultPassword,
        ]);
        
        User::factory()->create([
            'name' => 'Admin 2', 
            'email' => 'admin2@carwash.com',
            'role' => 'admin',
            'password' => $defaultPassword,
        ]);
        
        // User biasa (20 orang)
        User::factory(20)->create([
            'role' => 'user',
            'password' => $defaultPassword,
        ]);
    }
}