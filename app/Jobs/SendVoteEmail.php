<?php

namespace App\Jobs;

use App\Mail\ElectionMail;
use App\Models\VoteLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVoteEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private VoteLink $voteLink;
    private $electionTitle;
    public function __construct(VoteLink $voteLink, $electionTitle)
    {
        $this->voteLink = $voteLink;
        $this->electionTitle = $electionTitle;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->voteLink->email)->send(new ElectionMail($this->voteLink, $this->electionTitle));
    }
}
