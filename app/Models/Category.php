<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function craftsmen()
    {
        return $this->belongsToMany(Craftsman::class, 'craftsman_category');
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }
}
