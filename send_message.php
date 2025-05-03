<?php
$pdo = new PDO('mysql:host=localhost;dbname=integroo', 'root', '');
session_start();

$currentUserId = $_SESSION['user_id'];
$otherUserId = $_POST['other_user_id'] ?? 0;
$content = $_POST['content'] ?? '';

if (empty($content)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Message content is required']);
    exit();
}

// Insert the new message
$sql = "INSERT INTO messages (sender_id, receiver_id, content, is_read, created_at) 
        VALUES (:sender_id, :receiver_id, :content, 1, NOW())";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    'sender_id' => $currentUserId,
    'receiver_id' => $otherUserId,
    'content' => $content
]);

if ($result) {
    // Return the newly created message
    $messageId = $pdo->lastInsertId();
    $sql = "SELECT m.*, 
                   u.username as sender_name,
                   u.profile_pic as sender_profile_pic
            FROM messages m
            JOIN users u ON u.id = m.sender_id
            WHERE m.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$messageId]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($message);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to send message']);
}
?>