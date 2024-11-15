<?php

namespace App\Services;

use App\Repositories\EnrollmentRepository;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentService
{
    protected $enrollmentRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function getAllEnrollments(): Collection
    {
        return $this->enrollmentRepository->getAll();
    }

    public function getEnrollmentById(int $id): Enrollment
    {
        return $this->enrollmentRepository->findById($id);
    }

    public function createEnrollment(array $data): Enrollment
    {
        return $this->enrollmentRepository->create($data);
    }

    public function updateEnrollment(int $id, array $data): Enrollment
    {
        $user = $this->enrollmentRepository->findById($id);

        return $this->enrollmentRepository->update($user, $data);
    }

    public function deleteEnrollment(int $id): bool
    {
        $user = $this->enrollmentRepository->findById($id);
        return $this->enrollmentRepository->delete($user);
    }

    public function getEnrollmentsByUserId(): Collection
    {
        return $this->enrollmentRepository->getByUserId();
    }

    public function getEnrollmentsByCourseId(int $courseId): Collection
    {
        return $this->enrollmentRepository->getByCourseId($courseId);
    }
}
