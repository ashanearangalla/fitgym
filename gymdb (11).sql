-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 04:02 AM
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
-- Database: `gymdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `userID`) VALUES
(1, 9),
(2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `classenrollments`
--

CREATE TABLE `classenrollments` (
  `classEnrollmentID` int(11) NOT NULL,
  `classID` int(11) DEFAULT NULL,
  `memberID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classenrollments`
--

INSERT INTO `classenrollments` (`classEnrollmentID`, `classID`, `memberID`) VALUES
(1, 1, 2),
(2, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classID` int(11) NOT NULL,
  `className` varchar(100) NOT NULL,
  `classimage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`classID`, `className`, `classimage`) VALUES
(1, 'Yoga', 'https://cdn.sanity.io/images/uhnffrl6/production/f0af474c76ad9c7606a3c0f7ce8c472bf0f57661-6000x4000.jpg?w=1200&fit=min&auto=format'),
(2, 'CrossFit Beginners Class', 'https://artofhealthyliving.com/wp-content/uploads/2021/04/planning-a-new-crossfit-gym.jpg'),
(3, 'Zumba', 'https://www.liveabout.com/thmb/ia9vTGzC4fnTxr09GLjurYFzIUM=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/dance-fitness-1067009516-5c81907946e0fb0001136604.jpg'),
(4, 'CrossFit Olympic Lifting', 'assets/images/0011.jpg'),
(7, 'NoRa', 'assets/images/icon.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `classschedule`
--

CREATE TABLE `classschedule` (
  `classScheduleID` int(11) NOT NULL,
  `classID` int(11) DEFAULT NULL,
  `timeslotID` int(11) DEFAULT NULL,
  `day` enum('Mon','Tue','Wed','Thu','Fri','Sat') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classschedule`
--

INSERT INTO `classschedule` (`classScheduleID`, `classID`, `timeslotID`, `day`) VALUES
(1, 1, 1, 'Mon'),
(2, 2, 1, 'Tue'),
(3, 1, 1, 'Wed'),
(4, 3, 1, 'Thu'),
(5, 4, 1, 'Fri'),
(6, 1, 1, 'Sat'),
(7, 2, 2, 'Mon'),
(8, 1, 2, 'Tue'),
(9, 2, 2, 'Wed'),
(10, 4, 2, 'Thu'),
(11, 3, 2, 'Fri'),
(12, 2, 2, 'Sat'),
(13, 3, 3, 'Mon'),
(14, 4, 3, 'Tue'),
(15, 3, 3, 'Wed'),
(16, 2, 3, 'Thu'),
(17, 1, 3, 'Fri'),
(18, 3, 3, 'Sat'),
(19, 1, 4, 'Mon'),
(20, 2, 4, 'Tue'),
(21, 1, 4, 'Wed'),
(22, 3, 4, 'Thu'),
(23, 4, 4, 'Fri'),
(24, 1, 4, 'Sat'),
(25, 2, 5, 'Mon'),
(26, 1, 5, 'Tue'),
(27, 2, 5, 'Wed'),
(28, 1, 5, 'Thu'),
(29, 3, 5, 'Fri'),
(30, 2, 5, 'Sat'),
(33, 7, 4, 'Mon');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Namal', 'namal@gmail.com', 'Hi', '2024-07-18 11:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `memberenrollments`
--

