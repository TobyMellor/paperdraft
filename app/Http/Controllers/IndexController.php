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
        $assetsBasePath = '/assets/images/objects/';
        $classes = $classController->getClasses();
        $objects = $objectController->getObjects(9);

        if($classes->first() != null) {
            $classStudents = $studentController->getClassStudents($classes->first()->id, 9);

            return view('dashboard.index')
                ->with('classStudents', $classStudents)
                ->with('classes', $classes)
                ->with('objects', $objects)
                ->with('assetsBasePath', $assetsBasePath);
        } else {
            //Lets do something here for new users e.g. redirect them to force make a class
            return view('dashboard.index')
                ->with('objects', $objects)
                ->with('assetsBasePath', $assetsBasePath);
        }
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
        if($classes->first() != null) {
            $classStudents = $studentController->getClassStudents($classes->first()->id);
            $objects = $objectController->getObjects(9);
            return view('dashboard.classes')
                ->with('classStudents', $classStudents)
                ->with('classes', $classes);
        } else {
            //Lets do something here for new users
            return view('dashboard.classes');
        }
    }
}
