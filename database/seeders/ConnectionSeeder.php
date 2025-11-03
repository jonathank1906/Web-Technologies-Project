<?php

namespace Database\Seeders;

use App\Models\Connection;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Connection::create([
            'sender_id' => 2,
            'receiver_id' => 1,
            'status' => 'pending',
        ]);

        Connection::create([
            'sender_id' => 3,
            'receiver_id' => 1,
            'status' => 'pending',
        ]);

        Connection::create([
            'sender_id' => 4,
            'receiver_id' => 1,
            'status' => 'pending',
        ]);

        Connection::create([
            'sender_id' => 5,
            'receiver_id' => 1,
            'status' => 'pending',
        ]);

        Connection::create([
            'sender_id' => 6,
            'receiver_id' => 1,
            'status' => 'pending',
        ]);

        Connection::create([
            'sender_id' => 7,
            'receiver_id' => 1,
            'status' => 'accepted',
        ]);

        Connection::create([
            'sender_id' => 8,
            'receiver_id' => 1,
            'status' => 'declined',
        ]);
    }
}
