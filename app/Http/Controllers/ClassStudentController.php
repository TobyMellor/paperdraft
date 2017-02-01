<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassStudent;
use App\Student;
use App\CanvasItem;

use Auth;
use Validator;

use App\Http\Requests;

class ClassStudentController extends Controller
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

        $classStudents = [];
        $students      = ClassStudent::where('class_id', $classId)->get();

        foreach ($students as $student) {
            $classStudents[$student->id] = [
                'id'                       => $student->id,
                'student_id'               => $student->student_id,
                'name'                     => $student->student->name,
                'pupil_premium'            => ($student->student->pupil_premium ? 'true' : 'false'),
                'gender'                   => $student->student->gender,
                'current_attainment_level' => $student->current_attainment_level,
                'target_attainment_level'  => $student->target_attainment_level,
                'ability_cap'              => $student->ability_cap
            ];
        }

        return response()->json([
            'class_students' => $classStudents,
            'error'          => 0,
            'message'        => trans('api.class-student.success.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $studentId              = $request->input('student_id');
        $abilityCap             = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel  = $request->input('target_attainment_level');

        $classId = $request->input('class_id');

        $data = [
            'student_id'               => $studentId,
            'ability_cap'              => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level'  => $targetAttainmentLevel
        ];

        $student = Student::where('id', $studentId)
            ->where(function($query) {
                if (Auth::user()->institution_id !== null) {
                    $query->where('user_id', Auth::id())
                          ->orWhere('institution_id', Auth::user()->institution_id);
                } else {
                    $query->where('user_id', Auth::id());
                }
            });

        $validation = $this->validator($data);

        $validation->after(function($validation) use ($student) {
            if ($student->count() === 0) {
                $validation->errors()->add('student', trans('api.class-student.failure.no-access'));
            }
        });

        $validation->after(function($validation) use ($studentId, $classId) {
            $potentialClassStudent = ClassStudent::where('class_id', $classId)
                ->where('student_id', $studentId);

            if ($potentialClassStudent->count() > 0) {
                $validation->errors()->add('class-student', trans('api.class-student.failure.already-exists'));
            }
        });

        if (!$validation->fails()) {
            $classStudent = new ClassStudent;

            $classStudent->student_id               = $studentId;
            $classStudent->class_id                 = $classId;
            $classStudent->ability_cap              = $abilityCap;
            $classStudent->current_attainment_level = $currentAttainmentLevel;
            $classStudent->target_attainment_level  = $targetAttainmentLevel;
            $classStudent->user_id                  = Auth::id();

            $classStudent->save();

            return response()->json([
                'student'       => $student->first(),
                'class_student' => $classStudent,
                'error'         => 0,
                'message'       => trans('api.class-student.success.store')
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
        $abilityCap             = $request->input('ability_cap');
        $currentAttainmentLevel = $request->input('current_attainment_level');
        $targetAttainmentLevel  = $request->input('target_attainment_level');

        $classId = $request->input('class_id');

        $data = [
            'ability_cap'              => $abilityCap,
            'current_attainment_level' => $currentAttainmentLevel,
            'target_attainment_level'  => $targetAttainmentLevel
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            ClassStudent::where('class_id', $classId)
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->update([
                    'ability_cap'              => $abilityCap,
                    'current_attainment_level' => $currentAttainmentLevel,
                    'target_attainment_level'  => $targetAttainmentLevel
                ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.class-student.success.update')
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $classId = $request->input('class_id');

        CanvasItem::where('class_id', $classId)
            ->where('student_id', $id)
            ->update([
                'student_id' => null
            ]);

        ClassStudent::where('class_id', $classId)
            ->where('student_id', $id)
            ->delete();

        return response()->json([
            'error'   => 0,
            'message' => trans('api.class-student.success.destroy')
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
            'ability_cap'              => 'nullable|in:H,M,L',
            'current_attainment_level' => 'nullable|in:A*,A,B,C,D,E,F,G,U',
            'target_attainment_level'  => 'nullable|in:A*,A,B,C,D,E,F,G,U'
        ]);
    }
}
