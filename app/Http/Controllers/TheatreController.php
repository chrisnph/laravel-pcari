<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

use App\Models\Movie;
use App\Models\Theatre;
use App\Models\Schedule;

class TheatreController extends Controller
{
    public function index() {
        return Theatre::all();
    }

    public function add(Request $request) {
        $rules = array('name' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }
        else {
            return Theatre::create([
                'name' => request('name'),
            ]);
        }
    }

    public function find(Request $request) {
        $rules = array('theatre_id' => 'required', 'time_start' => 'date_format');
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors('asdasd');
        }
        else {
            // return Schedule::query()
            //     ->where('id', '=', $request->theatre_id)
            //     ->where('time_start', '=', $request->theatre_id)
            //     ->get();

            // $time_start = Carbon::parse($request->time_start);

            // return $time_start;
            return Carbon::parse('01/15/2022');
        }
    }
}
