<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Game;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    /**
     * Display trades for the authenticated user.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Trade::where(function($q) {
            $q->where('requester_id', auth()->id())
              ->orWhere('game_owner_id', auth()->id());
        });

        if ($status) {
            $query->where('status', $status);
        }

        $trades = $query->latest()->paginate(10);
        return view('trades.index', compact('trades'));
    }

    /**
     * Create a new trade request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requested_game_id' => 'required|exists:games,id',
            'offered_game_id' => 'nullable|exists:games,id',
            'message' => 'nullable|string|max:500',
        ]);

        $game = Game::findOrFail($validated['requested_game_id']);

        if ($game->user_id === auth()->id()) {
            return back()->with('error', 'You cannot trade with yourself!');
        }

        Trade::create([
            'requester_id' => auth()->id(),
            'game_owner_id' => $game->user_id,
            'requested_game_id' => $validated['requested_game_id'],
            'offered_game_id' => $validated['offered_game_id'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('trades.index')->with('success', 'Trade request sent!');
    }

    /**
     * Show a specific trade.
     */
    public function show(Trade $trade)
    {
        if ($trade->requester_id !== auth()->id() && $trade->game_owner_id !== auth()->id()) {
            abort(403);
        }

        return view('trades.show', compact('trade'));
    }

    /**
     * Accept a trade request.
     */
    public function accept(Trade $trade)
    {
        if ($trade->game_owner_id !== auth()->id()) {
            abort(403);
        }

        if ($trade->status !== 'pending') {
            return back()->with('error', 'This trade is no longer pending!');
        }

        $trade->update(['status' => 'accepted']);
        return back()->with('success', 'Trade request accepted!');
    }

    /**
     * Decline a trade request.
     */
    public function decline(Trade $trade)
    {
        if ($trade->game_owner_id !== auth()->id()) {
            abort(403);
        }

        if ($trade->status !== 'pending') {
            return back()->with('error', 'This trade is no longer pending!');
        }

        $trade->update(['status' => 'declined']);
        return back()->with('success', 'Trade request declined!');
    }

    /**
     * Delete a trade.
     */
    public function destroy(Trade $trade)
    {
        if ($trade->requester_id !== auth()->id() && $trade->game_owner_id !== auth()->id()) {
            abort(403);
        }

        $trade->delete();
        return redirect()->route('trades.index')->with('success', 'Trade deleted!');
    }
}
