<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\StandardResource;
use App\Services\EnrollmentService;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    protected $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function index(): StandardResource
    {
        $enrollments = $this->enrollmentService->getAllEnrollments();
        return new StandardResource($enrollments);
    }

    public function show($id): StandardResource
    {
        $enrollment = $this->enrollmentService->getEnrollmentById($id);
        return new StandardResource($enrollment);
    }

    public function store(EnrollmentRequest $request): StandardResource
    {
        $validatedData = $request->validated();

        $enrollment = $this->enrollmentService->createEnrollment($validatedData);

        return new StandardResource($enrollment);
    }

    public function update(EnrollmentRequest $request, $id): StandardResource
    {
        $validatedData = $request->validated();

        $enrollment = $this->enrollmentService->updateEnrollment($id, $validatedData);

        return new StandardResource($enrollment);
    }

    public function destroy($id): JsonResponse
    {
        $this->enrollmentService->deleteEnrollment($id);
        return response()->json(['message' => 'Inscrição excluída com sucesso'], 200);
    }
}
