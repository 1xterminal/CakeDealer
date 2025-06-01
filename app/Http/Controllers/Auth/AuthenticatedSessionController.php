<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        // Determine if this is an API call (URI prefixed with 'api/')
        if (str_starts_with($request->path(), 'api/')) {
            // API request: issue JWT token
            $creds = $request->validated();
            /** @var JWTGuard $guard */
            $guard = auth('api');
            if (! $token = $guard->attempt($creds)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => $guard->factory()->getTTL() * 60,
                'user'         => $guard->user(),
            ]);
        }

        // Web (session) login and redirect
        $request->authenticate();
        Session::regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse|RedirectResponse
    {
        // If there's a bearer token, perform JWT logout
        if ($request->bearerToken()) {
            auth('api')->logout();
            return response()->json(null, 204);
        }

        // Otherwise, perform session (web) logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Return the authenticated user.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
