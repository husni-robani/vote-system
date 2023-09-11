<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ResultLink extends Model
{
    protected $fillable = ['election_id', 'link'];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
