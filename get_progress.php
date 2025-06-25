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

try {
    $userId = $_SESSION['user_id'];
    $progress = getQuizProgress($userId);
    
    if ($progress) {
        echo json_encode([
            'success' => true,
            'progress' => $progress
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No progress found'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>