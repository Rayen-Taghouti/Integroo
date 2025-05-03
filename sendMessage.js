// JavaScript Code
document.querySelector('.btn_send').addEventListener('click', function (e) {
    e.preventDefault();

    // Get the input values
    const messageInput = document.querySelector('#chat-input'); // Assuming you have an input field with id 'chat-input'
    const senderIdInput = document.querySelector('#sender-id'); // Assuming you have a hidden input for sender_id with id 'sender-id'
    const receiverIdInput = document.querySelector('#receiver-id'); // Assuming you have a hidden input for receiver_id with id 'receiver-id'
    const chatBox = document.querySelector('#chat-box'); // Assuming you have a div with id 'chat-box' to display messages

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
            is_read: 1, // Always 1 as per the request
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the input field
                messageInput.value = '';

                // Append the new message to the chatbox
                const newMessage = document.createElement('div');
                newMessage.classList.add('message', 'sent'); // Add your desired classes for styling
                newMessage.textContent = message; // Add the message content
                chatBox.appendChild(newMessage);

                // Scroll the chatbox to the bottom
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                alert('Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message.');
        });
});