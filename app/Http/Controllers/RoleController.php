<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\Eloquent\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Override;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * The repository instance.
     */
    protected $roleRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(RoleRepository $roleRepository) {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get the middleware for the controller.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_roles')->only(['index', 'show']),
            new Middleware('permission:create_roles')->only(['create', 'store']),
            new Middleware('permission:edit_roles')->only(['edit', 'update']),
            new Middleware('permission:delete_roles')->only(['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->all($request);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roleRepository->create($request->validated());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleRepository->find($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->roleRepository->find($id);
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $this->roleRepository->update($id, $request->validated());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->roleRepository->delete($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
