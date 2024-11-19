<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Resources\StandardResource;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    protected PlanService $plansService;

    // Injeta o PlanService
    public function __construct(PlanService $plansService)
    {
        $this->plansService = $plansService;
    }

    // Método para listar todos os planos
    public function index(): StandardResource
    {
        $plans = $this->plansService->getAllPlans();
        return new StandardResource($plans);
    }

    // Método para mostrar um plano específico
    public function show(int $id)
    {
        $plan = $this->plansService->getPlanById($id);

        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado']);
        }

        return new StandardResource($plan);
    }

    // Método para criar um novo plano
    public function store(StorePlanRequest $request)
    {
        $plan = $this->plansService->createPlan($request->validated());

        return new StandardResource($plan);
    }

    // Método para atualizar um plano existente
    public function update(StorePlanRequest $request, int $id)
    {
        // Encontra o plano para atualizar
        $plan = $this->plansService->getPlanById($id);

        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado']);
        }

        // Atualiza o plano com os novos dados
        $updatedPlan = $this->plansService->updatePlan($plan,  $request->validated());

        return new StandardResource($updatedPlan);
    }

    // Método para excluir um plano
    public function destroy(int $id)
    {
        $deleted = $this->plansService->deletePlan($id);

        if ($deleted) {
            return response()->json(['message' => 'Plano excluído com sucesso']);
        }

        return response()->json(['message' => 'Plano não encontrado']);
    }
}
