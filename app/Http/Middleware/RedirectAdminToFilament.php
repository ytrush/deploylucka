<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminToFilament
{
    /**
     * Redirect admin/super_admin users away from non-Filament pages to the admin panel.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasAnyRole(['admin', 'super_admin', '2', '3'])) {
            return redirect('/admin');
        }

        return $next($request);
    }
}