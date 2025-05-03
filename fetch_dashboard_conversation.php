<?php
$pdo = new PDO('mysql:host=localhost;dbname=integroo', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit(json_encode(['error' => 'Unauthorized access']));
}

$currentUserId = $_SESSION['user_id'];

try {
    // Get the most recent conversation summary for each chat partner
    $sql = "
        SELECT 
            m.id,
            CASE 
                WHEN m.sender_id = :currentUserId THEN m.receiver_id 
                ELSE m.sender_id 
            END AS other_user_id,
            CASE 
                WHEN m.sender_id = :currentUserId THEN u_receiver.username
                ELSE u_sender.username
            END AS other_user_name,
            CASE 
                WHEN m.sender_id = :currentUserId THEN u_receiver.profile_pic
                ELSE u_sender.profile_pic
            END AS other_user_profile_pic,
            m.content AS last_message,
            m.created_at AS last_message_time,
            m.is_read
        FROM messages m
        JOIN users u_sender ON u_sender.id = m.sender_id
        JOIN users u_receiver ON u_receiver.id = m.receiver_id
        WHERE m.id IN (
            SELECT MAX(id) 
            FROM messages 
            WHERE sender_id = :currentUserId OR receiver_id = :currentUserId
            GROUP BY 
                CASE 
                    WHEN sender_id = :currentUserId THEN receiver_id 
                    ELSE sender_id 
                END
        )
        ORDER BY m.created_at DESC
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['currentUserId' => $currentUserId]);
    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$conversation) {
        header("HTTP/1.1 404 Not Found");
        exit(json_encode(['info' => 'No conversations found']));
    }

    // Set default profile picture if empty
    if (empty($conversation['other_user_profile_pic'])) {
        $conversation['other_user_profile_pic'] = 'Images/profile_rh.jpg';
    }

    header('Content-Type: application/json');
    echo json_encode($conversation);

} catch (PDOException $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
?>