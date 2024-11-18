<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Resources\StandardResource;
use App\Services\CustomerAsaasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomersAsaasController extends Controller
{
    protected $customerAsaas;

    public function __construct(CustomerAsaasService $customerAsaas)
    {
        $this->customerAsaas = $customerAsaas;
    }

    public function index(): StandardResource
    {
        $enrollments = $this->customerAsaas->getAllCourses();
        return new StandardResource($enrollments);
    }


    public function store(): JsonResponse
    {

        $response = $this->customerAsaas->createCustomer();

        if (isset($response['error']) && $response['error']) {
            return response()->json(['error' => $response['message']], 400);
        }

        return response()->json($response, 201);
    }

    public function show($id): StandardResource
    {
        $course = $this->customerAsaas->getCustomerById($id);
        return new StandardResource($course);
    }

    public function update(int $id, CreateCustomerRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $asaasId = $this->customerAsaas->getCustomerById($id)['asaas_id'];

        $response = $this->customerAsaas->updateCustomer($asaasId, $validatedData);

        if (isset($response['error']) && $response['error']) {
            return response()->json(['error' => $response['message']], 400);
        }

        return response()->json($response, 201);
    }

    public function destroy($id): JsonResponse
    {
        $this->customerAsaas->deleteCustomer($id);
        return response()->json(['message' => 'Inscrição excluída com sucesso'], 200);
    }
}
