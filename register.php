<?php
header('Content-Type: application/json');
$host = "localhost";
$dbname = "integroo";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
if (!file_exists('uploads')) {
    mkdir('uploads', 0755, true);
}
$user = $_POST['username'];
$email = $_POST['email'];
$cin = $_POST['cin'];
$role = $_POST['role'];
$profile_pic_path = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profile_picture'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024;
    if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('profile_') . '.' . $ext;
        $destination = 'uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $profile_pic_path = $destination;
        }
    }
}
$conn->begin_transaction();
try {
    $sql = "INSERT INTO users (username, email, cin, role, profile_pic) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $user, $email, $cin, $role, $profile_pic_path);
    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de l'insertion dans users: " . $stmt->error);
    }
    $user_id = $conn->insert_id;
    $stmt->close();
    switch ($role) {
        case 'boss':
            $sql = "INSERT INTO boss (user_id, username, email, cin) VALUES (?, ?, ?, ?)";
            break;
        case 'rh_manager':
            $sql = "INSERT INTO rh_manager (user_id, username, email, cin) VALUES (?, ?, ?, ?)";
            break;
        case 'employee':
            $sql = "INSERT INTO employee (user_id, username, email, cin) VALUES (?, ?, ?, ?)";
            break;
        default:
            throw new Exception("Rôle invalide");
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $user, $email, $cin);

    if (!$stmt->execute()) {
        if ($profile_pic_path && file_exists($profile_pic_path)) {
            unlink($profile_pic_path);
        }
        throw new Exception("Erreur lors de l'insertion dans la table de rôle: " . $stmt->error);
    }
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Demande envoyée avec succès']);
} catch (Exception $e) {
    $conn->rollback();
    if ($profile_pic_path && file_exists($profile_pic_path)) {
        unlink($profile_pic_path);
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
$conn->close();