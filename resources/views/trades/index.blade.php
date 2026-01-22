<x-layouts.gameswap :title="__('My Trades')">
    <div class="container mx-auto py-12 px-4">
        <!-- Page Header -->
        <section class="mb-12">
            <h1 class="text-4xl font-bold text-white mb-3">My Trades</h1>
            <p class="text-gray-400">Manage your trade requests and completed trades</p>
        </section>

        <!-- Filter Tabs -->
        <section class="mb-8 flex gap-4 flex-wrap">
            <a href="{{ route('trades.index') }}" class="px-6 py-2 rounded-full font-semibold transition {{ !request('status') ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                All Trades
            </a>
            <a href="{{ route('trades.index', ['status' => 'pending']) }}" class="px-6 py-2 rounded-full font-semibold transition {{ request('status') === 'pending' ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Pending
            </a>
            <a href="{{ route('trades.index', ['status' => 'accepted']) }}" class="px-6 py-2 rounded-full font-semibold transition {{ request('status') === 'accepted' ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Accepted
            </a>
            <a href="{{ route('trades.index', ['status' => 'completed']) }}" class="px-6 py-2 rounded-full font-semibold transition {{ request('status') === 'completed' ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Completed
            </a>
        </section>

        <!-- Trades List -->
        <section>
            @if($trades->count())
                <div class="space-y-4">
                    @foreach($trades as $trade)
                        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-blue-600 transition">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <!-- Requested Game -->
                                <div>
                                    <p class="text-gray-400 text-sm mb-2">Requested Game</p>
                                    <p class="text-white font-semibold mb-1">{{ $trade->requestedGame->title }}</p>
                                    <p class="text-gray-500 text-sm">{{ $trade->requestedGame->platform }}</p>
                                </div>

                                <!-- Offered Game -->
                                <div>
                                    <p class="text-gray-400 text-sm mb-2">
                                        {{ auth()->id() === $trade->requester_id ? 'Your Offer' : 'Their Offer' }}
                                    </p>
                                    @if($trade->offeredGame)
                                        <p class="text-white font-semibold mb-1">{{ $trade->offeredGame->title }}</p>
                                        <p class="text-gray-500 text-sm">{{ $trade->offeredGame->platform }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No game offered</p>
                                    @endif
                                </div>

                                <!-- Trade Partner -->
                                <div>
                                    <p class="text-gray-400 text-sm mb-2">
                                        {{ auth()->id() === $trade->requester_id ? 'Trade with' : 'From' }}
                                    </p>
                                    @php
                                        $otherUser = auth()->id() === $trade->requester_id ? $trade->gameOwner : $trade->requester;
                                    @endphp
                                    <p class="text-white font-semibold">{{ $otherUser->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $otherUser->email }}</p>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex flex-col items-end justify-between">
                                    <!-- Status Badge -->
                                    <div class="mb-4">
                                        @if($trade->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-900/30 text-yellow-400 text-xs font-semibold rounded-full">Pending</span>
                                        @elseif($trade->status === 'accepted')
                                            <span class="px-3 py-1 bg-green-900/30 text-green-400 text-xs font-semibold rounded-full">Accepted</span>
                                        @elseif($trade->status === 'declined')
                                            <span class="px-3 py-1 bg-red-900/30 text-red-400 text-xs font-semibold rounded-full">Declined</span>
                                        @else
                                            <span class="px-3 py-1 bg-blue-900/30 text-blue-400 text-xs font-semibold rounded-full">Completed</span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2 flex-wrap justify-end">
                                        @if($trade->status === 'pending' && auth()->id() === $trade->game_owner_id)
                                            <form action="{{ route('trades.accept', $trade) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded text-sm transition">
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('trades.decline', $trade) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded text-sm transition">
                                                    Decline
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('trades.show', $trade) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded text-sm transition">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if($trade->message)
                                <div class="mt-4 pt-4 border-t border-gray-700">
                                    <p class="text-gray-400 text-sm mb-1">Message:</p>
                                    <p class="text-gray-300">{{ $trade->message }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $trades->links() }}
                </div>
            @else
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-12 text-center">
                    <p class="text-gray-400 mb-4">No trades found</p>
                    <a href="{{ route('games.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition">
                        Browse Games
                    </a>
                </div>
            @endif
        </section>
    </div>
</x-layouts.gameswap>
