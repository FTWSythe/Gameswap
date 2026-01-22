<x-layouts.gameswap :title="'User: ' . $user->name">
    <div class="min-h-screen bg-gray-900 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('admin.users') }}" class="inline-block mb-6 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                ← Back to Users
            </a>

            <!-- Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 rounded-lg text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- User Info -->
            <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 mb-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $user->name }}</h1>
                        <p class="text-gray-400">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">Member since {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="text-lg px-4 py-2 rounded-full {{ $user->is_blocked ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                        {{ $user->is_blocked ? '🚫 Blocked' : '✓ Active' }}
                    </span>
                </div>

                @if ($user->bio)
                    <div class="mb-6 p-4 bg-gray-900 rounded-lg border border-gray-700">
                        <p class="text-gray-300"><strong>Bio:</strong> {{ $user->bio }}</p>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-3">
                    <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 {{ $user->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-lg transition font-semibold">
                            {{ $user->is_blocked ? '✓ Unblock User' : '🚫 Block User' }}
                        </button>
                    </form>

                    @if (auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Permanently delete this user? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-800 hover:bg-red-900 text-white rounded-lg transition font-semibold">
                                🗑️ Delete User
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <p class="text-gray-400 text-sm mb-2">Games Listed</p>
                    <p class="text-3xl font-bold text-white">{{ $user->games->count() }}</p>
                </div>
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <p class="text-gray-400 text-sm mb-2">Sent Trades</p>
                    <p class="text-3xl font-bold text-white">{{ $user->sentTrades->count() }}</p>
                </div>
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <p class="text-gray-400 text-sm mb-2">Received Trades</p>
                    <p class="text-3xl font-bold text-white">{{ $user->receivedTrades->count() }}</p>
                </div>
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <p class="text-gray-400 text-sm mb-2">Feedback Reviews</p>
                    <p class="text-3xl font-bold text-white">{{ $user->feedback->count() }}</p>
                </div>
                @if ($user->feedback->count() > 0)
                    <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                        <p class="text-gray-400 text-sm mb-2">Avg Rating</p>
                        <p class="text-3xl font-bold text-yellow-400">
                            {{ number_format($user->feedback->avg('rating'), 1) }}⭐
                        </p>
                    </div>
                @endif
            </div>

            <!-- Games Section -->
            @if ($user->games->count() > 0)
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Games ({{ $user->games->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($user->games as $game)
                            <div class="bg-gray-900 border border-gray-700 rounded-lg p-4 hover:border-blue-500 transition">
                                <h3 class="font-bold text-white mb-2">{{ $game->title }}</h3>
                                <p class="text-gray-400 text-sm mb-3">{{ $game->platform }}</p>
                                @if ($game->is_blocked)
                                    <span class="inline-block px-3 py-1 bg-red-900 text-red-200 text-xs rounded-full mb-2">🚫 Blocked</span>
                                @endif
                                <a href="{{ route('admin.games.show', $game) }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">
                                    View →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Trades Section -->
            @if ($user->sentTrades->count() > 0 || $user->receivedTrades->count() > 0)
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Trade History</h2>
                    
                    <div class="space-y-4">
                        @forelse ($user->sentTrades->merge($user->receivedTrades)->sortByDesc('created_at')->take(10) as $trade)
                            <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-white font-semibold">
                                        @if ($trade->requester_id === $user->id)
                                            Requested: <span class="text-blue-400">{{ $trade->requestedGame->title }}</span>
                                        @else
                                            Received request for: <span class="text-green-400">{{ $trade->requestedGame->title }}</span>
                                        @endif
                                    </p>
                                    <span class="text-xs px-3 py-1 rounded-full {{ $trade->status === 'completed' ? 'bg-green-900 text-green-200' : ($trade->status === 'pending' ? 'bg-yellow-900 text-yellow-200' : 'bg-gray-700 text-gray-300') }}">
                                        {{ ucfirst($trade->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-400 text-sm">{{ $trade->created_at->format('M d, Y') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400">No trades</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.gameswap>
