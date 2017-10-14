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
    public function store(Request $request)
    {
        $studentName    = $request->input('student_name');
        $gender         = $request->input('gender');
        $pupilPremium   = $request->input('pupil_premium');
        $forInstitution = $request->input('use_institution_data') == 'true' ? true : false;

        $data = [
            'student_name'  => $studentName,
            'gender'        => $gender,
            'pupil_premium' => $pupilPremium
        ];

        $validation = $this->validator($data);

        if ($forInstitution) {
            $validation->after(function($validation) {
                if (Auth::user()->institution_id === null || Auth::user()->priviledge === 0) {
                    $validation->errors()->add('student', trans('api.student.failure.store.no-access'));
                }
            });
        }

        if (!$validation->fails()) {
            $student = new Student;

            $student->name          = $studentName;
            $student->gender        = $gender;
            $student->pupil_premium = $pupilPremium;
            $student->user_id       = Auth::id();

            $student->save();

            return response()->json([
                'student'       => $student,
                'error'         => 0,
                'message'       => trans('api.student.success.store')
            ]);
        }
        
        return response()->json([
            'error'   => 1,
            'message' => $this->parseErrorMessages($validation)
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
        $studentName  = $request->input('student_name');
        $gender       = $request->input('gender');
        $pupilPremium = $request->input('pupil_premium');

        $data = [
            'student_name'  => $studentName,
            'gender'        => $gender,
            'pupil_premium' => $pupilPremium,
        ];

        $student = Student::where('id', $id);

        $validation = $this->validator($data);

        $validation->after(function($validation) use ($student) {
            $student = $student->first();
            
            if ($student->institution_id !== null) {
                if ($student->institution_id !== Auth::user()->institution_id) {
                    $validation->errors()->add('student', trans('api.student.failure.update.no-access'));
                }
            } else if ($student->user_id !== Auth::id()) {
                $validation->errors()->add('student', trans('api.student.failure.update.no-access'));
            }
        });

        if (!$validation->fails()) {
            $student->update([
                'name'          => $studentName,
                'gender'        => $gender,
                'pupil_premium' => $pupilPremium
            ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.student.success.update')
            ]);
        }

        return response()->json([
            'error'   => 1,
            'message' => $this->parseErrorMessages($validation)
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
        Student::where('id', $id)
            ->where(function($query) {
                if (Auth::user()->institution_id !== null && Auth::user()->priviledge === 1) {
                    $query->where('user_id', Auth::id())
                          ->orWhere('institution_id', Auth::user()->institution_id);
                } else {
                    $query->where('user_id', Auth::id());
                }
            })->delete();

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

    protected function parseErrorMessages($validation)
    {
        $errorMessages = $validation->errors()->all();
        $responseMessage = '';

        foreach ($errorMessages as $errorMessage) {
            $responseMessage .= $errorMessage;
        }

        return $responseMessage;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_name'             => 'required|between:2,30|regex:/^[a-zA-Z0-9\s-]+$/',
            'gender'                   => 'required|in:male,female',
            'pupil_premium'            => 'nullable|boolean'
        ]);
    }
}
