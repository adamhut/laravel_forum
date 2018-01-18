<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //
    public function index()
    {
        return view('admin.coupons.create');
    }

    /**
     *  Save a new coupon to the system.
     */
    public function store()
    {
        //create the coupon in our system
        //send an API request to Stripe to generate the coupon

        //email to user
    }
}
