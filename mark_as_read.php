<?php
$pdo = new PDO('mysql:host=localhost;dbname=integroo', 'root', '');
session_start();
$currentUserId = $_SESSION['user_id'];
$otherUserId = $_GET['other_user_id'] ?? 0;

// Mark all messages from this conversation as read
$sql = "UPDATE messages SET is_read = 1 
        WHERE receiver_id = :currentUserId 
        AND sender_id = :otherUserId
        AND is_read = 0";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'currentUserId' => $currentUserId,
    'otherUserId' => $otherUserId
]);

// Return updated conversation data
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>