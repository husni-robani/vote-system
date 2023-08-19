<?php
namespace App\Services;

use App\Models\VoteLink;
use Illuminate\Http\Request;


class VoteLinkService{
    public function createVoteLink(Request $request){
        //makesure when create votelink, there is no other votelink record
            //if there, delete the others
        $record = VoteLink::where('email', $request->input('email'));
        if ($record->exists()){
            //make sure no records have the same email
            $record->delete();
        }
        VoteLink::create($request->all());
    }
}