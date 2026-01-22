<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalGames' => Game::count(),
            'blockedUsers' => User::where('is_blocked', true)->count(),
            'blockedGames' => Game::where('is_blocked', true)->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentGames' => Game::latest()->take(5)->get(),
        ]);
    }

    /**
     * List all users with blocking options
     */
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        $user->load('games', 'sentTrades', 'receivedTrades', 'feedback');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Block/unblock a user
     */
    public function toggleUserBlock(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot block yourself!');
        }

        $user->update(['is_blocked' => !$user->is_blocked]);
        
        $action = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User {$user->name} has been {$action}.");
    }

    /**
     * List all games with blocking options
     */
    public function games()
    {
        $games = Game::with('user')->paginate(20);
        return view('admin.games.index', compact('games'));
    }

    /**
     * Show game details
     */
    public function showGame(Game $game)
    {
        $game->load('user', 'requestedInTrades', 'offeredInTrades');
        return view('admin.games.show', compact('game'));
    }

    /**
     * Block/unblock a game
     */
    public function toggleGameBlock(Game $game)
    {
        $game->update(['is_blocked' => !$game->is_blocked]);
        
        $action = $game->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "Game '{$game->title}' has been {$action}.");
    }

    /**
     * Delete a game (admin action)
     */
    public function destroyGame(Game $game)
    {
        $gameTitle = $game->title;
        $game->delete();
        return back()->with('success', "Game '{$gameTitle}' has been deleted.");
    }

    /**
     * Delete a user (admin action)
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $userName = $user->name;
        $user->delete();
        return back()->with('success', "User '{$userName}' has been deleted.");
    }
}
