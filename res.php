<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get user result
$stmt = $pdo->prepare("
    SELECT qr.*, u.name, u.mobile, u.school, u.stream 
    FROM quiz_results qr 
    JOIN users u ON qr.user_id = u.id 
    WHERE qr.user_id = ? 
    ORDER BY qr.completed_at DESC 
    LIMIT 1
");
$stmt->execute([$_SESSION['user_id']]);
$result = $stmt->fetch();

if (!$result) {
    header('Location: index.php');
    exit;
}

// Calculate performance level
$percentage = $result['percentage'];
if ($percentage >= 80) {
    $performance = ['level' => 'Excellent', 'color' => 'green', 'message' => 'Outstanding performance!'];
} elseif ($percentage >= 60) {
    $performance = ['level' => 'Good', 'color' => 'blue', 'message' => 'Well done!'];
} elseif ($percentage >= 40) {
    $performance = ['level' => 'Average', 'color' => 'yellow', 'message' => 'Keep practicing!'];
} else {
    $performance = ['level' => 'Needs Improvement', 'color' => 'red', 'message' => 'Don\'t give up!'];
}

// Format time taken
$minutes = floor($result['time_taken'] / 60);
$seconds = $result['time_taken'] % 60;
$timeFormatted = sprintf("%d:%02d", $minutes, $seconds);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Result Card -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="text-center mb-8">
                    <div class="w-24 h-24 mx-auto mb-4 bg-<?php echo $performance['color']; ?>-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-<?php echo $performance['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if ($percentage >= 60): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            <?php endif; ?>
                        </svg>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Quiz Completed!</h1>
                    <p class="text-lg text-<?php echo $performance['color']; ?>-600 font-semibold">
                        <?php echo $performance['level']; ?>
                    </p>
                    <p class="text-gray-600"><?php echo $performance['message']; ?></p>
                </div>

                <!-- Score Display -->
                <div class="text-center mb-8">
                    <div class="inline-block bg-<?php echo $performance['color']; ?>-50 rounded-lg p-6">
                        <div class="text-4xl font-bold text-<?php echo $performance['color']; ?>-600 mb-2">
                            <?php echo number_format($percentage, 1); ?>%
                        </div>
                        <div class="text-gray-600">
                            <?php echo $result['score']; ?> out of <?php echo $result['total_questions']; ?> correct
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Participant Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Name:</span>
                            <span class="ml-2 text-gray-800"><?php echo htmlspecialchars($result['name']); ?></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Mobile:</span>
                            <span class="ml-2 text-gray-800"><?php echo htmlspecialchars($result['mobile']); ?></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">School:</span>
                            <span class="ml-2 text-gray-800"><?php echo htmlspecialchars($result['school']); ?></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Stream:</span>
                            <span class="ml-2 text-gray-800"><?php echo htmlspecialchars($result['stream']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Quiz Stats -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600"><?php echo $timeFormatted; ?></div>
                        <div class="text-sm text-gray-600">Time Taken</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600"><?php echo $result['score']; ?></div>
                        <div class="text-sm text-gray-600">Correct Answers</div>
                    </div>
                </div>

                <!-- Completion Date -->
                <div class="text-center text-sm text-gray-500 mb-6">
                    Completed on <?php echo date('F j, Y \a\t g:i A', strtotime($result['completed_at'])); ?>
                </div>

                <!-- Actions -->
                <!-- <div class="text-center">
                    <a href="logout.php" 
                       class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200">
                        Logout & Exit
                    </a>
                </div> -->
            </div>

            <!-- Note -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Important:</strong> You have completed the quiz and cannot retake it. This is your final score.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>