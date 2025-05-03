<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}
require_once 'db_config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    http_response_code(500);
    exit(json_encode(['error' => 'Database connection failed']));
}
$user_id = $_SESSION['user_id'];
try {
    $tasks = [
        'pending' => 0,
        'completed' => 0,
        'total' => 0
    ];
    $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM tasks WHERE user_id = ? GROUP BY status");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tasks[$row['status']] = (int)$row['count'];
        $tasks['total'] += (int)$row['count'];
    }
    $stmt->close();
    $quizzes = [
        'pending' => 0,
        'completed' => 0,
        'total' => 0
    ];
    $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM quizzes WHERE user_id = ? GROUP BY status");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $quizzes[$row['status']] = (int)$row['count'];
        $quizzes['total'] += (int)$row['count'];
    }
    $stmt->close();
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = FALSE");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $unread_messages = $result->fetch_assoc()['count'];
    $stmt->close();
    $task_completion = $tasks['total'] > 0 ? round(($tasks['completed'] / $tasks['total']) * 100) : 0;
    $quiz_completion = $quizzes['total'] > 0 ? round(($quizzes['completed'] / $quizzes['total']) * 100) : 0;
    echo json_encode([
        'success' => true,
        'data' => [
            'tasks' => [
                'pending' => $tasks['pending'],
                'completed' => $tasks['completed'],
                'completion' => $task_completion
            ],
            'quizzes' => [
                'pending' => $quizzes['pending'],
                'completed' => $quizzes['completed'],
                'completion' => $quiz_completion
            ],
            'messages' => [
                'unread' => $unread_messages
            ]
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>