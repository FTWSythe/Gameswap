<x-layouts.gameswap :title="__('Dashboard')">
    <div class="container mx-auto py-12 px-4">
        <!-- Welcome Section -->
        <section class="mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white">
                @auth
                    <h2 class="text-4xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="text-lg opacity-90">Trade, sell, or discover games nearby. Connect with other gamers in your area.</p>
                    <a href="{{ route('games.create') }}" class="inline-block mt-6 px-6 py-3 bg-white text-blue-600 font-semibold rounded hover:bg-gray-100 transition">
                        + List a game
                    </a>
                @else
                    <h2 class="text-4xl font-bold mb-2">Welcome to GameSwap</h2>
                    <p class="text-lg opacity-90">Trade, sell, or discover games nearby. Connect with other gamers in your area.</p>
                    <div class="flex gap-4 mt-6">
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-white text-blue-600 font-semibold rounded hover:bg-gray-100 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-blue-700 text-white font-semibold rounded hover:bg-blue-800 transition">
                            Create Account
                        </a>
                    </div>
                @endauth
            </div>
        </section>

        <!-- Featured Games Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Featured Games</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($games as $game)
                    <a href="{{ route('games.show', $game) }}" class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 cursor-pointer border border-gray-700">
                        <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                            @if($game->cover_url)
                                <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 text-sm">{{ $game->platform }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="text-white font-semibold text-lg mb-1 truncate">{{ $game->title }}</h4>
                            <p class="text-gray-400 text-sm mb-3">{{ $game->platform }}</p>
                            <p class="text-gray-300 text-sm mb-4 line-clamp-2">{{ $game->description ?? 'No description' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-blue-400 font-semibold">View Details</span>
                                <span class="text-gray-400 text-sm">→</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-400 text-lg">No games listed yet. <a href="{{ route('games.create') }}" class="text-blue-400 hover:text-blue-300">List a game</a> to get started!</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('games.index') }}" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition">
                    Browse All Games
                </a>
            </div>
        </section>

        <!-- Quick Stats -->
        @auth
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">TOTAL GAMES</h3>
                <p class="text-4xl font-bold text-white">{{ $totalGames ?? 0 }}</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">YOUR LISTINGS</h3>
                <p class="text-4xl font-bold text-white">{{ $userListings ?? 0 }}</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">PROFILE VIEWS</h3>
                <p class="text-4xl font-bold text-white">{{ $userProfileViews ?? 0 }}</p>
            </div>
        </section>
        @endauth
    </div>
</x-layouts.gameswap>
