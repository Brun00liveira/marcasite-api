<?php

namespace App\Http\Controllers;

use App\Exports\UsersExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function export()
    {
        $users = $this->userService->getAllUsers();

        return Excel::download(new UsersExports($users), 'users.xlsx');
    }

    public function exportPdf()
    {
        $users = $this->userService->getAllUsers();

        $pdf = Pdf::loadView('pdf.exemplo', compact('users'));

        return $pdf->download('relatorio_usuarios.pdf');
    }
}
