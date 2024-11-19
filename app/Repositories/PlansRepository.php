<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PlansRepository
{
    // Tipagem da variável
    protected Plan $plan;

    // O construtor agora tem tipagem explícita para o modelo 'Plan'
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    // Método para pegar todos os planos, retorna uma Collection de Plan
    public function all(): Collection
    {
        return $this->plan
            ->with([
                'subscriptions.customer.user' => function ($query) {
                    $query->select('id', 'name', 'email'); // Ajuste os campos conforme necessário
                }
            ])
            ->get();
    }

    // Método para encontrar um plano por ID, pode retornar um objeto Plan ou null
    public function find(int $id): ?Plan
    {
        return $this->plan->find($id);
    }

    // Método para criar um novo plano, retorna um objeto Plan
    public function create(array $data): Plan
    {
        return $this->plan->create($data);
    }

    // Método para atualizar um plano existente, recebe um objeto Plan e um array de dados
    public function update(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan;
    }

    // Método para excluir um plano, retorna um booleano
    public function delete(int $id): bool
    {
        $plan = $this->find($id);
        return $plan ? $plan->delete() : false;
    }
}
