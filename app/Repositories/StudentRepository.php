<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAll()
    {
        return Student::all();
    }
    public function getById(int|string $id)
    {
        return Student::findOrFail($id);
    }

    public function create(array $data)
    {
        return Student::create($data);
    }

    public function update(array $data, int|string $id)
    {
        Student::where('id', $id)->update($data);
        return Student::findOrFail($id);
    }

    public function delete(int|string $id)
    {
        return Student::destroy($id);
    }
}
