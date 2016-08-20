<?php

namespace App\Http\Controllers;

use App\Student;
use App\ClassStudent;

use Auth;
use Validator;

use Illuminate\Http\Request;

class StudentOldController extends Controller
{
    public function __construct(Request $request)
    {
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

        if ($pupilPremium == 'on') {
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

        if (!$validation->fails()) {
            $student = Student::create([
                'name' => $studentName,
                'pupil_premium' => $pupilPremium,
                'user_id' => Auth::user()->id
            ]);

            $storedClassStudent = ClassStudent::create([
                'student_id' => $student->id,
                'class_id' => $classId,
                'ability_cap' => $abilityCap,
                'current_attainment_level' => $currentAttainmentLevel,
                'target_attainment_level' => $targetAttainmentLevel,
            ]);

            return response()->json([
                'student' => $storedStudent,
                'class_student' => $storedClassStudent,
                'error' => 0,
                'message' => trans('api.student.success.store')
            ]);
        }

        $message = $validation->errors()->messages();
        
        return response()->json([
            'student' => $storedStudent,
            'class_student' => $storedClassStudent,
            'error' => 0,
            'message' => $message
        ]);
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

        if ($paginate != null) {
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

    public function updateClassStudent()
    {
        $request = $this->request;
        $classStudentId = $request->input('class_student_id');

        ClassStudent::where('class_id', $classId)
            ->delete();
    }

    public function deleteClassStudents()
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        ClassStudent::where('class_id', $classId)
            ->delete();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name'             => 'required|between:2,30',
            'class_id'                 => 'required|integer|exists:classes,id,user_id,' . Auth::user()->id,
            'pupil_premium'            => 'boolean',
            'ability_cap'              => 'in:H,M,L',
            'current_attainment_level' => 'in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level'  => 'in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
