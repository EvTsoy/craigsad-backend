<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'user_1@example.com',
            'password' => Hash::make('password_1')
        ]);
        User::factory()->create([
            'email' => 'user_2@example.com',
            'password' => Hash::make('password_2')
        ]);

        User::factory()->count(2)->create();
    }
}
