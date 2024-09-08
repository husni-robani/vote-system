<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Generation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CandidateController extends Controller
{
    public function index(Request $request){
        $election = Election::with('voters', 'candidates.voters')->where('id', $request->route()->parameter('id'))->get();
        $candidates = $election[0]->candidates ;
        return Inertia::render('Admin/Election/Candidates', [
            'candidates' => $candidates,
            'totalVoter' => $election[0]->voters
        ]);
    }

    public function edit(Request $request){
        try {
            $candidate = Candidate::with('voters', 'voters.generation', 'election.generations')->find($request->route()->parameter('candidateId'));
            $candidateAttr = $candidate->getAttributes();
            $voters = $candidate->voters;
            $voterByGen = $candidate->voters->groupBy('generation_id');
            $voterByGen = $voterByGen->map(function ($voters, $generation_id) {
                return [
                    'gen_year' => Generation::where('id', $generation_id)->first()->year,
                    'voter_count' => $voters->count()
                ];
            });
            $candidate['photo'] = Storage::url($candidate['photo']);
            return Inertia::render('Admin/Election/DetailCandidate', [
                'candidate' => $candidateAttr,
                'voters' => $voters,
                'voter_by_gen' => $voterByGen
            ]);
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }

    public function destroy(Request $request){
        try {
            $candidate = Candidate::find($request->candidateId);
            $candidate->delete();
            return to_route('admin.vote-system.candidates', $request->route()->parameter('id'))->with('success', 'Candidate Success to Delete');
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }

    public function store(CandidateStoreRequest $request){
        //todo : create form request and implement imageService
        try {
            if ($request->hasFile('photo')){
                $photo = Storage::putFile('public/photo/candidates', $request->file('photo'));
            }else{
                $photo = 'public/photo/candidates/default.png';
            }
            $candidate = new Candidate();
            $candidate->election_id = $request->route()->parameter('id');
            $candidate->number = $request->input('number');
            $candidate->name = $request->input('name');
            $candidate->vision = $request->input('vision');
            $candidate->mission = $request->input('mission');
            $candidate->photo = $photo;
            $candidate->save();
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
        return  \Redirect::route('admin.vote-system.candidates', $request->route()->parameter('id'))->with('success', 'New Candidate Success to Added');
    }

    public function update(CandidateUpdateRequest $request){
        try {
            $candidate = Candidate::find($request->route()->parameter('candidateId'));
            $candidate->update($request->all());
            return back();
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }
}
