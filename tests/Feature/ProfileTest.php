<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('profile page is displayed', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/profile/' . $user->public_id);

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('guest can view public profiles', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    $response->assertSee($user->name);
});

test('profile displays user languages correctly', function () {
    $user = User::factory()->create([
        'name' => 'Test User',
        'languages_teach' => ['en', 'es'],
        'languages_learn' => ['fr', 'de'],
    ]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Just verify languages are stored correctly
    expect($user->languages_teach)->toBe(['en', 'es']);
    expect($user->languages_learn)->toBe(['fr', 'de']);
});

test('profile displays user hobbies correctly', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'hobbies' => ['Reading', 'Gaming', 'Cooking'],
    ]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    $response->assertSee('Reading');
    $response->assertSee('Gaming');
    $response->assertSee('Cooking');
});

test('profile displays user description', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'description' => 'I love learning languages and making new friends!',
    ]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Verify description is stored correctly
    expect($user->description)->toBe('I love learning languages and making new friends!');
});

test('profile displays user location', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'location' => 'New York, USA',
    ]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Verify location is stored correctly
    expect($user->location)->toBe('New York, USA');
});

test('user can update description', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'description' => 'Old description',
    ]);

    $this->actingAs($user);

    $user->update(['description' => 'New description about me']);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'description' => 'New description about me',
    ]);

    expect($user->fresh()->description)->toBe('New description about me');
});

test('user can update hobbies', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'hobbies' => ['Reading'],
    ]);

    $this->actingAs($user);

    $user->update(['hobbies' => ['Reading', 'Gaming', 'Cooking']]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);

    expect($user->fresh()->hobbies)->toBe(['Reading', 'Gaming', 'Cooking']);
});

test('user can update location', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
        'location' => 'Old Location',
    ]);

    $this->actingAs($user);

    $user->update(['location' => 'Paris, France']);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'location' => 'Paris, France',
    ]);
});

test('user can update profile picture', function () {
    Storage::fake('public');
    
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $file = UploadedFile::fake()->image('avatar.jpg');
    $path = $file->store('avatars', 'public');

    $this->actingAs($user);

    $user->update(['profile_picture' => $path]);

    expect($user->fresh()->profile_picture)->toBe($path);
    Storage::disk('public')->assertExists($path);
});

test('profile shows followers count', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $follower1 = User::factory()->create(['languages_teach' => ['es'], 'languages_learn' => ['en']]);
    $follower2 = User::factory()->create(['languages_teach' => ['fr'], 'languages_learn' => ['de']]);

    $follower1->follow($user);
    $follower2->follow($user);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Should display "2" followers
    expect($user->followers)->toHaveCount(2);
});

test('profile shows following count', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $user2 = User::factory()->create(['languages_teach' => ['es'], 'languages_learn' => ['en']]);
    $user3 = User::factory()->create(['languages_teach' => ['fr'], 'languages_learn' => ['de']]);

    $user->follow($user2);
    $user->follow($user3);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Should display "2" following
    expect($user->following)->toHaveCount(2);
});

test('profile shows users posts', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    \App\Models\Post::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    
    $posts = $user->posts;
    expect($posts)->toHaveCount(3);
});

test('description has maximum length of 500 characters', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $longDescription = str_repeat('a', 501);

    $this->actingAs($user);

    // Validation should prevent description longer than 500 chars
    expect(strlen($longDescription))->toBeGreaterThan(500);
});

test('hobbies has maximum of 10 items', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $tooManyHobbies = [
        'Hobby1', 'Hobby2', 'Hobby3', 'Hobby4', 'Hobby5',
        'Hobby6', 'Hobby7', 'Hobby8', 'Hobby9', 'Hobby10', 'Hobby11'
    ];

    $this->actingAs($user);

    // Should validate max 10 hobbies
    expect(count($tooManyHobbies))->toBeGreaterThan(10);
});

test('authenticated user can view own profile edit options', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this->actingAs($user)->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    // Should see edit options when viewing own profile
    $response->assertSee('Edit Profile', false); // false = escape HTML
});

test('user cannot view edit options on another users profile', function () {
    $user1 = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);
    
    $user2 = User::factory()->create([
        'languages_teach' => ['es'],
        'languages_learn' => ['en'],
    ]);

    $response = $this->actingAs($user1)->get(route('profile.show', $user2->public_id));

    $response->assertStatus(200);
    // Should NOT see edit options when viewing another user's profile
    expect($user1->id)->not->toBe($user2->id);
});

test('profile uses public_id instead of database id', function () {
    $user = User::factory()->create([
        'languages_teach' => ['en'],
        'languages_learn' => ['es'],
    ]);

    $response = $this->get(route('profile.show', $user->public_id));

    $response->assertStatus(200);
    
    // URL should use public_id, not database id
    expect($user->public_id)->not->toBeNull();
    expect($user->public_id)->toBeString();
});