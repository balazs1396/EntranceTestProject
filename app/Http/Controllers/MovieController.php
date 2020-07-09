<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return view('movies/movies_viewer', Movie::getAllProgram());
    }
}
