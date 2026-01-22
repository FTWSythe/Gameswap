<x-layouts.gameswap :title="__('Browse Games')">
    <div class="container mx-auto py-12 px-4">
        <!-- Page Header -->
        <section class="mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Browse Games</h1>
            <p class="text-gray-400">Discover games from the community and find your next trade</p>
        </section>

        <!-- Search and Filter Section -->
        <section class="mb-12">
            <form method="GET" action="{{ route('games.index') }}" class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-semibold text-white mb-2">Search</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition"
                            placeholder="Game title..."
                        />
                    </div>

                    <!-- Platform Filter -->
                    <div>
                        <label for="platform" class="block text-sm font-semibold text-white mb-2">Platform</label>
                        <select
                            id="platform"
                            name="platform"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-blue-500 transition"
                        >
                            <option value="">All Platforms</option>
                            <option value="PlayStation 5" {{ request('platform') === 'PlayStation 5' ? 'selected' : '' }}>PlayStation 5</option>
                            <option value="PlayStation 4" {{ request('platform') === 'PlayStation 4' ? 'selected' : '' }}>PlayStation 4</option>
                            <option value="Xbox Series X" {{ request('platform') === 'Xbox Series X' ? 'selected' : '' }}>Xbox Series X</option>
                            <option value="Xbox Series S" {{ request('platform') === 'Xbox Series S' ? 'selected' : '' }}>Xbox Series S</option>
                            <option value="Xbox One" {{ request('platform') === 'Xbox One' ? 'selected' : '' }}>Xbox One</option>
                            <option value="Nintendo Switch" {{ request('platform') === 'Nintendo Switch' ? 'selected' : '' }}>Nintendo Switch</option>
                            <option value="PC" {{ request('platform') === 'PC' ? 'selected' : '' }}>PC</option>
                        </select>
                    </div>

                    <!-- Genre Filter -->
                    <div>
                        <label for="genre" class="block text-sm font-semibold text-white mb-2">Genre</label>
                        <select
                            id="genre"
                            name="genre"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-blue-500 transition"
                        >
                            <option value="">All Genres</option>
                            <option value="Action" {{ request('genre') === 'Action' ? 'selected' : '' }}>Action</option>
                            <option value="Adventure" {{ request('genre') === 'Adventure' ? 'selected' : '' }}>Adventure</option>
                            <option value="RPG" {{ request('genre') === 'RPG' ? 'selected' : '' }}>RPG</option>
                            <option value="Sports" {{ request('genre') === 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Racing" {{ request('genre') === 'Racing' ? 'selected' : '' }}>Racing</option>
                            <option value="Shooter" {{ request('genre') === 'Shooter' ? 'selected' : '' }}>Shooter</option>
                            <option value="Strategy" {{ request('genre') === 'Strategy' ? 'selected' : '' }}>Strategy</option>
                            <option value="Indie" {{ request('genre') === 'Indie' ? 'selected' : '' }}>Indie</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 py-2 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition"
                        >
                            Search
                        </button>
                        <a
                            href="{{ route('games.index') }}"
                            class="py-2 px-4 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-full text-center transition"
                        >
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </section>

        <!-- Games Grid -->
        <section>
            @if($games->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($games as $game)
                        <a href="{{ route('games.show', $game) }}" class="group">
                            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 border border-gray-700 h-full flex flex-col">
                                <!-- Game Image -->
                                <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center overflow-hidden">
                                    @if($game->cover_url)
                                        <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <span class="text-gray-400 text-sm">Game Image</span>
                                    @endif
                                </div>

                                <!-- Game Info -->
                                <div class="p-4 flex-1 flex flex-col">
                                    <h3 class="text-white font-semibold text-sm mb-1 line-clamp-2">{{ $game->title }}</h3>
                                    <p class="text-gray-400 text-xs mb-2">{{ $game->platform }}</p>
                                    
                                    @if($game->genre)
                                        <p class="text-gray-500 text-xs mb-2">{{ $game->genre }}</p>
                                    @endif

                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs text-gray-400">
                                                @if($game->condition)
                                                    {{ $game->condition }}
                                                @else
                                                    Good
                                                @endif
                                            </span>
                                            @if($game->price)
                                                <span class="text-blue-400 font-semibold text-sm">${{ $game->price }}</span>
                                            @endif
                                        </div>

                                        <!-- User Info -->
                                        <div class="border-t border-gray-700 pt-3 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">{{ substr($game->user->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-gray-300 text-xs truncate">{{ $game->user->name }}</span>
                                            </div>
                                            @if($game->is_for_trade)
                                                <span class="text-xs bg-green-900/30 text-green-400 px-2 py-1 rounded">Trade</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mb-12">
                    {{ $games->links() }}
                </div>
            @else
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-12 text-center">
                    <p class="text-gray-400 mb-4">No games found matching your filters</p>
                    <a href="{{ route('games.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition">
                        View All Games
                    </a>
                </div>
            @endif
        </section>
    </div>
</x-layouts.gameswap>
