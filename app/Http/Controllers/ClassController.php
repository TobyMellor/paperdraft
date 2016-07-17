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
        $this->request = $request;
    }

    /**
     * Store the class in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeClass(ObjectController $objectController)
    {
        $request = $this->request;

        $className = $request->input('class_name');
        $classTemplate = $request->input('class_template');

        $data = [
            'class_name' => $className
        ];

        $validation = $this->validator($data);

        if(!$validation->fails()) {
            $class = SchoolClass::create([
                'user_id' => Auth::user()->id,
                'class_name' => $className
            ]);

            if(!empty($classTemplate)) {
                $objectController->duplicateClassObjects($classTemplate, $class->id);
            }

            return redirect()
                ->intended('/dashboard/classes')
                ->with('successMessage', 'The class has been successfully created');
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
        $classes = SchoolClass::where('user_id', Auth::user()->id)->get();
        return $classes;
    }

    /**
     * Get one class of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClass($classId)
    {   
        $class = SchoolClass::where('user_id', Auth::user()->id)
            ->where('id', $classId)
            ->first();
        return $class;
    }

    /**
     * Deletes the class, along with all connected relationships
     *
     * @return null
     */
    public function deleteClass(
        ObjectController $objectController,
        StudentController $studentController
    )
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        $objectController->deleteClassObjects();
        $studentController->deleteClassStudents();

        SchoolClass::where('id', $classId)
            ->delete(); 
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'class_name' => 'required|between:1,30',
            'class_template' => 'integer|exists:classes,id'
        ]);
    }
}
