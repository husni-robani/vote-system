<?php
namespace App\Services;

use App\Models\Election;

class SwitchElectionService{
    private Election $selectedElection;

    /**
     * @param Election $selectedElection
     */
    public function __construct(Election $selectedElection)
    {
        $this->selectedElection = $selectedElection;
    }

    public function getSelectedElection() : Election
    {
        return $this->selectedElection;
    }

    public function setSelectedElection(Election $election) : void
    {
        $this->selectedElection = $election;
    }


}