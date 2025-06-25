-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 25, 2025 at 08:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT 'Medium',
  `category` varchar(50) DEFAULT 'General',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `difficulty`, `category`, `created_at`) VALUES
(1, 'Which planet is closest to the Sun?', 'Earth', 'Venus', 'Mercury', 'Mars', 'C', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(2, 'Which country is known as the Land of the Rising Sun?', 'South Korea', 'China', 'Japan', 'Thailand', 'C', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(3, 'How many continents are there on Earth?', '6', '7', '8', '5', 'B', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(4, 'Which is the national flower of India?', 'Sunflower', 'Lotus', 'Rose', 'Marigold', 'B', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(5, 'What is the currency of the USA?', 'Euro', 'Dollar', 'Pound', 'Yen', 'B', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(6, 'Which one is an example of an output device?', 'Keyboard', 'Scanner', 'Monitor', 'Mouse', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(7, 'Which is used to store large amounts of data permanently?', 'RAM', 'Cache', 'Hard Disk', 'Register', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(8, 'Which of these is a web browser?', 'Linux', 'Google', 'Firefox', 'Yahoo', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(9, 'Which key is used to delete text to the left of the cursor?', 'Shift', 'Ctrl', 'Backspace', 'Enter', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(10, 'What does RAM stand for?', 'Read Access Memory', 'Read Automatic Memory', 'Random Automatic Memory', 'Random Access Memory', 'D', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(11, 'Which gas is most abundant in the Earth\'s atmosphere?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(12, 'Who is known as the Iron Man of India?', 'Subhash Chandra Bose', 'Bhagat Singh', 'Sardar Vallabhbhai Patel', 'Jawaharlal Nehru', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(13, 'In which year did India gain independence?', '1945', '1947', '1950', '1946', 'B', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(14, 'Who wrote \'Discovery of India\'?', 'Mahatma Gandhi', 'Rabindranath Tagore', 'Jawaharlal Nehru', 'APJ Abdul Kalam', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(15, 'Which river is known as the \'Sorrow of Bengal\'?', 'Ganga', 'Yamuna', 'Damodar', 'Brahmaputra', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(16, 'Which protocol is used to receive emails?', 'SMTP', 'IMAP', 'FTP', 'HTTP', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(17, 'Which file extension is used for Java source code?', '.exe', '.java', '.class', '.html', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(18, 'Which among these is NOT a database management system?', 'MySQL', 'Oracle', 'Windows', 'MongoDB', 'C', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(19, 'Which shortcut is used to redo an action?', 'Ctrl + R', 'Ctrl + Y', 'Ctrl + U', 'Ctrl + E', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(20, 'Which one is an open-source operating system?', 'Windows', 'macOS', 'Linux', 'DOS', 'C', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(21, 'Which is the deepest ocean in the world?', 'Atlantic', 'Arctic', 'Indian', 'Pacific', 'D', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(22, 'Who is known as the \'Napoleon of India\'?', 'Ashoka', 'Chandragupta Maurya', 'Harsha', 'Samudragupta', 'D', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(23, 'Which Indian scientist won the Nobel Prize for Physics in 1930?', 'Homi Bhabha', 'Satyendra Nath Bose', 'C.V. Raman', 'Meghnad Saha', 'C', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(24, 'Which city is known as the \'City of Joy\'?', 'Kolkata', 'Delhi', 'Mumbai', 'Chennai', 'A', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(25, 'Which Indian state has the longest coastline?', 'Gujarat', 'Andhra Pradesh', 'Maharashtra', 'Tamil Nadu', 'A', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(26, 'Which of these is NOT a type of computer network?', 'LAN', 'MAN', 'WAN', 'CAN', 'D', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(27, 'Which one is used for dynamic web page scripting?', 'HTML', 'CSS', 'JavaScript', 'XML', 'C', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(28, 'Which SQL command is used to add new data to a table?', 'INSERT', 'DELETE', 'UPDATE', 'SELECT', 'A', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(29, 'Which method is used to arrange numbers in order?', 'Searching', 'Sorting', 'Filtering', 'Merging', 'B', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(30, 'Which logic gate gives a high output if both inputs are high?', 'OR', 'AND', 'NOR', 'NOT', 'B', 'Hard', 'Computer Science', '2025-06-25 17:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_progress`
--

CREATE TABLE `quiz_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_question_index` int(11) DEFAULT 0,
  `score` int(11) DEFAULT 0,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answers`)),
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `time_taken` int(11) DEFAULT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `created_at`) VALUES
(4, 'Status page', '9365478210', '2025-06-25 18:27:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  ADD CONSTRAINT `quiz_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;