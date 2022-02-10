<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Theatre;


class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'theatre_id',
        'time_start',
        'time_end',
    ];

    public function scopeFindByDay($query, $timeStart) {
        return $query->whereDay('time_start', '=', $timeStart);
    }

    public function scopeFindByTimeslot($query, $timeStart, $timeEnd) {
        // return $query->whereRaw("time_start >= '{$timeStart}' AND time_end <= '{$timeEnd}'");
        return $query->where('time_start', '>=', $timeStart)
                ->where('time_end', '<=', $timeEnd);

    }

    public function scopeFindByTheatre($query, $theatreId) {
        return $query->where('id', $theatreId);
    }
}
