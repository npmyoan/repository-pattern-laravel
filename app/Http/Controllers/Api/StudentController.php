<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoresStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *  title="Api Swagger",
 *  version="1.0.0",
 *  description="Api Crud Students"
 * )
 * @OA\Server(url="http://localhost:8000")
 */
class StudentController extends Controller
{

    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    /**
     * @OA\Get(
     *  path="/api/students",
     *  tags={"Students"},
     *  summary="Get list of students",
     *  description="Return list of students",
     *  @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/StudentResource")
     *      )
     *  )
     * )
     */
    public function index()
    {
        return StudentResource::collection($this->studentRepository->getAll());
    }

    /**
     * @OA\Post(
     *     path="/api/students",
     *     tags={"Students"},
     *     summary="Create new student",
     *     description="Create a new student record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "age"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="age", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Record created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function store(StoresStudentRequest $request)
    {
        $user = Student::create($request->validated());
        return StudentResource::make($user);
    }

    /**
     * @OA\Get(
     *     path="/api/students/{id}",
     *     tags={"Students"},
     *     summary="Get student information",
     *     description="Get student details by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function show(Student $student)
    {
        return StudentResource::make($this->studentRepository->getById($student->id));
    }

    /**
     * @OA\Put(
     *     path="/api/students/{id}",
     *     tags={"Students"},
     *     summary="Update student information",
     *     description="Update student record by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "age"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="age", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Record updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {

        $user = $this->studentRepository->update($request->validated(), $student->id);
        return $user;
    }

    /**
     * @OA\Delete(
     *     path="/api/students/{id}",
     *     tags={"Students"},
     *     summary="Delete student record",
     *     description="Delete student by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Record deleted successfully"
     *     )
     * )
     */
    public function destroy(Student $student)
    {
        $this->studentRepository->delete($student->id);
        return response()->noContent();
    }
}
