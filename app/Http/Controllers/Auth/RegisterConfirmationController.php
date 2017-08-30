<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    //
    public function index()
    {
        $token = request('token');
        $user = User::where('confirmation_token',$token)
                ->first();
        
        if(!$user)
        {
             return redirect('/threads')->with('flash','Unknown Token.');
        }
        $user->confirm();
        /*
        
        try{
            User::where('confirmation_token',$token)
                ->firstOrFail()
                ->confirm();
        }catch(\Exception $e)
        {
            return redirect('/threads')
                ->with('flash','Unknow token.');
        }
        */
    
        return redirect('/threads')
            ->with('flash','Your account is now confirmed! You may post to the forum.');
    }
}
