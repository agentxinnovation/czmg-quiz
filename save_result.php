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

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON data'
    ]);
    exit();
}

// Validate required fields
if (!isset($input['score']) || !isset($input['total_questions']) || !isset($input['time_taken'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Missing required fields'
    ]);
    exit();
}

try {
    $userId = $_SESSION['user_id'];
    $score = (int)$input['score'];
    $totalQuestions = (int)$input['total_questions'];
    $timeTaken = (int)$input['time_taken'];
    
    $result = saveQuizResult($userId, $score, $totalQuestions, $timeTaken);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Result saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to save result'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>