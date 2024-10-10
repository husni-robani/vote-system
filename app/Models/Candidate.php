<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Candidate extends Model
{
    use  HasUuids;

    protected $fillable = ['name', 'vision', 'mission', 'photo', 'election_id', 'number', 'counter'];

    public function getPhotoAttribute($value): string
    {
        return Storage::url($value);
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }

    public function addCounter() : void
    {
        $this->counter = $this->counter + 1;
        $this->save();
    }
}
