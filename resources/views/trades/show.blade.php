<x-layouts.gameswap :title="__('Trade Details')">
    <div class="container mx-auto py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold text-white mb-3">Trade Details</h1>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        @php
                            $statusColor = match($trade->status) {
                                'pending' => 'bg-yellow-900/30 text-yellow-400',
                                'accepted' => 'bg-green-900/30 text-green-400',
                                'declined' => 'bg-red-900/30 text-red-400',
                                'completed' => 'bg-blue-900/30 text-blue-400',
                            };
                        @endphp
                        <span class="px-4 py-2 {{ $statusColor }} font-semibold rounded-full">
                            {{ ucfirst($trade->status) }}
                        </span>
                    </div>
                    <p class="text-gray-400">{{ $trade->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Requested Game -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                    <h2 class="text-xl font-bold text-white mb-4">Requested Game</h2>
                    <div class="bg-gray-800 rounded-lg h-48 mb-4 flex items-center justify-center overflow-hidden">
                        @if($trade->requestedGame->cover_url)
                            <img src="{{ $trade->requestedGame->cover_url }}" alt="{{ $trade->requestedGame->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400">Game Image</span>
                        @endif
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-2">{{ $trade->requestedGame->title }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Platform:</span>
                            <span class="text-white">{{ $trade->requestedGame->platform }}</span>
                        </div>
                        @if($trade->requestedGame->genre)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Genre:</span>
                                <span class="text-white">{{ $trade->requestedGame->genre }}</span>
                            </div>
                        @endif
                        @if($trade->requestedGame->condition)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Condition:</span>
                                <span class="text-white">{{ $trade->requestedGame->condition }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Offered Game -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                    <h2 class="text-xl font-bold text-white mb-4">
                        {{ auth()->id() === $trade->requester_id ? 'Your Offer' : 'Their Offer' }}
                    </h2>
                    @if($trade->offeredGame)
                        <div class="bg-gray-800 rounded-lg h-48 mb-4 flex items-center justify-center overflow-hidden">
                            @if($trade->offeredGame->cover_url)
                                <img src="{{ $trade->offeredGame->cover_url }}" alt="{{ $trade->offeredGame->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">Game Image</span>
                            @endif
                        </div>
                        <h3 class="text-white font-semibold text-lg mb-2">{{ $trade->offeredGame->title }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Platform:</span>
                                <span class="text-white">{{ $trade->offeredGame->platform }}</span>
                            </div>
                            @if($trade->offeredGame->genre)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Genre:</span>
                                    <span class="text-white">{{ $trade->offeredGame->genre }}</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-800 rounded-lg h-48 flex items-center justify-center">
                            <p class="text-gray-400 italic">No game offered yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Trade Partners -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Requester -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Trade Requester</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">{{ substr($trade->requester->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-lg">{{ $trade->requester->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $trade->requester->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Game Owner -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Game Owner</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">{{ substr($trade->gameOwner->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-lg">{{ $trade->gameOwner->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $trade->gameOwner->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trade Message -->
            @if($trade->message)
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6 mb-12">
                    <h3 class="text-lg font-bold text-white mb-4">Message from Requester</h3>
                    <p class="text-gray-300 leading-relaxed">{{ $trade->message }}</p>
                </div>
            @endif

            <!-- Actions -->
            @if($trade->status === 'pending' && auth()->id() === $trade->game_owner_id)
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6 mb-12">
                    <h3 class="text-lg font-bold text-white mb-4">Actions</h3>
                    <div class="flex gap-4 flex-wrap">
                        <form action="{{ route('trades.accept', $trade) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full transition">
                                Accept Trade
                            </button>
                        </form>
                        <form action="{{ route('trades.decline', $trade) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-full transition">
                                Decline Trade
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($trade->status === 'completed')
                <!-- Feedback Section -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6 mb-12">
                    <h3 class="text-lg font-bold text-white mb-4">Leave Feedback</h3>
                    
                    @php
                        $myFeedback = $trade->feedback()->where('from_user_id', auth()->id())->first();
                        $otherUser = auth()->id() === $trade->requester_id ? $trade->gameOwner : $trade->requester;
                    @endphp

                    @if($myFeedback)
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-white font-semibold">Your feedback for {{ $otherUser->name }}</p>
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-yellow-400 text-xl">{{ $i <= $myFeedback->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300">{{ $myFeedback->comment }}</p>
                        </div>
                    @else
                        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="trade_id" value="{{ $trade->id }}">
                            <input type="hidden" name="to_user_id" value="{{ $otherUser->id }}">

                            <div>
                                <label class="block text-sm font-semibold text-white mb-3">Rating</label>
                                <div class="flex gap-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}" required class="sr-only peer">
                                            <span class="text-4xl text-gray-500 peer-checked:text-yellow-400 transition">★</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label for="comment" class="block text-sm font-semibold text-white mb-2">Comment (Optional)</label>
                                <textarea
                                    id="comment"
                                    name="comment"
                                    rows="3"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition resize-none"
                                    placeholder="Share your experience..."
                                ></textarea>
                            </div>

                            <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition">
                                Submit Feedback
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Back Button -->
            <div>
                <a href="{{ route('trades.index') }}" class="inline-block px-6 py-3 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-full transition">
                    ← Back to Trades
                </a>
            </div>
        </div>
    </div>
</x-layouts.gameswap>
