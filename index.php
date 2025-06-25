<?php
session_start();
require_once './config.php';

// Check if user is already registered and attempted quiz
$userAttempted = false;
$userData = null;

if (isset($_COOKIE['quiz_user_mobile'])) {
    $userData = getUserByMobile($_COOKIE['quiz_user_mobile']);
    if ($userData) {
        $userAttempted = hasUserAttemptedQuiz($userData['id']);
    }
}

// Handle user registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = sanitize($_POST['name']);
    $mobile = sanitize($_POST['mobile']);

    if (empty($name) || empty($mobile)) {
        $error = "Please fill in all fields.";
    } elseif (!isValidMobile($mobile)) {
        $error = "Please enter a valid 10-digit mobile number.";
    } else {
        // Check if user already exists
        $existingUser = getUserByMobile($mobile);
        if ($existingUser) {
            // Check if this user has already attempted the quiz
            if (hasUserAttemptedQuiz($existingUser['id'])) {
                $error = "This mobile number has already been used to attempt the quiz.";
            } else {
                // User exists but hasn't attempted, set cookie and proceed
                setcookie('quiz_user_mobile', $mobile, time() + (86400 * 30), '/'); // 30 days
                $_SESSION['user_id'] = $existingUser['id'];
                $userData = $existingUser;
            }
        } else {
            // Create new user
            if (createUser($name, $mobile)) {
                $newUser = getUserByMobile($mobile);
                setcookie('quiz_user_mobile', $mobile, time() + (86400 * 30), '/'); // 30 days
                $_SESSION['user_id'] = $newUser['id'];
                $userData = $newUser;
            } else {
                $error = "Failed to register user. Please try again.";
            }
        }
    }
}

