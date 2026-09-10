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
    public function create(Request $request): View
    {
        $redirect = $request->query('redirect');

        if (is_string($redirect) && str_starts_with($redirect, '/') && ! str_starts_with($redirect, '//')) {
            $request->session()->put('url.intended', $redirect);
        } elseif ($request->has('redirect')) {
            $request->session()->forget('url.intended');
        }

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

        $dashboardRoute = $guard === 'admin' ? 'admin.dashboard' : 'home';
        $intended = $request->session()->pull('url.intended');

        if ($this->isAllowedDestination($intended, $guard)) {
            return redirect($intended);
        }

        return redirect()->route($dashboardRoute);
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

    private function isAllowedDestination(mixed $destination, string $guard): bool
    {
        if (! is_string($destination)) {
            return false;
        }

        $isRelative = str_starts_with($destination, '/') && ! str_starts_with($destination, '//');
        $isApplicationUrl = str_starts_with($destination, rtrim((string) config('app.url'), '/').'/');

        if (! $isRelative && ! $isApplicationUrl) {
            return false;
        }

        $path = parse_url($destination, PHP_URL_PATH);

        if (! is_string($path)) {
            return false;
        }

        return $guard === 'admin'
            ? str_starts_with($path, '/admin/')
            : str_starts_with($path, '/user/') || str_starts_with($path, '/submissoes/');
    }
}
