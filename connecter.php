<?php
session_start();

$host = "localhost";
$dbname = "integroo";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
$login_username = $_POST['username'];
$login_password = $_POST['password'];
$sql = "SELECT id, username, role FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login_username, $login_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    switch ($user['role']) {
        case 'boss':
            header("Location: dashbord_boss.php");
            break;
        case 'rh_manager':
            header("Location: dashbord_rh.php");
            break;
        case 'employee':
            header("Location: dashbord_employee.php");
            break;
        default:
            header("Location: login_signup.php?error=invalid_role");
            break;
    }
    exit();
} else {
    header("Location: login_signup.php?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>