<?php

namespace App\Http\Controllers;

use App\SchoolClass;

use Auth;
use Validator;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Store the class in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeClass(){}

    /**
     * Get all classes of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClasses()
    {
        $classes = SchoolClass::where('user_id', Auth::user()->id)->get();
        return $classes;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
