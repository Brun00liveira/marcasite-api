<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAll(): Collection
    {
        return $this->course->all();
    }

    public function findById($id): Course
    {
        return $this->course->findOrFail($id);
    }

    public function create(array $data): Course
    {
        return $this->course->create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course;
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }
}
