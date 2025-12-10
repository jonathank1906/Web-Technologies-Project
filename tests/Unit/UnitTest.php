<?php

use App\Models\User;

test('getRouteKeyName returns public_id', function () {
    $user = new User();
    expect($user->getRouteKeyName())->toBe('public_id');
});

test('getDefaultFlagUrl returns placeholder url', function () {
    $user = new User();
    expect($user->getDefaultFlagUrl())->toBe('https://placehold.co/120x120?text=??');
});

test('getFlagPictureUrl returns default when location is null', function () {
    $user = new User(['location' => null]);
    expect($user->getFlagPictureUrl())->toBe($user->getDefaultFlagUrl());
});

test('languages_teach and languages_learn are arrays', function () {
    $user = new User([
        'languages_teach' => ['en', 'es'],
        'languages_learn' => ['fr', 'de'],
    ]);
    expect($user->languages_teach)->toBeArray();
    expect($user->languages_learn)->toBeArray();
});

test('hobbies is cast to array', function () {
    $user = new User(['hobbies' => ['Reading', 'Gaming']]);
    expect($user->hobbies)->toBeArray();
    expect($user->hobbies)->toContain('Reading');
    expect($user->hobbies)->toContain('Gaming');
});