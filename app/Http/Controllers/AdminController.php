<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Role;
use App\Repositories\Eloquent\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Password;

class AdminController extends Controller implements HasMiddleware
{
    /**
     * The repository instance.
     */
    protected $adminRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Get the middleware the controller uses.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_admins', ['only' => ['index', 'show']]),
            new Middleware('permission:create_admins', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_admins', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_admins', ['only' => ['destroy']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = $this->adminRepository->all($request);
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admins.index', compact('admins', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $admin = $this->adminRepository->create($request->validated());

        try {
            Password::sendResetLink(['email' => $admin->email]);
            $message = 'Administrador criado com sucesso. Enviamos um e-mail para definição de senha.';
        } catch (\Throwable $throwable) {
            $message = 'Administrador criado com sucesso, mas não foi possível enviar o e-mail de definição de senha.';
        }

        return redirect()->route('admins.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = $this->adminRepository->find($id);

        return view('admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = $this->adminRepository->find($id);
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, string $id)
    {
        $this->adminRepository->update($id, $request->validated());

        return redirect()->route('admins.index')->with('success', 'Administrador atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->adminRepository->delete($id);

        return redirect()->route('admins.index')->with('success', 'Administrador deletado com sucesso.');
    }
}
