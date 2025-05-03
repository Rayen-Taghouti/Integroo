<?php
header('Content-Type: application/json');

// Check if request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (
        isset($data['content'], $data['sender_id'], $data['receiver_id'], $data['is_read']) &&
        !empty(trim($data['content'])) &&
        is_numeric($data['sender_id']) &&
        is_numeric($data['receiver_id'])
    ) {
        $content = trim($data['content']);
        $sender_id = intval($data['sender_id']);
        $receiver_id = intval($data['receiver_id']);
        $is_read = intval($data['is_read']);

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'integroo');

        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
            exit;
        }

        // Save message to DB
        $stmt = $conn->prepare("INSERT INTO messages (content, sender_id, receiver_id, is_read) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $content, $sender_id, $receiver_id, $is_read);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Message saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save message']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}