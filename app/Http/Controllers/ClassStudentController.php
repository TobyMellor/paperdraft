<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassStudent;
use App\CanvasItem;

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
        $students = ClassStudent::where('class_id', $classId)
            ->get();

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
}
