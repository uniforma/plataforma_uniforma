<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::query()
            ->where('email', (string) $request->string('email'))
            ->first();

        $guard = $user?->resolveAuthGuardName();

        if (! $user || ! $guard) {
            $request->failAuthentication();
        }

        $request->authenticateWithGuard($guard);

        foreach (['user', 'admin'] as $otherGuard) {
            if ($otherGuard !== $guard) {
                Auth::guard($otherGuard)->logout();
            }
        }

        $request->session()->regenerate();

        $dashboardRoute = $guard === 'admin' ? 'admin.dashboard' : 'user.vitrine';

        return redirect()->intended(route($dashboardRoute, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        foreach (['user', 'admin'] as $guard) {
            Auth::guard($guard)->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
