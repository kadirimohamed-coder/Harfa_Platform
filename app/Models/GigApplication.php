<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigApplication extends Model
{
    use HasFactory;

    protected $fillable = ['gig_id', 'craftsman_id', 'message', 'status'];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function craftsman()
    {
        return $this->belongsTo(Craftsman::class);
    }
}
