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

        if($objects != null) {
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
        } else {
            return [];
        }
        return $objects;
    }

    /**
     * Duplicate class objects from one class to another
     *
     * @return null
     */
    public function duplicateClassObjects($classIdToCopy, $classIdToPaste)
    {
        $classObjectsToCopy = ClassObject::where('class_id', $classIdToCopy)->get();

        $classObjectsToPaste = [];

        foreach($classObjectsToCopy as $classObjectToCopy) {
            array_push($classObjectsToPaste, [
                'object_id' => $classObjectToCopy->object_id,
                'class_id' => $classIdToPaste,
                'object_position_x' => $classObjectToCopy->object_position_x,
                'object_position_y' => $classObjectToCopy->object_position_y,
            ]);
        }

        ClassObject::insert($classObjectsToPaste);
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
        $classId = $request->input('class_id');

        if($request->input('class_objects') != null) {
            $classObjects = $request->input('class_objects');

            $classObjectIds = array_map(function($classObjects){ return $classObjects['active_object_id']; }, $classObjects);

            ClassObject::where('class_id', $classId)
                ->whereIn('id', $classObjectIds)
                ->delete(); 
        } else {
            ClassObject::where('class_id', $classId)
                ->delete(); 
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
