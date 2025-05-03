<?php
$pdo = new PDO('mysql:host=localhost;dbname=integroo', 'root', '');
session_start();
$currentUserId = $_SESSION['user_id'];
$otherUserId = $_GET['other_user_id'] ?? 0;

$sql = "
    SELECT m.*, 
           u_sender.username as sender_name,
           u_sender.profile_pic as sender_profile_pic,
           u_receiver.username as receiver_name,
           u_receiver.profile_pic as receiver_profile_pic
    FROM messages m
    JOIN users u_sender ON u_sender.id = m.sender_id
    JOIN users u_receiver ON u_receiver.id = m.receiver_id
    WHERE (m.sender_id = :currentUserId AND m.receiver_id = :otherUserId)
       OR (m.sender_id = :otherUserId AND m.receiver_id = :currentUserId)
    ORDER BY m.created_at ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'currentUserId' => $currentUserId,
    'otherUserId' => $otherUserId
]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
?>