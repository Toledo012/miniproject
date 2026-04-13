<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        /** @var Usuario|null $user */
        $user = $request->user();

        if (! $user || ! in_array($user->rol, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
