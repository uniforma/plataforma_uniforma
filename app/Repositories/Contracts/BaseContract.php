<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function restore(int $id);
    public function forceDelete(int $id);
    public function bulkDelete(array $ids);
    public function bulkRestore(array $ids);
    public function bulkForceDelete(array $ids);
}