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
     * Store the class objects in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeClassObjects()
    {
        $request = $this->request;
        $objects = $request->input('objects');
        $classId = $request->input('class_id');

        foreach ($objects as $key => $object) {
            if (isset($object['active_object_id']) && $object['active_object_id'] != null) {
                ClassObject::where('id', $object['active_object_id'])
                    ->where('class_id', $classId)
                    ->update([
                        'object_position_x' => $object['object_position_x'],
                        'object_position_y' => $object['object_position_y']
                    ]
                );
            } elseif(isset($object['object_id'])) {
                $classObject = new ClassObject;

                $classObject->object_id = $object['object_id'];
                $classObject->class_id = $classId;
                $classObject->object_position_x = $object['object_position_x'];
                $classObject->object_position_y = $object['object_position_y'];

                $classObject->save();

                $objects[$key]['active_object_id'] = $classObject->id;
            }
        }
        return $objects;
    }

    /**
     * Get all objects
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getObjects($paginate = null)
    {
        if ($paginate != null) {
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
    public function getClassObjects()
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        $classObjects = ClassObject::where('class_id', $classId)
            ->get();
        return $classObjects;
    }

    public function deleteClassObjects()
    {
        $request = $this->request;
        $classObjects = $request->input('class_objects');
        $classId = $request->input('class_id');

        $classObjectIds = array_map(function($classObjects){ return $classObjects['active_object_id']; }, $classObjects);

        ClassObject::where('class_id', $classId)
            ->whereIn('id', $classObjectIds)
            ->delete(); 
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
