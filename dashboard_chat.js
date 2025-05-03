document.addEventListener('DOMContentLoaded', function () {
    function formatTime(dateString) {
        const date = new Date(dateString);
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    function updateDashboardChatBox(conversation) {
        const chatBox = document.querySelector('.chat_box');
        if (!conversation) {
            chatBox.innerHTML = '<p class="no-conversations">Aucune conversation récente</p>';
            return;
        }


        fetch(`fetch_conversation.php?other_user_id=${conversation.other_user_id}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(messages => {
                if (!messages || messages.length === 0) {
                    chatBox.innerHTML += '<p class="no-messages">Aucun message dans cette conversation</p>';
                    return;
                }

                messages.forEach(message => {
                    const isMyMessage = message.sender_id == CURRENT_USER_ID;
                    const msgDiv = document.createElement('div');
                    msgDiv.className = isMyMessage ? 'msg me' : 'msg';

                    const profilePic = isMyMessage
                        ? document.querySelector('.prophile img').src
                        : (message.sender_id == CURRENT_USER_ID
                            ? message.receiver_profile_pic
                            : message.sender_profile_pic);

                    if (!isMyMessage) {
                        msgDiv.innerHTML = `
                            <img src="${profilePic}" alt="profile image">
                            <div class="chat">
                                <div class="profile">
                                    <span class="username">${conversation.other_user_name}</span>
                                    <span class="time">${formatTime(message.created_at)}</span>
                                </div>
                                <p>${message.content}</p>
                            </div>
                        `;
                    } else {
                        msgDiv.innerHTML = `
                            <div class="chat">
                                <div class="profile">
                                    <span class="time">${formatTime(message.created_at)}</span>
                                </div>
                                <p>${message.content}</p>
                            </div>
                        `;
                    }

                    chatBox.appendChild(msgDiv);
                });
            })
            .catch(error => {
                console.error('Error fetching conversation:', error);
                chatBox.innerHTML += '<p class="error">Erreur de chargement des messages</p>';
            });
    }

    // Load the conversation when page loads
    fetch('fetch_dashboard_conversation.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(conversation => {
            console.log('Fetched conversation:', conversation);
            updateDashboardChatBox(conversation);
        })
        .catch(error => {
            console.error('Error fetching dashboard conversation:', error);
            const chatBox = document.querySelector('.chat_box');
            chatBox.innerHTML = '<p class="error">Erreur de chargement de la conversation</p>';
        });
});