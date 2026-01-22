<x-layouts.gameswap :title="__('Manage Games')">
    <div class="min-h-screen bg-gray-900 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white">Manage Games</h1>
                    <p class="text-gray-400 mt-2">Total: {{ $games->total() }} games</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    ← Back
                </a>
            </div>

            <!-- Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 rounded-lg text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-900 border border-red-700 rounded-lg text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Games Table -->
            <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-900 border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-white font-semibold">Title</th>
                                <th class="px-6 py-4 text-left text-white font-semibold">Owner</th>
                                <th class="px-6 py-4 text-left text-white font-semibold">Platform</th>
                                <th class="px-6 py-4 text-left text-white font-semibold">Genre</th>
                                <th class="px-6 py-4 text-center text-white font-semibold">Status</th>
                                <th class="px-6 py-4 text-center text-white font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @forelse ($games as $game)
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.games.show', $game) }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                                            {{ $game->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <a href="{{ route('admin.users.show', $game->user) }}" class="text-blue-400 hover:text-blue-300">
                                            {{ $game->user->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">{{ $game->platform }}</td>
                                    <td class="px-6 py-4 text-gray-400">{{ $game->genre ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs px-3 py-1 rounded-full {{ $game->is_blocked ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                            {{ $game->is_blocked ? 'Blocked' : 'Active' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.games.show', $game) }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">
                                                View
                                            </a>
                                            <form action="{{ route('admin.games.toggle-block', $game) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold">
                                                    {{ $game->is_blocked ? 'Unblock' : 'Block' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-semibold">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        No games found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $games->links() }}
            </div>
        </div>
    </div>
</x-layouts.gameswap>
