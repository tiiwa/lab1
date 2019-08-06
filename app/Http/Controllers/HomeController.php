<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Route to home view.
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Content for home page.
     */
    public function index()
    {
    }
}
