<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Generation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'election_id', 'year'];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }
}
