<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Likes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chirps_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }

}
