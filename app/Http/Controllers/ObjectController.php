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
     * Store the objects in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeObjects()
    {
        $request = $this->request;

        $objects = $request->input('objects');

        foreach($objects as $object) {
            ClassObject::where('id', $object['object_id'])->update([
                'object_position_y' => $object['object_position_y'],
                'object_position_x' => $object['object_position_x']
            ]);
        }
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
