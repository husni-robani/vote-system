<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InActiveElectionException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        return Inertia::render('errors/403');
    }
}
