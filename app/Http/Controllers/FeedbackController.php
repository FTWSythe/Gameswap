<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Trade;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Store feedback for a trade.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trade_id' => 'required|exists:trades,id',
            'to_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $trade = Trade::findOrFail($validated['trade_id']);

        // Check if user already left feedback
        $existing = Feedback::where('trade_id', $trade->id)
            ->where('from_user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already left feedback for this trade!');
        }

        $validated['from_user_id'] = auth()->id();
        Feedback::create($validated);

        // Mark trade as completed if both users left feedback
        $allFeedback = $trade->feedback()->count();
        if ($allFeedback >= 2) {
            $trade->update(['status' => 'completed']);
        }

        return back()->with('success', 'Feedback submitted successfully!');
    }
}
