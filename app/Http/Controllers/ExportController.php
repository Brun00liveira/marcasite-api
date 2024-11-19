<?php

namespace App\Http\Controllers;

use App\Exports\UsersExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ExportController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function export(Request $request)
    {
        $users = $this->subscriptionService->getAllSubscriptions();


        return Excel::download(new UsersExports($users), 'users.xlsx');
    }

    public function exportPdf(Request $request)
    {

        $subscriptions = $this->subscriptionService->getAllSubscriptions();

        $pdf = Pdf::loadView('pdf.subscribersPdf', compact('subscriptions'));

        return $pdf->download('relatorio_usuarios.pdf');
    }
}
