<?php
session_start();
require_once 'db_config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    header("HTTP/1.1 500 Internal Server Error");
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit(json_encode(['error' => 'Unauthorized']));
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("
        SELECT 
            CASE 
                WHEN m.sender_id = ? THEN m.receiver_id 
                ELSE m.sender_id 
            END as other_user_id,
            u.profile_pic as other_user_profile_pic,
            u.name as other_user_name,
            MAX(m.created_at) as last_message_time
        FROM messages m
        JOIN users u ON u.id = CASE 
                WHEN m.sender_id = ? THEN m.receiver_id 
                ELSE m.sender_id 
            END
        WHERE m.sender_id = ? OR m.receiver_id = ?
        GROUP BY other_user_id, other_user_profile_pic, other_user_name
        ORDER BY last_message_time DESC
        LIMIT 1
    ");
    $stmt->bind_param("iiii", $userId, $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $conversation = null;
    if ($result->num_rows > 0) {
        $conversation = $result->fetch_assoc();
    }

    header('Content-Type: application/json');
    echo json_encode($conversation);
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => $e->getMessage()]);
}