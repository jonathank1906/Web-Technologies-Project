<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display any user's profile (public view).
     */
    public function show(User $user): View
    {
        return view('profile.show', [
            'user' => $user,
            'isFollowing' => false,
            'isPending' => false,
        ]);
    }

    /**
     * Display the user's settings.
     */
    public function edit(): RedirectResponse
    {
        return Redirect::to(route('profile.show', ['user' => auth()->user()]) . '#settings');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($request->user()->profile_picture) {
                \Storage::disk('public')->delete($request->user()->profile_picture);
            }
            
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }
        
        // Convert hobbies string to array
        if (isset($validated['hobbies'])) {
            $validated['hobbies'] = array_filter(
                array_map('trim', explode(',', $validated['hobbies'] ?? '')),
                fn($hobby) => !empty($hobby)
            );
        }
        
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.my')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
