<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Like extends Model
{
    use HasFactory;
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(Like::class, 'likes', 'post_id', 'user_id');
    }
}
