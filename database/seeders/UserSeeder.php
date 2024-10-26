<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'ねこ',
            'email' => 'neko@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'はむ',
            'email' => 'hamu@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'うし',
            'email' => 'ushi@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
