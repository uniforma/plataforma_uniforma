<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $guard = $this->currentGuard();

        return view($guard === 'admin' ? 'profile.edit' : 'profile.user-edit', [
            'user' => auth($guard)->user(),
            'profileRoutePrefix' => $guard.'.profile',
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $guard = $this->currentGuard();
        $user = auth($guard)->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route($guard.'.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $guard = $this->currentGuard();

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password:'.$guard],
        ]);

        $user = auth($guard)->user();

        Auth::guard($guard)->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function currentGuard(): string
    {
        return auth('admin')->check() ? 'admin' : 'user';
    }
}
