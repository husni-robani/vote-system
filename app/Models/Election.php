<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Election extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'active', 'period_id'];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function generations() : HasMany
    {
        return $this->hasMany(Generation::class);
    }

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }

    public function voteLinks(): HasMany
    {
        return $this->hasMany(VoteLink::class, 'election_id');
    }

    public function resultLink(): HasOne
    {
        return $this->hasOne(ResultLink::class);
    }

}
