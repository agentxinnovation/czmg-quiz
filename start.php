<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = trim($_POST['name']);
$mobile = trim($_POST['mobile']);
$school = trim($_POST['school']);
$stream = trim($_POST['stream']);

// Validate input
if (empty($name) || empty($mobile) || empty($school) || empty($stream)) {
    header('Location: index.php?error=Please fill all fields');
    exit;
}

// Check if user already exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE mobile = ?");
$stmt->execute([$mobile]);
$existingUser = $stmt->fetch();

if ($existingUser) {
    // Check if user has already completed quiz
    if (hasCompletedQuiz($existingUser['id'], $pdo)) {
        $error = "You have already completed the quiz. Only one attempt is allowed.";
        include 'error.php';
        exit;
    }
    
    $userId = $existingUser['id'];
} else {
    // Create new user
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, mobile, school, stream) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $mobile, $school, $stream]);
        $userId = $pdo->lastInsertId();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            $error = "A user with this mobile number already exists.";
            include 'error.php';
            exit;
        }
        throw $e;
    }
}

// Store user info in session
$_SESSION['user_id'] = $userId;
$_SESSION['user_name'] = $name;
$_SESSION['quiz_start_time'] = time();

// Redirect to quiz rules
header('Location: rules.php');
exit;
?>