<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Set quiz start time if not already set
if (!isset($_SESSION['quiz_start_time'])) {
    $_SESSION['quiz_start_time'] = time();
}

// Get questions for this user (maintains consistent order)
$questions = getQuestionsForUser($_SESSION['user_id'], $pdo);
$totalQuestions = count($questions);

// Get current progress
$stmt = $pdo->prepare("SELECT current_question_index, score, answers FROM quiz_progress WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$progress = $stmt->fetch();

$currentIndex = $progress ? $progress['current_question_index'] : 0;
$score = $progress ? $progress['score'] : 0;
$answers = $progress ? json_decode($progress['answers'], true) : array_fill(0, $totalQuestions, null);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer'])) {
        $selectedAnswer = $_POST['answer'];
        $questionIndex = intval($_POST['question_index']);
        
        // Validate question index
        if ($questionIndex >= $totalQuestions) {
            die("Invalid question index");
        }
        
        // Save answer
        $answers[$questionIndex] = $selectedAnswer;
        
        // Check if answer is correct
        if ($selectedAnswer === $questions[$questionIndex]['correct_option']) {
            $score++;
        }
        
        $currentIndex = $questionIndex + 1;
        
        // Check if quiz is complete
        if ($currentIndex >= $totalQuestions) {
            $timeTaken = time() - $_SESSION['quiz_start_time'];
            saveFinalResult($_SESSION['user_id'], $score, $totalQuestions, $timeTaken, $pdo);
            unset($_SESSION['quiz_start_time']);
            header('Location: res.php');
            exit;
        }
        
        // Save progress
        saveProgress($_SESSION['user_id'], $currentIndex, $score, $answers, $pdo);
    }
}

if ($currentIndex >= $totalQuestions) {
    header('Location: res.php');
    exit;
}

$currentQuestion = $questions[$currentIndex];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Question <?php echo $currentIndex + 1; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Progress Bar -->
        <div class="max-w-4xl mx-auto mb-6">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Question <?php echo $currentIndex + 1; ?> of <?php echo $totalQuestions; ?></span>
                <span>Score: <?php echo $score; ?></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                     style="width: <?php echo (($currentIndex) / $totalQuestions) * 100; ?>%"></div>
            </div>
        </div>

        <!-- Question Card -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <!-- Timer -->
            <div class="text-center mb-6">
                <div id="timer" class="text-3xl font-bold text-red-600 mb-2">45</div>
                <div class="text-sm text-gray-600">seconds remaining</div>
            </div>

            <!-- Question -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        <?php echo htmlspecialchars($currentQuestion['category']); ?>
                    </span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                        <?php echo htmlspecialchars($currentQuestion['difficulty']); ?>
                    </span>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 leading-relaxed">
                    <?php echo htmlspecialchars($currentQuestion['question']); ?>
                </h2>
            </div>

            <!-- Options -->
            <form id="quizForm" method="POST" class="space-y-4">
                <input type="hidden" name="question_index" value="<?php echo $currentIndex; ?>">
                
                <?php 
                $options = ['A', 'B', 'C', 'D'];
                foreach ($options as $option): 
                    $optionKey = 'option_' . strtolower($option);
                    if (isset($currentQuestion[$optionKey])) {
                        $optionText = $currentQuestion[$optionKey];
                    } else {
                        $optionText = '';
                    }
                ?>
                <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-200">
                    <input type="radio" name="answer" value="<?php echo $option; ?>" class="mr-4 text-blue-600 focus:ring-blue-500">
                    <span class="font-medium text-gray-700 mr-3"><?php echo $option; ?>.</span>
                    <span class="text-gray-800"><?php echo htmlspecialchars($optionText); ?></span>
                </label>
                <?php endforeach; ?>

                <div class="text-center pt-6">
                    <button type="submit" id="submitBtn" disabled
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Next Question
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let timeLeft = 45;
        let timer;
        
        function startTimer() {
            timer = setInterval(function() {
                timeLeft--;
                document.getElementById('timer').textContent = timeLeft;
                
                // Change color as time runs out
                const timerEl = document.getElementById('timer');
                if (timeLeft <= 10) {
                    timerEl.className = 'text-3xl font-bold text-red-600 mb-2 animate-pulse';
                } else if (timeLeft <= 20) {
                    timerEl.className = 'text-3xl font-bold text-orange-600 mb-2';
                }
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    autoSubmit();
                }
            }, 1000);
        }
        
        function autoSubmit() {
            const form = document.getElementById('quizForm');
            const selectedOption = form.querySelector('input[name="answer"]:checked');
            
            if (!selectedOption) {
                // If no option selected, select the first one as default
                const firstOption = form.querySelector('input[name="answer"]');
                if (firstOption) {
                    firstOption.checked = true;
                }
            }
            
            form.submit();
        }
        
        // Enable submit button when option is selected
        document.querySelectorAll('input[name="answer"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('submitBtn').disabled = false;
            });
        });
        
        // Start timer when page loads
        startTimer();
        
        // Prevent back button
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>