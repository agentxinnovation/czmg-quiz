-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2025 at 03:59 PM
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
(1, 'What is the full form of Smt. C.Z.M.G BCA and MSC.IT college?', 'Smt. Chandrikaben Zaverchand Meghji Goswami BCA and MSC.IT College', 'Smt. Chandramaniben Zaveri Meghji Gosrani BCA and MSC.IT College', 'Smt. Chandramaniben Zaverchand Meghji Gosrani BCA and MSC.IT College', 'Smt. Chandramaniben Zaverchand Meghji Goswami BCA and MSC.IT College', 'C', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(2, 'Which country is known as the Land of the Rising Sun?', 'South Korea', 'China', 'Japan', 'Thailand', 'C', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(3, 'If a cloak takes 5 seconds to strike 5, how long will it take to strike 10?', '9', '7', '8', '10', 'A', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(4, 'Which is the national flower of India?', 'Sunflower', 'Lotus', 'Rose', 'Marigold', 'B', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(5, 'What is the currency of the USA?', 'Euro', 'Dollar', 'Pound', 'Yen', 'B', 'Easy', 'General Knowledge', '2025-06-25 17:25:27'),
(6, 'Which one is an example of an output device?', 'Keyboard', 'Scanner', 'Monitor', 'Mouse', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(7, 'Which is used to store large amounts of data permanently?', 'RAM', 'Cache', 'Hard Disk', 'Register', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(8, 'Which of these is a web browser?', 'Linux', 'Google', 'Firefox', 'Yahoo', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(9, 'Which key is used to delete text to the left of the cursor?', 'Shift', 'Ctrl', 'Backspace', 'Enter', 'C', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(10, 'What does RAM stand for?', 'Read Access Memory', 'Read Automatic Memory', 'Random Automatic Memory', 'Random Access Memory', 'D', 'Easy', 'Computer Science', '2025-06-25 17:25:27'),
(11, 'Which gas is most abundant in the Earth\'s atmosphere?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(12, 'Who is known as the Iron Man of India?', 'Subhash Chandra Bose', 'Bhagat Singh', 'Sardar Vallabhbhai Patel', 'Jawaharlal Nehru', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(13, 'Which is the only country that is also a continent and has three internal time zones?', 'Japan', 'Australia', 'Europe', 'North America', 'B', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(14, 'Who wrote \'Discovery of India\'?', 'Mahatma Gandhi', 'Rabindranath Tagore', 'Jawaharlal Nehru', 'APJ Abdul Kalam', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(15, 'Which river is known as the \'Sorrow of Bengal\'?', 'Ganga', 'Yamuna', 'Damodar', 'Brahmaputra', 'C', 'Medium', 'General Knowledge', '2025-06-25 17:25:27'),
(16, 'Which protocol is used to receive emails?', 'SMTP', 'IMAP', 'FTP', 'HTTP', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(17, 'Which file extension is used for Java source code?', '.exe', '.java', '.class', '.html', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(18, 'What is the full form of HTTP?', 'Hyper Text Terminal Protocol', 'Hyper Text Transmission Protocol', 'Hyper Text Transfer Protocol', 'High Text Transfer Protocol', 'C', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(19, 'Which shortcut is used to redo an action?', 'Ctrl + R', 'Ctrl + Y', 'Ctrl + U', 'Ctrl + E', 'B', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(20, 'Which one is an open-source operating system?', 'Windows', 'macOS', 'Linux', 'DOS', 'C', 'Medium', 'Computer Science', '2025-06-25 17:25:27'),
(21, 'Which is the deepest ocean in the world?', 'Atlantic', 'Arctic', 'Indian', 'Pacific', 'D', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(22, 'Who is known as the \'Napoleon of India\'?', 'Ashoka', 'Chandragupta Maurya', 'Harsha', 'Samudragupta', 'D', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(23, 'Which Indian scientist won the Nobel Prize for Physics in 1930?', 'Homi Bhabha', 'Satyendra Nath Bose', 'C.V. Raman', 'Meghnad Saha', 'C', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(24, 'Which city is known as the \'City of Joy\'?', 'Kolkata', 'Delhi', 'Mumbai', 'Chennai', 'A', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(25, 'Which Indian state has the longest coastline?', 'Gujarat', 'Andhra Pradesh', 'Maharashtra', 'Tamil Nadu', 'A', 'Hard', 'General Knowledge', '2025-06-25 17:25:27'),
(26, 'Which of these is NOT a type of computer network?', 'LAN', 'MAN', 'WAN', 'CAN', 'D', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(27, 'Which one is used for dynamic web page scripting?', 'HTML', 'CSS', 'JavaScript', 'XML', 'C', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(28, 'What is the main difference between RAM and ROM?', 'ROM is volatile,RAM is not', 'RAM stores the BIOS', 'RAM is volatile, ROM is not', 'Both are permanent storage', 'C', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(29, 'Which method is used to arrange numbers in order?', 'Searching', 'Sorting', 'Filtering', 'Merging', 'B', 'Hard', 'Computer Science', '2025-06-25 17:25:27'),
(30, 'Which type of malware appears as a useful software but harms your system?', 'Virus', 'Worm', 'Trojan Horse', 'Spyware', 'C', 'Hard', 'Computer Science', '2025-06-25 17:25:27');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `question_order` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_progress`
--

INSERT INTO `quiz_progress` (`id`, `user_id`, `current_question_index`, `score`, `answers`, `started_at`, `updated_at`, `question_order`) VALUES
(265, 8, 21, 1, '[\"B\",\"A\",\"B\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '2025-06-26 09:37:25', '2025-06-26 09:37:25', NULL),
(282, 10, 5, 1, '[\"B\",null,null,null,\"B\",null]', '2025-06-26 13:23:35', '2025-06-26 13:23:35', NULL),
(284, 12, 16, 6, '[\"C\",\"D\",\"A\",\"C\",\"C\",\"D\",\"C\",\"C\",\"C\",\"D\",\"D\",\"D\",\"C\",\"C\",\"C\",\"C\",null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '2025-06-26 13:38:29', '2025-06-26 13:39:12', NULL);

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

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `score`, `total_questions`, `percentage`, `time_taken`, `completed_at`) VALUES
(5, 5, 2, 30, 6.67, 75, '2025-06-25 18:37:36'),
(6, 4, 3, 30, 10.00, 62, '2025-06-26 05:47:51'),
(7, 6, 8, 30, 26.67, 66, '2025-06-26 08:36:46'),
(8, 7, 24, 30, 80.00, 225, '2025-06-26 09:12:02'),
(9, 11, 10, 30, 33.33, 129, '2025-06-26 13:33:09'),
(10, 15, 17, 30, 56.67, 536, '2025-06-26 13:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `school` varchar(100) NOT NULL,
  `stream` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `created_at`, `school`, `stream`) VALUES
(4, 'Status page', '9365478210', '2025-06-25 18:27:56', '', ''),
(5, 'commando', '9876543210', '2025-06-25 18:36:15', '', ''),
(6, 's,nfs', '9632587410', '2025-06-26 08:35:38', '', ''),
(7, 'dhairya chavda', '9854712360', '2025-06-26 09:08:10', '', ''),
(8, 'Devx Harsh', '9658741230', '2025-06-26 09:34:59', '', ''),
(9, 'commando', '9874120563', '2025-06-26 13:12:19', '', 'sdhgf'),
(10, 'commando', '9996665874', '2025-06-26 13:20:39', 'kvd', 'com'),
(11, 'Devx Harsh', '9999996610', '2025-06-26 13:31:00', 'sdf', 'sdf'),
(12, 'harsh raithatha', '9327449233', '2025-06-26 13:37:11', 'kvd', 'comm'),
(13, 'commando', '9996665875', '2025-06-26 13:45:07', 'asd', 'asd'),
(14, 'Status page', '9996633221', '2025-06-26 13:46:14', 'asd', 'asd'),
(15, 'Devx Harsh', '9365478217', '2025-06-26 13:48:55', 'jh', 'kj');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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