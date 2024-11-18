<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EnrollmentRepository
{
    protected $enrollment;
    protected $course;

    public function __construct(Enrollment $enrollment, Course $course)
    {
        $this->enrollment = $enrollment;
        $this->course = $course;
    }

    public function getAll(): Collection
    {
        return $this->enrollment->get();
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
        return $this->enrollment
            ->where('user_id', Auth::id())
            ->with(['user', 'course'])
            ->get();
    }

    public function getByCourseId($courseId): Collection
    {
        return $this->enrollment->where('course_id', $courseId)->get();
    }


    public function countEnrollment(): array
    {
        // Buscar as inscrições, incluindo o nome do curso
        $data = $this->enrollment
            ->with('course') // Certifique-se de que o modelo de Enrollment tenha a relação com Course definida
            ->select('enrolled_at', 'course_id') // Incluir o curso (por ID)
            ->get()
            ->groupBy(function ($item) {
                return $item->enrolled_at->format('Y-m-d H:00:00'); // Agrupar por hora
            })
            ->map(function ($group) {
                return $group->count(); // Contar quantas inscrições por hora
            });

        // Contar o total de inscritos por curso
        $enrollmentsPerCourse = $this->enrollment
            ->with('course')
            ->get()
            ->whereNotNull('course_id')
            ->groupBy('course_id')
            ->map(function ($group) {
                return $group->count();
            });

        $courseNames = $enrollmentsPerCourse->keys()->map(function ($courseId) {

            return $this->course->find($courseId)->title;
        });

        $labels = $data->keys();
        $series = $data->values();

        $labelsCourse = $courseNames;
        $seriesCourse = $enrollmentsPerCourse->values();

        return [
            'totalEnrollments' => $this->enrollment->count(),
            'labelsEnrollments' => $labels,
            'seriesEnrollments' => $series,
            'labelsCourse' => $labelsCourse,
            'seriesCourse' => $seriesCourse,
        ];
    }
}
