<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest; // Requisição de pagamento
use App\Services\PaymentAsaasService;
use Illuminate\Http\JsonResponse;

class PaymentAsaasController extends Controller
{
    protected $paymentAsaasService;

    public function __construct(PaymentAsaasService $paymentAsaasService)
    {
        $this->paymentAsaasService = $paymentAsaasService;
    }

    public function store(CreatePaymentRequest $request): JsonResponse
    {
        dd($request);
        try {
            $paymentData = $this->paymentAsaasService->createPayment($request->validated());

            // Se tudo correr bem, você pode retornar a resposta com os dados do pagamento
            return response()->json([
                'success' => true,
                'payment' => $paymentData,
            ], 201);
        } catch (\Exception $e) {
            // Caso haja um erro, retorne uma mensagem de erro
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
