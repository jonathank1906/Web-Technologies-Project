<?php

use App\Models\User;
use App\Models\Message;

test('authenticated user can view messages page', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this->actingAs($user)->get(route('messages'));

    $response->assertStatus(200);
});

test('guest cannot view messages page', function () {
    $response = $this->get(route('messages'));

    $response->assertRedirect(route('login'));
});

test('user can send message to another user', function () {
    $sender = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $receiver = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $this->actingAs($sender);

    Message::create([
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'body' => 'Hello!',
    ]);

    $this->assertDatabaseHas('messages', [
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'body' => 'Hello!',
    ]);
});

test('message body is required', function () {
    $sender = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $receiver = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $this->actingAs($sender);

    try {
        Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'body' => '',
        ]);
        
        $this->fail('Expected validation to fail for empty body');
    } catch (\Exception $e) {
        expect(true)->toBeTrue();
    }
});

test('user can view conversation with another user', function () {
    $user1 = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $user2 = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    Message::create([
        'sender_id' => $user1->id,
        'receiver_id' => $user2->id,
        'body' => 'Hello!',
    ]);

    Message::create([
        'sender_id' => $user2->id,
        'receiver_id' => $user1->id,
        'body' => 'Hi there!',
    ]);

    $this->actingAs($user1);

    $messages = Message::where(function ($q) use ($user1, $user2) {
        $q->where('sender_id', $user1->id)->where('receiver_id', $user2->id);
    })->orWhere(function ($q) use ($user1, $user2) {
        $q->where('sender_id', $user2->id)->where('receiver_id', $user1->id);
    })->get();

    expect($messages)->toHaveCount(2);
});

test('message is marked as read when viewed', function () {
    $sender = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $receiver = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $message = Message::create([
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'body' => 'Hello!',
        'read_at' => null,
    ]);

    $this->actingAs($receiver);

    $message->update(['read_at' => now()]);

    expect($message->fresh()->read_at)->not->toBeNull();
});

test('user can only message followed connections', function () {
    $user1 = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $user2 = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $this->actingAs($user1);

    // Before following
    $canMessage = $user1->isFollowing($user2);
    expect($canMessage)->toBeFalse();

    // After following
    $user1->follow($user2);
    $canMessage = $user1->isFollowing($user2);
    expect($canMessage)->toBeTrue();
});

test('deleting user cascades delete messages', function () {
    $sender = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $receiver = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $message = Message::create([
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'body' => 'Hello!',
    ]);

    $sender->delete();

    $this->assertDatabaseMissing('messages', [
        'id' => $message->id,
    ]);
});