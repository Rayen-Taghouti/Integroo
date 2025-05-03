<?php
$pdo = new PDO('mysql:host=localhost;dbname=integroo', 'root', '');
session_start();
$currentUserId = $_SESSION['user_id'];
$sql = "
    SELECT m1.*, 
           CASE 
             WHEN m1.sender_id = :currentUserId THEN u_receiver.username
             ELSE u_sender.username
           END AS other_user_name,
           CASE 
            WHEN m1.sender_id = :currentUserId THEN u_receiver.profile_pic
            ELSE u_sender.profile_pic
           END AS other_user_profile_pic,
           CASE 
             WHEN m1.sender_id = :currentUserId THEN m1.receiver_id
             ELSE m1.sender_id
           END AS other_user_id
    FROM messages m1
    INNER JOIN (
        SELECT 
            CASE 
              WHEN sender_id = :currentUserId THEN receiver_id
              ELSE sender_id
            END as other_user_id,
            MAX(id) as last_message_id
        FROM messages
        WHERE sender_id = :currentUserId OR receiver_id = :currentUserId
        GROUP BY other_user_id
    ) m2 ON m1.id = m2.last_message_id
    INNER JOIN users u_sender ON u_sender.id = m1.sender_id
    INNER JOIN users u_receiver ON u_receiver.id = m1.receiver_id
    ORDER BY m1.created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['currentUserId' => $currentUserId]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as &$result) {
    if (empty($result['other_user_profile_pic'])) {
        $result['other_user_profile_pic'] = 'Images/profile_rh.jpg';
    }
}
header('Content-Type: application/json');
echo json_encode($results);
?>