CREATE TABLE `memberenrollments` (
  `enrollmentID` int(11) NOT NULL,
  `memberID` int(11) DEFAULT NULL,
  `subPackageID` int(11) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberenrollments`
--

INSERT INTO `memberenrollments` (`enrollmentID`, `memberID`, `subPackageID`, `startDate`, `endDate`) VALUES
(1, 1, 7, '2024-07-01', '2024-10-01'),
(2, 2, 15, '2024-07-01', '2024-08-01'),
(3, 3, 2, '2024-07-01', '2024-08-01'),
(5, 6, 2, '2024-07-19', '2024-08-19'),
(6, 9, 15, '2024-07-19', '2024-08-19'),
(7, 10, 15, '2024-07-19', '2024-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `healthConcerns` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `userID`, `healthConcerns`, `dob`, `join_date`) VALUES
(1, 11, '', '1997-07-02', '2024-07-01'),
(2, 12, '', '1988-07-15', '2024-07-01'),
(3, 13, '', '1994-07-15', '2024-07-01'),
(6, 41, 'Nothing', '2024-07-25', '2024-07-19'),
(8, 44, 'no', '2004-06-25', '2024-07-19'),
(9, 45, 'No', '2003-03-21', '2024-07-19'),
(10, 46, 'No', '2003-12-11', '2024-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `packageID` int(11) NOT NULL,
  `packageName` varchar(100) NOT NULL,
  `packageType` enum('individual','family','casual','couple','personal_training') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`packageID`, `packageName`, `packageType`) VALUES
(1, 'Individual Membership', 'individual'),
(2, 'Couple Membership', 'couple'),
(3, 'Family Membership', 'family'),
(4, 'Casual Day Payment', 'casual'),
(5, 'Personal Training', 'personal_training');

-- --------------------------------------------------------

--
-- Table structure for table `subpackages`
--

CREATE TABLE `subpackages` (
  `subPackageID` int(11) NOT NULL,
  `packageID` int(11) DEFAULT NULL,
  `duration` enum('1_month','3_months','6_months','12_months','1_session') NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subpackages`
--

INSERT INTO `subpackages` (`subPackageID`, `packageID`, `duration`, `price`) VALUES
(1, 1, '12_months', 36000.00),
(2, 1, '1_month', 5000.00),
(3, 1, '3_months', 12500.00),
(4, 1, '6_months', 21500.00),
(5, 2, '12_months', 68000.00),
(6, 2, '1_month', 9000.00),
(7, 2, '3_months', 24500.00),
(8, 2, '6_months', 42500.00),
(9, 3, '12_months', 96000.00),
(10, 3, '1_month', 12500.00),
(11, 3, '3_months', 35000.00),
(12, 3, '6_months', 60000.00),
(13, 4, '1_session', 1000.00),
(14, 5, '12_months', 72000.00),
(15, 5, '1_month', 8000.00),
(16, 5, '3_months', 22000.00),
(17, 5, '6_months', 38000.00);

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `timeslotID` int(11) NOT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`timeslotID`, `startTime`, `endTime`) VALUES
(1, '06:00:00', '07:00:00'),
(2, '08:00:00', '09:00:00'),
(3, '10:00:00', '11:00:00'),
(4, '17:00:00', '18:00:00'),
(5, '19:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `trainerID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `imageurl` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainerID`, `userID`, `title`, `about`, `imageurl`) VALUES
(1, 14, 'Fitness lifestyle and weight management consultant', 'Hello, I\'m Sanjeiwa Rathnayake, the owner of FITNESS WORLD. With over 15 years of experience in the fitness industry, I specialize in fitness lifestyle coaching and weight management. My passion is to inspire and help individuals transform their lives through fitness and healthy living.', 'assets/images/006.jpg'),
(2, 15, 'Mister Fitness Supermodel Srilanka 2024', 'Hi, I\'m Anjana Sameera, a passionate fitness trainer with a background in competitive bodybuilding and fitness modeling. I have been in the fitness industry for over 10 years and specialize in strength training, nutrition, and holistic wellness. My goal is to help my clients achieve their fitness goals and lead healthier, more active lives.', 'assets/images/004.jpg'),
(3, 16, 'Fitness trainer', 'Hello, I\'m Lakash Atputharaja, a certified fitness trainer with a passion for helping clients achieve their fitness goals. With over 8 years of experience in the fitness industry, I specialize in personal training, strength conditioning, and weight loss programs. My approach to fitness is holistic, focusing on both physical and mental well-being.', 'assets/images/005.jpg'),
(4, 17, 'Fitness trainer', 'Hello, I\'m Ravindu Theekshana, a senior fitness trainer with a decade of experience in helping clients achieve their fitness goals. My expertise lies in functional training, HIIT, and personalized fitness coaching. I believe in a balanced approach to fitness, integrating strength, endurance, and flexibility training for optimal results.', 'assets/images/007.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `trainerspecialties`
--

CREATE TABLE `trainerspecialties` (
  `specialityID` int(11) NOT NULL,
  `trainerID` int(11) NOT NULL,
  `specialty` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainerspecialties`
--

INSERT INTO `trainerspecialties` (`specialityID`, `trainerID`, `specialty`) VALUES
(1, 1, 'Fitness Lifestyle Coaching'),
(2, 1, 'Weight Management'),
(3, 1, 'Strength Training'),
(4, 1, 'Nutrition Planning'),
(5, 1, 'Personalized Fitness Programs'),
(6, 2, 'Strength Training'),
(7, 2, 'Nutrition and Diet Planning'),
(8, 2, 'Bodybuilding'),
(9, 2, 'Holistic Wellness'),
(10, 2, 'Personalized Fitness Programs'),
(11, 3, 'Personal Training'),
(12, 3, 'Strength Conditioning'),
(13, 3, 'Weight Loss Programs'),
(14, 3, 'Cardiovascular Training'),
(15, 3, 'Nutrition Guidance'),
(16, 4, 'Functional Training'),
(17, 4, 'High-Intensity Interval Training (HIIT)'),
(18, 4, 'Personalized Fitness Coaching'),
(19, 4, 'Endurance Training'),
(20, 4, 'Flexibility and Mobility Work');

-- --------------------------------------------------------

--
-- Table structure for table `trainingschedules`
--

CREATE TABLE `trainingschedules` (
  `scheduleID` int(11) NOT NULL,
  `trainerID` int(11) DEFAULT NULL,
  `timeslotID` int(11) DEFAULT NULL,
  `availableDate` enum('weekdays','saturday','monday','tuesday','wednesday','thursday','friday') DEFAULT NULL,
  `sessionType` enum('private','public','','') DEFAULT NULL,
  `enrollmentID` int(11) DEFAULT NULL,
  `sessionStatus` varchar(100) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainingschedules`
--

INSERT INTO `trainingschedules` (`scheduleID`, `trainerID`, `timeslotID`, `availableDate`, `sessionType`, `enrollmentID`, `sessionStatus`) VALUES
(1, 1, 1, 'weekdays', 'public', NULL, 'Active'),
(2, 1, 4, 'weekdays', 'public', NULL, 'Active'),
(3, 1, 3, 'saturday', 'public', NULL, 'Active'),
(4, 2, 1, 'weekdays', 'public', NULL, 'Active'),
(5, 2, 4, 'weekdays', 'public', NULL, 'Active'),
(6, 2, 2, 'saturday', 'public', NULL, 'Active'),
(7, 3, 1, 'weekdays', 'public', NULL, 'Active'),
(8, 3, 4, 'weekdays', 'public', NULL, 'Active'),
(9, 3, 3, 'saturday', 'public', NULL, 'Active'),
(10, 4, 1, 'weekdays', 'public', NULL, 'Active'),
(11, 4, 4, 'weekdays', 'public', NULL, 'Active'),
(12, 4, 5, 'saturday', 'public', NULL, 'Active'),
(20, 1, 2, 'monday', 'private', 2, 'Cancelled'),
(21, 1, 2, 'wednesday', 'private', 7, 'Booked'),
(25, 3, 2, 'friday', 'private', NULL, 'Not Booked'),
(26, 1, 3, 'thursday', 'private', NULL, 'Not Booked'),
(27, 1, 5, 'saturday', 'private', NULL, 'Not Booked');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text DEFAULT NULL,
  `contactNo` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` enum('Member','Trainer','Admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `contactNo`, `name`, `role`) VALUES
(9, 'admin@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '1234567890', 'Admin One', 'Admin'),
(10, 'admin2@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '0987654321', 'Admin Two', 'Admin'),
(11, 'saman@gmail.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '1112223334', 'Saman fernando', 'Member'),
(12, 'piyal@gmail.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '5556667778', 'Piyal Perera', 'Member'),
(13, 'nimal@gmail.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '9990001112', 'Nimal Jayasanka', 'Member'),
(14, 'sanjeiwa.rathnayake@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '123', 'Sanjeiva Rathnayake', 'Trainer'),
(15, 'anjana.sameera@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '1234567892', 'Anjana Sameera', 'Trainer'),
(16, 'lakash.atputharaja@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '1234567893', 'Lakash Atputharaja', 'Trainer'),
(17, 'ravidu.theekshana@fitnessworld.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '1234567894', 'Ravidu Theekshana', 'Trainer'),
(33, 'saranga@gmail.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '0776521122', 'Saranga Disasekara', 'Member'),
(41, 'thilanga@gmail.com', '$2y$10$sLgKjSg5m0DDPZWsa23pCePu4uzv.GvjuTcUh2HAquHPR2cv2i8i.', '0776544455', 'Thilanga Sumathipala', 'Member'),
(44, 'ediri@gmail.com', '$2y$10$liLt3rxA.cr7Qpt773YM6.KWs18ke93GZ8RmhOndoWockiXg0BDpS', '111', 'Saman Edirimuni', 'Member'),
(45, 'thilina@gmail.com', '123', '0776542211', 'Thilina Kandamby', 'Member'),
(46, 'sajith@gmail.com', '$2y$10$lg4lNrfTRnoQID3WVocS7uvyVXwRJIJCGIiIuKnQAY0wHyHjRladi', '1190', 'Sajith Premadasa', 'Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- Indexes for table `classenrollments`
--
ALTER TABLE `classenrollments`
  ADD PRIMARY KEY (`classEnrollmentID`),
  ADD KEY `classenrollments_ibfk_1` (`classID`),
  ADD KEY `classenrollments_ibfk_2` (`memberID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `classschedule`
--
ALTER TABLE `classschedule`
  ADD PRIMARY KEY (`classScheduleID`),
  ADD KEY `classschedule_ibfk_1` (`classID`),
  ADD KEY `classschedule_ibfk_2` (`timeslotID`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberenrollments`
--
ALTER TABLE `memberenrollments`
  ADD PRIMARY KEY (`enrollmentID`),
  ADD KEY `memberenrollments_ibfk_1` (`memberID`),
  ADD KEY `memberenrollments_ibfk_2` (`subPackageID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`packageID`);

--
-- Indexes for table `subpackages`
--
ALTER TABLE `subpackages`
  ADD PRIMARY KEY (`subPackageID`),
  ADD KEY `subpackages_ibfk_1` (`packageID`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`timeslotID`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`trainerID`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- Indexes for table `trainerspecialties`
--
ALTER TABLE `trainerspecialties`
  ADD PRIMARY KEY (`specialityID`),
  ADD KEY `fk_trainerID3` (`trainerID`);

--
-- Indexes for table `trainingschedules`
--
ALTER TABLE `trainingschedules`
  ADD PRIMARY KEY (`scheduleID`),
  ADD KEY `fk_enrolid3` (`enrollmentID`),
  ADD KEY `trainingschedules_ibfk_1` (`trainerID`),
  ADD KEY `trainingschedules_ibfk_2` (`timeslotID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classenrollments`
--
ALTER TABLE `classenrollments`
  MODIFY `classEnrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classschedule`
--
ALTER TABLE `classschedule`
  MODIFY `classScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberenrollments`
--
ALTER TABLE `memberenrollments`
  MODIFY `enrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `packageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subpackages`
--
ALTER TABLE `subpackages`
  MODIFY `subPackageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `timeslotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `trainerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `trainerspecialties`
--
ALTER TABLE `trainerspecialties`
  MODIFY `specialityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `trainingschedules`
--
ALTER TABLE `trainingschedules`
  MODIFY `scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classenrollments`
--
ALTER TABLE `classenrollments`
  ADD CONSTRAINT `classenrollments_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classenrollments_ibfk_2` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classschedule`
--
ALTER TABLE `classschedule`
  ADD CONSTRAINT `classschedule_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classschedule_ibfk_2` FOREIGN KEY (`timeslotID`) REFERENCES `timeslots` (`timeslotID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `memberenrollments`
--
ALTER TABLE `memberenrollments`
  ADD CONSTRAINT `memberenrollments_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memberenrollments_ibfk_2` FOREIGN KEY (`subPackageID`) REFERENCES `subpackages` (`subPackageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subpackages`
--
ALTER TABLE `subpackages`
  ADD CONSTRAINT `subpackages_ibfk_1` FOREIGN KEY (`packageID`) REFERENCES `packages` (`packageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainerspecialties`
--
ALTER TABLE `trainerspecialties`
  ADD CONSTRAINT `fk_trainerID3` FOREIGN KEY (`trainerID`) REFERENCES `trainers` (`trainerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainingschedules`
--
ALTER TABLE `trainingschedules`
  ADD CONSTRAINT `fk_enrolid3` FOREIGN KEY (`enrollmentID`) REFERENCES `memberenrollments` (`enrollmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trainingschedules_ibfk_1` FOREIGN KEY (`trainerID`) REFERENCES `trainers` (`trainerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trainingschedules_ibfk_2` FOREIGN KEY (`timeslotID`) REFERENCES `timeslots` (`timeslotID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
