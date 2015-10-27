<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the appropriate dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getDashboard()
    {
        return view('dashboard.index');
    }

    /**
     * Display the classes dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getClassesDashboard()
    {
        return view('dashboard.classes');
    }
}
