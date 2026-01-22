@extends('layouts.app')

@section('title', 'Log In - GameSwap')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-800">
            <!-- Illustration Section -->
            <div class="h-48 bg-gradient-to-br from-purple-900 via-blue-900 to-purple-900 flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg viewBox="0 0 100 100" class="w-full h-full">
                        <path d="M20 80 Q 50 20, 80 80" fill="none" stroke="currentColor" stroke-width="2" class="text-white"/>
                    </svg>
                </div>
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-white text-center mb-2">Welcome Back</h2>
                <p class="text-gray-400 text-center text-sm mb-6">Sign in to your GameSwap account</p>

                <!-- Session Status -->
                @if ($errors->any())
                    <div class="bg-red-900/20 border border-red-600 rounded-lg p-4 mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-400 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm text-gray-300 mb-2">Email Address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="you@example.com"
                        />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm text-gray-300 mb-2">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="••••••••"
                        />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="w-4 h-4 bg-gray-800 border-gray-700 rounded cursor-pointer accent-blue-500"
                        />
                        <label for="remember" class="ml-2 text-sm text-gray-400 cursor-pointer">Keep me logged in</label>
                    </div>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-right">
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                                Forgot your password?
                            </a>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-teal-400 to-blue-500 hover:from-teal-500 hover:to-blue-600 text-white font-semibold rounded-full transition duration-200 transform hover:scale-105 active:scale-95"
                    >
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-900 text-gray-500">Don't have an account?</span>
                    </div>
                </div>

                <!-- Register Link -->
                <a
                    href="{{ route('register') }}"
                    class="block w-full py-3 px-4 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-lg text-center transition"
                >
                    Create Account
                </a>
            </div>
        </div>

        <!-- Footer Text -->
        <p class="text-center text-gray-400 text-sm mt-6">
            © 2026 GameSwap. All rights reserved.
        </p>
    </div>
</div>
@endsection
