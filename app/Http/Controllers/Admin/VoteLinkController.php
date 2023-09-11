<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoteLinkController extends Controller
{
    public function index(Request $request){
        $links = Election::findOrFail($request->route()->parameter('id'))->voteLinks;
        return Inertia::render('Admin/Election/VoteLinks', compact('links'));
    }
}
