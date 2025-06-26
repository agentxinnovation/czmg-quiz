<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Check if user has already completed quiz
if (hasCompletedQuiz($_SESSION['user_id'], $pdo)) {
    header('Location: res.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Rules</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <p class="text-lg text-gray-600">Ready to start the quiz?</p>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-yellow-800 mb-3">Quiz Rules & Instructions</h3>
                        <ul class="list-disc list-inside text-yellow-700 space-y-2">
                            <li><strong>Time Limit:</strong> You have 45 seconds for each question</li>
                            <li><strong>Total Questions:</strong> 30 questions covering General Knowledge and Computer Science</li>
                            <li><strong>One Attempt Only:</strong> You can only take this quiz once</li>
                            <li><strong>Auto Submit:</strong> Questions will auto-submit when time runs out</li>
                            <li><strong>No Going Back:</strong> You cannot return to previous questions</li>
                            <li><strong>Stay Focused:</strong> Closing the browser will end your quiz</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">Question Categories:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded border">
                        <h4 class="font-medium text-gray-800">General Knowledge</h4>
                        <p class="text-sm text-gray-600">History, Geography, Current Affairs</p>
                    </div>
                    <div class="bg-white p-4 rounded border">
                        <h4 class="font-medium text-gray-800">Computer Science</h4>
                        <p class="text-sm text-gray-600">Programming, Networks, Hardware</p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <form action="quiz.php" method="POST">
                    <button type="submit" 
                            class="bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                        Let's Start Quiz!
                    </button>
                </form>
                
                <p class="mt-4 text-sm text-gray-500">
                    Make sure you have a stable internet connection
                </p>
            </div>
        </div>
    </div>
</body>
</html>