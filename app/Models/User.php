<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'city', 'address', 'photo',
        'status', 'points',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'points'            => 'integer',
    ];

    // ── Relationships ────────────────────────────────────
    public function craftsman()
    {
        return $this->hasOne(Craftsman::class);
    }

    public function bookingsAsClient()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    // ── Role helpers ─────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCraftsman(): bool
    {
        return $this->role === 'craftsman';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // ── Computed helpers ─────────────────────────────────
    public function initials(): string
    {
        return strtoupper(substr($this->name, 0, 2));
    }
}
