<x-layouts.gameswap :title="__('Admin Dashboard')">
    <div class="min-h-screen bg-gray-900 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Admin Dashboard</h1>
                <p class="text-gray-400">Manage users, games, and platform settings</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg p-6 text-white">
                    <p class="text-gray-200 text-sm">Total Users</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
                </div>

                <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-lg p-6 text-white">
                    <p class="text-gray-200 text-sm">Total Games</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalGames }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-lg p-6 text-white">
                    <p class="text-gray-200 text-sm">Blocked Users</p>
                    <p class="text-4xl font-bold mt-2">{{ $blockedUsers }}</p>
                </div>

                <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-lg p-6 text-white">
                    <p class="text-gray-200 text-sm">Blocked Games</p>
                    <p class="text-4xl font-bold mt-2">{{ $blockedGames }}</p>
                </div>
            </div>

            <!-- Management Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Users -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white">Recent Users</h2>
                        <a href="{{ route('admin.users') }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">
                            View All →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($recentUsers as $user)
                            <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                                <div>
                                    <p class="text-white font-semibold">{{ $user->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ $user->is_blocked ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                    {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">No users yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Games -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white">Recent Games</h2>
                        <a href="{{ route('admin.games') }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">
                            View All →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($recentGames as $game)
                            <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                                <div>
                                    <p class="text-white font-semibold">{{ $game->title }}</p>
                                    <p class="text-gray-400 text-sm">by {{ $game->user->name ?? 'Unknown' }}</p>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ $game->is_blocked ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                    {{ $game->is_blocked ? 'Blocked' : 'Active' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">No games yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                <h2 class="text-xl font-bold text-white mb-6">Management Tools</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.users') }}" class="block p-4 bg-gray-900 border border-gray-700 hover:border-blue-500 rounded-lg text-white hover:text-blue-400 transition">
                        <h3 class="font-semibold mb-1">Manage Users</h3>
                        <p class="text-sm text-gray-400">View, block, and delete users</p>
                    </a>
                    <a href="{{ route('admin.games') }}" class="block p-4 bg-gray-900 border border-gray-700 hover:border-blue-500 rounded-lg text-white hover:text-blue-400 transition">
                        <h3 class="font-semibold mb-1">Manage Games</h3>
                        <p class="text-sm text-gray-400">Review, block, and remove game listings</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.gameswap>
