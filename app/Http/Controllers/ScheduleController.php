<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use DateTimeZone;

use App\Models\Movie;
use App\Models\Theatre;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index() {
        return Schedule::all();
    }

    public function add(Request $request) {
        $rules = array(
            'movie_id' => 'required',
            'theatre_id' => 'required',
            'time_start' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }
        else {
            $movieDurationByHour = ceil(Movie::where('id', '=', $request->movie_id)
                                    ->value('duration') / 60);

            $timeEnd = Carbon::parse(request('time_start'))
                        ->addHour($movieDurationByHour);
            
            return Schedule::create([
                'movie_id' => request('movie_id'),
                'theatre_id' => request('theatre_id'),
                'time_start' => Carbon::parse(request('time_start')),
                'time_end' => $timeEnd,
            ]);
        }
    }

    public function findByTheatre(Request $request) {
        $rules = array(
            'time_start' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }
        else {
            $movies = array();

            $theatreName = $request->filled('theatre_name') ? $request->theatre_name : null;
            $timeStart = Carbon::parse($request->time_start);

            if($theatreName) {
                $theatreId = Theatre::FindTheatre($theatreName)->value('id');
                $schedule = Schedule::FindByTheatre($theatreId)->FindByDay($timeStart)->get();
            } else {
                $schedule = Schedule::FindByDay($timeStart)->get();
            }

            foreach ($schedule as $_schedule) {
                $movie = Movie::query()->where('id', $_schedule->movie_id)->get();
                $_schedule->movie_info = $movie[0];
            }

            return $schedule;
        }
    }

    public function findByTimeslot(Request $request) {
        $rules = array(
            'time_start' => 'required',
            'time_end' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }
        else {
            $theatreName = $request->filled('theatre_name') ? $request->theatre_name : null;
            $timeStart = Carbon::parse($request->time_start);
            $timeEnd = Carbon::parse($request->time_end);

            if($theatreName) {
                $theatreId = Theatre::FindTheatre($theatreName)->value('id');

                $schedule = Schedule::FindByTheatre($theatreId)
                        ->FindByTimeslot($timeStart, $timeEnd)
                        ->get();
            } else {
                $schedule = Schedule::FindByTimeslot($timeStart, $timeEnd)->get();
            }
        }

        foreach ($schedule as $_schedule) {
            $movie = Movie::query()->where('id', $_schedule->movie_id)->get();
            $_schedule->movie_info = $movie[0];
        }

        return $schedule;

    }
}
