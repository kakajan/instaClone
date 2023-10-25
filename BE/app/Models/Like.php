<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Like extends Model
{
    use HasFactory;
    protected $table = 'post_user';
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(Like::class, 'post_user', 'user_id', 'post_id');
    }
}
