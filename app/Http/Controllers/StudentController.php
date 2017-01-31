<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClassStudentController;

use App\Student;
use App\ClassStudent;

use Validator;
use Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $classId = $request->input('class_id');

        $students = Student::where('class_id', $classId)
            ->get();

        return response()->json([
            'students' => $students,
            'error'    => 0,
            'message'  => trans('api.student.success.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ClassStudentController $classStudentController)
    {
        $studentName            = $request->input('student_name');
        $gender                 = $request->input('gender');
        $pupilPremium           = $request->input('pupil_premium');
        $abilityCap             = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel  = $request->input('target_attainment_level');
        $studentImage           = $request->input('student_image');

        $classId = $request->input('class_id');

        $data = [
            'student_name'             => $studentName,
            'gender'                   => $gender,
            'pupil_premium'            => $pupilPremium,
            'ability_cap'              => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level'  => $targetAttainmentLevel
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            $storedStudent = Student::create([
                'name'          => $studentName,
                'gender'        => $gender,
                'pupil_premium' => $pupilPremium == 'true' ? true : false,
                'user_id'       => Auth::user()->id
            ]);

            $storedClassStudent = null;

            if ($classId !== null) {
                $storedClassStudent = ClassStudent::create([
                    'student_id'               => $storedStudent->id,
                    'class_id'                 => $classId,
                    'ability_cap'              => $abilityCap,
                    'current_attainment_level' => $currentAttainmentLevel,
                    'target_attainment_level'  => $targetAttainmentLevel,
                ]);
            }

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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $studentName            = $request->input('student_name');
        $gender                 = $request->input('gender');
        $pupilPremium           = $request->input('pupil_premium');
        $abilityCap             = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel  = $request->input('target_attainment_level');
        $studentImage           = $request->input('student_image');

        $classId = $request->input('class_id');

        $data = [
            'student_name'             => $studentName,
            'gender'                   => $gender,
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
                    'gender'        => $gender,
                    'pupil_premium' => $pupilPremium == 'true' ? true : false
                ]);

            if ($classId !== null) {
                ClassStudent::where('class_id', $classId)
                    ->where('student_id', $id)
                    ->update([
                        'ability_cap'              => $abilityCap,
                        'current_attainment_level' => $currentAttainmentLevel,
                        'target_attainment_level'  => $targetAttainmentLevel
                    ]);
            }

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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        Student::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return response()->json([
            'error'   => 0,
            'message' => trans('api.student.success.destroy')
        ]);
    }

    public function guessGender(Request $request)
    {
        $studentName = $request->input('student_name');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://api.genderize.io?name=' . $studentName);

        $result = json_decode(curl_exec($ch));

        curl_close($ch);

        if (isset($result->gender) && ($result->gender === 'male' || $result->gender === 'female')) {
            return response()->json([
                'error' => 0,
                'gender' => $result->gender,
                'probability' => $result->probability * 100,
                'message' => trans('api.student.success.guess-gender')
            ]);
        }

        return response()->json([
            'error' => 0,
            'gender' => 'N/A',
            'message' => trans('api.student.failure.guess-gender')
        ]);
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name'             => 'required|between:2,30|regex:/^[a-zA-Z0-9\s-]+$/',
            'gender'                   => 'required|in:male,female',
            'pupil_premium'            => 'nullable|in:true,false',
            'ability_cap'              => 'nullable|in:H,M,L',
            'current_attainment_level' => 'nullable|in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level'  => 'nullable|in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
