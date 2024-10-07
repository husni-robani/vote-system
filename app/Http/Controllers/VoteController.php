<?php

namespace App\Http\Controllers;

use App\Http\Requests\Election\RequestVoteLink;
use App\Http\Requests\Election\StoreVoteRequest;
use App\Jobs\SendVoteEmail;
use App\Models\Candidate;
use App\Models\Election;
use App\Services\CandidateService;
use App\Services\ElectionService;
use App\Services\VoteLinkService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function index(Request $request){
        return Inertia::render('Election/Elections');
    }

    public function requestLink(Request $request){
        return Inertia::render('Election/Registration')->with('election.selected', $request->route()->parameter('id'));
    }

    public function storeEmail(RequestVoteLink $request){
        //checking voter is never voted, done in RequestVoteLink form request
        //token create for identify the email to get in the store method
        try {
            $election = Election::findOrFail($request->route()->parameter('id'));
            $voteLink = VoteLinkService::createVoteLink($election->id, $request->get('email'));
            //Sending link to email voter
            dispatch(new SendVoteEmail($voteLink, $election->title));
        }catch (ModelNotFoundException $exception){
            return Inertia::render('errors/500', [
                'message' => 'Election doesnt exist',
                'originalMessage' => $exception->getMessage()
            ])->toResponse($request)->setStatusCode(500);
        }catch (\Exception $exception){
            abort(505);
        }
        return to_route('election.requestLink', $request->route()->parameter('id'));

    }

    public function create(Request $request){
        //Check is the token exists in database
        if (!$request->hasValidSignature() || !VoteLinkService::getFromToken($request->route()->parameter('token'))){
            abort(401);
        }

        try {
            $election = Election::findOrFail($request->route()->parameter('id'));
            $candidates = $election->candidates;
            $generations = $election->generations()->get();
            $email = VoteLinkService::getFromToken($request->route()->parameter('token'))->email;
        }catch (ModelNotFoundException $exception){
            return Inertia::render('errors/500', [
                'message' => 'Election doesnt exist',
                'originalMessage' => $exception->getMessage()
            ])->toResponse($request)->setStatusCode(404);
        }catch (\Exception $exception){
            abort(500);
        }
        return Inertia::render('Election/Vote', compact('candidates', 'generations', 'email'))->with('election', [
            'selected' => $request->route()->parameter('id'),
            'token' => $request->route()->parameter('token'),
        ]);
    }

    public function store(StoreVoteRequest $request){
        //accept token & title of election

        //check is the token exists in database
        $voteLink = VoteLinkService::getFromToken($request->route()->parameter('token'));
        if (!$voteLink){
            abort(403);
        }
            //if exists take the email from
        $email = $voteLink->email;
            //create voter
        try {
            $request->merge(['email' => $email]);
            $electionService = new ElectionService(Election::findOrFail($request->route()->parameter('id')));
            $electionService->createVoter($request);
            $link = Election::with('resultLink')->find($request->route()->parameter('id'));
        }catch (\Exception $exception){
            abort(500);
        }

            //check is create voter success
                //if success counter on candidate +1
        $candidateService = new CandidateService(Candidate::find($request->get('candidate_id')));
        $candidateService->addCounter();
            //delete vote_link
        $voteLink->delete();
        return Inertia::render('Election/Finish', [
            'link' => $link->resultLink->link
        ])->toResponse($request)->setStatusCode(201);
    }

    public function firstStep(Request $request){
        $request->validate([
            'name' => 'required',
            'npm' => 'required|digits_between:6,15',
            'generation_id' => 'required|uuid'
        ]);

        return back();
    }
}
