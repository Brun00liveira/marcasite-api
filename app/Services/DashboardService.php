<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;

class DashboardService
{
    protected $courseRepository;
    protected $categoryRepository;
    protected $enrollmentRepository;
    protected $userRepository;
    protected $subscriptionRepository;

    public function __construct(
        CourseRepository $courseRepository,
        CategoryRepository $categoryRepository,
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository,
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->categoryRepository = $categoryRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userRepository = $userRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getDashboardData()
    {

        $subscription = $this->subscriptionRepository->getCountData();
        $courses = $this->courseRepository->countCourses();
        $users = $this->userRepository->countUser();
        $enrollment = $this->enrollmentRepository->countEnrollment();
        $mergedData = array_merge($subscription,  $users, $courses, $enrollment);

        return $mergedData;
    }
}
