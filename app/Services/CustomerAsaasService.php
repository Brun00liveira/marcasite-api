<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Models\Customer;
use App\Repositories\CustomerAsaasRepository;
use Illuminate\Database\Eloquent\Collection;

class CustomerAsaasService
{
    protected AsaasIntegration $asaasIntegration;
    protected CustomerAsaasRepository $customerAsaasRepository;

    public function __construct(AsaasIntegration $asaasIntegration, CustomerAsaasRepository $customerAsaasRepository)
    {
        $this->asaasIntegration = $asaasIntegration;
        $this->customerAsaasRepository = $customerAsaasRepository;
    }

    public function getAllCourses(): Collection
    {
        return $this->customerAsaasRepository->getAll();
    }

    public function createCustomer(array $data): array
    {
        $customerData = $this->asaasIntegration->createCustomer($data);

        if (isset($customerData['error'])) {
            return $customerData;
        }

        $customer = $this->customerAsaasRepository->create([
            "name" => $customerData['name'],
            "email" => $customerData['email'],
            "phone" => $customerData['phone'],
            "cpfCnpj" => $customerData['cpfCnpj'],
            "asaas_id" => $customerData['id'],
        ]);

        return $customer->toArray();
    }

    public function getCustomerById($id): ?Customer
    {
        return $this->customerAsaasRepository->findById($id);
    }

    public function updateCustomer(string $asaasId, array $data): array
    {
        $customerData = $this->asaasIntegration->updateCustomer($asaasId, $data);

        if (isset($customerData['error'])) {
            return $customerData;
        }

        $user = $this->customerAsaasRepository->findByAsaasId($asaasId);

        $customer = $this->customerAsaasRepository->update($user, [
            "name" => $customerData['name'],
            "email" => $customerData['email'],
            "phone" => $customerData['phone'],
            "cpfCnpj" => $customerData['cpfCnpj'],
            "asaas_id" => $customerData['id'],
        ]);

        return $customer->toArray();
    }

    public function deleteCustomer(int $id): bool
    {
        $user = $this->customerAsaasRepository->findById($id);
        return $this->customerAsaasRepository->delete($user);
    }
}
