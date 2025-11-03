<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ConnectionSeeder::class
        // Create two users for messaging tests
        $alice = User::factory()->create([
            'name' => 'Test1',
            'email' => 'test1@example.com',
        ]);

        $bob = User::factory()->create([
            'name' => 'Test2',
            'email' => 'test2@example.com',
        ]);

    }

    
}




