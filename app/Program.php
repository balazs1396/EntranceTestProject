<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    public function getChannelName ($id) {
        \App\Channel::find($id);
    }
}
