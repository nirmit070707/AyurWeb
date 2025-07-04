<?php
require_once 'config.php';

// Only allow logged-in users
if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

// Receive JSON data from frontend
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['dosha'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Dosha not provided']);
    exit;
}

$dosha = sanitize_input($input['dosha']);
$user_id = $_SESSION['user_id'];

if (update_user_dosha($user_id, $dosha)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update dosha']);
}
?>