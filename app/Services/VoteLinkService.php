<?php
namespace App\Services;

use App\Models\VoteLink;
use Illuminate\Http\Request;


class VoteLinkService{
    protected VoteLink $voteLink;

    /**
     * @param VoteLink $voteLink
     */
    public function __construct(VoteLink $voteLink)
    {
        $this->voteLink = $voteLink;
    }

    public static function createVoteLink(Request $request){
        //makesure when create votelink, there is no other votelink record
            //if there, delete the others
        $record = VoteLink::where('email', $request->input('email'));
        if ($record->exists()){
            //make sure no records have the same email
            $record->delete();
        }
        return VoteLink::create($request->all());
    }

    public static function getFromToken($token){
        return VoteLink::where('token', $token)->first();
    }
}