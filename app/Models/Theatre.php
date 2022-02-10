<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theatre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeFindTheatre($query, $theatreName) {
        return $query->where('name', 'LIKE', "%$theatreName%");
    }
}
