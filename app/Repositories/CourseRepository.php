<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Type\Integer;

class CourseRepository
{
    protected $course;
    protected $category;

    public function __construct(Course $course, Category $category)
    {
        $this->course = $course;
        $this->category = $category;
    }

    public function getAll(int $perPage = 6, $query = null): LengthAwarePaginator | Collection
    {

        $dataQuery = $this->course->newQuery()
            ->with('category', 'enrollments')
            ->withCount('enrollments');


        if ($query && isset($query['name'])) {
            $dataQuery->where('title', 'like', '%' . $query['name'] . '%');
        }

        if ($query && isset($query['category_id'])) {
            $categoryIds = is_array($query['category_id']) ? $query['category_id'] : explode(',', $query['category_id']);
            $dataQuery->whereIn('category_id', $categoryIds);
        }

        if ($query && isset($query['page'])) {
            return $dataQuery->paginate($perPage);
        }

        return $dataQuery->get();
    }

    public function findById($id): Course
    {
        return $this->course->with('category')->find($id);
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

    public function countCourses(): array
    {

        $courses = $this->course
            ->with('category')
            ->whereNotNull('category_id')
            ->get();

        $coursesByCategory = $courses->groupBy('category_id');

        $enrollmentsPerCategory = $coursesByCategory->map(function ($group) {
            return $group->count();
        });

        $categoryNames = $this->category
            ->whereIn('id', $enrollmentsPerCategory->keys())
            ->pluck('name', 'id');

        $labels = $enrollmentsPerCategory->keys()->map(function ($categoryId) use ($categoryNames) {
            return $categoryNames->get($categoryId);
        });

        $series = $enrollmentsPerCategory->values();

        return [
            'coursesQuantity' => $this->course->count(),
            'labelsCategory' => $labels,
            'seriesCategory' => $series,
        ];
    }
}
