<?php
session_start();
require_once './config.php';

// Function to safely destroy session
function destroySession() {
    // Unset all session variables
    $_SESSION = array();
    
    // Delete the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
}

// Function to clear quiz-related cookies
function clearQuizCookies() {
    // Clear the quiz user mobile cookie
    if (isset($_COOKIE['quiz_user_mobile'])) {
        setcookie('quiz_user_mobile', '', time() - 3600, '/');
        unset($_COOKIE['quiz_user_mobile']);
    }
    
    // Clear any other quiz-related cookies
    $cookiesToClear = [
        'quiz_user_id',
        'quiz_session',
        'quiz_progress',
        'quiz_started'
    ];
    
    foreach ($cookiesToClear as $cookieName) {
        if (isset($_COOKIE[$cookieName])) {
            setcookie($cookieName, '', time() - 3600, '/');
            unset($_COOKIE[$cookieName]);
        }
    }
}

// Function to clear user progress from database
function clearUserProgress() {
    global $pdo;
    
    try {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            
            // Clear quiz progress
            $stmt = $pdo->prepare("DELETE FROM quiz_progress WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // Optionally, you might want to keep quiz results but clear progress
            // If you want to clear results too, uncomment the line below:
            // $stmt = $pdo->prepare("DELETE FROM quiz_results WHERE user_id = ?");
            // $stmt->execute([$userId]);
            
            return true;
        }
    } catch (PDOException $e) {
        error_log("Error clearing user progress: " . $e->getMessage());
        return false;
    }
    
    return false;
}

// Handle different logout scenarios
$logoutType = isset($_GET['type']) ? $_GET['type'] : 'full';
$redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

// Validate redirect URL to prevent open redirect attacks
$allowedRedirects = ['index.php', 'admin.php', '/'];
if (!in_array($redirectUrl, $allowedRedirects)) {
    $redirectUrl = 'index.php';
}

switch ($logoutType) {
    case 'session_only':
        // Only destroy session, keep cookies
        destroySession();
        $message = "Session cleared successfully.";
        break;
        
    case 'cookies_only':
        // Only clear cookies, keep session
        clearQuizCookies();
        $message = "Quiz data cleared successfully.";
        break;
        
    case 'progress_only':
        // Only clear quiz progress from database
        if (clearUserProgress()) {
            $message = "Quiz progress cleared successfully.";
        } else {
            $message = "Failed to clear quiz progress.";
        }
        break;
        
    case 'full':
    default:
        // Full logout - clear everything
        clearUserProgress();
        clearQuizCookies();
        destroySession();
        $message = "Logged out successfully.";
        break;
}

// Handle AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => $message,
        'redirect' => $redirectUrl
    ]);
    exit();
}

// Handle form submission with confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_logout'])) {
    // Set a success message in session for next page load
    session_start();
    $_SESSION['logout_message'] = $message;
    
    // Redirect after logout
    redirect($redirectUrl);
}

// If accessed directly via GET, show confirmation page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Quiz Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 text-center">
                <div class="text-6xl mb-6">🚪</div>
                <h1 class="text-3xl font-bold text-white mb-6">Confirm Logout</h1>
                
                <div class="bg-white/5 rounded-2xl p-6 mb-8">
                    <p class="text-gray-300 mb-4">
                        <?php
                        switch ($logoutType) {
                            case 'session_only':
                                echo "This will end your current session but keep your quiz data.";
                                break;
                            case 'cookies_only':
                                echo "This will clear your saved quiz data but keep your session active.";
                                break;
                            case 'progress_only':
                                echo "This will clear your quiz progress from the database.";
                                break;
                            case 'full':
                            default:
                                echo "This will clear all your quiz data and end your session.";
                                break;
                        }
                        ?>
                    </p>
                    <p class="text-gray-400 text-sm">Are you sure you want to continue?</p>
                </div>
                
                <div class="space-y-4">
                    <form method="POST" class="inline">
                        <input type="hidden" name="confirm_logout" value="1">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Yes, Logout
                        </button>
                    </form>
                    
                    <a href="<?php echo htmlspecialchars($redirectUrl); ?>" 
                       class="block w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                        Cancel
                    </a>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-gray-400 text-sm">
                        <a href="index.php" class="text-blue-400 hover:text-blue-300">← Back to Quiz</a>
                        <?php if ($logoutType === 'full'): ?>
                            | <a href="admin.php" class="text-purple-400 hover:text-purple-300">Admin Panel</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-logout after 5 minutes of inactivity on this page
        let inactivityTimer;
        
        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                window.location.href = 'index.php';
            }, 300000); // 5 minutes
        }
        
        // Reset timer on user activity
        document.addEventListener('click', resetInactivityTimer);
        document.addEventListener('keypress', resetInactivityTimer);
        document.addEventListener('mousemove', resetInactivityTimer);
        
        // Initialize timer
        resetInactivityTimer();
        
        // AJAX logout function (can be called from JavaScript)
        function performLogout(type = 'full', redirect = 'index.php') {
            fetch(`logout.php?type=${type}&redirect=${redirect}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Redirect after delay
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showMessage('Logout failed. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                showMessage('An error occurred during logout.', 'error');
            });
        }
        
        function showMessage(message, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 px-6 py-3 rounded-lg font-semibold text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            messageDiv.textContent = message;
            
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 3000);
        }
    </script>
</body>
</html>