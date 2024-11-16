<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\UserRepository;

class DashboardService
{
    protected $courseRepository;
    protected $categoryRepository;
    protected $enrollmentRepository;
    protected $userRepository;

    public function __construct(
        CourseRepository $courseRepository,
        CategoryRepository $categoryRepository,
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->categoryRepository = $categoryRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userRepository = $userRepository;
    }

    public function getDashboardData()
    {
        $courses = $this->courseRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $totalEnrollments = $this->enrollmentRepository->getAll();
        $totalUsers = $this->userRepository->getAll();

        return [
            'courses' => $courses,
            'categories' => $categories,
            'totalEnrollments' => $totalEnrollments,
            'totalUsers' => $totalUsers,
        ];
    }
}
