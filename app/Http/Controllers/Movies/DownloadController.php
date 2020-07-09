<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Channel;
use App\Http\Services\Movie;

class DownloadController extends Controller
{
    public function index()
    {
        return view('movies/index', Channel::getTopChannels());
    }

    public function store(Request $req)
    {
        Movie::downloadProgramsByAllChannel($req->date);

        return redirect('show');
    }
}
