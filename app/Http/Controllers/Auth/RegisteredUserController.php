<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ValidCpf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['cpf' => ValidCpf::digits($request->input('cpf'))]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:aluno,servidor'],
            'cpf' => ['required', new ValidCpf, Rule::unique('users', 'cpf')],
            'gender' => ['required', Rule::in(['feminino', 'masculino', 'nao_binario', 'outro', 'nao_informar'])],
            'skills' => ['required', 'array', 'min:1', 'max:20'],
            'skills.*' => ['required', 'string', 'max:80', 'distinct:ignore_case'],
            'knowledge_areas' => ['required', 'array', 'min:1', 'max:20'],
            'knowledge_areas.*' => ['required', 'string', 'max:80', 'distinct:ignore_case'],
            'recommendation_emails_enabled' => ['sometimes', 'boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'skills' => $request->input('skills'),
            'knowledge_areas' => $request->input('knowledge_areas'),
            'recommendation_emails_enabled' => $request->boolean('recommendation_emails_enabled'),
        ]);

        $user->assignRole($request->input('role'));

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
