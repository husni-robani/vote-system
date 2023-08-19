<?php

namespace App\Http\Controllers;

use App\Http\Requests\Election\RequestVoteLink;
use App\Mail\ElectionMail;
use App\Services\ElectionService;
use App\Services\VoteLinkService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function requestLink(Request $request){
        return Inertia::render('Election/Registration')->with('election.selected', $request->route()->parameter('title'));
    }

    public function storeEmail(RequestVoteLink $request){
        //checking voter is never voted, done in RequestVoteLink form request

        //token create for identify the email to get in the store method
        $token = Str::random(5);

        //create signed Url tha has expiry time
        //TODO : try to implement temporarySignedRoute with setDate() method, which should to utilize the expiry date on election
        $signedUrl = URL::temporarySignedRoute('election', now()->addDay(), [
            'title' => $request->route()->parameter('title'),
            'token' => $token
        ]);

        try {
            $election = (new ElectionService())->getElectionFromTitle($request->route()->parameter('title'));
            $request->merge(['link' => $signedUrl, 'token' => $token, 'election_id' => $election->getAttribute('id')]);
            (new VoteLinkService())->createVoteLink($request);

            //Sending link to email voter
            Mail::to($request->input('email'))->send(new ElectionMail($signedUrl));
        }catch (\Exception $exception){
            return $exception;
        }


        return to_route('election.requestLink', $request->route()->parameter('title'));

    }

    public function create(Request $request){
        //Check is the token exists in database
        if (!$request->hasValidSignature()){
            abort(401);
        }
        dd($request->route()->parameter('title'));
    }

    public function store(Request $request){
        //check is the token exists in database
    }
}
