-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2025 at 04:04 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elkpd`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `user_id`, `school_id`, `name`, `code`, `created_at`) VALUES
('01K92EK6YBT0FSC80TDYYD3ZN2', '01K91853JEGYFN8Z034389ETB3', '01K8ZB7PXYMHWEQ4K6C5651EB1', 'Kelas 5A', 'Pan-5A', '2025-11-02 21:12:31'),
('01KDJMXAYHPMHEP86J0Q1TWDPQ', '01K974STMBGJGP4BEC1C216M48', '01K8ZAAFMB5A11GW0PCX2W793X', 'Kelas 5B', 'D40DCD', '2025-12-28 21:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_class_reflections`
--

CREATE TABLE `pbl_class_reflections` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strengths` text COLLATE utf8mb4_unicode_ci,
  `obstacles` text COLLATE utf8mb4_unicode_ci,
  `competency_achievement` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_class_reflections`
--

INSERT INTO `pbl_class_reflections` (`id`, `class_id`, `teacher_id`, `strengths`, `obstacles`, `competency_achievement`, `created_at`, `updated_at`) VALUES
('01KD5NY3ZFX4VH66S9G3WQ2DJK', '01K92EK6YBT0FSC80TDYYD3ZN2', '01K91853JEGYFN8Z034389ETB3', 'baik', 'kurang', 'baik', '2025-12-23 20:21:19', '2025-12-23 20:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_discussion_topics`
--

CREATE TABLE `pbl_discussion_topics` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_discussion_topics`
--

INSERT INTO `pbl_discussion_topics` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9HBR0JAWBTQF8K4443MBXSF', '01K92EK6YBT0FSC80TDYYD3ZN2', 'diskusi ipas', 'pertemuan 1 ipas', '2025-11-08 16:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_essay_questions`
--

CREATE TABLE `pbl_essay_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_solution_essays.id',
  `question_number` int NOT NULL COMMENT 'Nomor urut pertanyaan',
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Teks pertanyaan',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_essay_questions`
--

INSERT INTO `pbl_essay_questions` (`id`, `essay_id`, `question_number`, `question_text`, `created_at`) VALUES
('01KD0MCVRWE7Y2HTHEV8DNEQVR', '01KD0MAY7TN4ABV4ETC48J54DB', 3, 'dimanakah', '2025-12-21 21:18:13'),
('01KD0MCVRWHR27D3QB1NKKN2JA', '01KD0MAY7TN4ABV4ETC48J54DB', 1, 'siapakah yang', '2025-12-21 21:18:13'),
('01KD0MCVRWTVQY0F3WTDVRX2VE', '01KD0MAY7TN4ABV4ETC48J54DB', 2, 'kapankah', '2025-12-21 21:18:13'),
('01KD77QAEZS4Q38GRMH1DAWHSA', '01KD77PS1JNENA5SMXY1B1MHGD', 2, 'bagaimana', '2025-12-24 10:51:25'),
('01KD77QAEZTZ5C8ZP1WC2SHB89', '01KD77PS1JNENA5SMXY1B1MHGD', 1, 'mengapa', '2025-12-24 10:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_essay_submissions`
--

CREATE TABLE `pbl_essay_submissions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_solution_essays.id',
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke users.id (siswa)',
  `submission_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` int DEFAULT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_essay_submissions`
--

INSERT INTO `pbl_essay_submissions` (`id`, `essay_id`, `user_id`, `submission_content`, `grade`, `feedback`, `created_at`, `updated_at`) VALUES
('01KD25VRZG1YNFGNRMY8YTAKBC', '01KD0MAY7TN4ABV4ETC48J54DB', '01K912FR1QZHEWJ6MCVK8WEK5V', '1.dfgh\r\n2.fgh\r\n3.dfghj', 80, 'ok bagus', '2025-12-22 11:42:42', '2025-12-22 11:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_evaluation_quizzes`
--

CREATE TABLE `pbl_evaluation_quizzes` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_evaluation_quiz_questions`
--

CREATE TABLE `pbl_evaluation_quiz_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_evaluation_quizzes.id',
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('A','B','C','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_final_reflections`
--

CREATE TABLE `pbl_final_reflections` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Instruksi/prompt untuk refleksi',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_final_reflections`
--

INSERT INTO `pbl_final_reflections` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9RDYC2RBRY0DGEHCNSF782D', '01K92EK6YBT0FSC80TDYYD3ZN2', 'a', 'refleksi akhir', '2025-11-11 10:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_final_results`
--

CREATE TABLE `pbl_final_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke users.id (siswa)',
  `final_score` int DEFAULT '0' COMMENT 'Nilai Akhir (0-100)',
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Refleksi/Penguatan dari Guru',
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_forum_posts`
--

CREATE TABLE `pbl_forum_posts` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_discussion_topics.id',
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke users.id',
  `post_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_forum_posts`
--

INSERT INTO `pbl_forum_posts` (`id`, `topic_id`, `user_id`, `post_content`, `created_at`) VALUES
('01K9HYYMNSC0XPWQDCXDSDPTT2', '01K9HBR0JAWBTQF8K4443MBXSF', '01K91853JEGYFN8Z034389ETB3', 'selamat', '2025-11-08 21:47:00'),
('01K9HYYRMD5PK321ERK3NG28CJ', '01K9HBR0JAWBTQF8K4443MBXSF', '01K91853JEGYFN8Z034389ETB3', 'malam', '2025-11-08 21:47:04'),
('01KAT3PR6B8WZH12HHWP0TDH83', '01K9HBR0JAWBTQF8K4443MBXSF', '01K912FR1QZHEWJ6MCVK8WEK5V', 'selamat siang', '2025-11-24 11:59:41'),
('01KBP7F192G62HW353EWD9F3FP', '01K9HBR0JAWBTQF8K4443MBXSF', '01K912FR1QZHEWJ6MCVK8WEK5V', 'test', '2025-12-05 10:04:07');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_observation_results`
--

CREATE TABLE `pbl_observation_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation_slot_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_observation_results`
--

INSERT INTO `pbl_observation_results` (`id`, `observation_slot_id`, `user_id`, `score`, `feedback`, `created_at`) VALUES
('01KD74HJ342NCA3Y0ZNP6BGCR2', '01KAJ4NJ1XTEZ89738D7997ZE0', '01K912FR1QZHEWJ6MCVK8WEK5V', 78, 'ok', '2025-12-24 09:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_observation_slots`
--

CREATE TABLE `pbl_observation_slots` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_observation_slots`
--

INSERT INTO `pbl_observation_slots` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01KAJ4NJ1XTEZ89738D7997ZE0', '01K92EK6YBT0FSC80TDYYD3ZN2', 'ruang', 'ruang', '2025-11-21 09:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_observation_uploads`
--

CREATE TABLE `pbl_observation_uploads` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation_slot_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ID Siswa',
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_observation_uploads`
--

INSERT INTO `pbl_observation_uploads` (`id`, `observation_slot_id`, `user_id`, `file_name`, `original_name`, `description`, `created_at`) VALUES
('01KD74GG18RMZ1W5XE5S9ANBMN', '01KAJ4NJ1XTEZ89738D7997ZE0', '01K912FR1QZHEWJ6MCVK8WEK5V', '0c5099ac7cc7c1e346511d24821e3c87.docx', 'usecase.docx', 'sdfgh', '2025-12-24 09:55:16'),
('01KDF2FB8EMGQB42ZH3H6NRRQ7', '01KAJ4NJ1XTEZ89738D7997ZE0', '01K94KA9TRKC5ZEAPM3PRKVP9S', 'eafcb34540f7e6b3b5d03521fbb5715f.jpg', '01KCRYBV7NVJTASBSXNC69MM5H.jpg', 'tugas', '2025-12-27 11:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_orientasi`
--

CREATE TABLE `pbl_orientasi` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reflection` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_orientasi`
--

INSERT INTO `pbl_orientasi` (`id`, `class_id`, `title`, `reflection`, `file_path`, `created_at`) VALUES
('01KCY0YXK2H849VN0N0R1BJS21', '01K92EK6YBT0FSC80TDYYD3ZN2', 'test', 'test', 'uploads/pbl/01KDEXWJ3RS7DK33FTPWHQMRGD.jpg', '2025-12-20 21:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quizzes`
--

CREATE TABLE `pbl_quizzes` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quizzes`
--

INSERT INTO `pbl_quizzes` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9RB3FNYYXBC5SBAT705K85N', '01K92EK6YBT0FSC80TDYYD3ZN2', 'kuis', 'kuis ipas', '2025-11-11 09:14:48'),
('01KD74N5NJWSJ7H86KVYY3Y8WQ', '01K92EK6YBT0FSC80TDYYD3ZN2', 'kuis kedua', 'kuis', '2025-12-24 09:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quiz_answers`
--

CREATE TABLE `pbl_quiz_answers` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `result_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected_option` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quiz_answers`
--

INSERT INTO `pbl_quiz_answers` (`id`, `result_id`, `question_id`, `selected_option`, `is_correct`, `created_at`) VALUES
('01KCG42QW8HN3FGTE03DM3HPTK', '01KCG42QW7GXC5Q4N0N0PSJ99N', '01K9RB47XCXWVSSEBMT8NRTNC6', 'A', 0, '2025-12-15 11:25:13'),
('01KCG42QW8MPE080ZKCTEQQ009', '01KCG42QW7GXC5Q4N0N0PSJ99N', '01K9RB47XCZ8MQ9BQQXK134F59', 'C', 1, '2025-12-15 11:25:13'),
('01KCRD31YR2Y7HZRQXEKV8A287', '01KCRD31YRH785NDRP4H7SVH6G', '01KCRCYDZ1PV0FGRM1VMYWJHT4', 'C', 1, '2025-12-18 16:36:36'),
('01KCRD31YR674K0GZ30WC9C3GA', '01KCRD31YRH785NDRP4H7SVH6G', '01KCRCYDZ1J1DECFR6QRSBAF3K', 'B', 1, '2025-12-18 16:36:36'),
('01KCY1FRNVFKKXQ8DFG96BP43G', '01KCY1FRNV152S9NYA8AP4J1SB', '01K9RB47XCXWVSSEBMT8NRTNC6', 'C', 1, '2025-12-20 21:09:17'),
('01KCY1FRNVPRWCNBAB1XVY1B0K', '01KCY1FRNV152S9NYA8AP4J1SB', '01K9RB47XCZ8MQ9BQQXK134F59', 'C', 1, '2025-12-20 21:09:17'),
('01KD74Q2XE3GKP2W8MEBH8046Y', '01KD74Q2XENEDQG40MQNBVB8KC', '01KD74NS1T2H06XJBZ7T1YMAEH', 'C', 1, '2025-12-24 09:58:52'),
('01KD74Q2XEXSZB3JBDCDV7DBZ2', '01KD74Q2XENEDQG40MQNBVB8KC', '01KD74NS1TVEKSMVDBQ926B430', 'C', 1, '2025-12-24 09:58:52'),
('01KD7X89SNC544GEZA1P808C96', '01KD7X89SNC4BGCPQMV7A5GBW0', '01KD74NS1TVEKSMVDBQ926B430', 'C', 1, '2025-12-24 17:07:42'),
('01KD7X89SNXEXAFKFQXAMG7Y9Y', '01KD7X89SNC4BGCPQMV7A5GBW0', '01KD74NS1T2H06XJBZ7T1YMAEH', 'C', 1, '2025-12-24 17:07:42'),
('01KDCVSC2JBJ2X16AV1R5WGQ95', '01KDCVSC2JPS0R1QDSAWCKNNFV', '01KDCVPPPKPEN54E7V2N5FG5C6', 'C', 1, '2025-12-26 15:18:16'),
('01KDCVSC2JG0FD0M3HAZS8B0V6', '01KDCVSC2JPS0R1QDSAWCKNNFV', '01KDCVPPPK8J234A82672E8BDX', 'C', 1, '2025-12-26 15:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quiz_questions`
--

CREATE TABLE `pbl_quiz_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('A','B','C','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quiz_questions`
--

INSERT INTO `pbl_quiz_questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `created_at`) VALUES
('01K9RB47XCXWVSSEBMT8NRTNC6', '01K9RB3FNYYXBC5SBAT705K85N', 'siapa', 'Saya', 'Aku', 'Dia', 'Kamu', 'C', '2025-11-11 09:15:13'),
('01K9RB47XCZ8MQ9BQQXK134F59', '01K9RB3FNYYXBC5SBAT705K85N', '1+1=', '1', '0', '2', '3', 'C', '2025-11-11 09:15:13'),
('01KD74NS1T2H06XJBZ7T1YMAEH', '01KD74N5NJWSJ7H86KVYY3Y8WQ', 'siapa', 'Saya', 'Aku', 'Dia', 'Kamu', 'C', '2025-12-24 09:58:09'),
('01KD74NS1TVEKSMVDBQ926B430', '01KD74N5NJWSJ7H86KVYY3Y8WQ', '1+1=', '1', '0', '2', '3', 'C', '2025-12-24 09:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quiz_results`
--

CREATE TABLE `pbl_quiz_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `total_correct` int NOT NULL,
  `total_questions` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quiz_results`
--

INSERT INTO `pbl_quiz_results` (`id`, `quiz_id`, `user_id`, `score`, `total_correct`, `total_questions`, `created_at`) VALUES
('01KCY1FRNV152S9NYA8AP4J1SB', '01K9RB3FNYYXBC5SBAT705K85N', '01K94KA9TRKC5ZEAPM3PRKVP9S', 100, 2, 2, '2025-12-20 21:09:16'),
('01KD74Q2XENEDQG40MQNBVB8KC', '01KD74N5NJWSJ7H86KVYY3Y8WQ', '01K912FR1QZHEWJ6MCVK8WEK5V', 100, 2, 2, '2025-12-24 09:58:52'),
('01KD7X89SNC4BGCPQMV7A5GBW0', '01KD74N5NJWSJ7H86KVYY3Y8WQ', '01K94KA9TRKC5ZEAPM3PRKVP9S', 100, 2, 2, '2025-12-24 17:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_reflection`
--

CREATE TABLE `pbl_reflection` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_reflection` text COLLATE utf8mb4_unicode_ci,
  `teacher_feedback` text COLLATE utf8mb4_unicode_ci,
  `student_reflection` text COLLATE utf8mb4_unicode_ci,
  `final_score` decimal(5,2) DEFAULT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_reflections`
--

CREATE TABLE `pbl_reflections` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Siswa ID',
  `teacher_reflection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `student_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Draft/Hidden, 1=Published/Visible',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_reflections`
--

INSERT INTO `pbl_reflections` (`id`, `class_id`, `user_id`, `teacher_reflection`, `student_feedback`, `is_locked`, `created_at`, `updated_at`) VALUES
('01KC6D1T5M9WEJX1CWEFMB1F4W', '01K92EK6YBT0FSC80TDYYD3ZN2', '01K912FR1QZHEWJ6MCVK8WEK5V', 'ok', 'ayo semangat', 1, '2025-12-11 16:49:36', '2025-12-27 10:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_solution_essays`
--

CREATE TABLE `pbl_solution_essays` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Instruksi/prompt untuk esai',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_solution_essays`
--

INSERT INTO `pbl_solution_essays` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01KD0MAY7TN4ABV4ETC48J54DB', '01K92EK6YBT0FSC80TDYYD3ZN2', 'test', 'test', '2025-12-21 21:17:10'),
('01KD77PS1JNENA5SMXY1B1MHGD', '01K92EK6YBT0FSC80TDYYD3ZN2', 'esai', 'esai', '2025-12-24 10:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts`
--

CREATE TABLE `pbl_tts` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts`
--

INSERT INTO `pbl_tts` (`id`, `class_id`, `title`, `grid_data`, `created_at`) VALUES
('01K9BNTQP0WNJEWQ6H48J1KNJR', '01K92EK6YBT0FSC80TDYYD3ZN2', 'teka5', '5', '2025-11-06 11:12:08'),
('01KCRCZ7Q1YD8M2JXVSX7H2G42', '01K92EK6YBT0FSC80TDYYD3ZN2', 'tes', '12', '2025-12-18 16:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts_answers`
--

CREATE TABLE `pbl_tts_answers` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `result_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_answer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts_answers`
--

INSERT INTO `pbl_tts_answers` (`id`, `result_id`, `question_id`, `user_answer`, `is_correct`, `created_at`) VALUES
('01KCGHZX9J0FH2G8NS0QQ4XB4S', '01KCGHZX9JDDZKH1YWYKTRM3ER', '01KATJT02QY755SYVEF7ENAC7J', 'MALAS', 0, '2025-12-15 15:28:21'),
('01KCGHZX9JHSAPGE03SDJ8GF3C', '01KCGHZX9JDDZKH1YWYKTRM3ER', '01KAR25DRCMG96KXHYZ8G4QK6X', 'MINUM', 1, '2025-12-15 15:28:21'),
('01KCGJ53EME5EN9C3KQDHZPTHY', '01KCGJ53EM5TBHETVRQTFY21Q8', '01KATJT02QY755SYVEF7ENAC7J', 'MALAM', 1, '2025-12-15 15:31:11'),
('01KCGJ53EMSSPZMAQ7ZD3RBPPR', '01KCGJ53EM5TBHETVRQTFY21Q8', '01KAR25DRCMG96KXHYZ8G4QK6X', 'MINUM', 1, '2025-12-15 15:31:11'),
('01KCRD405CK8Y7B5QK111K1H5A', '01KCRD405BAVVP8ZK101XEB8ZC', '01KCRCZQMC9QNDV4H0JJRCBHD9', 'QSDFGH', 0, '2025-12-18 16:37:07'),
('01KD74V9DT9J5KWQMQ4Y4SWGHM', '01KD74V9DT6JN90N3ZF8R3X4KS', '01KCY42B1K9RC45M0H9W4A8CSY', 'KALIAN', 1, '2025-12-24 10:01:10'),
('01KD74V9DTZBEJVKVADDY7TZ1P', '01KD74V9DT6JN90N3ZF8R3X4KS', '01KCRCZQMC9QNDV4H0JJRCBHD9', 'MEREKA', 1, '2025-12-24 10:01:10'),
('01KD7X9CXMPK9VZQ18EZM40WE9', '01KD7X9CXMVFM1A0TAR6EHHR5G', '01KCRCZQMC9QNDV4H0JJRCBHD9', 'MEREKA', 1, '2025-12-24 17:08:18'),
('01KD7X9CXMXQHZ1D81Z716JS4J', '01KD7X9CXMVFM1A0TAR6EHHR5G', '01KCY42B1K9RC45M0H9W4A8CSY', 'KALIAN', 1, '2025-12-24 17:08:18'),
('01KDF126T5T0J5D12QT3BMKYZZ', '01KDF126T56MY2VJN5TMRVFTBV', '01KCRCZQMC9QNDV4H0JJRCBHD9', 'MEREKA', 1, '2025-12-27 11:28:58'),
('01KDFZC6VCT065KXYKR39S411G', '01KDFZC6VCDYZ1AM2S3ENM6XF5', '01KCRCZQMC9QNDV4H0JJRCBHD9', 'MEREKA', 1, '2025-12-27 20:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts_questions`
--

CREATE TABLE `pbl_tts_questions` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tts_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `direction` enum('across','down') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_x` int DEFAULT '1',
  `start_y` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts_questions`
--

INSERT INTO `pbl_tts_questions` (`id`, `tts_id`, `number`, `direction`, `question`, `answer`, `start_x`, `start_y`, `created_at`) VALUES
('01KAR25DRCMG96KXHYZ8G4QK6X', '01K9BNTQP0WNJEWQ6H48J1KNJR', 1, 'across', 'Haus', 'MINUM', 1, 1, '2025-11-23 16:54:16'),
('01KATJT02QY755SYVEF7ENAC7J', '01K9BNTQP0WNJEWQ6H48J1KNJR', 1, 'down', 'bintang', 'MALAM', 1, 1, '2025-11-24 16:23:36'),
('01KCRCZQMC9QNDV4H0JJRCBHD9', '01KCRCZ7Q1YD8M2JXVSX7H2G42', 1, 'across', 'Siapakah', 'MEREKA', 4, 1, '2025-12-18 16:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts_results`
--

CREATE TABLE `pbl_tts_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tts_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `total_correct` int NOT NULL,
  `total_questions` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts_results`
--

INSERT INTO `pbl_tts_results` (`id`, `tts_id`, `user_id`, `score`, `total_correct`, `total_questions`, `created_at`) VALUES
('01KDF126T56MY2VJN5TMRVFTBV', '01KCRCZ7Q1YD8M2JXVSX7H2G42', '01K94KA9TRKC5ZEAPM3PRKVP9S', 100, 1, 1, '2025-12-27 11:28:58'),
('01KDFZC6VCDYZ1AM2S3ENM6XF5', '01KCRCZ7Q1YD8M2JXVSX7H2G42', '01K912FR1QZHEWJ6MCVK8WEK5V', 100, 1, 1, '2025-12-27 20:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
('01K8WA6A9HTVM98RYM1P5ZWNYH', 'Admin'),
('01K8WA6WVXEKX7JK822G9PVZG9', 'Guru'),
('01K8WA74MMB7VBRM1Y05NS7GNQ', 'Siswa'),
('01K8WA7CX41SY2BEDRT2QBXQ7Q', 'Tamu');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `address`, `created_at`) VALUES
('01K8ZAAFMB5A11GW0PCX2W793X', 'SD 01 Bahagia', 'Jalan Bahagia 01', '2025-11-01 16:00:08'),
('01K8ZB7PXYMHWEQ4K6C5651EB1', 'SD 02 Pantai Hurip', 'Pantai Hurip, Babelan', '2025-11-01 16:16:05'),
('01K8ZBQ39A778289E67FJD2XY3', 'SD 01 Babelan', 'Ujung Harapan, Babelan', '2025-11-01 16:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `class_id`, `created_at`) VALUES
('01K9A3CMSD46G85CSDZPSMQCX6', '01K912FR1QZHEWJ6MCVK8WEK5V', '01K92EK6YBT0FSC80TDYYD3ZN2', '2025-11-05 20:30:37'),
('01KA3AJMXBWYDCS60QFP26Y9CX', '01K94KA9TRKC5ZEAPM3PRKVP9S', '01K92EK6YBT0FSC80TDYYD3ZN2', '2025-11-15 15:37:15'),
('01KDJMXK2A8DS0TZHP8WN5AQ2Q', '01K976AHZGDA70DMQ7M9MF6SHS', '01KDJMXAYHPMHEP86J0Q1TWDPQ', '2025-12-28 21:13:41'),
('01KDJMXPBY4VHA29A7YVX0CRT4', '01KDJMKX3FBSMWGKZAP2GSF7SE', '01KDJMXAYHPMHEP86J0Q1TWDPQ', '2025-12-28 21:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `school_id`, `created_at`) VALUES
('01K91853QK4JH6WM8C5618YK6Z', '01K91853JEGYFN8Z034389ETB3', '01K8ZB7PXYMHWEQ4K6C5651EB1', '2025-11-02 10:00:43'),
('01K974STT5E77FJFV23HJY0Q80', '01K974STMBGJGP4BEC1C216M48', '01K8ZAAFMB5A11GW0PCX2W793X', '2025-11-04 16:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '01K8WA74MMB7VBRM1Y05NS7GNQ',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'foto.jpg',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `name`, `email`, `image`, `is_active`, `created_at`) VALUES
('01K8WAF2VCSHCNQYZQNDQ0K806', 'test', '$2y$10$ZBicPw.RXfH2mZVnD.IHruqGGg9S8pVR/cQWGOnujiryKogfnqakq', '01K8WA6A9HTVM98RYM1P5ZWNYH', 'adm', 'test@example.com', 'profile_01K8WAF2VCSHCNQYZQNDQ0K806_1766979677.jpg', 1, '2025-10-31 12:04:55'),
('01K8WTRAA9YN933F4BJ2NXXNKQ', 'guru', '$2y$10$H3S1k38s5/ItrsR.6fOKI.4z74dJtcmHe/AUts9cee6T6rXYkpWJy', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru_ipas', 'guru_ipas@example.com', 'foto.jpg', 1, '2025-10-31 16:49:35'),
('01K912FR1QZHEWJ6MCVK8WEK5V', 'murid', '$2y$10$Sl7f2LZh5aRqpR1HwsGlwumimlhdRlWVrXBBCu6QlRbz8OA7APJbK', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid', 'murid@mu.rid', 'profile_01K912FR1QZHEWJ6MCVK8WEK5V_1766980198.jpg', 1, '2025-11-02 08:21:41'),
('01K91853JEGYFN8Z034389ETB3', 'guru_pkn', '$2y$10$BSu7zVS5g04VE8lL2rE1v.HoMMPktC87r6l/v9uAS6Bq29SSM44Uq', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru PKN', 'guru@guru2.id', 'profile_01K91853JEGYFN8Z034389ETB3_1766979821.jpg', 1, '2025-11-02 10:00:43'),
('01K94KA9TRKC5ZEAPM3PRKVP9S', 'murid_2', '$2y$10$U/opFpM538ZKLQf2OSF.3evyqEERt/bA4bsxaDsWL4nFqQi1SlRIe', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid2', 'murid@mu.rid2', 'foto.jpg', 1, '2025-11-03 17:13:31'),
('01K974STMBGJGP4BEC1C216M48', 'guru_ipas', '$2y$10$f0IWScMr4dFKCCb3GI1ji.30AITxeDIFA.3iuz2cKK8z38R7DBCA2', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru Ipas', 'guru@guru3.id', 'foto.jpg', 1, '2025-11-04 16:57:35'),
('01K976AHZGDA70DMQ7M9MF6SHS', 'murid_3', '$2y$10$QpYl4IuqPUX1JXXgnhoN4OBg.nPy5Ra/9rPmEvtURp7UtkRcXqh/G', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid3', 'murid@mu.rid3', 'profile_01K976AHZGDA70DMQ7M9MF6SHS_1766980257.jpg', 1, '2025-11-04 17:24:11'),
('01KDJMKX3FBSMWGKZAP2GSF7SE', 'murid4', '$2y$10$z41SgYGaOkGfcurVi2AzKe1v1LyhOWGg3BhWO3eKslMtMnSPEMh4a', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid4', 'murid@mu.rid4', 'foto.jpg', 1, '2025-12-28 21:08:24'),
('01KDJMWD7E8SW5XE0J2VZ6JC8Q', 'murid5', '$2y$10$zGqcRJDXIv2kpM3CrOUVWOx8ocjgEj.uu5/eT0LPITCM.d33QC2Xe', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid5', 'murid@mu.rid5', 'foto.jpg', 1, '2025-12-28 21:13:02'),
('01KDJMZ4C6KKWZK3GSV8E3P90T', 'murid6', '$2y$10$F7pW.ky3xNjDvn.8I1EuPOO5cXh3hE0QYBzCPWyFMRyEjRFRSE0..', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid6', 'murid@mu.rid6', 'foto.jpg', 1, '2025-12-28 21:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int NOT NULL,
  `role_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, '01K8WA6A9HTVM98RYM1P5ZWNYH', 1),
(2, '01K8WA6A9HTVM98RYM1P5ZWNYH', 2),
(3, '01K8WA6A9HTVM98RYM1P5ZWNYH', 3),
(4, '01K8WA6A9HTVM98RYM1P5ZWNYH', 4),
(5, '01K8WA6WVXEKX7JK822G9PVZG9', 2),
(6, '01K8WA74MMB7VBRM1Y05NS7GNQ', 3),
(7, '01K8WA6A9HTVM98RYM1P5ZWNYH', 6),
(8, '01K8WA6WVXEKX7JK822G9PVZG9', 6),
(9, '01K8WA74MMB7VBRM1Y05NS7GNQ', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int NOT NULL,
  `menu` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Guru'),
(3, 'Siswa'),
(4, 'Menu'),
(6, 'Profile');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int NOT NULL,
  `menu_id` int NOT NULL,
  `title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard Admin', 'admin/dashboard', 'bi-grid', 1),
(2, 1, 'Kelola Sekolah', 'admin/dashboard/schools', 'bi-building', 1),
(3, 1, 'Kelola Guru', 'admin/dashboard/teachers', 'bi-person', 1),
(4, 1, 'Kelola Murid', 'admin/dashboard/students', 'bi-people', 1),
(5, 4, 'Kelola Menu', 'menu', 'bi-folder', 1),
(6, 4, 'Kelola Submenu', 'menu/submenu', 'bi-folder2-open', 1),
(10, 2, 'Dashboard Guru', 'guru/dashboard', 'bi-grid', 1),
(11, 3, 'Dashboard Siswa', 'siswa/dashboard', 'bi-grid', 1),
(12, 6, 'Profile', 'profile', 'bi-person', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_class_reflections`
--
ALTER TABLE `pbl_class_reflections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_discussion_topics`
--
ALTER TABLE `pbl_discussion_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_essay_questions`
--
ALTER TABLE `pbl_essay_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_essay` (`essay_id`);

--
-- Indexes for table `pbl_essay_submissions`
--
ALTER TABLE `pbl_essay_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `essay_id` (`essay_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_evaluation_quizzes`
--
ALTER TABLE `pbl_evaluation_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_evaluation_quiz_questions`
--
ALTER TABLE `pbl_evaluation_quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `pbl_final_reflections`
--
ALTER TABLE `pbl_final_reflections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_final_results`
--
ALTER TABLE `pbl_final_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_class` (`class_id`,`user_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_forum_posts`
--
ALTER TABLE `pbl_forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_observation_results`
--
ALTER TABLE `pbl_observation_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_observation_slots`
--
ALTER TABLE `pbl_observation_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_observation_uploads`
--
ALTER TABLE `pbl_observation_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `observation_slot_id` (`observation_slot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_quizzes`
--
ALTER TABLE `pbl_quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_quiz_answers`
--
ALTER TABLE `pbl_quiz_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_quiz_questions`
--
ALTER TABLE `pbl_quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `pbl_quiz_results`
--
ALTER TABLE `pbl_quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_reflection`
--
ALTER TABLE `pbl_reflection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_reflections`
--
ALTER TABLE `pbl_reflections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_class_user` (`class_id`,`user_id`);

--
-- Indexes for table `pbl_solution_essays`
--
ALTER TABLE `pbl_solution_essays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_tts`
--
ALTER TABLE `pbl_tts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_tts_answers`
--
ALTER TABLE `pbl_tts_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_tts_questions`
--
ALTER TABLE `pbl_tts_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_tts_results`
--
ALTER TABLE `pbl_tts_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tts_id` (`tts_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pbl_essay_questions`
--
ALTER TABLE `pbl_essay_questions`
  ADD CONSTRAINT `fk_question_essay` FOREIGN KEY (`essay_id`) REFERENCES `pbl_solution_essays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_essay_submissions`
--
ALTER TABLE `pbl_essay_submissions`
  ADD CONSTRAINT `pbl_essay_submissions_ibfk_1` FOREIGN KEY (`essay_id`) REFERENCES `pbl_solution_essays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_evaluation_quiz_questions`
--
ALTER TABLE `pbl_evaluation_quiz_questions`
  ADD CONSTRAINT `pbl_eval_quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `pbl_evaluation_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_forum_posts`
--
ALTER TABLE `pbl_forum_posts`
  ADD CONSTRAINT `pbl_forum_posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `pbl_discussion_topics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pbl_forum_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_observation_uploads`
--
ALTER TABLE `pbl_observation_uploads`
  ADD CONSTRAINT `fk_obs_slot` FOREIGN KEY (`observation_slot_id`) REFERENCES `pbl_observation_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_quiz_questions`
--
ALTER TABLE `pbl_quiz_questions`
  ADD CONSTRAINT `pbl_quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `pbl_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
