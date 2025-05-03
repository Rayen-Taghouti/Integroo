document.addEventListener('DOMContentLoaded', function() {

    let currentConversationId = null;
    const emojiButton = document.getElementById('emojiButton');
    const emojiPicker = document.getElementById('emojiPicker');
    const emojiContainer = document.querySelector('.emoji-container');
    const messageInput = document.getElementById('messageInput');
    const emojis = [
        '😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣',
        '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰',
        '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜',
        '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏',
        '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣',
        '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠',
        '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨',
        '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥',
        '😶', '😐', '😑', '😬', '🙄', '😯', '😦', '😧',
        '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐',
        '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑',
        '🤠', '😈', '👿', '👹', '👺', '🤡', '💩', '👻',
        '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸',
        '😹', '😻', '😼', '😽', '🙀', '😿', '😾'
    ];
    function initEmojiPicker() {
        emojis.forEach(emoji => {
            const emojiElement = document.createElement('span');
            emojiElement.textContent = emoji;
            emojiElement.addEventListener('click', () => {
                messageInput.value += emoji;
                messageInput.focus();
            });
            emojiContainer.appendChild(emojiElement);
        });
    }
    emojiButton.addEventListener('click', (e) => {
        e.stopPropagation();
        emojiPicker.classList.toggle('show');
    });
    document.addEventListener('click', (e) => {
        if (!emojiPicker.contains(e.target)) {
            emojiPicker.classList.remove('show');
        }
    });
    initEmojiPicker();
    fetch('fetch_messages.php')
        .then(response => response.json())
        .then(data => {
            const chatlist = document.querySelector('.chatlist');
            chatlist.innerHTML = "";            
            const firstReadConversation = data.find(chat => chat.is_read == 1);
            const defaultConversation = firstReadConversation || data[0];
            
            data.forEach(chat => {
                const block = document.createElement('div');
                block.dataset.userId = chat.other_user_id;

                if (chat.is_read == 0) {
                    block.classList.add('block', 'unread');
                } else {
                    block.classList.add('block', 'raed');
                }

                block.innerHTML = `
                    <div class="imgBox">
                        <img src="${chat.other_user_profile_pic}" alt="profile image" class="cover">
                    </div>
                    <div class="details">
                        <div class="listHead">
                            <h4>${chat.other_user_name}</h4>
                            <p class="time">${formatTime(chat.created_at)}</p>
                        </div>
                        <div class="message-p">
                            <p>${chat.content}</p>
                        </div>
                    </div>
                `;
                
                block.addEventListener('click', async function() {
                    if (chat.is_read == 0) {
                        await markMessagesAsRead(chat.other_user_id);
                        block.classList.remove('unread');
                        block.classList.add('raed');
                        chat.is_read = 1;
                    }

                    currentConversationId = chat.other_user_id;
                    updateChatHeader(chat.other_user_name, chat.other_user_profile_pic);
                    loadConversation(chat.other_user_id);
                });
                
                chatlist.appendChild(block);
            });
            if (defaultConversation) {
                currentConversationId = defaultConversation.other_user_id;
                updateChatHeader(defaultConversation.other_user_name, 
                               defaultConversation.other_user_profile_pic);
                loadConversation(defaultConversation.other_user_id);
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });

    const sendButton = document.getElementById('sendButton');
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && currentConversationId) {
            const content = this.value.trim();
            if (content) {
                sendMessage(content, currentConversationId);
                this.value = '';
            }
        }
    });
    sendButton.addEventListener('click', function() {
        const content = messageInput.value.trim();
        if (content && currentConversationId) {
            sendMessage(content, currentConversationId);
            messageInput.value = '';
        }
    });
});

function formatTime(dateString) {
    const date = new Date(dateString);
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
}

function updateChatHeader(username, profilePic) {
    const imgText = document.querySelector('.rightSide .imgText');
    imgText.innerHTML = `
        <div class="userImage">
            <img src="${profilePic}" alt="profile image" class="cover">
        </div>
        <h4>${username} <br><span>en ligne</span></h4>
    `;
}

function loadConversation(otherUserId) {
    currentConversationId = otherUserId;
    fetch(`fetch_conversation.php?other_user_id=${otherUserId}`)
        .then(response => response.json())
        .then(messages => {
            const chatbox = document.querySelector('.rightSide .chatbox');
            chatbox.innerHTML = '';
            
            messages.forEach(message => {
                addMessageToChatbox(message);
            });
            
            chatbox.scrollTop = chatbox.scrollHeight;
        })
        .catch(error => {
            console.error('Error fetching conversation:', error);
        });
}

function addMessageToChatbox(message) {
    const chatbox = document.querySelector('.rightSide .chatbox');
    const isMyMessage = message.sender_id == CURRENT_USER_ID;
    const messageDiv = document.createElement('div');
    messageDiv.className = isMyMessage ? 'message my-msg' : 'message friend-msg';
    
    messageDiv.innerHTML = `
        <p>${message.content} <br><span>${formatTime(message.created_at)}</span></p>
    `;
    
    chatbox.appendChild(messageDiv);
}

async function markMessagesAsRead(otherUserId) {
    try {
        const response = await fetch(`mark_as_read.php?other_user_id=${otherUserId}`);
        const result = await response.json();
        return result.success;
    } catch (error) {
        console.error('Error marking messages as read:', error);
        return false;
    }
}

async function sendMessage(content, otherUserId) {
    try {
        document.getElementById('emojiPicker').classList.remove('show');
        
        const response = await fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `other_user_id=${otherUserId}&content=${encodeURIComponent(content)}`
        });
        
        if (!response.ok) {
            throw new Error('Failed to send message');
        }
        
        const message = await response.json();
        addMessageToChatbox(message);
        updateChatListWithNewMessage(message, otherUserId);
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Failed to send message. Please try again.');
    }
}

function updateChatListWithNewMessage(message, otherUserId) {
    const chatBlocks = document.querySelectorAll('.chatlist .block');
    for (const block of chatBlocks) {
        if (block.dataset.userId === otherUserId.toString()) {
            const messagePreview = block.querySelector('.message-p p');
            if (messagePreview) {
                messagePreview.textContent = message.content;
            }
            const timeElement = block.querySelector('.time');
            if (timeElement) {
                timeElement.textContent = formatTime(message.created_at);
            }
            block.parentNode.insertBefore(block, block.parentNode.firstChild);
            break;
        }
    }
}