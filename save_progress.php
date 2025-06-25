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
if (!isset($input['current_question_index']) || !isset($input['score']) || !isset($input['answers'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Missing required fields'
    ]);
    exit();
}

try {
    $userId = $_SESSION['user_id'];
    $currentIndex = (int)$input['current_question_index'];
    $score = (int)$input['score'];
    $answers = $input['answers'];
    
    $result = saveQuizProgress($userId, $currentIndex, $score, $answers);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Progress saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to save progress'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>