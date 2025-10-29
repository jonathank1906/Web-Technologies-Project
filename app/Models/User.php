<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Connection;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    function posts() : HasMany{
        return $this->hasMany( related: Post::class);
    }

    function sentMessages() : HasMany {
        return $this->hasMany(Message::class, 'sender_id');
    }

    function receivedMessages() : HasMany {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Connections where this user initiated the request
    public function sentConnections(): HasMany
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    // Connections where this user received the request
    public function receivedConnections(): HasMany
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    // Accepted friends (both sides)
    public function friends()
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

    // Pending requests this user received
    public function pendingRequests()
    {
        return $this->receivedConnections()->where('status', 'pending')->get();
    }
}