// Check for existing progress
$hasProgress = false;
if ($userData && !$userAttempted) {
    $progress = getQuizProgress($userData['id']);
    $hasProgress = ($progress !== false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .timer-warning {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">

        <?php if (!$userData || $userAttempted): ?>
            <!-- Registration/Already Attempted Screen -->
            <div id="registrationScreen" class="max-w-2xl mx-auto text-center">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <h1 class="text-5xl font-bold text-white mb-6 bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        🧠 Quiz Master
                    </h1>

                    <?php if ($userAttempted): ?>
                        <div class="bg-red-500/20 border border-red-500/30 rounded-2xl p-6 mb-8">
                            <div class="text-6xl mb-4">🚫</div>
                            <h3 class="text-2xl font-semibold text-white mb-4">Quiz Already Attempted</h3>
                            <p class="text-gray-300">You have already completed the quiz with this mobile number.</p>
                            <p class="text-gray-400 mt-2">Each user gets only one chance to attempt the quiz.</p>
                        </div>
                    <?php else: ?>
                        <p class="text-xl text-gray-200 mb-8">Enter your details to start the quiz!</p>

                        <?php if (isset($error)): ?>
                            <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-6">
                                <p class="text-red-300"><?php echo $error; ?></p>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="bg-white/5 rounded-2xl p-6 mb-8">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-white text-sm font-medium mb-2">Full Name</label>
                                    <input type="text" name="name" required
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-white text-sm font-medium mb-2">Mobile Number</label>
                                    <input type="tel" name="mobile" required pattern="[6-9][0-9]{9}" maxlength="10"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter 10-digit mobile number">
                                </div>
                            </div>
                            <button type="submit" name="register"
                                class="w-full mt-6 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-full text-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Register & Start Quiz 🚀
                            </button>
                        </form>

                        <div class="bg-white/5 rounded-2xl p-6">
                            <h3 class="text-2xl font-semibold text-white mb-4">Game Rules</h3>
                            <ul class="text-gray-300 space-y-2">
                                <li>🕐 30 seconds per question</li>
                                <li>📝 30 multiple choice questions</li>
                                <li>🎯 Choose the best answer</li>
                                <li>🏆 See your final score at the end</li>
                                <li>⚠️ Only one attempt per mobile number</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>

            <!-- Start Screen -->
            <div id="startScreen" class="max-w-2xl mx-auto text-center">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <h1 class="text-5xl font-bold text-white mb-6 bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        🧠 Quiz Master
                    </h1>
                    <div class="bg-white/5 rounded-2xl p-6 mb-8">
                        <h3 class="text-xl font-semibold text-white mb-3">Welcome, <?php echo htmlspecialchars($userData['name']); ?>!</h3>
                        <p class="text-gray-300">Mobile: <?php echo htmlspecialchars($userData['mobile']); ?></p>
                    </div>

                    <?php if ($hasProgress): ?>
                        <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-2xl p-6 mb-8">
                            <div class="text-4xl mb-4">⏸️</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Resume Quiz</h3>
                            <p class="text-gray-300">You have an incomplete quiz. You can resume from where you left off.</p>
                        </div>
                        <button id="resumeBtn" class="bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white font-bold py-4 px-8 rounded-full text-xl transition-all duration-300 transform hover:scale-105 shadow-lg mr-4">
                            Resume Quiz 🚀
                        </button>
                        <button id="restartBtn" class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-4 px-8 rounded-full text-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Start Fresh 🔄
                        </button>
                    <?php else: ?>
                        <div class="bg-white/5 rounded-2xl p-6 mb-8">
                            <h3 class="text-2xl font-semibold text-white mb-4">Game Rules</h3>
                            <ul class="text-gray-300 space-y-2">
                                <li>🕐 30 seconds per question</li>
                                <li>📝 30 multiple choice questions</li>
                                <li>🎯 Choose the best answer</li>
                                <li>🏆 See your final score at the end</li>
                            </ul>
                        </div>
                        <button id="startBtn" class="bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-full text-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Start Quiz 🚀
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quiz Screen -->
            <div id="quizScreen" class="max-w-4xl mx-auto hidden">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-8">
                        <div class="text-white">
                            <span class="text-lg">Question <span id="currentQuestion" class="font-bold text-yellow-400">1</span> of <span class="font-bold">30</span></span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-white">
                                <span class="text-lg">Score: <span id="currentScore" class="font-bold text-green-400">0</span></span>
                            </div>
                            <div id="timer" class="bg-red-500 text-white px-4 py-2 rounded-full font-bold text-lg min-w-[80px] text-center">
                                30
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-600 rounded-full h-3 mb-8">
                        <div id="progressBar" class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full transition-all duration-500" style="width: 3.33%"></div>
                    </div>

                    <!-- Question -->
                    <div class="mb-8">
                        <h2 id="questionText" class="text-2xl font-semibold text-white mb-6 leading-relaxed">
                            Loading question...
                        </h2>
                    </div>

                    <!-- Options -->
                    <div id="optionsContainer" class="space-y-4">
                        <!-- Options will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Results Screen -->
            <div id="resultScreen" class="max-w-2xl mx-auto text-center hidden">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <div id="resultIcon" class="text-8xl mb-6">🎉</div>
                    <h2 class="text-4xl font-bold text-white mb-4">Quiz Complete!</h2>
                    <div class="bg-white/5 rounded-2xl p-6 mb-8">
                        <p class="text-2xl text-gray-200 mb-4">Your Score</p>
                        <p id="finalScore" class="text-6xl font-bold text-yellow-400 mb-2">0/30</p>
                        <p id="percentage" class="text-xl text-gray-300">0%</p>
                        <p id="resultMessage" class="text-lg text-gray-300 mt-4"></p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-400">Thank you for participating!</p>
                        <p class="text-gray-500 mt-2">Your result has been saved.</p>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
    <div class="text-center mt-8 text-gray-500 text-sm">
        Made by Harsh Raithatha
    </div>
    <script>
        // Quiz Game JavaScript - Complete Implementation
        class QuizGame {
            constructor() {
                this.questions = [];
                this.currentQuestionIndex = 0;
                this.score = 0;
                this.timeLeft = 30;
                this.timer = null;
                this.userAnswers = [];
                this.quizStartTime = null;
                this.userId = null;
                this.isResuming = false;

                this.initializeElements();
                this.bindEvents();
                this.loadQuestions();
            }

            initializeElements() {
                // Screen elements
                this.startScreen = document.getElementById('startScreen');
                this.quizScreen = document.getElementById('quizScreen');
                this.resultScreen = document.getElementById('resultScreen');

                // Button elements
                this.startBtn = document.getElementById('startBtn');
                this.resumeBtn = document.getElementById('resumeBtn');
                this.restartBtn = document.getElementById('restartBtn');

                // Quiz elements
                this.currentQuestionEl = document.getElementById('currentQuestion');
                this.currentScoreEl = document.getElementById('currentScore');
                this.timerEl = document.getElementById('timer');
                this.progressBar = document.getElementById('progressBar');
                this.questionText = document.getElementById('questionText');
                this.optionsContainer = document.getElementById('optionsContainer');

                // Result elements
                this.resultIcon = document.getElementById('resultIcon');
                this.finalScore = document.getElementById('finalScore');
                this.percentage = document.getElementById('percentage');
                this.resultMessage = document.getElementById('resultMessage');
            }

            bindEvents() {
                if (this.startBtn) {
                    this.startBtn.addEventListener('click', () => this.startQuiz());
                }

                if (this.resumeBtn) {
                    this.resumeBtn.addEventListener('click', () => this.resumeQuiz());
                }

                if (this.restartBtn) {
                    this.restartBtn.addEventListener('click', () => this.restartQuiz());
                }

                // Prevent page refresh/close during quiz
                window.addEventListener('beforeunload', (e) => {
                    if (this.quizScreen && !this.quizScreen.classList.contains('hidden')) {
                        e.preventDefault();
                        e.returnValue = '';
                        return '';
                    }
                });

                // Handle visibility change (tab switch)
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden && this.timer) {
                        // User switched tab during quiz - handle as needed
                        console.log('User switched tab during quiz');
                    }
                });
            }

            async loadQuestions() {
                try {
                    const response = await fetch('get_questions.php');
                    const data = await response.json();

                    if (data.success) {
                        this.questions = data.questions;
                        console.log(`Loaded ${this.questions.length} questions`);
                    } else {
                        console.error('Failed to load questions:', data.error);
                        this.showError('Failed to load questions. Please refresh the page.');
                    }
                } catch (error) {
                    console.error('Error loading questions:', error);
                    this.showError('Network error. Please check your connection.');
                }
            }

            async startQuiz() {
                this.quizStartTime = Date.now();
                this.currentQuestionIndex = 0;
                this.score = 0;
                this.userAnswers = [];
                this.isResuming = false;

                await this.initializeQuiz();
            }

            async resumeQuiz() {
                this.isResuming = true;
                try {
                    const response = await fetch('get_progress.php');
                    const data = await response.json();

                    if (data.success && data.progress) {
                        this.currentQuestionIndex = parseInt(data.progress.current_question_index) || 0;
                        this.score = parseInt(data.progress.score) || 0;
                        this.userAnswers = data.progress.answers ? JSON.parse(data.progress.answers) : [];

                        console.log('Resuming quiz from question', this.currentQuestionIndex + 1);
                        await this.initializeQuiz();
                    } else {
                        console.error('Failed to load progress:', data.error);
                        await this.startQuiz(); // Fallback to fresh start
                    }
                } catch (error) {
                    console.error('Error loading progress:', error);
                    await this.startQuiz(); // Fallback to fresh start
                }
            }

            async restartQuiz() {
                if (confirm('Are you sure you want to start fresh? Your current progress will be lost.')) {
                    try {
                        await fetch('clear_progress.php', {
                            method: 'POST'
                        });
                        await this.startQuiz();
                    } catch (error) {
                        console.error('Error clearing progress:', error);
                        await this.startQuiz();
                    }
                }
            }

            async initializeQuiz() {
                if (this.questions.length === 0) {
                    this.showError('No questions available. Please contact administrator.');
                    return;
                }

                this.showScreen('quiz');
                this.updateQuizDisplay();
                this.displayCurrentQuestion();
                this.startTimer();
            }

            showScreen(screen) {
                // Hide all screens
                if (this.startScreen) this.startScreen.classList.add('hidden');
                if (this.quizScreen) this.quizScreen.classList.add('hidden');
                if (this.resultScreen) this.resultScreen.classList.add('hidden');

                // Show target screen
                switch (screen) {
                    case 'start':
                        if (this.startScreen) this.startScreen.classList.remove('hidden');
                        break;
                    case 'quiz':
                        if (this.quizScreen) this.quizScreen.classList.remove('hidden');
                        break;
                    case 'result':
                        if (this.resultScreen) this.resultScreen.classList.remove('hidden');
                        break;
                }
            }

            updateQuizDisplay() {
                const questionNumber = this.currentQuestionIndex + 1;
                const totalQuestions = Math.min(this.questions.length, 30);

                if (this.currentQuestionEl) {
                    this.currentQuestionEl.textContent = questionNumber;
                }

                if (this.currentScoreEl) {
                    this.currentScoreEl.textContent = this.score;
                }

                if (this.progressBar) {
                    const progress = (questionNumber / totalQuestions) * 100;
                    this.progressBar.style.width = `${progress}%`;
                }
            }

            displayCurrentQuestion() {
                if (this.currentQuestionIndex >= this.questions.length || this.currentQuestionIndex >= 30) {
                    this.completeQuiz();
                    return;
                }

                const question = this.questions[this.currentQuestionIndex];

                if (this.questionText) {
                    this.questionText.textContent = question.question;
                }

                this.displayOptions(question);
                this.resetTimer();
            }

            displayOptions(question) {
                if (!this.optionsContainer) return;

                this.optionsContainer.innerHTML = '';

                const options = [{
                        letter: 'A',
                        text: question.option_a
                    },
                    {
                        letter: 'B',
                        text: question.option_b
                    },
                    {
                        letter: 'C',
                        text: question.option_c
                    },
                    {
                        letter: 'D',
                        text: question.option_d
                    }
                ];

                options.forEach((option, index) => {
                    const optionElement = document.createElement('button');
                    optionElement.className = 'w-full text-left p-4 bg-white/5 hover:bg-white/10 border border-white/20 rounded-lg text-white transition-all duration-200 hover:scale-105 hover:border-white/40';
                    optionElement.innerHTML = `
                <span class="inline-block w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full text-center leading-8 font-bold mr-4">
                    ${option.letter}
                </span>
                <span class="text-lg">${option.text}</span>
            `;

                    optionElement.addEventListener('click', () => this.selectOption(option.letter, optionElement));
                    this.optionsContainer.appendChild(optionElement);
                });
            }

            async selectOption(selectedOption, optionElement) {
                // Disable all options
                const allOptions = this.optionsContainer.querySelectorAll('button');
                allOptions.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.remove('hover:bg-white/10', 'hover:scale-105', 'hover:border-white/40');
                });

                // Highlight selected option
                optionElement.classList.add('bg-blue-500/30', 'border-blue-400');

                // Stop timer
                this.stopTimer();

                // Check if answer is correct
                const currentQuestion = this.questions[this.currentQuestionIndex];
                const isCorrect = selectedOption === currentQuestion.correct_option;

                if (isCorrect) {
                    this.score++;
                    optionElement.classList.add('bg-green-500/30', 'border-green-400');
                    this.showFeedback('Correct! 🎉', 'success');
                } else {
                    optionElement.classList.add('bg-red-500/30', 'border-red-400');

                    // Highlight correct answer
                    const correctOption = currentQuestion.correct_option;
                    const correctIndex = ['A', 'B', 'C', 'D'].indexOf(correctOption);
                    if (correctIndex !== -1) {
                        allOptions[correctIndex].classList.add('bg-green-500/30', 'border-green-400');
                    }
                    this.showFeedback('Incorrect! 😞', 'error');
                }

                // Store user answer
                this.userAnswers[this.currentQuestionIndex] = selectedOption;

                // Update score display
                if (this.currentScoreEl) {
                    this.currentScoreEl.textContent = this.score;
                }

                // Save progress
                await this.saveProgress();

                // Move to next question after delay
                setTimeout(() => {
                    this.nextQuestion();
                }, 1500);
            }

            showFeedback(message, type) {
                // Create feedback element
                const feedback = document.createElement('div');
                feedback.className = `fixed top-4 right-4 px-6 py-3 rounded-lg font-semibold text-white z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
                feedback.textContent = message;

                document.body.appendChild(feedback);

                // Animate in
                setTimeout(() => {
                    feedback.classList.add('translate-x-0');
                }, 100);

                // Remove after delay
                setTimeout(() => {
                    feedback.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (feedback.parentNode) {
                            feedback.parentNode.removeChild(feedback);
                        }
                    }, 300);
                }, 1000);
            }

            nextQuestion() {
                this.currentQuestionIndex++;
                this.updateQuizDisplay();

                if (this.currentQuestionIndex < this.questions.length && this.currentQuestionIndex < 30) {
                    this.displayCurrentQuestion();
                } else {
                    this.completeQuiz();
                }
            }

            startTimer() {
                this.timeLeft = 30;
                this.updateTimerDisplay();

                this.timer = setInterval(() => {
                    this.timeLeft--;
                    this.updateTimerDisplay();

                    if (this.timeLeft <= 0) {
                        this.timeUp();
                    }
                }, 1000);
            }

            updateTimerDisplay() {
                if (this.timerEl) {
                    this.timerEl.textContent = this.timeLeft;

                    // Add warning animation for last 10 seconds
                    if (this.timeLeft <= 10) {
                        this.timerEl.classList.add('timer-warning', 'bg-red-600');
                    } else {
                        this.timerEl.classList.remove('timer-warning', 'bg-red-600');
                        this.timerEl.classList.add('bg-red-500');
                    }
                }
            }

            stopTimer() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            }

            resetTimer() {
                this.stopTimer();
                this.startTimer();
            }

            async timeUp() {
                this.stopTimer();

                // Mark question as unanswered
                this.userAnswers[this.currentQuestionIndex] = null;

                // Show time up message
                // this.showFeedback('Time Up! ⏰', 'error');

                // Highlight correct answer
                const currentQuestion = this.questions[this.currentQuestionIndex];
                const correctOption = currentQuestion.correct_option;
                const correctIndex = ['A', 'B', 'C', 'D'].indexOf(correctOption);
                const allOptions = this.optionsContainer.querySelectorAll('button');

                if (correctIndex !== -1 && allOptions[correctIndex]) {
                    allOptions[correctIndex].classList.add('bg-green-500/30', 'border-green-400');
                }

                // Disable all options
                allOptions.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.remove('hover:bg-white/10', 'hover:scale-105', 'hover:border-white/40');
                });

                // Save progress
                await this.saveProgress();

                // Move to next question after delay
                setTimeout(() => {
                    this.nextQuestion();
                }, 2000);
            }

            async saveProgress() {
                try {
                    const progressData = {
                        current_question_index: this.currentQuestionIndex,
                        score: this.score,
                        answers: this.userAnswers
                    };

                    const response = await fetch('save_progress.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(progressData)
                    });

                    const data = await response.json();
                    if (!data.success) {
                        console.error('Failed to save progress:', data.error);
                    }
                } catch (error) {
                    console.error('Error saving progress:', error);
                }
            }

            async completeQuiz() {
                this.stopTimer();

                const timeTaken = Math.floor((Date.now() - this.quizStartTime) / 1000);
                const totalQuestions = Math.min(this.questions.length, 30);
                const percentage = Math.round((this.score / totalQuestions) * 100);

                // Save final result
                try {
                    const resultData = {
                        score: this.score,
                        total_questions: totalQuestions,
                        time_taken: timeTaken
                    };

                    const response = await fetch('save_result.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(resultData)
                    });

                    const data = await response.json();
                    if (!data.success) {
                        console.error('Failed to save result:', data.error);
                    }
                } catch (error) {
                    console.error('Error saving result:', error);
                }

                // Display results
                this.displayResults(this.score, totalQuestions, percentage);
            }

            displayResults(score, total, percentage) {
                this.showScreen('result');

                if (this.finalScore) {
                    this.finalScore.textContent = `${score}/${total}`;
                }

                if (this.percentage) {
                    this.percentage.textContent = `${percentage}%`;
                }

                // Set result message and icon based on performance
                let message = '';
                let icon = '';

                if (percentage >= 90) {
                    message = 'Outstanding! You\'re a quiz master! 🌟';
                    icon = '🏆';
                } else if (percentage >= 80) {
                    message = 'Excellent work! Keep it up! 👏';
                    icon = '🎉';
                } else if (percentage >= 70) {
                    message = 'Great job! You did well! 👍';
                    icon = '😊';
                } else if (percentage >= 60) {
                    message = 'Good effort! Room for improvement! 📚';
                    icon = '👌';
                } else if (percentage >= 50) {
                    message = 'Not bad! Keep practicing! 💪';
                    icon = '😐';
                } else {
                    message = 'Better luck next time! Study more! 📖';
                    icon = '😔';
                }

                if (this.resultMessage) {
                    this.resultMessage.textContent = message;
                }

                if (this.resultIcon) {
                    this.resultIcon.textContent = icon;
                }

                // Add confetti effect for high scores
                if (percentage >= 80) {
                    this.showConfetti();
                }
            }

            showConfetti() {
                // Simple confetti effect
                for (let i = 0; i < 50; i++) {
                    setTimeout(() => {
                        this.createConfettiPiece();
                    }, i * 100);
                }
            }

            createConfettiPiece() {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 70%, 60%)`;
                confetti.style.left = Math.random() * window.innerWidth + 'px';
                confetti.style.top = '-10px';
                confetti.style.zIndex = '9999';
                confetti.style.pointerEvents = 'none';
                confetti.style.borderRadius = '50%';

                document.body.appendChild(confetti);

                // Animate confetti falling
                let position = -10;
                const fall = setInterval(() => {
                    position += 5;
                    confetti.style.top = position + 'px';

                    if (position > window.innerHeight) {
                        clearInterval(fall);
                        if (confetti.parentNode) {
                            confetti.parentNode.removeChild(confetti);
                        }
                    }
                }, 50);
            }

            showError(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg font-semibold z-50';
                errorDiv.textContent = message;

                document.body.appendChild(errorDiv);

                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.parentNode.removeChild(errorDiv);
                    }
                }, 5000);
            }
        }

        // Initialize the quiz game when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            // Only initialize if we're not on registration screen
            if (document.getElementById('startScreen') || document.getElementById('quizScreen')) {
                new QuizGame();
            }
        });

        // Additional utility functions
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }
    </script>
</body>

</html>