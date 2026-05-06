<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($request = null, $perPage = 15)
    {
        $query = $this->model->applyQueryFilters($request);

        if ($request && (is_object($request) || is_array($request))) {
            $requestData = is_array($request) ? $request : (method_exists($request, 'all') ? $request->all() : (array) $request);
            $perPage = $requestData['per_page'] ?? $requestData['perPage'] ?? $perPage;
            
            $perPage = min($perPage, 100);
        }
        
        return $query->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function restore(int $id)
    {
        $record = $this->model->onlyTrashed()->findOrFail($id);
        return $record ? $record->restore() : null;
    }

    public function forceDelete(int $id)
    {
        $record = $this->model->onlyTrashed()->findOrFail($id);
        return $record ? $record->forceDelete() : null;
    }

    public function bulkDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkRestore(array $ids)
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }

    public function bulkForceDelete(array $ids)
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
}