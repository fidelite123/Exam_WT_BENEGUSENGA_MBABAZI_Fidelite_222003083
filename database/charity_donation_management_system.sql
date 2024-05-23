-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 10:01 AM
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
-- Database: `charity_donation_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `charity_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `goal_amount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `current_amount_raised` decimal(10,2) DEFAULT 0.00,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`campaign_id`, `charity_id`, `name`, `goal_amount`, `description`, `start_date`, `end_date`, `current_amount_raised`, `status`, `created_at`) VALUES
(1, 1, 'Plant Trees', 10000.00, 'A campaign to plant 1000 trees.', '2024-01-01', '2024-12-31', 0.00, 'active', '2024-05-16 11:57:33'),
(2, 2, 'Winter Shelter', 5000.00, 'Provide winter shelter for the homeless.', '2024-01-01', '2024-03-31', 0.00, 'active', '2024-05-16 11:57:33'),
(3, 3, 'School Supplies', 3000.00, 'Provide school supplies to underprivileged children.', '2024-06-01', '2024-08-31', 0.00, 'active', '2024-05-16 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `charities`
--

CREATE TABLE `charities` (
  `charity_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `registration_details` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `mission_statement` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charities`
--

INSERT INTO `charities` (`charity_id`, `name`, `registration_details`, `contact_info`, `mission_statement`, `created_at`) VALUES
(1, 'Save the Earth', 'REG123456', '123 Green St, Eco City', 'Promote environmental sustainability.', '2024-05-16 11:57:33'),
(2, 'Help the Homeless', 'REG654321', '456 Shelter Ave, Kindtown', 'Provide shelter and support to homeless individuals.', '2024-05-16 11:57:33'),
(3, 'Education for All', 'REG112233', '789 Learning Rd, Edutown', 'Ensure access to education for all children.', '2024-05-16 11:57:33'),
(5, 'sdfg', 'qwert', 'asdfg', 'aerty', '2024-05-19 19:50:59'),
(6, 'sdfg', 'qwert', 'asdfg', 'aerty', '2024-05-19 20:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`donation_id`, `campaign_id`, `donor_id`, `amount`, `date`, `payment_method`) VALUES
(1, 1, 1, 100.00, '2024-05-16 12:09:37', 'Credit Card'),
(2, 2, 2, 50.00, '2024-05-16 12:09:37', 'PayPal'),
(3, 3, 3, 30.00, '2024-05-16 12:09:37', 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `donordetails`
--

CREATE TABLE `donordetails` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `preferred_causes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donordetails`
--

INSERT INTO `donordetails` (`donor_id`, `name`, `contact_info`, `preferred_causes`, `created_at`) VALUES
(1, 'Emily Green', 'emily.green@example.com', 'Environment', '2024-05-16 11:57:33'),
(2, 'David Black', 'david.black@example.com', 'Homelessness', '2024-05-16 11:57:33'),
(3, 'Sophia White', 'sophia.white@example.com', 'Education', '2024-05-16 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `goal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `campaign_id`, `name`, `date`, `location`, `description`, `goal`, `created_at`) VALUES
(1, 1, 'Tree Planting Day', '2024-04-22', 'Central Park', 'Join us to plant trees.', 2000.00, '2024-05-16 11:57:33'),
(2, 2, 'Shelter Opening', '2024-01-15', '456 Shelter Ave', 'Opening of the new winter shelter.', 1000.00, '2024-05-16 11:57:33'),
(3, 3, 'Back to School Fair', '2024-07-15', '789 Learning Rd', 'Fair to distribute school supplies.', 1500.00, '2024-05-16 11:57:33'),
(5, 1, 'sdg', '2024-05-02', 'sdf', 'asd', 0.00, '2024-05-18 16:25:33');

-- --------------------------------------------------------

--
-- Table structure for table `eventvolunteers`
--

CREATE TABLE `eventvolunteers` (
  `event_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventvolunteers`
--

INSERT INTO `eventvolunteers` (`event_id`, `volunteer_id`) VALUES
(1, 1),
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fundraisers`
--

CREATE TABLE `fundraisers` (
  `fundraiser_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `total_amount_raised` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fundraisers`
--

INSERT INTO `fundraisers` (`fundraiser_id`, `user_id`, `campaign_id`, `total_amount_raised`) VALUES
(1, 2, 1, 500.00),
(2, 2, 2, 250.00),
(3, 2, 3, 150.00),
(4, 1, 1, 23456.00),
(5, 1, 1, 23456.00),
(6, 1, 2, 23456.00);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `report_type` varchar(50) DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `related_campaigns` text DEFAULT NULL,
  `related_donors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `report_type`, `generated_at`, `related_campaigns`, `related_donors`) VALUES
