<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Session::has('visits')) {
            $visits = Session::get('visits');
            $visits++;
        } else {
            $visits = 1;
        }
        Session::put('visits', $visits);

        return view('home');
    }
}
