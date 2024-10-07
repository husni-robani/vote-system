<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResultLinkController extends Controller
{
    public function index(Request $request){
        $election = Election::findOrFail($request->route()->parameter('id'))->load(['candidates.voters', 'voters', 'generations.voters']);
        return Inertia::render('Election/Result', compact('election'));
    }
}
