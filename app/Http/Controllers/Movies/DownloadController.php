<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        return view('movies/index');
    }
}
