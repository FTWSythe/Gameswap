@extends('layouts.app')

@section('title', 'Create Account - GameSwap')

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
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-white text-center mb-2">Create Account</h2>
                <p class="text-gray-400 text-center text-sm mb-6">Join GameSwap and start trading games</p>

                <!-- Session Status -->
                @if ($errors->any())
                    <div class="bg-red-900/20 border border-red-600 rounded-lg p-4 mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-400 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm text-gray-300 mb-2">Full Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="John Doe"
                        />
                    </div>

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
                            autocomplete="new-password"
                            required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="••••••••"
                        />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm text-gray-300 mb-2">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="••••••••"
                        />
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition duration-200 transform hover:scale-105 active:scale-95"
                    >
                        Create Account
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-900 text-gray-500">Already have an account?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <a
                    href="{{ route('login') }}"
                    class="block w-full py-3 px-4 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-lg text-center transition"
                >
                    Sign In
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
