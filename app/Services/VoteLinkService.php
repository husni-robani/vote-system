<?php
namespace App\Services;

use App\Models\Election;
use App\Models\VoteLink;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class VoteLinkService{
    protected VoteLink $voteLink;

    /**
     * @param VoteLink $voteLink
     */
    public function __construct(VoteLink $voteLink)
    {
        $this->voteLink = $voteLink;
    }

    public static function createVoteLink($election_id, $email){
        $token = Str::random(5);
        $signedUrl = URL::temporarySignedRoute('election', now()->addDay(), [
            'id' => $election_id,
            'token' => $token
        ]);
        //makesure when create votelink, there is no other votelink record
        //if there, delete the others
        $record = VoteLink::where('email', $email);
        if ($record->exists()){
            //make sure no records have the same email
            $record->delete();
        }
        return VoteLink::create([
            "email" => $email,
            "link" => $signedUrl,
            "token" => $token,
            "election_id" => $election_id,
        ]);
    }

    public static function getFromToken($token){
        return VoteLink::where('token', $token)->first();
    }
}
