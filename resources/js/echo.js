import Echo from 'laravel-echo'
import Pusher from 'pusher-js';
window.Pusher = Pusher;

Pusher.logToConsole = true;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true
});

window.Echo.channel('my-channel.' + roomId)
    .listen('.my-event', function (data) {
        // Function to generate chat message HTML
        function createChatMessage(chat) {
            const isCurrentUser = chat.user_id === authenticatedUserId;
            const chatContainer = document.createElement('div');
            chatContainer.classList.add('flex');
            chatContainer.classList.add(isCurrentUser ? 'justify-end' : 'justify-start');

            if (!isCurrentUser) {
                const userName = document.createElement('p');
                userName.classList.add('text-xs', 'text-gray-600', 'mb-1');
                userName.textContent = chat.user.name;
                chatContainer.appendChild(userName);
            }

            const messageContainer = document.createElement('div');
            messageContainer.classList.add('bg-gray-100', 'p-2', 'rounded-md', 'max-w-xs');
            const messageText = document.createElement('p');
            messageText.classList.add('text-sm', 'text-gray-900');
            messageText.textContent = chat.chat;
            messageContainer.appendChild(messageText);

            chatContainer.appendChild(messageContainer);

            return chatContainer;
        }

        // Function to append chat message to the chat container
        function appendChatMessage(chat) {
            const chatContainer = document.getElementById('chat-container');
            const chatMessage = createChatMessage(chat);
            chatContainer.appendChild(chatMessage);
        }

        // Append the received chat message
        appendChatMessage(data.message);
    });
