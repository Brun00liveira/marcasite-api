<?php

namespace App\Services;

use App\Integrations\AsaasIntegration;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\CustomerAsaasRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CustomerAsaasService
{
    protected AsaasIntegration $asaasIntegration;
    protected CustomerAsaasRepository $customerAsaasRepository;
    protected UserRepository $userRepository;

    public function __construct(AsaasIntegration $asaasIntegration, CustomerAsaasRepository $customerAsaasRepository, UserRepository $userRepository)
    {
        $this->asaasIntegration = $asaasIntegration;
        $this->customerAsaasRepository = $customerAsaasRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllCourses(): Collection
    {
        return $this->customerAsaasRepository->getAll();
    }

    public function createCustomer(): array
    {
        $user = Auth::user();

        if (!$user) {
            return ['error' => 'User not authenticated'];
        }

        $customerData = $this->asaasIntegration->createCustomer([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'cpfCnpj' => $user->cpf,
        ]);

        if (isset($customerData['error'])) {
            return $customerData;
        }

        $customer = $this->customerAsaasRepository->create([
            "user_id" => $user['id'],
            "asaas_id" => $customerData['id'],
        ]);

        return $customer->toArray();
    }

    public function getCustomerById($id): ?Customer
    {
        return $this->customerAsaasRepository->findById($id);
    }

    public function updateCustomer(string $asaasId, array $data): User
    {
        $this->asaasIntegration->updateCustomer($asaasId, $data);

        $user = $this->userRepository->findById(Auth::user()->id);

        return $this->userRepository->update($user, $data);
    }

    public function deleteCustomer(int $id): bool
    {
        $user = $this->customerAsaasRepository->findById($id);
        return $this->customerAsaasRepository->delete($user);
    }

    public function getCustomerByUserId(): ?Customer
    {
        return $this->customerAsaasRepository->findByUserId();
    }
}
