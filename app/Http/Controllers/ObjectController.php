<?php

namespace App\Http\Controllers;

use App\Object;

use Auth;
use Validator;

use Illuminate\Http\Request;

class ObjectController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Get all objects
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getObjects($paginate = null)
    {
        if($paginate != null) {
            $objects = Object::paginate();
        } else {
            $objects = Object::all();
        }
        return $objects;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
