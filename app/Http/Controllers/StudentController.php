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
     * @return null
     */
    public function storeStudent()
    {
        $request = $this->request;

        $studentName = $request->input('student_name');
        $pupilPremium = $request->input('pupil_premium');
        $classId = $request->input('class_id');

        if($pupilPremium != 'on') {
            $pupilPremium = 'off';
        }

        if($request->input('ability_cap_high') == 'on') {
            $abilityCap = 'high';
        } else if($request->input('ability_cap_medium') == 'on') {
            $abilityCap = 'medium';
        } else {
            $abilityCap = 'low';
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name' => 'required|between:1,30',
            'class_id' => 'required|integer|exists:classes,id,user_id,' . Auth::user()->id,
            'pupil_premium' => 'in:on,off',
            'ability_cap' => 'required|in:high,medium,low',
            'current_attainment_level' => 'required|in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level' => 'required|in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
