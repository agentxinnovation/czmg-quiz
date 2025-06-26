<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'quiz_game';
$username = 'root'; // Change as needed
$password = '';     // Change as needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to check if user has already completed quiz
function hasCompletedQuiz($userId, $pdo) {
    $stmt = $pdo->prepare("SELECT id FROM quiz_results WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch() !== false;
}

// Function to get all questions in random order
function getQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY RAND()");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get questions for a specific user (maintains same order for that user's session)
function getQuestionsForUser($userId, $pdo) {
    // Check if user already has a question order stored
    $stmt = $pdo->prepare("SELECT question_order FROM quiz_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    $progress = $stmt->fetch();
    
    if ($progress && !empty($progress['question_order'])) {
        // Use existing question order
        $questionIds = json_decode($progress['question_order'], true);
        $placeholders = str_repeat('?,', count($questionIds) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE id IN ($placeholders) ORDER BY FIELD(id, " . implode(',', array_fill(0, count($questionIds), '?')) . ")");
        $stmt->execute(array_merge($questionIds, $questionIds));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Generate new random order
        $questions = getQuestions($pdo);
        $questionIds = array_column($questions, 'id');
        
        // Store the question order for this user
        if ($progress) {
            // Update existing progress with question order
            $stmt = $pdo->prepare("UPDATE quiz_progress SET question_order = ? WHERE user_id = ?");
            $stmt->execute([json_encode($questionIds), $userId]);
        } else {
            // Create new progress record with question order
            $stmt = $pdo->prepare("INSERT INTO quiz_progress (user_id, current_question_index, score, answers, question_order) VALUES (?, 0, 0, '[]', ?)");
            $stmt->execute([$userId, json_encode($questionIds)]);
        }
        
        return $questions;
    }
}

// Function to save quiz progress
function saveProgress($userId, $questionIndex, $score, $answers, $pdo) {
    $answersJson = json_encode($answers);
    
    // Check if progress exists
    $stmt = $pdo->prepare("SELECT id FROM quiz_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->fetch()) {
        // Update existing progress
        $stmt = $pdo->prepare("UPDATE quiz_progress SET current_question_index = ?, score = ?, answers = ?, updated_at = NOW() WHERE user_id = ?");
        $stmt->execute([$questionIndex, $score, $answersJson, $userId]);
    } else {
        // Insert new progress
        $stmt = $pdo->prepare("INSERT INTO quiz_progress (user_id, current_question_index, score, answers) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $questionIndex, $score, $answersJson]);
    }
}

// Function to save final result
function saveFinalResult($userId, $score, $totalQuestions, $timeTaken, $pdo) {
    $percentage = ($score / $totalQuestions) * 100;
    
    $stmt = $pdo->prepare("INSERT INTO quiz_results (user_id, score, total_questions, percentage, time_taken) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $score, $totalQuestions, $percentage, $timeTaken]);
    
    // Clear progress
    $stmt = $pdo->prepare("DELETE FROM quiz_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
}
?>