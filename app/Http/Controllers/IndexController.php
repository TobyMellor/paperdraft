<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the appropriate dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getDashboard(
        ClassController $classController,
        StudentController $studentController,
        ObjectController $objectController
    )
    {
        $classes = $classController->getClasses();
        $classStudents = $studentController->getClassStudents($classes->first()->id, 9);
        $objects = $objectController->getObjects(9);
        $assetsBasePath = '/assets/images/objects/';

        return view('dashboard.index')
            ->with('classStudents', $classStudents)
            ->with('classes', $classes)
            ->with('objects', $objects)
            ->with('assetsBasePath', $assetsBasePath);
    }

    /**
     * Display the classes dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getClassesDashboard(
        ClassController $classController,
        StudentController $studentController,
        ObjectController $objectController
    )
    {
        $classes = $classController->getClasses();
        $classStudents = $studentController->getClassStudents($classes->first()->id);
        $objects = $objectController->getObjects(9);
        return view('dashboard.classes')
            ->with('classStudents', $classStudents)
            ->with('classes', $classes);
    }
}
