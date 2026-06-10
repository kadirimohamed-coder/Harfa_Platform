<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description',
        'city', 'deadline', 'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(GigApplication::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
