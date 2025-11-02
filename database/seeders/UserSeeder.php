<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     *  Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Steve',
            'email' => 'steve@example.com',
        ]);
        User::factory()->create([
            'name' => 'Mike',
            'email' => 'mike@example.com',
        ]);
        User::factory()->create([
            'name' => 'Alexa',
            'email' => 'alexa@example.com',
        ]);
        User::factory()->create([
            'name' => 'Phil',
            'email' => 'phil@example.com',
        ]);
        User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
        ]);
        User::factory()->create([
            'name' => 'Joe',
            'email' => 'joe@example.com',
        ]);

        User::factory()->create([
            'name' => 'Lukas',
            'email' => 'lukas@example.com',
        ]);
        User::factory()->create([
            'name' => 'Jonathan',
            'email' => 'jonathan@example.com',
        ]);
        User::factory()->create([
            'name' => 'Daniils',
            'email' => 'daniils@example.com',
        ]);
        User::factory()->create([
            'name' => 'Benjamin',
            'email' => 'benjamin@example.com',
        ]);
        User::factory()->create([
            'name' => 'Azzam',
            'email' => 'azzam@example.com',
        ]);
        User::factory()->create([
            'name' => 'David',
            'email' => 'david@example.com',
        ]);
    }
}