(1, 1, 'Financial', '2024-05-16 11:57:33', '1,2', '1,2'),
(2, 1, 'Progress', '2024-05-16 11:57:33', '3', '3'),
(3, 2, 'Impact', '2024-05-16 11:57:33', '1,3', '1,3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `address`, `phone_number`, `password`, `role`, `created_at`) VALUES
(1, 'Alice Johnson', 'alice@example.com', 'musanze', '23456789', 'password123', 'admin', '2024-05-16 11:57:33'),
(2, 'Bob Smith', 'bob@example.com', 'kicukiro', '234567890', 'password123', 'fundraiser', '2024-05-16 11:57:33'),
(3, 'Charlie Brown', 'charlie@example.com', 'gasabo', '123456789', 'password123', 'volunteer', '2024-05-16 11:57:33'),
(4, 'keke', 'keke@gmail.com', 'nyarugenge', '23456789', '$2y$10$v1DUwCTHAW20DSm4B2BkxeJRZs6UpeWU0ybFLNhjT5PZ9EMik818W', 'user', '2024-05-16 12:38:12'),
(7, 'vivi', 'vivi@gmail.com', 'kicukiro', '09876543', '$2y$10$uHLnvHcpEQFCcu9zp1mLFuYZFPlhRdpFQ.nwzLBASGCNBKA3tDLGu', 'user', '2024-05-16 12:52:42'),
(8, 'teta', 'teta@gmail.com', 'huye', '987655678', '$2y$10$KPXTDjryBKv0MIeeGXBR5O3pQjQIRpsyfnuOI4S0TCB8/3lAajJNa', 'user', '2024-05-16 13:02:51'),
(9, 'teta', 'tet@gmail.com', 'rwamagana', '23456789', '$2y$10$GsvhV4iih5g7YhXo4E6HOOin6r/3mL4YNG8n5YAQl.fCMZJV/yize', 'user', '2024-05-16 13:27:04'),
(10, 'Didas', 'dd@gmail.com', 'kayonza', '2345678', '$2y$10$E/1g1vgmS77H5fKFkAZbPengV8nwBG.eGGYbbK0s2n9JAXUkWv1IC', 'user', '2024-05-16 13:35:37'),
(15, '', 'fils@gmail.com', 'kicukiro', '3456789', '$2y$10$E3NMzoegxc.YKb.xNlikAOv9/..NTvYEvPxKH4KGkpfZodg1MSvKe', 'user', '2024-05-18 08:39:33'),
(16, '', 'fillete@gmail.com', 'kicukiro', '234567890', '$2y$10$FI7.Fyl1R.r5Ajr/zNjQMufsRqfBEJPLXZaikn.fbVbIixAJ.wdNu', 'donor', '2024-05-18 08:44:07'),
(17, 'sdfghj', 'wertyuj@gmail.com', 'wertyui', 'wertyu', '$2y$10$PjiixEVWddoQE8UwXFcLieQafs0xJLG7C7XKMh7FG2VSolwjLiC6a', 'user', '2024-05-18 08:48:23'),
(18, 'louise', 'louise@gmail.html', 'gasabo', '12345678', '$2y$10$H0dTAL/QSzzCjqAjKa7dZuPFVo8Smhy4P6AMcMgXbkD1bMY.haWq2', 'manager', '2024-05-18 09:17:27'),
(19, 'nepo', 'nepo@gmail.com', 'Rwanda', '78543787', '$2y$10$9h53iyYAf/3NgVIZJ6LJSu1YZi.B6XKTYFW2ae/07A1NX6C3Evjk.', 'user', '2024-05-22 20:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `assigned_tasks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`volunteer_id`, `name`, `contact_info`, `skills`, `availability`, `assigned_tasks`, `created_at`) VALUES
(1, 'Daniel Green', 'daniel.green@example.com', 'Tree Planting, Event Coordination', 'Weekends', 'Assist in tree planting events.', '2024-05-16 11:57:33'),
(2, 'Rachel Brown', 'rachel.brown@example.com', 'Cooking, Shelter Management', 'Weekdays', 'Assist in the shelter.', '2024-05-16 11:57:33'),
(3, 'Laura White', 'laura.white@example.com', 'Teaching, Event Coordination', 'Evenings', 'Assist in school supply distribution.', '2024-05-16 11:57:33'),
(35, 'erty', 'qwer', 'wert', 'wert', 'sdf', '2024-05-18 14:07:23'),
(36, 'kjhytr', 'jhgfd', 'kjuhytrs', 'jhgfd', 'jhgfd', '2024-05-18 14:30:38'),
(37, 'kjhytr', 'jhgfd', 'kjuhytrs', 'jhgfd', 'jhgfd', '2024-05-18 14:32:14'),
(38, 'kjhytr', 'jhgfd', 'kjuhytrs', 'jhgfd', 'jhgfu', '2024-05-18 14:36:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `charity_id` (`charity_id`);

--
-- Indexes for table `charities`
--
ALTER TABLE `charities`
  ADD PRIMARY KEY (`charity_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `donordetails`
--
ALTER TABLE `donordetails`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `eventvolunteers`
--
ALTER TABLE `eventvolunteers`
  ADD PRIMARY KEY (`event_id`,`volunteer_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Indexes for table `fundraisers`
--
ALTER TABLE `fundraisers`
  ADD PRIMARY KEY (`fundraiser_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`volunteer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `charities`
--
ALTER TABLE `charities`
  MODIFY `charity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `donordetails`
--
ALTER TABLE `donordetails`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fundraisers`
--
ALTER TABLE `fundraisers`
  MODIFY `fundraiser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`charity_id`) REFERENCES `charities` (`charity_id`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `donordetails` (`donor_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Constraints for table `eventvolunteers`
--
ALTER TABLE `eventvolunteers`
  ADD CONSTRAINT `eventvolunteers_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `eventvolunteers_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`);

--
-- Constraints for table `fundraisers`
--
ALTER TABLE `fundraisers`
  ADD CONSTRAINT `fundraisers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fundraisers_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
