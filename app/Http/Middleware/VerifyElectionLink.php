<?php

namespace App\Http\Middleware;

use App\Models\VoteLink;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyElectionLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasValidSignature() && VoteLink::where('token', $request->route()->parameter('token'))->exists()){
            return $next($request);
        }
        abort(403);
    }
}
