<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $quote = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->quote = Auth::user()->quote ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'quote' => ['nullable', 'string', 'max:500'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="min-h-screen bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold">GS</span>
                    </div>
                    <span class="text-2xl font-bold text-white">GameSwap</span>
                </a>
                <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    ← Back to Profile
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto py-12 px-4 max-w-2xl flex-1">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-8">
            <h1 class="text-3xl font-bold text-white mb-2">Edit Profile</h1>
            <p class="text-gray-400 mb-6">Update your name, email and add a quote</p>

            <form wire:submit="updateProfileInformation" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                    <input 
                        wire:model="name" 
                        type="text" 
                        required 
                        autofocus 
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                    />
                    @error('name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input 
                        wire:model="email" 
                        type="email" 
                        required 
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                    />
                    @error('email') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div class="mt-4 p-4 bg-yellow-900/20 border border-yellow-600 rounded-lg">
                            <p class="text-yellow-400 text-sm mb-2">Your email address is unverified.</p>
                            <button type="button" wire:click.prevent="resendVerificationNotification" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">
                                Click here to re-send the verification email.
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p class="text-green-400 text-sm mt-2">A new verification link has been sent to your email address.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Quote Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quote (maximum 100 words)</label>
                    <textarea 
                        wire:model="quote" 
                        maxlength="500"
                        rows="4"
                        placeholder="Share your favorite quote or a personal message..."
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 resize-none"
                    ></textarea>
                    <p class="text-xs text-gray-400 mt-2">
                        <span id="word-count">0</span> / 100 words
                    </p>
                    @error('quote') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        updateWordCount();
                    });
                    
                    const textarea = document.querySelector('textarea');
                    if (textarea) {
                        textarea.addEventListener('input', updateWordCount);
                    }
                    
                    function updateWordCount() {
                        const textarea = document.querySelector('textarea');
                        if (!textarea) return;
                        const words = textarea.value.trim().split(/\s+/).filter(w => w.length > 0).length;
                        document.getElementById('word-count').textContent = words;
                    }
                </script>

                <!-- Save Button -->
                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition"
                    >
                        Save Changes
                    </button>
                    <a 
                        href="{{ route('profile.show') }}" 
                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition"
                    >
                        Cancel
                    </a>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="p-4 bg-green-900/20 border border-green-600 rounded-lg">
                        <p class="text-green-400 font-semibold">✓ Profile updated successfully!</p>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} GameSwap. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
