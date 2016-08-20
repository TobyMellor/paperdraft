<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Student;
use App\ClassStudent;

use Validator;
use Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $classId = $request->input('class_id');

        $students = Student::where('class_id', $classId)
            ->get();

        return response()->json([
            'students' => $students,
            'error' => 0,
            'message' => trans('api.student.success.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $studentName = $request->input('student_name');
        $pupilPremium = $request->input('pupil_premium');
        $abilityCap = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel = $request->input('target_attainment_level');
        $studentImage = $request->input('student_image');

        $classId = $request->input('class_id');

        if ($pupilPremium == 'on') {
            $pupilPremium = true;
        } else {
            $pupilPremium = false;
        }

        $data = [
            'student_name'             => $studentName,
            'pupil_premium'            => $pupilPremium,
            'ability_cap'              => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level'  => $targetAttainmentLevel
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            $storedStudent = Student::create([
                'name'          => $studentName,
                'pupil_premium' => $pupilPremium,
                'user_id'       => Auth::user()->id
            ]);

            $storedClassStudent = ClassStudent::create([
                'student_id'               => $storedStudent->id,
                'class_id'                 => $classId,
                'ability_cap'              => $abilityCap,
                'current_attainment_level' => $currentAttainmentLevel,
                'target_attainment_level'  => $targetAttainmentLevel,
            ]);

            return response()->json([
                'student'       => $storedStudent,
                'class_student' => $storedClassStudent,
                'error'         => 0,
                'message'       => trans('api.student.success.store')
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $studentName = $request->input('student_name');
        $pupilPremium = $request->input('pupil_premium');
        $abilityCap = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel = $request->input('target_attainment_level');
        $studentImage = $request->input('student_image');

        $classId = $request->input('class_id');

        if ($pupilPremium == 'on') {
            $pupilPremium = true;
        } else {
            $pupilPremium = false;
        }

        $data = [
            'student_name'             => $studentName,
            'pupil_premium'            => $pupilPremium,
            'ability_cap'              => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level'  => $targetAttainmentLevel
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            Student::where('user_id', Auth::user()->id)
                ->where('id', $id)
                ->update([
                    'name'          => $studentName,
                    'pupil_premium' => $pupilPremium
                ]);

            ClassStudent::where('class_id', $classId)
                ->where('student_id', $id)
                ->update([
                    'ability_cap'              => $abilityCap,
                    'current_attainment_level' => $currentAttainmentLevel,
                    'target_attainment_level'  => $targetAttainmentLevel
                ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.student.success.update')
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
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $studentId = $request->input('student_id');
        $classId = $request->input('class_id');

        ClassStudent::where('class_id', $classId)
            ->where('student_id', $id)
            ->delete();

        if (ClassStudent::where('student_id', $id)->count() == 0 && Student::where('id', $id)->first()->user_id == Auth::user()->id) {
            Student::where('id', $id)
                ->delete();
        }

        return response()->json([
            'error' => 0,
            'message' => trans('api.student.success.destroy')
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name'             => 'required|between:2,30|regex:/^[a-zA-Z0-9\s-]+$/',
            'pupil_premium'            => 'boolean',
            'ability_cap'              => 'in:H,M,L',
            'current_attainment_level' => 'in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level'  => 'in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
