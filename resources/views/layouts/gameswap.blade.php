<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GameSwap' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold">GS</span>
                    </div>
                    <span class="text-2xl font-bold text-white">GameSwap</span>
                </a>

                <!-- Center Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('games.index') }}" class="text-gray-300 hover:text-white transition">Browse Games</a>
                    <a href="{{ route('games.create') }}" class="text-gray-300 hover:text-white transition">List a Game</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-300 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-300">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">GameSwap</h3>
                    <p class="text-gray-400 text-sm">Trade, sell, or discover games nearby.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Browse</h4>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><a href="{{ route('games.index') }}" class="hover:text-white transition">All Games</a></li>
                        <li><a href="{{ route('games.create') }}" class="hover:text-white transition">List a Game</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Account</h4>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition">Settings</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} GameSwap. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
