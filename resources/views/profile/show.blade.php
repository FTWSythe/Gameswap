<x-layouts.gameswap :title="$user->name ?? __('My Profile')">
    <div class="container mx-auto py-12 px-4">
        <!-- Profile Header Section -->
        <section class="mb-12">
            <div class="bg-gradient-to-r from-blue-900 to-purple-900 rounded-lg p-8 text-white">
                <div class="flex items-center justify-between">
                    <!-- Left: Profile Info -->
                    <div class="flex items-center gap-6">
                        <!-- Avatar -->
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center border-4 border-white">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold mb-2">
                                {{ $user->name ?? Auth::user()->name }}
                                @if (($user->is_admin ?? Auth::user()->is_admin))
                                    <span class="ml-3 px-3 py-1 bg-yellow-900 text-yellow-400 text-lg font-semibold rounded-full inline-block">Admin</span>
                                @endif
                            </h1>
                            <p class="text-gray-200 text-sm mb-2">{{ $user->email ?? Auth::user()->email }}</p>
                            @if (($user->quote ?? Auth::user()->quote))
                                <p class="text-gray-100 italic mb-4 max-w-2xl">{{ $user->quote ?? Auth::user()->quote }}</p>
                            @endif
                            <div class="flex gap-4">
                                @if(!$user || Auth::check() && Auth::user()->id === $user->id)
                                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-white text-blue-600 font-semibold rounded-full hover:bg-gray-100 transition">
                                        Edit Profile
                                    </a>
                                    <a href="{{ route('games.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition">
                                        List Game
                                    </a>
                                @elseif(Auth::check())
                                    <a href="{{ route('games.index', ['user' => $user->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition">
                                        View Games
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Stats -->
                    <div class="text-right">
                        <div class="mb-6">
                            <p class="text-gray-200 text-sm mb-2">Friends</p>
                            <div class="grid grid-cols-4 gap-2">
                                <p class="text-2xl font-bold text-white">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Your Games Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">{{ ($user && $user->id !== Auth::user()?->id) ? 'Games' : 'Your Games' }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @forelse (($user ?? Auth::user())->games ?? [] as $game)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 cursor-pointer border border-gray-700">
                        <div class="w-full h-40 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Game Image</span>
                        </div>
                        <div class="p-4">
                            <h4 class="text-white font-semibold text-sm mb-2">{{ $game->title }}</h4>
                            <p class="text-gray-400 text-xs mb-3">{{ $game->platform }}</p>
                            <a href="{{ route('games.show', $game) }}" class="block w-full px-3 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-semibold rounded text-center transition">
                                Manage
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-5 bg-gray-800 rounded-lg p-12 border border-gray-700 text-center">
                        <p class="text-gray-400 mb-4">{{ ($user && $user->id !== Auth::user()?->id) ? 'This user hasn\'t listed any games' : 'You haven\'t listed any games yet' }}</p>
                        @if(!$user || Auth::check() && Auth::user()->id === $user->id)
                            <a href="{{ route('games.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition">
                                List Your First Game
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Recent Trades Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Recent Trades</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 cursor-pointer border border-gray-700">
                    <div class="w-full h-40 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Trade Image</span>
                    </div>
                    <div class="p-4">
                        <h4 class="text-white font-semibold text-sm mb-2">Elden Ring</h4>
                        <p class="text-gray-400 text-xs mb-3">Traded 3 days ago</p>
                        <button class="w-full px-3 py-2 bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-semibold rounded transition">
                            View
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">TOTAL GAMES</h3>
                <p class="text-4xl font-bold text-white">{{ ($user ?? Auth::user())->games->count() ?? 0 }}</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">TRADES COMPLETED</h3>
                <p class="text-4xl font-bold text-white">1</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold mb-2">FRIENDS</h3>
                <p class="text-4xl font-bold text-white">0</p>
            </div>
        </section>
    </div>
</x-layouts.gameswap>
