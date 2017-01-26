<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassStudent;

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
                'canvas_item_id'           => $student->canvas_item_id,
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
