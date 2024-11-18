<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Repositories\PaymentsAsaasRepository;
use App\Repositories\CustomerAsaasRepository;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentAsaasService
{
    protected AsaasIntegration $asaasIntegration;
    protected PaymentsAsaasRepository $paymentsAsaasRepository;
    protected CustomerAsaasRepository $customerAsaasRepository;

    public function __construct(AsaasIntegration $asaasIntegration, PaymentsAsaasRepository $paymentsAsaasRepository, CustomerAsaasRepository $customerAsaasRepository)
    {
        $this->asaasIntegration = $asaasIntegration;
        $this->paymentsAsaasRepository = $paymentsAsaasRepository;
        $this->customerAsaasRepository = $customerAsaasRepository;
    }

    public function createPayment(array $data): Payment
    {
        $customers = $this->customerAsaasRepository->findById(Auth::user()->id);
        $data['customer'] = $customers['asaas_id'];
        $paymentData = $this->asaasIntegration->createPayment($data);


        return $this->paymentsAsaasRepository->create([
            'asaas_id' =>  $data['customer'],
            'customer_id' => $customers['id'],
            'value' => $paymentData['value'],
            'status' => $paymentData['status'],
            'billing_type' => $paymentData['billingType'],
            'due_date' => $paymentData['originalDueDate'],
            'description' => $paymentData['description']
        ]);


        throw new \Exception($paymentData['message']);
    }
}
