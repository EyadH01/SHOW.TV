<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete existing users first to avoid duplicates
        User::where('email', 'admin@showtv.com')->delete();
        User::where('email', 'user@showtv.com')->delete();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@showtv.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@showtv.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Admin login: admin@showtv.com / admin123');
        $this->command->info('User login: user@showtv.com / password123');
    }
}
