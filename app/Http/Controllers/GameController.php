<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Game::where('is_blocked', false);
        
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->has('platform') && $request->input('platform')) {
            $query->where('platform', $request->input('platform'));
        }

        if ($request->has('genre') && $request->input('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        $games = $query->latest()->paginate(12);
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|string',
            'genre' => 'nullable|string',
            'condition' => 'required|string',
            'release_year' => 'nullable|integer|min:1980|max:' . date('Y'),
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_url' => 'nullable|url',
            'is_for_trade' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        Game::create($validated);
        return redirect()->route('games.index')->with('success', 'Game listed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(Game $game)
    {
        $this->authorize('update', $game);
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $this->authorize('update', $game);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|string',
            'genre' => 'nullable|string',
            'condition' => 'required|string',
            'release_year' => 'nullable|integer|min:1980|max:' . date('Y'),
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_url' => 'nullable|url',
            'is_for_trade' => 'nullable|boolean',
        ]);

        $game->update($validated);
        return redirect()->route('games.show', $game)->with('success', 'Game updated successfully!');
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }
}

