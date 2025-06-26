<?php
session_start();

// Clear all session data
session_unset();
session_destroy();

// Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - Quiz Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="3;url=index.php">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Successfully Logged Out</h1>
            <p class="text-gray-600 mb-6">Thank you for participating in the quiz!</p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    You will be redirected to the home page in <span id="countdown">3</span> seconds...
                </p>
            </div>
            
            <a href="index.php" 
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                Go to Home Page
            </a>
        </div>
    </div>

    <script>
        let count = 3;
        const countdownEl = document.getElementById('countdown');
        
        const timer = setInterval(function() {
            count--;
            countdownEl.textContent = count;
            
            if (count <= 0) {
                clearInterval(timer);
                window.location.href = 'index.php';
            }
        }, 1000);
    </script>
</body>
</html>