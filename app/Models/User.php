<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(related: Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(related: Comment::class);
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function receivedConnections(): HasMany
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function pendingRequests()
    {
        return $this->receivedConnections()
            ->where('status', 'pending')
            ->with('sender')
            ->get()
            ->pluck('sender');
    }

    public function getConnections()
    {
        $sent = Connection::query()
            ->where('sender_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id')
            ->toArray();

        $received = Connection::query()
            ->where('receiver_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->toArray();

        $ids = array_unique(array_merge($sent, $received));

        return User::query()->whereIn('id', $ids)->get();
    }
}
