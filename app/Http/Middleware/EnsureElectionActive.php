<?php

namespace App\Http\Middleware;

use App\Exceptions\InActiveElectionException;
use App\Models\Election;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureElectionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $election = Election::findOrFail($request->route()->parameter('id'));
        if ($election !== null){
            if ($election->active){
                return $next($request);
            }
        }
//         abort(403, 'FORBIDDEN');
        throw new InActiveElectionException();
    }
}
