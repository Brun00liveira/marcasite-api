<?php

namespace App\Services;

use App\Models\Plan;
use App\Repositories\PlansRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanService
{
    protected PlansRepository $plansRepository;

    // Injeta o PlansRepository
    public function __construct(PlansRepository $plansRepository)
    {
        $this->plansRepository = $plansRepository;
    }

    // Retorna todos os planos
    public function getAllPlans(): Collection
    {
        return $this->plansRepository->all();
    }

    // Encontra um plano pelo ID
    public function getPlanById(int $id): ?Plan
    {
        return $this->plansRepository->find($id);
    }

    // Cria um novo plano
    public function createPlan(array $data): Plan
    {
        return $this->plansRepository->create($data);
    }

    // Atualiza um plano existente
    public function updatePlan(Plan $plan, array $data): Plan
    {
        // Aqui você passa o objeto do plano e os dados para atualização
        return $this->plansRepository->update($plan, $data);
    }

    // Exclui um plano
    public function deletePlan(int $id): bool
    {
        return $this->plansRepository->delete($id);
    }
}
