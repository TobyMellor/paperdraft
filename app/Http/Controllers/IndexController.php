<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display the appropriate dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getDashboard(
        ClassController $classController,
        StudentController $studentController,
        ItemController $itemController
    )
    {
        $classes = $classController->getClasses();
        $items = $itemController->getItems(9);

        if($classes->first() != null) {
            $classStudents = $studentController->getClassStudents($classes->first()->id, 9);

            return view('dashboard.index-test')
                ->with('classStudents', $classStudents)
                ->with('classes', $classes)
                ->with('items', $items);
        } else {
            //Lets do something here for new users e.g. redirect them to force make a class
            return view('dashboard.index')
                ->with('items', $items);
        }
    }

    /**
     * Find a class to redirect to. If none, show creation options
     *
     * @return \Illuminate\Http\Redirect || \Illuminate\Http\View
     */
    public function getClassesDashboard(ClassController $classController)
    {
        $classes = $classController->getClasses();
        if($classes->first() != null) {
            return redirect('/dashboard/classes/' . $classes->first()->id);
        } else {
            //Lets do something here for new users
            return view('dashboard.classes');
        }
    }

    /**
     * Display the class dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getClassDashboard(
        $classId,
        ClassController $classController,
        StudentController $studentController
    )
    {
        $classes = $classController->getClasses();
        $selectedClass = $classController->getClass($classId);
        $classStudents = $studentController->getClassStudents($classId);

        return view('dashboard.classes')
            ->with('classStudents', $classStudents)
            ->with('classes', $classes)
            ->with('selectedClass', $selectedClass)
            ->with('classId', $classId);
    }
}
