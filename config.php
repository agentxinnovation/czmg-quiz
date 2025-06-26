<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'quiz_game');
define('DB_USER', 'root'); // Change as per your setup
define('DB_PASS', ''); // Change as per your setup

// Create database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper functions
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isValidMobile($mobile) {
    return preg_match('/^[6-9]\d{9}$/', $mobile);
}

function getUserByMobile($mobile) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE mobile = ?");
    $stmt->execute([$mobile]);
    return $stmt->fetch();
}
function createUser($name, $mobile , $school, $stream) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, mobile, school, stream) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $mobile, $school, $stream]);
}

function hasUserAttemptedQuiz($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM quiz_results WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() > 0;
}

function getQuestions() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY RAND() LIMIT 30");
    return $stmt->fetchAll();
}

function saveQuizProgress($userId, $currentIndex, $score, $answers) {
    global $pdo;
    
    // Delete existing progress for this user
    $stmt = $pdo->prepare("DELETE FROM quiz_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    // Insert new progress
    $stmt = $pdo->prepare("INSERT INTO quiz_progress (user_id, current_question_index, score, answers) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$userId, $currentIndex, $score, json_encode($answers)]);
}

function getQuizProgress($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM quiz_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function saveQuizResult($userId, $score, $totalQuestions, $timeTaken) {
    global $pdo;
    $percentage = ($score / $totalQuestions) * 100;
    
    $stmt = $pdo->prepare("INSERT INTO quiz_results (user_id, score, total_questions, percentage, time_taken) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([$userId, $score, $totalQuestions, $percentage, $timeTaken]);
    
    // Clear progress after completion
    if ($result) {
        $stmt = $pdo->prepare("DELETE FROM quiz_progress WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
    
    return $result;
}

function getTopScorers($limit = 10) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT u.name, u.mobile, qr.score, qr.total_questions, qr.percentage, qr.completed_at 
        FROM quiz_results qr 
        JOIN users u ON qr.user_id = u.id 
        ORDER BY qr.score DESC, qr.percentage DESC, qr.completed_at ASC 
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getAllQuizResults() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT u.name, u.mobile, qr.score, qr.total_questions, qr.percentage, qr.time_taken, qr.completed_at 
        FROM quiz_results qr 
        JOIN users u ON qr.user_id = u.id 
        ORDER BY qr.completed_at DESC
    ");
    return $stmt->fetchAll();
}
?>