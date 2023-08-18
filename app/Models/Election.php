<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'active', 'period_id'];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function voters() : HasMany
    {
        return $this->hasMany(Voter::class);
    }

}
