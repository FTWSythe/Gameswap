<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'game_owner_id',
        'requested_game_id',
        'offered_game_id',
        'status',
        'message',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function gameOwner()
    {
        return $this->belongsTo(User::class, 'game_owner_id');
    }

    public function requestedGame()
    {
        return $this->belongsTo(Game::class, 'requested_game_id');
    }

    public function offeredGame()
    {
        return $this->belongsTo(Game::class, 'offered_game_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
