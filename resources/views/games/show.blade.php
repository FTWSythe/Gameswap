<x-layouts.gameswap :title="$game->title">
    <div class="container mx-auto py-12 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Game Image & Info -->
            <div class="md:col-span-1">
                <!-- Game Image -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden mb-6 h-80 flex items-center justify-center">
                    @if($game->cover_url)
                        <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400">Game Image</span>
                    @endif
                </div>

                <!-- User Card -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
                    <h3 class="text-white font-semibold mb-4">Seller</h3>
                    <a href="{{ route('profile.user', $game->user) }}" class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">{{ substr($game->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold">{{ $game->user->name }}</p>
                            <p class="text-gray-400 text-sm">View Profile</p>
                        </div>
                    </a>
                </div>

                <!-- Action Buttons -->
                @auth
                    @if(Auth::user()->id !== $game->user->id)
                        <form action="{{ route('trades.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="requested_game_id" value="{{ $game->id }}">
                            
                            <button
                                type="submit"
                                class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition"
                            >
                                Send Trade Request
                            </button>
                        </form>
                    @else
                        <div class="flex gap-3">
                            <a href="{{ route('games.edit', $game) }}" class="flex-1 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full text-center transition">
                                Edit
                            </a>
                            <form action="{{ route('games.destroy', $game) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this game?')" class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-full transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endauth
                @else
                    <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full text-center transition block">
                        Sign In to Trade
                    </a>
                @endif
            </div>

            <!-- Right: Game Details -->
            <div class="md:col-span-2">
                <!-- Title & Price -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-white mb-3">{{ $game->title }}</h1>
                    @if($game->price)
                        <p class="text-3xl font-bold text-blue-400 mb-4">${{ $game->price }}</p>
                    @endif
                </div>

                <!-- Game Details Cards -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
                        <p class="text-gray-400 text-sm mb-1">Platform</p>
                        <p class="text-white font-semibold">{{ $game->platform }}</p>
                    </div>
                    @if($game->genre)
                        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
                            <p class="text-gray-400 text-sm mb-1">Genre</p>
                            <p class="text-white font-semibold">{{ $game->genre }}</p>
                        </div>
                    @endif
                    @if($game->condition)
                        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
                            <p class="text-gray-400 text-sm mb-1">Condition</p>
                            <p class="text-white font-semibold">{{ $game->condition }}</p>
                        </div>
                    @endif
                    @if($game->release_year)
                        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
                            <p class="text-gray-400 text-sm mb-1">Release Year</p>
                            <p class="text-white font-semibold">{{ $game->release_year }}</p>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($game->description)
                    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Description</h2>
                        <p class="text-gray-300 leading-relaxed">{{ $game->description }}</p>
                    </div>
                @endif

                <!-- Trade Status -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <p class="text-white font-semibold">
                            @if($game->is_for_trade)
                                Available for Trade
                            @else
                                Selling Only
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.gameswap>
