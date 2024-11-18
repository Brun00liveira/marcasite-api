<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CustomerAsaasRepository
{
    protected Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function create(array $data): Customer
    {
        return $this->customer->create($data);
    }

    public function getAll(): Collection
    {
        return $this->customer->with("user")->get();
    }

    public function findById(int $id): Customer
    {
        return $this->customer->findOrFail($id);
    }

    public function findByUserId(): Customer
    {
        return $this->customer->findOrFail(Auth::user()->id);
    }

    public function findByAsaasId(string $asaasId): Customer
    {

        return $this->customer->where('asaas_id', $asaasId)->first();
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer): bool
    {
        return $customer->delete();
    }
}
