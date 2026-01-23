@if(session('success') && str_contains(session('success'), 'Trade request accepted'))
    <div id="tradeCompleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-12 text-center max-w-md w-full mx-4">
            <div class="mb-6">
                <svg class="w-16 h-16 text-green-400 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-white mb-2">Trade complete!</h2>
            <p class="text-gray-400 mb-6">The trade has been successfully accepted.</p>
            
            <button 
                onclick="document.getElementById('tradeCompleteModal').remove()"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-full transition"
            >
                Got it
            </button>
        </div>
    </div>
    
    <script>
        // Auto-close modal after 3 seconds
        setTimeout(() => {
            const modal = document.getElementById('tradeCompleteModal');
            if (modal) {
                modal.remove();
            }
        }, 3000);
    </script>
@endif
