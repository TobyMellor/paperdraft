<?php

namespace App\Http\Controllers;

use App\Student;
use App\ClassStudent;
use App\SchoolClass;

use Auth;

class IndexController extends Controller
{
    public function __construct() {
        $this->middleware('should_reset_password');
    }

    /**
     * Display the appropriate dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getDashboard(
        ClassController $classController,
        ItemController $itemController,
        SettingController $settingController
    )
    {
        $classes = $classController->getClasses();
        $items = $itemController->index();

        if ($classes->first() !== null && Auth::user()->first_name !== null) {
            $recentClassId   = $classController->getRecentClassId();
            $userPreferences = $settingController->getUserPreferences();
            $classRooms      = null;

            if (Auth::user()->institution_id !== null && Auth::user()->priviledge === 1) {
                $classRooms = SchoolClass::where('institution_id', Auth::user()->institution_id)
                    ->get();
            }

            return view('dashboard.index')
                ->with('classes', $classes)
                ->with('items', $items)
                ->with('recentClassId', $recentClassId)
                ->with('userPreferences', $userPreferences)
                ->with('classRooms', $classRooms);
        }

        return $this->getClassesDashboard($classController);
    }

    public function getWizardDashboard(ClassController $classController)
    {
        $classes = $classController->getClasses();
        
        return view('dashboard.wizard')
            ->with('classes', $classes);
    }

    /**
     * Find a class to redirect to. If none, show creation options
     *
     * @return \Illuminate\Http\Redirect || \Illuminate\Http\View
     */
    public function getClassesDashboard(ClassController $classController)
    {
        $classes = $classController->getClasses();

        if ($classes->first() !== null && Auth::user()->first_name !== null) {
            return redirect('/dashboard/classes/' . $classes->first()->id);
        }
        
        return $this->getWizardDashboard($classController);
    }

    /**
     * Display the class dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getClassDashboard(
        $classId,
        ClassController $classController,
        SettingController $settingController
    )
    {
        $classes = $classController->getClasses();
        $selectedClass = $classController->getClass($classId);
        $classStudents = ClassStudent::where('class_id', $classId)->get();
        $userPreferences = $settingController->getUserPreferences();

        $institutionStudents = null;

        if (Auth::user()->institution_id !== null) {
            $institutionStudents = Student::where('user_id', Auth::id())->get();
        }

        return view('dashboard.classes')
            ->with('classStudents', $classStudents)
            ->with('classes', $classes)
            ->with('selectedClass', $selectedClass)
            ->with('classId', $classId)
            ->with('institutionStudents', $institutionStudents)
            ->with('userPreferences', $userPreferences);
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\View
     */
    public function getAdminDashboard(ClassController $classController)
    {
        $classes  = $classController->getClasses();
        $students = Student::where('user_id', Auth::id())->get(); // TODO: may need to change to institution_id in future

        if ($classes->first() !== null && Auth::user()->first_name !== null) {
            return view('dashboard.admin')
                ->with('classes', $classes)
                ->with('students', $students);
        }
        
        return $this->getWizardDashboard($classController);
    }
}
