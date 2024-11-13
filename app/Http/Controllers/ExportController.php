<?php

namespace App\Http\Controllers;

use App\Exports\UsersExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ExportController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function export(Request $request)
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);

        $users = $this->userService->getAllUsers($perPage, $page);


        return Excel::download(new UsersExports($users), 'users.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);

        $users = $this->userService->getAllUsers($perPage, $page);

        $pdf = Pdf::loadView('pdf.exemplo', compact('users'));

        return $pdf->download('relatorio_usuarios.pdf');
    }
}
