<?php

namespace App\Http\Controllers;

use App\Http\Requests\Election\RequestVoteLink;
use App\Http\Requests\Election\StoreVoteRequest;
use App\Jobs\SendVoteEmail;
use App\Mail\ElectionMail;
use App\Models\Candidate;
use App\Models\Election;
use App\Services\CandidateService;
use App\Services\ElectionService;
use App\Services\VoteLinkService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
        $token = Str::random(5);

        $signedUrl = URL::temporarySignedRoute('election', now()->addDay(), [
            'id' => $request->route()->parameter('id'),
            'token' => $token
        ]);

        try {
            $election = Election::findOrFail($request->route()->parameter('id'));
            $request->merge(['link' => $signedUrl, 'token' => $token, 'election_id' => $election->getAttribute('id')]);
            $voteLink = VoteLinkService::createVoteLink($request);
            //Sending link to email voter
            dispatch(new SendVoteEmail($voteLink, $election->title));
        }catch (ModelNotFoundException $exception){
            return Inertia::render('errors/500', [
                'message' => 'Election doesnt exist',
                'originalMessage' => $exception->getMessage()
            ]);
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
            ]);
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
        ]);
    }

    public function firstStep(Request $request){
        $request->validate([
            'name' => 'required',
            'npm' => 'required|digits_between:6,15',
            'generation_id' => 'required|uuid'
        ]);

        return back();
    }

    public function result(Request $request){
        $election = Election::findOrFail($request->route()->parameter('id'))->load(['candidates.voters', 'voters', 'generations.voters']);
        return Inertia::render('Election/Result', compact('election'));
    }
}
