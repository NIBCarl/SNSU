<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create default admin user
        // IMPORTANT: Change these credentials immediately after first login!
        User::firstOrCreate(
            ['email' => 'studentaffairs@snsu.edu.ph'],
            [
                'name' => 'SNSU Student Affairs',
                'email' => 'studentaffairs@snsu.edu.ph',
                'password' => Hash::make('SNSU2024@SecurePass'), // Change this password immediately!
            ]
        );
    }
}
