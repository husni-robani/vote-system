<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteLink extends Model
{
    use HasFactory;

    protected $fillable = ['link', 'email', 'token', 'election_id'];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
