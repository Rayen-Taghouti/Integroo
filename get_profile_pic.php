<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    header('Content-Type: application/json');
}
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['success' => false, 'profile_pic' => 'Images/default_profile.jpg']));
}
$conn = new mysqli('localhost', 'root', '', 'integroo');

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    exit(json_encode(['success' => false, 'profile_pic' => 'Images/default_profile.jpg']));
}

try {
    $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $profile_pic = 'Images/default_profile.jpg';
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (!empty($user['profile_pic']) && file_exists($user['profile_pic'])) {
            $profile_pic = $user['profile_pic'];
        }
    }
    
    echo json_encode(['success' => true, 'profile_pic' => $profile_pic]);
    
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'profile_pic' => 'Images/default_profile.jpg']);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>