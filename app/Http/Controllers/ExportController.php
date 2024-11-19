<?php

namespace App\Http\Controllers;

use App\Exports\CoursesExports;
use App\Exports\UsersExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Services\CourseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ExportController extends Controller
{
    protected $userService;
    protected $courseService;

    public function __construct(UserService $userService, CourseService $courseService)
    {
        $this->userService = $userService;
        $this->courseService = $courseService;
    }

    public function export(Request $request)
    {
        $users = $this->userService->getAllUsers();

        return Excel::download(new UsersExports($users), 'users.xlsx');
    }

    public function exportPdf(Request $request)
    {

        $users = $this->userService->getAllUsers();

        $pdf = Pdf::loadView('pdf.subscribersPdf', compact('users'));

        return $pdf->download('relatorio_usuarios.pdf');
    }

    public function exportCoursesExcel(Request $request)
    {
        $courses = $this->courseService->getAllCourses();


        return Excel::download(new CoursesExports($courses), 'courses.xlsx');
    }

    public function exportCoursesPdf(Request $request)
    {

        $courses = $this->courseService->getAllCourses();

        $pdf = Pdf::loadView('pdf.coursePdf', compact('courses'));

        return $pdf->download('relatorio_usuarios.pdf');
    }
}
