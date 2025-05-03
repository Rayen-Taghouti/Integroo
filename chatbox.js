// JavaScript Code for Sending and Displaying Messages
document.querySelector('.btn_send').addEventListener('click', function (e) {
    e.preventDefault();

    // Get the input values
    const messageInput = document.querySelector('#chat-input');
    const senderIdInput = document.querySelector('#sender-id');
    const receiverIdInput = document.querySelector('#receiver-id');
    const chatBox = document.querySelector('#chat-box');

    const message = messageInput.value;
    const senderId = senderIdInput.value;
    const receiverId = receiverIdInput.value;

    if (message.trim() === '') {
        alert('Please enter a message');
        return;
    }

    // Send the message to the server via AJAX
    fetch('saveMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            content: message,
            sender_id: senderId,
            receiver_id: receiverId,
            is_read: 1,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the input field
                messageInput.value = '';

                // Fetch and update the chatbox
                fetchMessages(chatBox, senderId, receiverId);
            } else {
                alert('Failed to send the message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message.');
        });
});

// Function to Fetch and Display Messages
function fetchMessages(chatBox, senderId, receiverId) {
    fetch(`fetchMessages.php?sender_id=${senderId}&receiver_id=${receiverId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the chatbox before appending messages
                chatBox.innerHTML = '';

                // Append messages dynamically
                data.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(message.sender_id == senderId ? 'sent' : 'received'); // Add class based on sender
                    messageDiv.textContent = message.content;
                    chatBox.appendChild(messageDiv);
                });

                // Scroll the chatbox to the bottom
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                console.error('Failed to fetch messages:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
}

// Real-Time Fetching Using setInterval
const chatBox = document.querySelector('#chat-box');
const senderId = document.querySelector('#sender-id').value;
const receiverId = document.querySelector('#receiver-id').value;

// Update chatbox every 5 seconds
setInterval(() => {
    fetchMessages(chatBox, senderId, receiverId);
}, 5000);