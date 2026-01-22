<x-layouts.gameswap :title="__('List a Game')">
    <div class="container mx-auto py-12 px-4">
        <!-- Page Header -->
        <section class="mb-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-3">List Your Game</h1>
                <p class="text-gray-400">Share your games with the community and start trading</p>
            </div>
        </section>

        <!-- Form Section -->
        <section class="max-w-2xl mx-auto">
            <div class="bg-gray-900 rounded-lg border border-gray-800 p-8">
                <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-white mb-2">Game Title *</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            required
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="e.g., Elden Ring"
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Platform -->
                    <div>
                        <label for="platform" class="block text-sm font-semibold text-white mb-2">Platform *</label>
                        <select
                            id="platform"
                            name="platform"
                            required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                        >
                            <option value="">Select a platform</option>
                            <option value="PlayStation 5">PlayStation 5</option>
                            <option value="PlayStation 4">PlayStation 4</option>
                            <option value="Xbox Series X">Xbox Series X</option>
                            <option value="Xbox Series S">Xbox Series S</option>
                            <option value="Xbox One">Xbox One</option>
                            <option value="Nintendo Switch">Nintendo Switch</option>
                            <option value="PC">PC</option>
                            <option value="Nintendo Wii">Nintendo Wii</option>
                        </select>
                        @error('platform')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-semibold text-white mb-2">Genre</label>
                        <select
                            id="genre"
                            name="genre"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                        >
                            <option value="">Select a genre</option>
                            <option value="Action">Action</option>
                            <option value="Adventure">Adventure</option>
                            <option value="RPG">RPG</option>
                            <option value="Sports">Sports</option>
                            <option value="Racing">Racing</option>
                            <option value="Shooter">Shooter</option>
                            <option value="Strategy">Strategy</option>
                            <option value="Indie">Indie</option>
                            <option value="Horror">Horror</option>
                            <option value="Puzzle">Puzzle</option>
                        </select>
                        @error('genre')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Condition -->
                    <div>
                        <label for="condition" class="block text-sm font-semibold text-white mb-2">Condition *</label>
                        <select
                            id="condition"
                            name="condition"
                            required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                        >
                            <option value="">Select condition</option>
                            <option value="Like New">Like New</option>
                            <option value="Good">Good</option>
                            <option value="Fair">Fair</option>
                            <option value="Poor">Poor</option>
                        </select>
                        @error('condition')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Release Year -->
                    <div>
                        <label for="release_year" class="block text-sm font-semibold text-white mb-2">Release Year</label>
                        <input
                            id="release_year"
                            name="release_year"
                            type="number"
                            min="1980"
                            max="{{ date('Y') }}"
                            value="{{ old('release_year') }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="e.g., 2022"
                        />
                        @error('release_year')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-white mb-2">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none"
                            placeholder="Describe the game's condition and any details..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-white mb-2">Price (Optional)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500">$</span>
                            <input
                                id="price"
                                name="price"
                                type="number"
                                step="0.01"
                                min="0"
                                value="{{ old('price') }}"
                                class="w-full pl-8 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                placeholder="0.00"
                            />
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_url" class="block text-sm font-semibold text-white mb-2">Game Cover Image URL</label>
                        <input
                            id="cover_url"
                            name="cover_url"
                            type="url"
                            value="{{ old('cover_url') }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            placeholder="https://example.com/image.jpg"
                        />
                        @error('cover_url')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is For Trade -->
                    <div class="flex items-center">
                        <input
                            id="is_for_trade"
                            name="is_for_trade"
                            type="checkbox"
                            value="1"
                            {{ old('is_for_trade') ? 'checked' : '' }}
                            class="w-4 h-4 bg-gray-800 border-gray-700 rounded cursor-pointer accent-blue-500"
                        />
                        <label for="is_for_trade" class="ml-3 text-sm text-gray-300 cursor-pointer">
                            I'm willing to trade this game
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-6 border-t border-gray-700">
                        <button
                            type="submit"
                            class="flex-1 py-3 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition duration-200 transform hover:scale-105 active:scale-95"
                        >
                            List Game
                        </button>
                        <a
                            href="{{ route('games.index') }}"
                            class="flex-1 py-3 px-6 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-full text-center transition"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </section>

        <!-- Help Section -->
        <section class="max-w-2xl mx-auto mt-12">
            <h2 class="text-2xl font-bold text-white mb-6">Tips for Listing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <h3 class="text-white font-semibold mb-2">Be Accurate</h3>
                    <p class="text-gray-400 text-sm">Provide accurate information about the game's condition and platform.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <h3 class="text-white font-semibold mb-2">Add Details</h3>
                    <p class="text-gray-400 text-sm">Include any scratches, missing items, or special features in the description.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <h3 class="text-white font-semibold mb-2">Good Images</h3>
                    <p class="text-gray-400 text-sm">Use clear images to help buyers see the game's actual condition.</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.gameswap>
