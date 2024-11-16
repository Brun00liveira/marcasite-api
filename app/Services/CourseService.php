<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function getAllCourses(int $perPage = 6, $query = null): LengthAwarePaginator
    {
        return $this->courseRepository->getAll($perPage, $query);
    }

    public function getCourseById($id): ?Course
    {
        return $this->courseRepository->findById($id);
    }

    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse($id, array $data): Course
    {
        $course = $this->courseRepository->findById($id);
        return $this->courseRepository->update($course, $data);
    }

    public function deleteCourse($id): bool
    {
        $course = $this->courseRepository->findById($id);
        return $this->courseRepository->delete($course);
    }
}
