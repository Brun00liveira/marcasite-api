<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Repositories\SubscriptionRepository;
use App\Repositories\CustomerAsaasRepository;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected AsaasIntegration $asaasIntegration;
    protected SubscriptionRepository $subscriptionRepository;
    protected CustomerAsaasRepository $customerAsaasRepository;

    public function __construct(
        AsaasIntegration $asaasIntegration,
        SubscriptionRepository $subscriptionRepository,
        CustomerAsaasRepository $customerAsaasRepository
    ) {
        $this->asaasIntegration = $asaasIntegration;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->customerAsaasRepository = $customerAsaasRepository;
    }

    public function createOrUpdatePayment(array $data, string $event): ?Subscription
    {
        try {
            // Busca inscrição pelo ID de pagamento
            $subscription = $this->subscriptionRepository->findSubscriptionBypaymentId($data['id']);

            // Busca cliente pelo ID do Asaas
            $customer = $this->customerAsaasRepository->findByAsaasId($data['customer']);

            if (!$customer) {
                Log::error("Cliente não encontrado para o Asaas ID: {$data['customer']}");
                return null;
            }

            $payload = [
                'payment_id' => $data['id'],
                'customer_id' => $customer->id,
                'billing_type' => $data['billingType'],
                'value' => $data['value'],
                'status' => $event,
                'due_date' => $data['dueDate'],
                'payment_date' => $data['paymentDate'] ?? null,
            ];

            // Cria ou atualiza a inscrição
            return $subscription
                ? $this->subscriptionRepository->update($subscription, $payload)
                : $this->subscriptionRepository->create($payload);
        } catch (\Exception $e) {
            Log::error('Erro ao criar/atualizar pagamento: ' . $e->getMessage());
            return null;
        }
    }

    public function getAllSubscriptions(int $perPage = 6, $query = null): Collection|LengthAwarePaginator
    {
        return $this->subscriptionRepository->getAll($perPage, $query);
    }
}
