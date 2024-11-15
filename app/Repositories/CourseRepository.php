<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAll(int $perPage = 10, $query = null): LengthAwarePaginator
    {
        // Inicia a consulta
        $dataQuery = $this->course->newQuery();

        // Aplica os filtros
        if ($query && isset($query['name'])) {
            $dataQuery->where('title', 'like', '%' . $query['name'] . '%');
        }

        if ($query && isset($query['category_id'])) {
            $dataQuery->where('category_id', 'like', '%' . $query['category_id'] . '%');
        }

        // Retorna a paginação com os filtros aplicados
        return $dataQuery->paginate($perPage);
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
