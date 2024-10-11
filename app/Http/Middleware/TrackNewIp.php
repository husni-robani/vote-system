<?php

namespace App\Http\Middleware;

use App\Models\ClientAccsess;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackNewIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!ClientAccsess::where('ip', $request->ip())->first()){
            ClientAccsess::create([
                'ip' => $request->ip()
            ]);
        }
        return $next($request);
    }
}
