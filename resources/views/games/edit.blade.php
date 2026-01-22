<x-layouts.gameswap :title="__('Edit Game')">
    <div class="container mx-auto py-12 px-4">
        <section class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-3">Edit Game</h1>
                <p class="text-gray-400">Update your game listing</p>
            </div>

            <div class="bg-gray-900 rounded-lg border border-gray-800 p-8">
                <form method="POST" action="{{ route('games.update', $game) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-white mb-2">Game Title *</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            required
                            value="{{ old('title', $game->title) }}"
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
                            <option value="PlayStation 5" {{ old('platform', $game->platform) === 'PlayStation 5' ? 'selected' : '' }}>PlayStation 5</option>
                            <option value="PlayStation 4" {{ old('platform', $game->platform) === 'PlayStation 4' ? 'selected' : '' }}>PlayStation 4</option>
                            <option value="Xbox Series X" {{ old('platform', $game->platform) === 'Xbox Series X' ? 'selected' : '' }}>Xbox Series X</option>
                            <option value="Xbox Series S" {{ old('platform', $game->platform) === 'Xbox Series S' ? 'selected' : '' }}>Xbox Series S</option>
                            <option value="Xbox One" {{ old('platform', $game->platform) === 'Xbox One' ? 'selected' : '' }}>Xbox One</option>
                            <option value="Nintendo Switch" {{ old('platform', $game->platform) === 'Nintendo Switch' ? 'selected' : '' }}>Nintendo Switch</option>
                            <option value="PC" {{ old('platform', $game->platform) === 'PC' ? 'selected' : '' }}>PC</option>
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
                            <option value="Action" {{ old('genre', $game->genre) === 'Action' ? 'selected' : '' }}>Action</option>
                            <option value="Adventure" {{ old('genre', $game->genre) === 'Adventure' ? 'selected' : '' }}>Adventure</option>
                            <option value="RPG" {{ old('genre', $game->genre) === 'RPG' ? 'selected' : '' }}>RPG</option>
                            <option value="Sports" {{ old('genre', $game->genre) === 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Racing" {{ old('genre', $game->genre) === 'Racing' ? 'selected' : '' }}>Racing</option>
                            <option value="Shooter" {{ old('genre', $game->genre) === 'Shooter' ? 'selected' : '' }}>Shooter</option>
                            <option value="Strategy" {{ old('genre', $game->genre) === 'Strategy' ? 'selected' : '' }}>Strategy</option>
                            <option value="Indie" {{ old('genre', $game->genre) === 'Indie' ? 'selected' : '' }}>Indie</option>
                        </select>
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
                            <option value="Like New" {{ old('condition', $game->condition) === 'Like New' ? 'selected' : '' }}>Like New</option>
                            <option value="Good" {{ old('condition', $game->condition) === 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Fair" {{ old('condition', $game->condition) === 'Fair' ? 'selected' : '' }}>Fair</option>
                            <option value="Poor" {{ old('condition', $game->condition) === 'Poor' ? 'selected' : '' }}>Poor</option>
                        </select>
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
                            value="{{ old('release_year', $game->release_year) }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                        />
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-white mb-2">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none"
                        >{{ old('description', $game->description) }}</textarea>
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
                                value="{{ old('price', $game->price) }}"
                                class="w-full pl-8 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            />
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_url" class="block text-sm font-semibold text-white mb-2">Game Cover Image URL</label>
                        <input
                            id="cover_url"
                            name="cover_url"
                            type="url"
                            value="{{ old('cover_url', $game->cover_url) }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                        />
                    </div>

                    <!-- Is For Trade -->
                    <div class="flex items-center">
                        <input
                            id="is_for_trade"
                            name="is_for_trade"
                            type="checkbox"
                            value="1"
                            {{ old('is_for_trade', $game->is_for_trade) ? 'checked' : '' }}
                            class="w-4 h-4 bg-gray-800 border-gray-700 rounded cursor-pointer accent-blue-500"
                        />
                        <label for="is_for_trade" class="ml-3 text-sm text-gray-300 cursor-pointer">
                            I'm willing to trade this game
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t border-gray-700">
                        <button
                            type="submit"
                            class="flex-1 py-3 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition"
                        >
                            Update Game
                        </button>
                        <a
                            href="{{ route('games.show', $game) }}"
                            class="flex-1 py-3 px-6 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-full text-center transition"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</x-layouts.gameswap>
