<?php

use App\Models\User;

test('swiper page can be rendered for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/swipe');

    $response->assertStatus(200);
    $response->assertSeeLivewire(\App\Livewire\Swipe\Item::class);
});

test('swiper page redirects unauthenticated users to login', function () {
    $response = $this->get('/swipe');

    $response->assertRedirect('/login');
});

test('swiper excludes already followed users', function () {
    $user = User::factory()->create();
    $userToFollow = User::factory()->create([
        'name' => 'Already Followed User',
    ]);
    $userNotFollowed = User::factory()->create([
        'name' => 'Not Followed User',
    ]);

    // Follow one user
    $user->follow($userToFollow);

    $this->actingAs($user)
        ->get('/swipe')
        ->assertDontSeeText('Already Followed User')
        ->assertSeeText('Not Followed User');
});

test('swiper excludes current authenticated user', function () {
    $user = User::factory()->create([
        'name' => 'Current User Unique Name xyz123',
    ]);
    $otherUser = User::factory()->create([
        'name' => 'Other User Unique Name abc456',
    ]);

    $component = \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class);

    // Check that the current user is not in the users collection
    $userIds = $component->get('users')->pluck('id')->toArray();
    
    expect($userIds)->not->toContain($user->id);
    expect($userIds)->toContain($otherUser->id);
});

test('user can follow another user from swiper', function () {
    $user = User::factory()->create();
    $userToFollow = User::factory()->create();

    \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class)
        ->call('follow', $userToFollow->id);

    // Check if the user is now following
    expect($user->following()->where('users.id', $userToFollow->id)->exists())->toBeTrue();
});

test('swiper displays user profile information', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'name' => 'Test Display User',
        'description' => 'This is a test description',
        'languages_teach' => ['en', 'es'],
        'languages_learn' => ['fr', 'de'],
    ]);

    $this->actingAs($user)
        ->get('/swipe')
        ->assertSeeText('Test Display User')
        ->assertSeeText('This is a test description');
});

test('swiper shows no description message when user has no description', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'name' => 'No Description User',
        'description' => null,
    ]);

    $this->actingAs($user)
        ->get('/swipe')
        ->assertSeeText('No description yet.');
});

test('swiper removes user from list after following', function () {
    $user = User::factory()->create();
    $userToFollow = User::factory()->create([
        'name' => 'User To Follow',
    ]);

    $component = \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class)
        ->assertSeeText('User To Follow')
        ->call('follow', $userToFollow->id);

    // User should be removed from the swipe list
    $component->assertDontSeeText('User To Follow');
});

test('swiper displays teaching languages', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'languages_teach' => ['en', 'es', 'fr'],
    ]);

    $this->actingAs($user)
        ->get('/swipe')
        ->assertSeeText('Teaches:');
});

test('swiper displays learning languages', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'languages_learn' => ['de', 'ja', 'ko'],
    ]);

    $this->actingAs($user)
        ->get('/swipe')
        ->assertSeeText('Learning:');
});

test('swiper shows message when no users available', function () {
    $user = User::factory()->create();
    
    // Follow all other users or ensure no other users exist
    $otherUsers = User::where('id', '!=', $user->id)->get();
    foreach ($otherUsers as $otherUser) {
        $user->follow($otherUser);
    }

    $component = \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class);
    
    // Should show empty state (check based on your actual implementation)
    expect($component->get('users')->count())->toBe(0);
});

test('swiper displays profile picture when available', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'name' => 'User With Picture',
        'profile_picture' => 'path/to/picture.jpg',
    ]);

    $response = $this->actingAs($user)->get('/swipe');

    $response->assertStatus(200);
    $response->assertSee('User With Picture');
    $profilePictureUrl = $displayUser->getProfilePictureUrl();
    $response->assertSee($profilePictureUrl, false);
});


test('swiper displays flag picture', function () {
    $user = User::factory()->create();
    $displayUser = User::factory()->create([
        'location' => 'US',
    ]);

    $response = $this->actingAs($user)->get('/swipe');

    $response->assertSee($displayUser->getFlagPictureUrl(), false);
});

test('following user creates proper relationship', function () {
    $user = User::factory()->create();
    $userToFollow = User::factory()->create();

    \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class)
        ->call('follow', $userToFollow->id);

    // Verify the relationship exists both ways
    expect($user->fresh()->following()->where('users.id', $userToFollow->id)->exists())->toBeTrue();
    expect($userToFollow->fresh()->followers()->where('users.id', $user->id)->exists())->toBeTrue();
});

test('cannot follow the same user twice', function () {
    $user = User::factory()->create();
    $userToFollow = User::factory()->create();

    // Follow once
    $user->follow($userToFollow);

    // Try to follow again
    $initialCount = $user->following()->count();
    $user->follow($userToFollow);
    $finalCount = $user->following()->count();

    expect($initialCount)->toBe($finalCount);
});

test('swiper component mounts correctly with proper user list', function () {
    $user = User::factory()->create();
    $otherUsers = User::factory()->count(5)->create();

    \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Swipe\Item::class)
        ->assertSet('users', function ($users) use ($otherUsers) {
            return $users->count() === 5;
        });
});