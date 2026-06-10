<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Craftsman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'description', 'experience_years',
        'price', 'certification', 'availability_status',
    ];

    protected $casts = [
        'availability_status' => 'boolean',
        'price'               => 'decimal:2',
        'experience_years'    => 'integer',
    ];

    // ── Relationships ────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'craftsman_category');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Booking::class);
    }


    public function gigApplications()
    {
        return $this->hasMany(GigApplication::class);
    }

    // ── Helpers ──────────────────────────────────────────
    public function averageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function totalEarnings(): float
    {
        return $this->earnings()->sum('amount');
    }
}
