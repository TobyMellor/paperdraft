<?php

namespace App\Http\Controllers;

use App\SchoolClass;
use App\CanvasItem;
use App\CanvasHistory;
use App\ClassStudent;

use Auth;
use Validator;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $className    = $request->input('class_name');
        $classSubject = $request->input('class_subject');
        $classRoom    = $request->input('class_room');

        $data = [
            'class_name'    => $className,
            'class_subject' => $classSubject,
            'class_room'    => $classRoom,
        ];

        $validation = $this->validateClass($data);

        if (!$validation->fails()) {
            $storedClass = SchoolClass::create([
                'user_id'       => Auth::id(),
                'class_name'    => $className,
                'class_subject' => $classSubject,
                'class_room'    => $classRoom,
            ]);

            return response()->json([
                'class'   => $storedClass,
                'error'   => 0,
                'message' => trans('api.class.success.store')
            ]);
        }

        $errorMessages = $validation->errors()->all();
        $responseMessage = '';

        foreach ($errorMessages as $errorMessage) {
            $responseMessage .= $errorMessage;
        }
        
        return response()->json([
            'error'   => 1,
            'message' => $responseMessage
        ]);
    }

    /**
     * Store the class in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeClass(Request $request)
    {
        $className       = $request->input('class_name');
        $classSubject    = $request->input('class_subject');
        $classRoom       = $request->input('class_room');
        $classTemplateId = $request->input('class_template_id');

        $data = [
            'class_name'    => $className,
            'class_id'      => $classTemplateId,
            'class_subject' => $classSubject,
            'class_room'    => $classRoom
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            if ($classTemplateId !== null) {
                $classId = $this->duplicateClass($classTemplateId, $className, $classSubject, $classRoom);
            } else {
                $classId = SchoolClass::create([
                    'user_id'       => Auth::id(),
                    'class_name'    => $className,
                    'class_subject' => $classSubject,
                    'class_room'    => $classRoom
                ])->id;
            }

            return redirect('/dashboard/classes/' . $classId)
                ->with('successMessage', trans('api.class.success.store'));
        }

        $response = $validation->messages();

        return redirect()
            ->intended('/dashboard/classes')
            ->with('errorMessage', 'There were error(s) with the data you gave us:')
            ->with('errorValidationResponse', $response);
    }

    /**
     * Get all classes of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClasses()
    {   
        $classes = SchoolClass::where('user_id', Auth::id())->get();

        return $classes;
    }

    /**
     * Get one class of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClass($classId)
    {   
        $class = SchoolClass::where('user_id', Auth::id())
            ->where('id', $classId)
            ->first();

        return $class;
    }

    /**
     * Get most recent class id of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getRecentClassId()
    {   
        $canvasItem = CanvasItem::whereHas('SchoolClass', function($query){                           
            $query->where('classes.user_id', Auth::id());                             
        })->orderBy('created_at', 'desc')->first();

        if ($canvasItem != null) {
            return $canvasItem->class_id;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $data = [
            'class_id' => $id
        ];

        $validation = $this->validateClassId($data);

        if (!$validation->fails()) {
            CanvasHistory::where('class_id', $id)
                ->delete();

            ClassStudent::where('class_id', $id)
                ->delete();

            CanvasItem::withTrashed()
                ->where('class_id', $id)
                ->forceDelete();

            SchoolClass::where('id', $id)
                ->delete();

            return response()->json([
                'error'   => 0,
                'message' => trans('api.class.success.destroy')
            ]);
        }

        $errorMessages = $validation->errors()->all();
        $responseMessage = '';

        foreach ($errorMessages as $errorMessage) {
            $responseMessage .= $errorMessage;
        }
        
        return response()->json([
            'error'   => 1,
            'message' => $responseMessage
        ]);
    }

    /**
     * Duplicate class items from one class to another
     *
     * @return $classIdToPaste
     */
    public function duplicateClass($classId, $className = null, $classSubject = null, $classRoom = null)
    {
        $classToDuplicate = SchoolClass::where('id', $classId)->first();

        $newClassId = SchoolClass::create([
            'user_id'       => Auth::id(),
            'class_name'    => $className === null ? substr($classToDuplicate->class_name, 0, 23) . ' (copy)' : $className,
            'class_subject' => $classSubject,
            'class_room'    => $classRoom === null ? $classToDuplicate->class_room : $classRoom
        ])->id;

        $canvasItemsToCopy = CanvasItem::where('class_id', $classId)->get();

        $canvasItemsToPaste = [];

        foreach ($canvasItemsToCopy as $canvasItemToCopy) {
            array_push($canvasItemsToPaste, [
                'item_id'    => $canvasItemToCopy->item_id,
                'class_id'   => $newClassId,
                'position_x' => $canvasItemToCopy->position_x,
                'position_y' => $canvasItemToCopy->position_y,
            ]);
        }

        CanvasItem::insert($canvasItemsToPaste);

        return $newClassId;
    }

    /**
     * Clear the seating plan
     *
     * @return \Illuminate\Http\Redirect
     */
    public function clearSeatingPlan($id) {
        $data = [
            'class_id' => $id
        ];

        $validation = $this->validateClassId($data);

        if (!$validation->fails()) {
            CanvasHistory::where('class_id', $id)
                ->delete();

            CanvasItem::withTrashed()
                ->where('class_id', $id)
                ->forceDelete();

            return redirect()
                ->route('dashboard', ['class' => $id]);
        }

        abort(403);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'class_name'        => 'required|between:1,30',
            'class_subject'     => 'nullable|string|between:1,30',
            'class_room'        => 'nullable|string|between:1,30',
            'class_template_id' => 'nullable|integer|exists:classes,id,user_id,' . Auth::id(),
        ]);
    }

    protected function validateClass(array $data)
    {
        return Validator::make($data, [
            'class_name'    => 'required|between:1,30',
            'class_subject' => 'nullable|string|between:1,30',
            'class_room'    => 'nullable|string|between:1,30'
        ]);
    }

    protected function validateClassId(array $data)
    {
        return Validator::make($data, [
            'class_id' => 'required|integer|exists:classes,id,user_id,' . Auth::id()
        ]);
    }
}
