<?php

namespace App\Interfaces;

interface StudentRepositoryInterface
{
    public function getAll();
    public function getById(int|string $id);
    public function create(array $data);
    public function update(array $data, int|string $id);
    public function delete(int|string $id);
}
