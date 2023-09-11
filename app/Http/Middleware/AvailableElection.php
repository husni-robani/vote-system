<?php

namespace App\Http\Middleware;

use App\Models\Election;
use App\Services\ElectionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AvailableElection
{
    /**
     * Handle an incoming request.
     *

     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->route()->hasParameter('id')){
            $title = Election::first()->id;
            return to_route('admin.vote-system', $title);
        }

        if (Election::find($request->route()->parameter('id')) !== null){
            return $next($request);
        }
        abort(401);
    }
}
