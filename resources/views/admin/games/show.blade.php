<x-layouts.gameswap :title="'Game: ' . $game->title">
    <div class="min-h-screen bg-gray-900 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('admin.games') }}" class="inline-block mb-6 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                ← Back to Games
            </a>

            <!-- Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 rounded-lg text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Game Info -->
            <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-8">
                    <!-- Game Cover -->
                    <div>
                        @if ($game->cover_url)
                            <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-96 object-cover rounded-lg mb-4">
                        @else
                            <div class="w-full h-96 bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 mb-4">
                                <p>No cover image</p>
                            </div>
                        @endif
                    </div>

                    <!-- Game Details -->
                    <div class="md:col-span-2">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">{{ $game->title }}</h1>
                                <p class="text-gray-400">
                                    Listed by:
                                    <a href="{{ route('admin.users.show', $game->user) }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                                        {{ $game->user->name }}
                                    </a>
                                </p>
                            </div>
                            <span class="text-lg px-4 py-2 rounded-full {{ $game->is_blocked ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                {{ $game->is_blocked ? '🚫 Blocked' : '✓ Active' }}
                            </span>
                        </div>

                        <!-- Game Details Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">Platform</p>
                                <p class="text-white font-semibold">{{ $game->platform }}</p>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">Genre</p>
                                <p class="text-white font-semibold">{{ $game->genre ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">Condition</p>
                                <p class="text-white font-semibold">{{ $game->condition ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">Release Year</p>
                                <p class="text-white font-semibold">{{ $game->release_year ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">Price</p>
                                <p class="text-white font-semibold">
                                    @if ($game->price)
                                        €{{ number_format($game->price, 2) }}
                                    @else
                                        For Trade Only
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-1">For Trade</p>
                                <p class="text-white font-semibold">{{ $game->is_for_trade ? '✓ Yes' : 'No' }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($game->description)
                            <div class="bg-gray-900 rounded-lg p-4 mb-6">
                                <p class="text-gray-400 text-sm mb-2">Description</p>
                                <p class="text-gray-200">{{ $game->description }}</p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <form action="{{ route('admin.games.toggle-block', $game) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2 {{ $game->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-lg transition font-semibold">
                                    {{ $game->is_blocked ? '✓ Unblock Game' : '🚫 Block Game' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" onsubmit="return confirm('Permanently delete this game? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-6 py-2 bg-red-800 hover:bg-red-900 text-white rounded-lg transition font-semibold">
                                    🗑️ Delete Game
                                </button>
                            </form>
                        </div>

                        <!-- Metadata -->
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <p class="text-sm text-gray-500">
                                Listed on {{ $game->created_at->format('M d, Y') }} •
                                {{ $game->is_blocked ? 'Blocked' : 'Visible' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trades Section -->
            @if ($game->requestedInTrades->count() > 0 || $game->offeredInTrades->count() > 0)
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Trade Activity</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-white font-semibold mb-3">Requested in Trades ({{ $game->requestedInTrades->count() }})</h3>
                            <div class="space-y-2">
                                @forelse ($game->requestedInTrades as $trade)
                                    <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                                        <p class="text-gray-400 text-sm">
                                            <strong class="text-blue-400">{{ $trade->requester->name }}</strong> 
                                            requested this game with 
                                            <strong>{{ $trade->offeredGame->title ?? 'No game offered' }}</strong>
                                        </p>
                                        <span class="inline-block mt-2 text-xs px-3 py-1 rounded-full {{ $trade->status === 'completed' ? 'bg-green-900 text-green-200' : ($trade->status === 'pending' ? 'bg-yellow-900 text-yellow-200' : 'bg-gray-700 text-gray-300') }}">
                                            {{ ucfirst($trade->status) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-400">No trades yet</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="border-t border-gray-700 pt-6">
                            <h3 class="text-white font-semibold mb-3">Offered in Trades ({{ $game->offeredInTrades->count() }})</h3>
                            <div class="space-y-2">
                                @forelse ($game->offeredInTrades as $trade)
                                    <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                                        <p class="text-gray-400 text-sm">
                                            <strong class="text-green-400">{{ $trade->requester->name }}</strong> 
                                            offered this game to get 
                                            <strong>{{ $trade->requestedGame->title }}</strong>
                                        </p>
                                        <span class="inline-block mt-2 text-xs px-3 py-1 rounded-full {{ $trade->status === 'completed' ? 'bg-green-900 text-green-200' : ($trade->status === 'pending' ? 'bg-yellow-900 text-yellow-200' : 'bg-gray-700 text-gray-300') }}">
                                            {{ ucfirst($trade->status) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-400">No trades yet</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.gameswap>
