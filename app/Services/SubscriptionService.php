<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Repositories\SubscriptionRepository;
use App\Repositories\CustomerAsaasRepository;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    protected AsaasIntegration $asaasIntegration;
    protected SubscriptionRepository $subscriptionRepository;
    protected CustomerAsaasRepository $customerAsaasRepository;

    public function __construct(AsaasIntegration $asaasIntegration, SubscriptionRepository $subscriptionRepository, CustomerAsaasRepository $customerAsaasRepository)
    {
        $this->asaasIntegration = $asaasIntegration;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->customerAsaasRepository = $customerAsaasRepository;
    }

    public function createPayment(array $data): Subscription
    {
        $subscription = $this->subscriptionRepository->findSubscriptionBypaymentId($data['id']);

        $customer = $this->customerAsaasRepository->findByAsaasId($data['customer']);

        if ($subscription == null) {
            return $this->subscriptionRepository->create([
                'payment_id' => $data['id'],
                'customer_id' => $customer->id,
                'billing_type' => $data['billingType'],
                'value' => $data['value'],
                'status' => $data['status'],
                'due_date' => $data['dueDate'],
                'payment_date' => $data['paymentDate'] ?? null,
            ]);
        } else {
            return $this->subscriptionRepository->update($subscription, [
                'payment_id' => $data['id'],
                'customer_id' => $subscription->customer_id,
                'billing_type' => $data['billingType'],
                'value' => $data['value'],
                'status' => $data['status'],
                'due_date' => $data['dueDate'],
                'payment_date' => $data['paymentDate'] ?? null,
            ]);
        }
    }
    public function receivePayment(array $data): Subscription
    {

        $subscription = $this->subscriptionRepository->findSubscriptionBypaymentId($data['id']);

        $customer = $this->customerAsaasRepository->findByAsaasId($data['customer']);

        if ($subscription == null) {
            return $this->subscriptionRepository->create([
                'payment_id' => $data['id'],
                'customer_id' => $customer->id,
                'billing_type' => $data['billingType'],
                'value' => $data['value'],
                'status' => $data['status'],
                'due_date' => $data['dueDate'],
                'payment_date' => $data['paymentDate'] ?? null,
            ]);
        } else {
            return $this->subscriptionRepository->update($subscription, [
                'payment_id' => $data['id'],
                'customer_id' => $subscription->customer_id,
                'billing_type' => $data['billingType'],
                'value' => $data['value'],
                'status' => $data['status'],
                'due_date' => $data['dueDate'],
                'payment_date' => $data['paymentDate'] ?? null,
            ]);
        }

        // Se a assinatura não for encontrada, você pode lançar um erro ou fazer outro tipo de manipulação
        throw new \Exception('Subscription not found for the given customer.');
    }
}
