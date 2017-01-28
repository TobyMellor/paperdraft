<?php

namespace App\Http\Controllers;

use App\ClassStudent;

class IndexController extends Controller
{
    public function __construct() {}

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
        $items = $itemController->index();

        if ($classes->first() !== null) {
            $recentClassId = $classController->getRecentClassId();
            $classStudents = ClassStudent::where('class_id', $classes->first()->id)->paginate(9);

            return view('dashboard.index-test')
                ->with('classStudents', $classStudents)
                ->with('classes', $classes)
                ->with('items', $items)
                ->with('recentClassId', $recentClassId);
        }

        return $this->getClassesDashboard($classController);
    }

    public function getWizardDashboard()
    {
        return view('dashboard.wizard');
    }

    /**
     * Find a class to redirect to. If none, show creation options
     *
     * @return \Illuminate\Http\Redirect || \Illuminate\Http\View
     */
    public function getClassesDashboard(ClassController $classController)
    {
        $classes = $classController->getClasses();

        if ($classes->first() !== null) {
            return redirect('/dashboard/classes/' . $classes->first()->id);
        }
        
        return $this->getWizardDashboard();
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
        $classStudents = ClassStudent::where('class_id', $classId)->get();

        return view('dashboard.classes')
            ->with('classStudents', $classStudents)
            ->with('classes', $classes)
            ->with('selectedClass', $selectedClass)
            ->with('classId', $classId);
    }
}
