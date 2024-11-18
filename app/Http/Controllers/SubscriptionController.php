<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function asaasWebhook(Request $request)
    {
        // Obtém todos os dados do corpo da requisição
        $body = $request->all();

        // Verifica o tipo de evento
        switch ($body['event']) {
            case 'PAYMENT_CREATED':
                $payment = $body['payment'];
                $this->createPayment($payment);
                break;
            case 'PAYMENT_RECEIVED':
                $payment = $body['payment'];
                $this->receivePayment($payment);
                break;
                // ... Adicione mais casos de eventos conforme necessário
            default:
                Log::info('Este evento não é aceito: ' . $body['event']);
        }

        // Retorna uma resposta de confirmação
        return response()->json($payment);
    }

    private function createPayment($payment)
    {
        return $this->subscriptionService->createPayment($payment);
    }

    // Função para tratar o evento PAYMENT_RECEIVED
    private function receivePayment($payment)
    {
        return $this->subscriptionService->receivePayment($payment);
    }
}
