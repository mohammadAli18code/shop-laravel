<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     * $roles می‌تونه یک آرایه یا یک رشته باشه
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('admin')->user(); // ← اینجا guard رو مشخص کن

        if (!$user) {
            return redirect()->route('admin.login'); // ← ریدایرکت به login admin
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'شما دسترسی لازم را ندارید.');
        }

        return $next($request);
    }
}
