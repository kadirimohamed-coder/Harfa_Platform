<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'craftsman_id', 'booking_date',
        'description', 'address', 'urgency', 'status',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function craftsman()
    {
        return $this->belongsTo(Craftsman::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ── Scopes ───────────────────────────────────────────
    public function scopeForClient($query, int $userId)
    {
        return $query->where('client_id', $userId);
    }

    public function scopeForCraftsman($query, int $craftsmanId)
    {
        return $query->where('craftsman_id', $craftsmanId);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }
}
