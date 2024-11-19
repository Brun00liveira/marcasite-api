<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Type\Integer;

class CourseRepository
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAll(int $perPage = 6, $query = null): LengthAwarePaginator | Collection
    {

        $dataQuery = $this->course->newQuery();

        if ($query && isset($query['name'])) {
            $dataQuery->where('title', 'like', '%' . $query['name'] . '%');
        }

        if ($query && isset($query['category_id'])) {

            $categoryIds = is_array($query['category_id']) ? $query['category_id'] : explode(',', $query['category_id']);

            $dataQuery->whereIn('category_id', $categoryIds);
        }

        if ($query && isset($query['price'])) {
            $dataQuery->where('price', '<=', $query['price']);
        }
        if ($query && isset($query['page'])) {
            return $dataQuery->paginate($perPage);
        }
        return $this->course->get();
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

    public function countCourses(): array
    {
        $data =  $this->course->count();

        return [
            'coursesQuatity' => $data
        ];
    }
}
