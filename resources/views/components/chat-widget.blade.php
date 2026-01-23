@auth
<div id="chatWidget" class="fixed bottom-4 right-4 w-80 bg-gray-800 rounded-lg border border-gray-700 shadow-2xl z-40 flex flex-col max-h-96">
    <!-- Chat Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-t-lg p-4 flex items-center justify-between cursor-pointer hover:from-blue-700 hover:to-purple-700 transition" onclick="toggleChat()">
        <div>
            <h3 class="text-white font-semibold">Messages</h3>
            <p id="chatUserName" class="text-gray-200 text-sm">Select a user</p>
        </div>
        <button onclick="toggleChat(event)" class="text-white hover:text-gray-200 transition">
            <svg id="chatToggleIcon" class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </button>
    </div>

    <!-- Chat Content -->
    <div id="chatContent" class="flex flex-col flex-1">
        <!-- User Selection Dropdown -->
        <div class="p-4 border-b border-gray-700">
            <label class="text-gray-400 text-sm mb-2 block">Start a conversation:</label>
            <select id="userSelect" onchange="selectUser()" class="w-full py-2 px-3 bg-gray-700 border border-gray-600 text-white rounded text-sm focus:outline-none focus:border-blue-500">
                <option value="">-- Select a user --</option>
            </select>
        </div>

        <!-- Messages Container -->
        <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3 hidden">
            <!-- Messages will be loaded here -->
        </div>

        <!-- No Chat Selected -->
        <div id="noChatSelected" class="flex-1 flex items-center justify-center p-4">
            <p class="text-gray-400 text-sm text-center">Select a user to start messaging</p>
        </div>

        <!-- Message Input -->
        <div id="messageInputArea" class="border-t border-gray-700 p-4 hidden">
            <form id="messageForm" onsubmit="sendMessage(event)" class="flex gap-2">
                <input 
                    type="text" 
                    id="messageInput" 
                    placeholder="Type a message..." 
                    class="flex-1 py-2 px-3 bg-gray-700 border border-gray-600 text-white rounded text-sm focus:outline-none focus:border-blue-500"
                    maxlength="1000"
                >
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold text-sm transition">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let currentUserId = null;
let messageRefreshInterval = null;

// Load users on page load
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    // Auto-refresh messages every 2 seconds when a chat is open
    setInterval(function() {
        if (currentUserId) {
            loadMessages();
        }
    }, 2000);
});

function toggleChat(event) {
    if (event) {
        event.stopPropagation();
    }
    const chatContent = document.getElementById('chatContent');
    const chatMinimized = document.getElementById('chatMinimized');
    const icon = document.getElementById('chatToggleIcon');
    
    chatContent.classList.toggle('hidden');
    chatMinimized.classList.toggle('hidden');
    icon.style.transform = chatContent.classList.contains('hidden') ? 'rotate(180deg)' : 'rotate(0deg)';
}

async function loadUsers() {
    try {
        const response = await fetch('{{ route("messages.users") }}');
        const users = await response.json();
        
        const userSelect = document.getElementById('userSelect');
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            userSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading users:', error);
    }
}

function selectUser() {
    const userSelect = document.getElementById('userSelect');
    currentUserId = userSelect.value;
    
    if (!currentUserId) {
        document.getElementById('messagesContainer').classList.add('hidden');
        document.getElementById('noChatSelected').classList.remove('hidden');
        document.getElementById('messageInputArea').classList.add('hidden');
        document.getElementById('chatUserName').textContent = 'Select a user';
        return;
    }
    
    // Get selected user name
    const selectedOption = userSelect.options[userSelect.selectedIndex];
    document.getElementById('chatUserName').textContent = selectedOption.text;
    
    document.getElementById('noChatSelected').classList.add('hidden');
    document.getElementById('messagesContainer').classList.remove('hidden');
    document.getElementById('messageInputArea').classList.remove('hidden');
    document.getElementById('messageInput').focus();
    
    loadMessages();
}

async function loadMessages() {
    if (!currentUserId) return;
    
    try {
        const response = await fetch(`/messages/${currentUserId}`);
        const messages = await response.json();
        
        const container = document.getElementById('messagesContainer');
        container.innerHTML = '';
        
        messages.forEach(message => {
            const isOwn = message.sender_id === {{ auth()->id() }};
            const messageEl = document.createElement('div');
            messageEl.className = `flex ${isOwn ? 'justify-end' : 'justify-start'}`;
            messageEl.innerHTML = `
                <div class="${isOwn ? 'bg-blue-600' : 'bg-gray-700'} rounded-lg px-3 py-2 max-w-xs">
                    <p class="text-white text-sm break-words">${escapeHtml(message.content)}</p>
                    <p class="text-gray-300 text-xs mt-1">${new Date(message.created_at).toLocaleTimeString()}</p>
                </div>
            `;
            container.appendChild(messageEl);
        });
        
        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    } catch (error) {
        console.error('Error loading messages:', error);
    }
}

async function sendMessage(event) {
    event.preventDefault();
    
    if (!currentUserId) return;
    
    const messageInput = document.getElementById('messageInput');
    const content = messageInput.value.trim();
    
    if (!content) return;
    
    try {
        const response = await fetch('{{ route("messages.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                recipient_id: currentUserId,
                content: content
            })
        });
        
        if (response.ok) {
            messageInput.value = '';
            loadMessages();
        } else {
            alert('Error sending message');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Error sending message');
    }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>
@endauth
