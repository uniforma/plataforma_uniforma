<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    /**
     * PermissionController constructor.
     */
    protected $permissionRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(PermissionRepository $permissionRepository) {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get the middleware for the controller.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_permissions')->only(['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepository->all($request);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = $this->permissionRepository->find($id);
        return view('permissions.show', compact('permission'));
    }
}
