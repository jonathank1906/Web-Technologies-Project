<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Overtrue\LaravelLike\Traits\Liker;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use Liker;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'hobbies',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hobbies' => 'array',
        ];
    }

    function posts() : HasMany{
        return $this->hasMany( related: Post::class);
    }

    function comments() : HasMany{
        return $this->hasMany( related: Comment::class);
    }

    /**
     * Get the profile picture URL or default avatar
     */
    public function getProfilePictureUrl(): string
    {
        if ($this->profile_picture && \Storage::disk('public')->exists($this->profile_picture)) {
            return \Storage::url($this->profile_picture);
        }
        
        // Return default avatar (using initials)
        return $this->getDefaultAvatarUrl();
    }

    /**
     * Get default avatar URL (you can customize this)
     */
    public function getDefaultAvatarUrl(): string
    {
        // For now, we'll return null to keep using the current initial-based avatar
        // You could integrate with services like Gravatar, UI Avatars, etc.
        return '';
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
