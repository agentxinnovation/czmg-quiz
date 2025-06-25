<?php
session_start();
require_once './config.php';

// Set JSON response header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'User not authenticated'
    ]);
    exit();
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
    exit();
}

try {
    global $pdo;
    $userId = $_SESSION['user_id'];
    
    // Clear quiz progress for the user
    $stmt = $pdo->prepare("DELETE FROM quiz_progress WHERE user_id = ?");
    $result = $stmt->execute([$userId]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Progress cleared successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to clear progress'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>