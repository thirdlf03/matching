import Echo from 'laravel-echo'
import Pusher from 'pusher-js';
window.Pusher = Pusher;

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
            chatContainer.classList.add('flex', isCurrentUser ? 'justify-end' : 'justify-start');

            if (!isCurrentUser) {
                const userAvatar = document.createElement('img');
                userAvatar.src = chat.avatar;
                userAvatar.alt = chat.user.name;
                userAvatar.classList.add('w-6', 'h-6', 'rounded-full', 'mr-2', 'mt-1');
                chatContainer.appendChild(userAvatar);

                const userInfo = document.createElement('div');
                userInfo.classList.add('text-xs', 'text-gray-600', 'mb-1');

                const userName = document.createElement('p');
                userName.textContent = chat.user.name;
                userInfo.appendChild(userName);

                const timestamp = document.createElement('p');
                timestamp.textContent = new Date(chat.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                userInfo.appendChild(timestamp);

                chatContainer.appendChild(userInfo);
            } else {
                const timestamp = document.createElement('p');
                timestamp.classList.add('text-xs', 'text-gray-600', 'mb-1');
                timestamp.textContent = new Date(chat.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                chatContainer.appendChild(timestamp);
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
