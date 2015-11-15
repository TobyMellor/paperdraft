<?php

namespace App\Http\Controllers;

use App\Student;
use App\ClassStudent;

use Auth;
use Validator;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Store the student in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeStudent()
    {
        $request = $this->request;

        $studentName = $request->input('student_name');
        $pupilPremium = $request->input('pupil_premium');
        $classId = $request->input('class_id');
        $abilityCap = $request->input('ability_cap');

        if($pupilPremium == 'on') {
            $pupilPremium = true;
        } else {
            $pupilPremium = false;
        }

        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel = $request->input('target_attainment_level');

        $studentImage = $request->input('student_image');

        $data = [
            'student_name' => $studentName,
            'pupil_premium' => $pupilPremium,
            'class_id' => $classId,
            'ability_cap' => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level' => $targetAttainmentLevel
        ];

        $validation = $this->validator($data);

        if(!$validation->fails()) {
            $student = Student::create([
                'name' => $studentName,
                'pupil_premium' => $pupilPremium,
                'user_id' => Auth::user()->id
            ]);
            ClassStudent::create([
                'student_id' => $student->id,
                'class_id' => $classId,
                'ability_cap' => $abilityCap,
                'current_attainment_level' => $currentAttainmentLevel,
                'target_attainment_level' => $targetAttainmentLevel,
            ]);
            return redirect()
                ->intended('/dashboard/classes')
                ->with('successMessage', 'The student has been successfully created');
        }

        $response = $validation->messages();
        return redirect()
            ->intended('/dashboard/classes')
            ->with('errorMessage', 'There were error(s) with the data you gave us:')
            ->with('errorValidationResponse', $response);
    }

    /**
     * Get all students from a given class
     * TODO: Check if user owns class
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getClassStudents($classId, $paginate = null)
    {
        $classStudents = ClassStudent::where('class_id', $classId);
        if($paginate != null) {
            $classStudents = $classStudents->paginate($paginate);
        } else {
            $classStudents = $classStudents->get();
        }
        return $classStudents;
    }

    /**
     * Get all students of a teacher
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getStudents()
    {
        $students = Student::where('user_id', Auth::user()->id)->get();
        return $students;
    }

    /**
     * Get a specific student of a teacher
     * TODO: Check if user owns student
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getStudent($studentId)
    {
        $student = Student::where('id', $studentId)->first();
        return $student;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name' => 'required|between:1,30',
            'class_id' => 'required|integer|exists:classes,id,user_id,' . Auth::user()->id,
            'pupil_premium' => 'required|boolean',
            'ability_cap' => 'required|in:H,M,L',
            'current_attainment_level' => 'required|in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level' => 'required|in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
