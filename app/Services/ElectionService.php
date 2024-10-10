<?php

namespace App\Services;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


class ElectionService{
    private Election $election;

    /**
     * @param Election $election
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public static function create(array $attribute){
        $election = Election::create($attribute);
        $election->resultLink()->create([
            'link' => URL::signedRoute('election.result', [
                'id' => $election->id,
            ]),
        ]);
        return $election;
    }

    public function createVoter(Request $request){
        $this->election->voters()->create($request->all());
        return $this;
    }
}
