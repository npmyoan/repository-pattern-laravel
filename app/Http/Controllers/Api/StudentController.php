<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoresStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StudentResource::collection($this->studentRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresStudentRequest $request)
    {
        $user =  Student::create($request->validated());
        return StudentResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return StudentResource::make($this->studentRepository->getById($student->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {

        $user = $this->studentRepository->update($request->validated(), $student->id);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $this->studentRepository->delete($student->id);
        return response()->noContent();
    }
}
