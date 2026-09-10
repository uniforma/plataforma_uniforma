<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Password;

class UserController extends Controller implements HasMiddleware
{
    public function __construct(protected UserRepository $userRepository) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_users', only: ['index', 'show']),
            new Middleware('permission:create_users', only: ['create', 'store']),
            new Middleware('permission:edit_users', only: ['edit', 'update']),
            new Middleware('permission:delete_users', only: ['destroy']),
            new Middleware('permission:restore_users', only: ['restore']),
            new Middleware('permission:force_delete_users', only: ['forceDelete']),
        ];
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->all($request);
        $roles = $this->roles();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = $this->roles();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        $status = Password::sendResetLink(['email' => $user->email]);
        $message = $status === Password::RESET_LINK_SENT
            ? 'Usuário criado com sucesso. Enviamos um e-mail para definição de senha.'
            : 'Usuário criado com sucesso, mas não foi possível enviar o e-mail de definição de senha.';

        return redirect()->route('users.index')->with('status', $message);
    }

    public function show(string $id)
    {
        $user = $this->userRepository->find((int) $id);

        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = $this->userRepository->find((int) $id);
        abort_if($user->trashed(), 404);
        $roles = $this->roles();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $this->userRepository->update((int) $id, $request->validated());

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $this->userRepository->delete((int) $id);

        return redirect()->route('users.index')->with('status', 'Usuário enviado para a lixeira.');
    }

    public function restore(string $id)
    {
        $this->userRepository->restore((int) $id);

        return redirect()->route('users.index', ['trash' => 'trashed'])->with('status', 'Usuário restaurado com sucesso.');
    }

    public function forceDelete(string $id)
    {
        $this->userRepository->forceDelete((int) $id);

        return redirect()->route('users.index', ['trash' => 'trashed'])->with('status', 'Usuário excluído definitivamente.');
    }

    private function roles()
    {
        return Role::query()->where('guard_name', 'user')->orderBy('name')->get();
    }
}
