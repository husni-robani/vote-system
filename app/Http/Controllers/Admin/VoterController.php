<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoterController extends Controller
{
    public function index(Request $request){
        try{
            $voters = Voter::with('candidate', 'generation')->where('election_id', $request->route()->parameter('id'));
            if (!$voters->exists()){
                $voters = null;
            }else{
                $voters = $voters->paginate(10)->through(function ($voter){
                    return [
                        'id' => $voter->id,
                        'email' => $voter->email,
                        'name' => $voter->name,
                        'npm' => $voter->npm,
                        'generation' => $voter->generation->year,
                        'candidateVoted' => $voter->candidate->number
                    ];
                });
            }
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
        return Inertia::render('Admin/Election/Voters', compact('voters'));
    }

    public function destroy(Request $request){
        try {
            $voter = Voter::find($request->route()->parameter('voterId'));
            $voter->delete();
            return \Redirect::back();
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }
}
