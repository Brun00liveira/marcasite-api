<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Repositories\PaymentsAsaasRepository;
use App\Models\Payment;

class PaymentAsaasService
{
    protected $asaasIntegration;
    protected $paymentsAsaasRepository;

    public function __construct(AsaasIntegration $asaasIntegration, PaymentsAsaasRepository $paymentsAsaasRepository)
    {
        $this->asaasIntegration = $asaasIntegration;
        $this->paymentsAsaasRepository = $paymentsAsaasRepository;
    }

    public function createPayment(array $data): Payment
    {   
        $this->CustomerAsaasService->
        $paymentData = $this->asaasIntegration->createPayment($data);
        dd($paymentData);
        // Se o pagamento foi criado com sucesso no Asaas, armazena no banco
        if (isset($paymentData['error']) && $paymentData['error'] === false) {
            return $this->paymentsAsaasRepository->create([
                'payment_id' => $paymentData['id'],  // Exemplo: ID retornado pela API do Asaas
                'value' => $paymentData['value'],
                'status' => $paymentData['status'],
                // Outras informações que você deseja armazenar
            ]);
        }

        // Se houve erro ao criar o pagamento, você pode lançar uma exceção ou retornar um erro.
        throw new \Exception($paymentData['message']);
    }
}
