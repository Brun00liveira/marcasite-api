<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses(): Collection
    {
        return $this->courseRepository->getAll();
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
