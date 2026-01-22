<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'platform', 'genre', 'condition', 'release_year', 'description', 'price', 'cover_url', 'is_for_trade', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestedInTrades()
    {
        return $this->hasMany(Trade::class, 'requested_game_id');
    }

    public function offeredInTrades()
    {
        return $this->hasMany(Trade::class, 'offered_game_id');
    }
}
