<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index(Request $request) {
        $movies = $request->order_by == 'newest' ? Movie::all()->sortByDesc('release') : Movie::all();
        return $movies;
    }

    public function add(Request $request) {
        $rules = array(
            'title' => 'required',
            'genres' => 'required',
            'duration' => 'required',
            'views' => 'required',
            'image' => 'required',
            'release' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }
        else {
            return Movie::create([
                'title' => request('title'),
                'genres' => json_encode(request('genres')),
                'duration' => request('duration'),
                'views' => request('views'),
                'image' => request('image'),
                'release' => carbon::parse(request('release')),
            ]);
        }
    }
}
