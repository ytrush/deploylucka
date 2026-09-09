<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        $existing = PageView::where('ip_address', $ip)
            ->whereDate('created_at', today())
            ->first();

        if ($existing) {
            // Sudah ada → update last_activity saja
            $existing->update(['last_activity' => now()]);
        } else {
            // Pertama kali → simpan sebagai visitor baru
            PageView::create([
                'ip_address' => $ip,
                'url' => $request->url(),
                'last_activity' => now(),
            ]);
        }

        return $next($request);
    }
}
