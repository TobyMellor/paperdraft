<?php

namespace App\Http\Controllers;

use App\Object;
use App\ClassObject;

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

    /**
     * Get all class objects
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClassObjects($paginate = null)
    {
        if($paginate != null) {
            $classObjects = ClassObject::paginate();
        } else {
            $classObjects = ClassObject::all();
        }
        return $classObjects;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
