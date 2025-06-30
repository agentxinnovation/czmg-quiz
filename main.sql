-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2025 at 08:36 AM
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
(1, 'What does BCA stand for?', 'Bachelor of Commerce in Accounting', 'Bachelor of Computer Applications', 'Basic Computer Architecture', 'Business and Computing Administration', 'B', 'Easy', 'College Awareness', '2025-06-30 06:32:40'),
(2, 'What is the minimum duration of a BCA course?', '2 years', '4 years', '3 years', '5 years', 'C', 'Easy', 'College Awareness', '2025-06-30 06:32:40'),
(3, 'Which of the following is a subject generally taught in the first semester of BCA?', 'Operating System Internals', 'Data Structures', 'Digital Marketing', 'Accountancy', 'B', 'Easy', 'College Awareness', '2025-06-30 06:32:40'),
(4, 'Who is responsible for maintaining discipline in your college?', 'Librarian', 'Principal', 'Discipline Committee/ANO', 'Peon', 'C', 'Easy', 'College Awareness', '2025-06-30 06:32:40'),
(5, 'Full form of your college name (C.Z.M.G BCA and MSC.IT)?', 'Smt. Chandrikaben Zaverchand Meghji Goswami', 'Smt. Chandramaniben Zaveri Meghji Gosrani', 'Smt. Chandramaniben Zaverchand Meghji Gosrani', 'Smt. Chandramaniben Zaverchand Meghji Goswami', 'C', 'Medium', 'College Awareness', '2025-06-30 06:32:40'),
(6, 'Which of the following is an input device?', 'Monitor', 'Keyboard', 'Printer', 'Speaker', 'B', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(7, 'Which is the brain of the computer?', 'RAM', 'Hard Disk', 'CPU', 'Keyboard', 'C', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(8, 'Which of these is NOT an operating system?', 'Linux', 'Windows', 'Oracle', 'macOS', 'C', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(9, 'Which programming language is known as the “mother of all languages”?', 'Java', 'Python', 'C', 'HTML', 'C', 'Medium', 'Computer Basics', '2025-06-30 06:32:40'),
(10, 'The full form of HTML is:', 'HighText Machine Language', 'HyperText Markup Language', 'HyperTool Multi Language', 'None of the above', 'B', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(11, 'What does RAM stand for?', 'Read Access Memory', 'Random Access Memory', 'Random Automatic Memory', 'Read Automatic Memory', 'B', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(12, 'Which key deletes text to the left of the cursor?', 'Shift', 'Ctrl', 'Backspace', 'Enter', 'C', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(13, 'Which device helps you hear sound from the computer?', 'Monitor', 'CPU', 'Speaker', 'Scanner', 'C', 'Easy', 'Computer Basics', '2025-06-30 06:32:40'),
(14, 'Full form of HTTP:', 'Hyper Text Terminal Protocol', 'Hyper Text Transmission Protocol', 'Hyper Text Transfer Protocol', 'High Text Transfer Protocol', 'C', 'Easy', 'Internet Awareness', '2025-06-30 06:32:40'),
(15, 'What is the full form of URL?', 'Uniform Resource Locator', 'User Record Link', 'Universal Request Log', 'Uniform Register Location', 'A', 'Easy', 'Internet Awareness', '2025-06-30 06:32:40'),
(16, 'Which of the following is a web browser?', 'Google', 'Yahoo', 'Chrome', 'Bing', 'C', 'Easy', 'Internet Awareness', '2025-06-30 06:32:40'),
(17, 'Which one is an example of cloud storage?', 'Pendrive', 'Google Drive', 'CD-ROM', 'SSD', 'B', 'Easy', 'Internet Awareness', '2025-06-30 06:32:40'),
(18, 'Phishing refers to:', 'Catching viruses', 'Email-based fraud', 'File download issues', 'Internet buffering', 'B', 'Medium', 'Internet Awareness', '2025-06-30 06:32:40'),
(19, 'Which protocol is used to receive emails?', 'SMTP', 'IMAP', 'FTP', 'HTTP', 'B', 'Medium', 'Internet Awareness', '2025-06-30 06:32:40'),
(20, 'Which of these is an example of good digital etiquette?', 'SHOUTING IN CAPS', 'Being respectful online', 'Ignoring emails', 'Sending fake forwards', 'B', 'Easy', 'Digital Etiquette', '2025-06-30 06:32:40'),
(21, 'Which is a formal communication tool?', 'WhatsApp', 'TikTok', 'Gmail', 'Snapchat', 'C', 'Easy', 'Digital Etiquette', '2025-06-30 06:32:40'),
(22, 'What should you check before sending a formal email?', 'Subject Line', 'Grammar', 'Attachments', 'All of the above', 'D', 'Easy', 'Digital Etiquette', '2025-06-30 06:32:40'),
(23, 'Important skill during group discussion?', 'Loud talking', 'Interrupting', 'Listening and responding', 'Staying silent', 'C', 'Easy', 'Digital Etiquette', '2025-06-30 06:32:40'),
(24, 'Netiquette means:', 'Network etiquette', 'Internet behavior manners', 'Net speed', 'None', 'B', 'Easy', 'Digital Etiquette', '2025-06-30 06:32:40'),
(25, 'What improves your resume during college?', 'Internships', 'Competitions', 'Hackathons', 'All of the above', 'D', 'Medium', 'Career & Motivation', '2025-06-30 06:32:40'),
(26, 'Best way to manage studies?', 'Group discussions', 'Studying only at exam time', 'Regular revision & attendance', 'Skipping lectures', 'C', 'Easy', 'Career & Motivation', '2025-06-30 06:32:40'),
(27, 'Enhance your BCA career by:', 'Coding practice', 'Doing projects', 'Joining tech clubs', 'All of the above', 'D', 'Medium', 'Career & Motivation', '2025-06-30 06:32:40'),
(28, 'Which one is a soft skill?', 'Java', 'C++', 'Communication', 'Python', 'C', 'Easy', 'Career & Motivation', '2025-06-30 06:32:40'),
(29, 'Best way to start college positively?', 'Be active & punctual', 'Skip activities', 'Avoid interaction', 'Copy notes only', 'A', 'Easy', 'Career & Motivation', '2025-06-30 06:32:40'),
(30, 'Which country is known as the Land of the Rising Sun?', 'South Korea', 'China', 'Japan', 'Thailand', 'C', 'Easy', 'Fun GK', '2025-06-30 06:32:40');

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
(286, 16, 0, 0, '[]', '2025-06-28 06:13:48', '2025-06-28 06:13:48', '[6,20,19,21,23,10,4,22,25,16,8,1,9,14,11,7,3,30,5,26,27,24,28,29,2,13,18,12,15,17]');

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
(10, 15, 17, 30, 56.67, 536, '2025-06-26 13:58:15'),
(11, 12, 12, 30, 40.00, 32, '2025-06-26 14:03:29');

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
(15, 'Devx Harsh', '9365478217', '2025-06-26 13:48:55', 'jh', 'kj'),
(16, 'Devx Harsh', '7451263980', '2025-06-28 06:13:45', 'dcfljh', 'qxdcgh');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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