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
        $showPopup = false;

        if (auth()->check() && !Cookie::get('welcome_shown')) {
            Cookie::queue('welcome_shown', true, 1440); // 1 day
            $showPopup = true;

        } 
        
        $userProfile = App\Models\UserProfile::find("user_id", Auth::user() ->id);

        return view('homepage', compact('showPopup', 'userProfile'));
    }

    
}
