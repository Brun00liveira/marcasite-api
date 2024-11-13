<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\PhotoRequest;
use App\Http\Resources\StandardResource;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request): StandardResource
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);

        $courses = $this->courseService->getAllCourses($perPage, $page);

        return new StandardResource($courses);
    }


    public function show($id): StandardResource
    {
        $course = $this->courseService->getCourseById($id);
        return new StandardResource($course);
    }

    public function store(CourseRequest $request): StandardResource
    {

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $path = $request->file('photo')->store('courses', 'public');
        } else {
            $path = null;
        }

        $course = $this->courseService->createCourse([
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'price' => $request->validated()['price'],
            'photo' => $path,
        ]);

        return new StandardResource($course);
    }

    public function update(CourseRequest $request, $id): StandardResource
    {
        $course = $this->courseService->updateCourse($id, $request->all());

        return new StandardResource($course);
    }

    public function updatePhoto(PhotoRequest $request, $id): StandardResource
    {

        $course = $this->courseService->getCourseById($id);

        if ($course && $course->photo) {
            $oldPhotoPath = $course->photo;

            if (Storage::exists($oldPhotoPath)) {
                Storage::delete($oldPhotoPath);
            }
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $path = $request->file('photo')->store('courses', 'public');
        } else {
            $path = null;
        }

        $course = $this->courseService->updateCourse($id, [
            "photo" => $path
        ]);

        return new StandardResource($course);
    }

    public function destroy($id): JsonResponse
    {
        $this->courseService->deleteCourse($id);
        return response()->json(['message' => 'Curso excluído com sucesso'], 200);
    }
}
