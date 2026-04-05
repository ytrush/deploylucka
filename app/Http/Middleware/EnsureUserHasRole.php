<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $parsedRoles = [];

        foreach ($roles as $role) {
            foreach (explode(',', $role) as $singleRole) {
                $trimmed = trim($singleRole);

                if ($trimmed !== '') {
                    $parsedRoles[] = $trimmed;
                }
            }
        }

        if (! $user->hasAnyRole($parsedRoles)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
