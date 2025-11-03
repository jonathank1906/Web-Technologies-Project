<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'description' => 'They call me the dog.',
            'hobbies' => ['Fishing', 'Hiking', 'Watching movies'],
        ]);

        User::factory()->create([
            'name' => 'Mike',
            'email' => 'mike@example.com',
            'description' => 'Just Mike.',
            'hobbies' => ['Basketball', 'Reading', 'Gaming'],
        ]);

        User::factory()->create([
            'name' => 'Alexa',
            'email' => 'alexa@example.com',
            'description' => 'Hey, Alexa..',
            'hobbies' => ['Singing', 'Coding', 'Cooking'],
        ]);

        User::factory()->create([
            'name' => 'Phil Cheeseburger',
            'email' => 'phil@example.com',
            'description' => 'Ayo?',
            'hobbies' => ['Cooking', 'Eating out', 'Gym'],
        ]);

        User::factory()->create([
            'name' => 'Bill',
            'email' => 'bill@example.com',
            'description' => 'LF for hot singles in my area.',
            'hobbies' => ['Gaming', 'biking', 'collecting memes'],
        ]);

        User::factory()->create([
            'name' => 'Joe',
            'email' => 'joe@example.com',
            'description' => 'Looking for friends.',
            'hobbies' => ['Music', 'Running', 'Board games'],
        ]);

        User::factory()->create([
            'name' => 'Lukas',
            'email' => 'lukas@example.com',
            'description' => '^^',
            'hobbies' => [],
        ]);

        User::factory()->create([
            'name' => 'Jonathan',
            'email' => 'jonathan@example.com',
            'description' => 'Always curious.',
            'hobbies' => [],
        ]);

        User::factory()->create([
            'name' => 'Daniils',
            'email' => 'daniils@example.com',
            'description' => 'Calm and focused.',
            'hobbies' => [],
        ]);

        User::factory()->create([
            'name' => 'Benjamin',
            'email' => 'benjamin@example.com',
            'description' => 'Enjoying the little things.',
            'hobbies' => [],
        ]);

        User::factory()->create([
            'name' => 'Azzam',
            'email' => 'azzam@example.com',
            'description' => 'On a mission to learn.',
            'hobbies' => [],
        ]);

        User::factory()->create([
            'name' => 'David',
            'email' => 'david@example.com',
            'description' => '(╯°□°)╯︵ ┻━┻',
            'hobbies' => ['Coding'],
        ]);
    }
}
