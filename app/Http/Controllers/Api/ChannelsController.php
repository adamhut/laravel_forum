<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    
    /**
     * fetch all channels
     *
     * @return void
     */
    public function index()
    {
        return cache()->rememberForever('channels',function(){
            return Channel::all();
        });
    }
}
