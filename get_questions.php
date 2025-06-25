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
    // Get questions from database
    $questions = getQuestions();
    
    if (empty($questions)) {
        echo json_encode([
            'success' => false,
            'error' => 'No questions found in database'
        ]);
        exit();
    }
    
    // Return questions
    echo json_encode([
        'success' => true,
        'questions' => $questions,
        'count' => count($questions)
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>