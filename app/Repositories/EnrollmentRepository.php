<?php

namespace App\Repositories;

use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EnrollmentRepository
{
    protected $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function getAll(): Collection
    {
        return $this->enrollment->all();
    }

    public function findById($id): Enrollment
    {
        return $this->enrollment->findOrFail($id);
    }

    public function create(array $data): Enrollment
    {
        return $this->enrollment->create($data);
    }

    public function update(Enrollment $enrollment, array $data): Enrollment
    {
        $enrollment->update($data);
        return $enrollment;
    }

    public function delete(Enrollment $enrollment): bool
    {
        return $enrollment->delete();
    }

    public function getByUserId(): Collection
    {
        return $this->enrollment->where('user_id', Auth::user()->id)->get();
    }

    public function getByCourseId($courseId): Collection
    {
        return $this->enrollment->where('course_id', $courseId)->get();
    }
}
