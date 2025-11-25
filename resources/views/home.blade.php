@extends('layouts.app')

@section('title', 'GameSwap — Home')

@section('content')
<div class="container mx-auto py-8 px-4">
    <header class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">GameSwap</h1>
        <div class="space-x-2">
            @guest
                <a href="{{ route('login') }}" class="px-4 py-2 border rounded">Sign in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Create account</a>
            @else
                <a href="{{ route('games.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">List a game</a>
            @endguest
        </div>
    </header>

    <section class="bg-gray-100 p-6 rounded-lg mb-8">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="flex-1">
                <h2 class="text-2xl font-semibold mb-2">Trade, sell, or discover games nearby</h2>
                <p class="text-gray-700 mb-4">Search listings, message sellers and swap titles — simple and local.</p>

                <form action="{{ route('games.index') }}" method="GET" class="flex gap-2">
                    <input
                        name="q"
                        type="search"
                        placeholder="Search games, platform or tag"
                        value="{{ request('q') }}"
                        class="flex-1 border rounded px-3 py-2"
                    />
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
                </form>
            </div>

            <div class="w-48 bg-gray-200 h-40 rounded shadow flex items-center justify-center">
                <span class="text-gray-400">Game Image</span>
            </div>
        </div>
    </section>

    <section>
        <h3 class="text-xl font-semibold mb-4">Featured listings</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($featuredGames ?? [] as $game)
                <a href="{{ route('games.show', $game) }}" class="block border rounded overflow-hidden hover:shadow">
                    <img src="{{ $game->cover_url ?? asset('images/placeholder.png') }}" alt="{{ $game->title }}" class="w-full h-40 object-cover" />
                    <div class="p-3">
                        <h4 class="font-semibold">{{ $game->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $game->platform ?? 'Platform unknown' }}</p>
                        <p class="mt-2 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($game->description, 80) }}</p>
                    </div>
                </a>
            @empty
                @for($i = 0; $i < 6; $i++)
                    <div class="border rounded p-6 flex items-center justify-center text-gray-400">No listings yet</div>
                @endfor
            @endforelse
        </div>
    </section>

    <section class="mt-8">
        <h3 class="text-lg font-semibold mb-2">Browse by category</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($categories ?? ['Action','RPG','Indie','Sports','Racing'] as $cat)
                <a href="{{ route('games.index', ['category' => $cat]) }}" class="px-3 py-1 border rounded text-sm">{{ $cat }}</a>
            @endforeach
        </div>
    </section>

    <footer class="mt-10 text-center text-sm text-gray-500">
        © {{ date('Y') }} GameSwap — Built with Laravel
    </footer>
</div>
@endsection