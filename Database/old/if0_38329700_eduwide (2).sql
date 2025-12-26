-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.infinityfree.com
-- Generation Time: Oct 19, 2025 at 10:07 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38329700_eduwide`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `user_id` int(11) NOT NULL,
  `about_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`user_id`, `about_text`) VALUES
(5, 'test'),
(6, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `active_student_projects`
--

CREATE TABLE `active_student_projects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('completed','ongoing','planned') DEFAULT 'ongoing',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `active_student_project_links`
--

CREATE TABLE `active_student_project_links` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `link_type` varchar(50) NOT NULL,
  `link_url` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `active_student_project_photos`
--

CREATE TABLE `active_student_project_photos` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `active_student_skills`
--

CREATE TABLE `active_student_skills` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.png',
  `facebook` varchar(200) NOT NULL,
  `github` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `nic`, `email`, `mobile`, `password`, `profile_picture`, `facebook`, `github`, `linkedin`, `blog`, `created_at`, `status`, `last_login`) VALUES
(1, 'Malitha Tishamal', '20002202615', 'admin.malithatishamal@gmail.com', '0785530992', '$2y$10$/62hdNg8q8XxoL3FIs..CeJ2YKN6fXpHIQ3RSqYjxFbdkV07BV1ne', 'uploads/profile_pictures/67d2ddfb6f751-411001152_1557287805017611_3900716309730349802_n.jpg', 'https://www.facebook.com/malitha.tishamal', 'https://github.com/malitha-tishamal', 'https://www.linkedin.com/in/malitha-tishamal', 'https://malitha-tishamal.github.io/blog', '2025-03-08 14:00:46', 'approved', '2025-10-19 19:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `business_finance_skills`
--

CREATE TABLE `business_finance_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `business_finance_skills`
--

INSERT INTO `business_finance_skills` (`id`, `skill_name`, `category`) VALUES
(1001, 'Financial Accounting', 'Business Finance'),
(1002, 'Management Accounting', 'Business Finance'),
(1003, 'Corporate Finance', 'Business Finance'),
(1004, 'Financial Reporting', 'Business Finance'),
(1005, 'Taxation', 'Business Finance'),
(1006, 'Auditing', 'Business Finance'),
(1007, 'Business Law', 'Business Finance'),
(1008, 'Economics', 'Business Finance'),
(1009, 'Investment Analysis', 'Business Finance'),
(1010, 'Banking & Insurance', 'Business Finance'),
(1011, 'Budgeting & Forecasting', 'Business Finance'),
(1012, 'Risk Management', 'Business Finance'),
(1013, 'Financial Modelling', 'Business Finance'),
(1014, 'Strategic Management', 'Business Finance'),
(1015, 'Business Communication', 'Business Finance'),
(1016, 'Excel for Finance', 'Business Finance'),
(1017, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1018, 'Business Analytics', 'Business Finance'),
(1019, 'Corporate Governance', 'Business Finance'),
(1020, 'Ethics & Professional Practice', 'Business Finance'),
(1021, 'Financial Accounting', 'Business Finance'),
(1022, 'Management Accounting', 'Business Finance'),
(1023, 'Corporate Finance', 'Business Finance'),
(1024, 'Financial Reporting', 'Business Finance'),
(1025, 'Taxation', 'Business Finance'),
(1026, 'Auditing', 'Business Finance'),
(1027, 'Business Law', 'Business Finance'),
(1028, 'Economics', 'Business Finance'),
(1029, 'Investment Analysis', 'Business Finance'),
(1030, 'Banking & Insurance', 'Business Finance'),
(1031, 'Budgeting & Forecasting', 'Business Finance'),
(1032, 'Risk Management', 'Business Finance'),
(1033, 'Financial Modelling', 'Business Finance'),
(1034, 'Strategic Management', 'Business Finance'),
(1035, 'Business Communication', 'Business Finance'),
(1036, 'Excel for Finance', 'Business Finance'),
(1037, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1038, 'Business Analytics', 'Business Finance'),
(1039, 'Corporate Governance', 'Business Finance'),
(1040, 'Ethics & Professional Practice', 'Business Finance'),
(1041, 'Financial Statement Analysis', 'Business Finance'),
(1042, 'Cost Accounting', 'Business Finance'),
(1043, 'Portfolio Management', 'Business Finance'),
(1044, 'Derivatives & Futures', 'Business Finance'),
(1045, 'Mutual Funds & Securities', 'Business Finance'),
(1046, 'Treasury & Cash Management', 'Business Finance'),
(1047, 'Credit Management', 'Business Finance'),
(1048, 'Financial Planning', 'Business Finance'),
(1049, 'Mergers & Acquisitions', 'Business Finance'),
(1050, 'Entrepreneurship & Business Planning', 'Business Finance'),
(1051, 'Internal Controls', 'Business Finance'),
(1052, 'Economic Policy & Regulation', 'Business Finance'),
(1053, 'Quantitative Methods', 'Business Finance'),
(1054, 'Corporate Tax Planning', 'Business Finance'),
(1055, 'Ethical Decision Making', 'Business Finance'),
(1056, 'Financial Risk Assessment', 'Business Finance'),
(1057, 'ERP & Accounting Systems', 'Business Finance'),
(1058, 'Financial Accounting', 'Business Finance'),
(1059, 'Management Accounting', 'Business Finance'),
(1060, 'Corporate Finance', 'Business Finance'),
(1061, 'Financial Reporting', 'Business Finance'),
(1062, 'Taxation', 'Business Finance'),
(1063, 'Auditing', 'Business Finance'),
(1064, 'Business Law', 'Business Finance'),
(1065, 'Economics', 'Business Finance'),
(1066, 'Investment Analysis', 'Business Finance'),
(1067, 'Banking & Insurance', 'Business Finance'),
(1068, 'Budgeting & Forecasting', 'Business Finance'),
(1069, 'Risk Management', 'Business Finance'),
(1070, 'Financial Modelling', 'Business Finance'),
(1071, 'Strategic Management', 'Business Finance'),
(1072, 'Business Communication', 'Business Finance'),
(1073, 'Excel for Finance', 'Business Finance'),
(1074, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1075, 'Business Analytics', 'Business Finance'),
(1076, 'Corporate Governance', 'Business Finance'),
(1077, 'Ethics & Professional Practice', 'Business Finance'),
(1078, 'Financial Statement Analysis', 'Business Finance'),
(1079, 'Cost Accounting', 'Business Finance'),
(1080, 'Portfolio Management', 'Business Finance'),
(1081, 'Derivatives & Futures', 'Business Finance'),
(1082, 'Mutual Funds & Securities', 'Business Finance'),
(1083, 'Treasury & Cash Management', 'Business Finance'),
(1084, 'Credit Management', 'Business Finance'),
(1085, 'Financial Planning', 'Business Finance'),
(1086, 'Mergers & Acquisitions', 'Business Finance'),
(1087, 'Entrepreneurship & Business Planning', 'Business Finance'),
(1088, 'Internal Controls', 'Business Finance'),
(1089, 'Economic Policy & Regulation', 'Business Finance'),
(1090, 'Quantitative Methods', 'Business Finance'),
(1091, 'Corporate Tax Planning', 'Business Finance'),
(1092, 'Ethical Decision Making', 'Business Finance'),
(1093, 'Financial Risk Assessment', 'Business Finance'),
(1094, 'ERP & Accounting Systems', 'Business Finance'),
(1095, 'Budget Analysis Project', 'Project-Based'),
(1096, 'Financial Forecasting Project', 'Project-Based'),
(1097, 'Investment Portfolio Simulation', 'Project-Based'),
(1098, 'Business Plan Development', 'Project-Based'),
(1099, 'Corporate Valuation Project', 'Project-Based'),
(1100, 'Accounting Software Implementation', 'Project-Based'),
(1101, 'Cost Reduction & Efficiency Analysis', 'Project-Based'),
(1102, 'Risk Assessment Case Study', 'Project-Based'),
(1103, 'Bank Reconciliation Project', 'Project-Based'),
(1104, 'Tax Compliance Simulation', 'Project-Based'),
(1105, 'Financial Modelling Case Study', 'Project-Based'),
(1106, 'Auditing Project', 'Project-Based'),
(1107, 'Market Research & Analysis Project', 'Project-Based'),
(1108, 'Internship Financial Report', 'Project-Based'),
(1109, 'ERP Implementation Case Study', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `business_finance_skills_backup`
--

CREATE TABLE `business_finance_skills_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `business_finance_skills_backup`
--

INSERT INTO `business_finance_skills_backup` (`id`, `skill_name`, `category`) VALUES
(1001, 'Financial Accounting', 'Business Finance'),
(1002, 'Management Accounting', 'Business Finance'),
(1003, 'Corporate Finance', 'Business Finance'),
(1004, 'Financial Reporting', 'Business Finance'),
(1005, 'Taxation', 'Business Finance'),
(1006, 'Auditing', 'Business Finance'),
(1007, 'Business Law', 'Business Finance'),
(1008, 'Economics', 'Business Finance'),
(1009, 'Investment Analysis', 'Business Finance'),
(1010, 'Banking & Insurance', 'Business Finance'),
(1011, 'Budgeting & Forecasting', 'Business Finance'),
(1012, 'Risk Management', 'Business Finance'),
(1013, 'Financial Modelling', 'Business Finance'),
(1014, 'Strategic Management', 'Business Finance'),
(1015, 'Business Communication', 'Business Finance'),
(1016, 'Excel for Finance', 'Business Finance'),
(1017, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1018, 'Business Analytics', 'Business Finance'),
(1019, 'Corporate Governance', 'Business Finance'),
(1020, 'Ethics & Professional Practice', 'Business Finance'),
(1021, 'Financial Accounting', 'Business Finance'),
(1022, 'Management Accounting', 'Business Finance'),
(1023, 'Corporate Finance', 'Business Finance'),
(1024, 'Financial Reporting', 'Business Finance'),
(1025, 'Taxation', 'Business Finance'),
(1026, 'Auditing', 'Business Finance'),
(1027, 'Business Law', 'Business Finance'),
(1028, 'Economics', 'Business Finance'),
(1029, 'Investment Analysis', 'Business Finance'),
(1030, 'Banking & Insurance', 'Business Finance'),
(1031, 'Budgeting & Forecasting', 'Business Finance'),
(1032, 'Risk Management', 'Business Finance'),
(1033, 'Financial Modelling', 'Business Finance'),
(1034, 'Strategic Management', 'Business Finance'),
(1035, 'Business Communication', 'Business Finance'),
(1036, 'Excel for Finance', 'Business Finance'),
(1037, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1038, 'Business Analytics', 'Business Finance'),
(1039, 'Corporate Governance', 'Business Finance'),
(1040, 'Ethics & Professional Practice', 'Business Finance'),
(1041, 'Financial Statement Analysis', 'Business Finance'),
(1042, 'Cost Accounting', 'Business Finance'),
(1043, 'Portfolio Management', 'Business Finance'),
(1044, 'Derivatives & Futures', 'Business Finance'),
(1045, 'Mutual Funds & Securities', 'Business Finance'),
(1046, 'Treasury & Cash Management', 'Business Finance'),
(1047, 'Credit Management', 'Business Finance'),
(1048, 'Financial Planning', 'Business Finance'),
(1049, 'Mergers & Acquisitions', 'Business Finance'),
(1050, 'Entrepreneurship & Business Planning', 'Business Finance'),
(1051, 'Internal Controls', 'Business Finance'),
(1052, 'Economic Policy & Regulation', 'Business Finance'),
(1053, 'Quantitative Methods', 'Business Finance'),
(1054, 'Corporate Tax Planning', 'Business Finance'),
(1055, 'Ethical Decision Making', 'Business Finance'),
(1056, 'Financial Risk Assessment', 'Business Finance'),
(1057, 'ERP & Accounting Systems', 'Business Finance'),
(1058, 'Financial Accounting', 'Business Finance'),
(1059, 'Management Accounting', 'Business Finance'),
(1060, 'Corporate Finance', 'Business Finance'),
(1061, 'Financial Reporting', 'Business Finance'),
(1062, 'Taxation', 'Business Finance'),
(1063, 'Auditing', 'Business Finance'),
(1064, 'Business Law', 'Business Finance'),
(1065, 'Economics', 'Business Finance'),
(1066, 'Investment Analysis', 'Business Finance'),
(1067, 'Banking & Insurance', 'Business Finance'),
(1068, 'Budgeting & Forecasting', 'Business Finance'),
(1069, 'Risk Management', 'Business Finance'),
(1070, 'Financial Modelling', 'Business Finance'),
(1071, 'Strategic Management', 'Business Finance'),
(1072, 'Business Communication', 'Business Finance'),
(1073, 'Excel for Finance', 'Business Finance'),
(1074, 'Accounting Software (Tally, QuickBooks)', 'Business Finance'),
(1075, 'Business Analytics', 'Business Finance'),
(1076, 'Corporate Governance', 'Business Finance'),
(1077, 'Ethics & Professional Practice', 'Business Finance'),
(1078, 'Financial Statement Analysis', 'Business Finance'),
(1079, 'Cost Accounting', 'Business Finance'),
(1080, 'Portfolio Management', 'Business Finance'),
(1081, 'Derivatives & Futures', 'Business Finance'),
(1082, 'Mutual Funds & Securities', 'Business Finance'),
(1083, 'Treasury & Cash Management', 'Business Finance'),
(1084, 'Credit Management', 'Business Finance'),
(1085, 'Financial Planning', 'Business Finance'),
(1086, 'Mergers & Acquisitions', 'Business Finance'),
(1087, 'Entrepreneurship & Business Planning', 'Business Finance'),
(1088, 'Internal Controls', 'Business Finance'),
(1089, 'Economic Policy & Regulation', 'Business Finance'),
(1090, 'Quantitative Methods', 'Business Finance'),
(1091, 'Corporate Tax Planning', 'Business Finance'),
(1092, 'Ethical Decision Making', 'Business Finance'),
(1093, 'Financial Risk Assessment', 'Business Finance'),
(1094, 'ERP & Accounting Systems', 'Business Finance'),
(1095, 'Budget Analysis Project', 'Project-Based'),
(1096, 'Financial Forecasting Project', 'Project-Based'),
(1097, 'Investment Portfolio Simulation', 'Project-Based'),
(1098, 'Business Plan Development', 'Project-Based'),
(1099, 'Corporate Valuation Project', 'Project-Based'),
(1100, 'Accounting Software Implementation', 'Project-Based'),
(1101, 'Cost Reduction & Efficiency Analysis', 'Project-Based'),
(1102, 'Risk Assessment Case Study', 'Project-Based'),
(1103, 'Bank Reconciliation Project', 'Project-Based'),
(1104, 'Tax Compliance Simulation', 'Project-Based'),
(1105, 'Financial Modelling Case Study', 'Project-Based'),
(1106, 'Auditing Project', 'Project-Based'),
(1107, 'Market Research & Analysis Project', 'Project-Based'),
(1108, 'Internship Financial Report', 'Project-Based'),
(1109, 'ERP Implementation Case Study', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'uploads/profile_pictures/default.png',
  `facebook` varchar(255) NOT NULL,
  `github` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `username`, `email`, `address`, `mobile`, `category`, `profile_picture`, `facebook`, `github`, `blog`, `linkedin`, `password`, `status`, `last_login`, `created_at`) VALUES
(1, 'testCompanyName', 'testcompany@gmail.com', 'testAddress', '771000000', 'Software Engineering', 'uploads/profile_pictures/default.png', '', '', '', '', '$2y$10$NOCCWFamgxlt9YYMlIcg8uzwDls1P/DS6p2jv8WIZ5OYWrENDaPcy', 'approved', '2025-10-16 12:03:24', '2025-06-06 05:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school` varchar(255) NOT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_month` varchar(20) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_month` varchar(20) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `activities` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `user_id`, `school`, `degree`, `field_of_study`, `start_month`, `start_year`, `end_month`, `end_year`, `grade`, `activities`, `description`) VALUES
(1, 6, 'SLIATE', 'HNDIT', 'Infromation Technology', 'January', 2025, NULL, NULL, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `engineering_skills`
--

CREATE TABLE `engineering_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `branch` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `engineering_skills`
--

INSERT INTO `engineering_skills` (`id`, `skill_name`, `branch`) VALUES
(0, 'AutoCAD', 'Civil'),
(1, 'Revit', 'Civil'),
(2, 'STAAD Pro', 'Civil'),
(3, 'ETABS', 'Civil'),
(4, 'Surveying', 'Civil'),
(5, 'Construction Management', 'Civil'),
(6, 'Structural Analysis', 'Civil'),
(7, 'Concrete Technology', 'Civil'),
(8, 'Soil Mechanics', 'Civil'),
(9, 'Project Planning', 'Civil'),
(10, 'SolidWorks', 'Mechanical'),
(11, 'CATIA', 'Mechanical'),
(12, 'ANSYS', 'Mechanical'),
(13, 'MATLAB', 'Mechanical'),
(14, 'Thermodynamics', 'Mechanical'),
(15, 'Fluid Mechanics', 'Mechanical'),
(16, 'HVAC Design', 'Mechanical'),
(17, 'Automobile Engineering', 'Mechanical'),
(18, 'Manufacturing Processes', 'Mechanical'),
(19, 'Mechanical Design', 'Mechanical'),
(20, 'Circuit Analysis', 'Electrical'),
(21, 'MATLAB', 'Electrical'),
(22, 'Simulink', 'Electrical'),
(23, 'Power Systems', 'Electrical'),
(24, 'Control Systems', 'Electrical'),
(25, 'PLC Programming', 'Electrical'),
(26, 'SCADA', 'Electrical'),
(27, 'Electrical Machines', 'Electrical'),
(28, 'Power Electronics', 'Electrical'),
(29, 'Electrical Design', 'Electrical'),
(30, 'Microcontrollers', 'Electronics'),
(31, 'Embedded Systems', 'Electronics'),
(32, 'Digital Electronics', 'Electronics'),
(33, 'Analog Electronics', 'Electronics'),
(34, 'VHDL', 'Electronics'),
(35, 'FPGA Design', 'Electronics'),
(36, 'Signal Processing', 'Electronics'),
(37, 'Communication Systems', 'Electronics'),
(38, 'PCB Design', 'Electronics'),
(39, 'Sensors & Actuators', 'Electronics'),
(40, 'C Programming', 'Computer'),
(41, 'C++ Programming', 'Computer'),
(42, 'Java', 'Computer'),
(43, 'Python', 'Computer'),
(44, 'Data Structures', 'Computer'),
(45, 'Algorithms', 'Computer'),
(46, 'Database Management', 'Computer'),
(47, 'Networking', 'Computer'),
(48, 'Web Development', 'Computer'),
(49, 'Mobile App Development', 'Computer'),
(50, 'Vehicle Dynamics', 'Automotive'),
(51, 'Automotive Design', 'Automotive'),
(52, 'Engine Design', 'Automotive'),
(53, 'Powertrain', 'Automotive'),
(54, 'Thermal Systems', 'Automotive'),
(55, 'Automotive Electronics', 'Automotive'),
(56, 'CAD for Automotive', 'Automotive'),
(57, 'Manufacturing Processes', 'Automotive'),
(58, 'Automobile Materials', 'Automotive'),
(59, 'Automotive Safety Systems', 'Automotive'),
(60, 'SolidWorks', 'Mechanical'),
(61, 'CATIA', 'Mechanical'),
(62, 'ANSYS', 'Mechanical'),
(63, 'MATLAB', 'Mechanical'),
(64, 'Thermodynamics', 'Mechanical'),
(65, 'Fluid Mechanics', 'Mechanical'),
(66, 'HVAC Design', 'Mechanical'),
(67, 'Automobile Engineering', 'Mechanical'),
(68, 'Manufacturing Processes', 'Mechanical'),
(69, 'Mechanical Design', 'Mechanical'),
(70, 'Circuit Analysis', 'Electrical'),
(71, 'MATLAB', 'Electrical'),
(72, 'Simulink', 'Electrical'),
(73, 'Power Systems', 'Electrical'),
(74, 'Control Systems', 'Electrical'),
(75, 'PLC Programming', 'Electrical'),
(76, 'SCADA', 'Electrical'),
(77, 'Electrical Machines', 'Electrical'),
(78, 'Power Electronics', 'Electrical'),
(79, 'Electrical Design', 'Electrical'),
(80, 'Microcontrollers', 'Electronics'),
(81, 'Embedded Systems', 'Electronics'),
(82, 'Digital Electronics', 'Electronics'),
(83, 'Analog Electronics', 'Electronics'),
(84, 'VHDL', 'Electronics'),
(85, 'FPGA Design', 'Electronics'),
(86, 'Signal Processing', 'Electronics'),
(87, 'Communication Systems', 'Electronics'),
(88, 'PCB Design', 'Electronics'),
(89, 'Sensors & Actuators', 'Electronics'),
(90, 'C Programming', 'Computer'),
(91, 'C++ Programming', 'Computer'),
(92, 'Java', 'Computer'),
(93, 'Python', 'Computer'),
(94, 'Data Structures', 'Computer'),
(95, 'Algorithms', 'Computer'),
(96, 'Database Management', 'Computer'),
(97, 'Networking', 'Computer'),
(98, 'Web Development', 'Computer'),
(99, 'Mobile App Development', 'Computer'),
(100, 'Vehicle Dynamics', 'Automotive'),
(101, 'Automotive Design', 'Automotive'),
(102, 'Engine Design', 'Automotive'),
(103, 'Powertrain', 'Automotive'),
(104, 'Thermal Systems', 'Automotive'),
(105, 'Automotive Electronics', 'Automotive'),
(106, 'CAD for Automotive', 'Automotive'),
(107, 'Manufacturing Processes', 'Automotive'),
(108, 'Automobile Materials', 'Automotive'),
(109, 'Automotive Safety Systems', 'Automotive'),
(110, 'Bridge Design Project', ''),
(111, 'Mechanical Simulation Project', ''),
(112, 'Electrical Circuit Design Project', ''),
(113, 'Embedded System Implementation', ''),
(114, 'HVAC System Design Project', ''),
(115, 'Automobile Engine Testing', ''),
(116, 'Construction Site Survey Project', ''),
(117, 'CAD/3D Modeling Project', ''),
(118, 'PLC & Automation Project', ''),
(119, 'PCB Fabrication Project', ''),
(120, 'Finite Element Analysis', 'Mechanical'),
(121, 'Thermal Analysis', 'Mechanical'),
(122, 'Hydraulics & Pneumatics', 'Mechanical'),
(123, 'Material Science', 'Mechanical'),
(124, 'Mechanical Maintenance', 'Mechanical'),
(125, 'Automotive CAD Design', 'Mechanical'),
(126, '3D Printing & Rapid Prototyping', 'Mechanical'),
(127, 'Renewable Energy Systems', 'Electrical'),
(128, 'Electrical Safety & Standards', 'Electrical'),
(129, 'High Voltage Engineering', 'Electrical'),
(130, 'Smart Grid Technology', 'Electrical'),
(131, 'Electric Vehicle Systems', 'Electrical'),
(132, 'Energy Management', 'Electrical'),
(133, 'IoT Device Design', 'Electronics'),
(134, 'Analog & Digital Signal Processing', 'Electronics'),
(135, 'Robotics Electronics', 'Electronics'),
(136, 'Embedded System Debugging', 'Electronics'),
(137, 'Wireless Communication', 'Electronics'),
(138, 'Microcontroller Programming', 'Electronics'),
(139, 'Software Engineering', 'Computer'),
(140, 'Operating Systems', 'Computer'),
(141, 'Cloud Computing Basics', 'Computer'),
(142, 'Cybersecurity Fundamentals', 'Computer'),
(143, 'Database Design & SQL', 'Computer'),
(144, 'Mobile App UI/UX Design', 'Computer'),
(145, 'Data Analysis with Python', 'Computer'),
(146, 'Engine Performance Testing', 'Automotive'),
(147, 'Vehicle Diagnostics & Troubleshooting', 'Automotive'),
(148, 'Automotive Electronics Integration', 'Automotive'),
(149, 'Hybrid & Electric Vehicle Systems', 'Automotive'),
(150, 'Automotive Aerodynamics', 'Automotive'),
(151, 'Chassis Design & Testing', 'Automotive'),
(152, 'Industrial Internship Report', 'Project-Based'),
(153, 'Capstone Engineering Project', 'Project-Based'),
(154, 'Prototype Design & Fabrication', 'Project-Based'),
(155, 'Structural Load Analysis Project', 'Project-Based'),
(156, 'Mechanical Assembly & Testing Project', 'Project-Based'),
(157, 'Electrical Circuit Simulation Project', 'Project-Based'),
(158, 'Embedded IoT Project', 'Project-Based'),
(159, 'Vehicle Safety System Project', 'Project-Based'),
(160, 'Renewable Energy Mini Project', 'Project-Based'),
(161, 'Engineering Design Documentation', 'Project-Based'),
(162, 'Robotics Mechanics', 'Mechanical'),
(163, 'Automation Systems Design', 'Mechanical'),
(164, 'Advanced Thermodynamics', 'Mechanical'),
(165, 'CNC Machining & Programming', 'Mechanical'),
(166, 'Maintenance Planning & Reliability', 'Mechanical'),
(167, 'Hydraulic System Design', 'Mechanical'),
(168, 'Vibration Analysis', 'Mechanical'),
(169, 'Power System Protection', 'Electrical'),
(170, 'Industrial Automation', 'Electrical'),
(171, 'Smart Home Electrical Systems', 'Electrical'),
(172, 'Power Electronics Design', 'Electrical'),
(173, 'Electrical Load Flow Analysis', 'Electrical'),
(174, 'Energy Efficiency Management', 'Electrical'),
(175, 'FPGA Programming & Applications', 'Electronics'),
(176, 'Analog Circuit Design', 'Electronics'),
(177, 'Digital System Design', 'Electronics'),
(178, 'PCB Layout & Manufacturing', 'Electronics'),
(179, 'Microprocessor Applications', 'Electronics'),
(180, 'Wireless Sensor Networks', 'Electronics'),
(181, 'Artificial Intelligence Basics', 'Computer'),
(182, 'Machine Learning Applications', 'Computer'),
(183, 'Database Optimization', 'Computer'),
(184, 'Network Security & Firewall Management', 'Computer'),
(185, 'Web Application Security', 'Computer'),
(186, 'Cloud Deployment & DevOps Basics', 'Computer'),
(187, 'Automotive Engine Tuning', 'Automotive'),
(188, 'Hybrid Vehicle Powertrain Design', 'Automotive'),
(189, 'Vehicle Emission Analysis', 'Automotive'),
(190, 'Automotive Sensors Integration', 'Automotive'),
(191, 'Chassis Dynamics Simulation', 'Automotive'),
(192, 'Vehicle Telematics & IoT', 'Automotive'),
(193, 'Industry Internship Project', 'Project-Based'),
(194, 'Engineering Capstone Project', 'Project-Based'),
(195, 'Design Optimization Project', 'Project-Based'),
(196, 'Electrical Installation Project', 'Project-Based'),
(197, 'Robotics Prototype Project', 'Project-Based'),
(198, 'Renewable Energy System Project', 'Project-Based'),
(199, 'Automobile Diagnostics Project', 'Project-Based'),
(200, 'Civil Structural Load Analysis Project', 'Project-Based'),
(201, 'Mechanical Assembly & Testing Project', 'Project-Based'),
(202, 'IoT Embedded System Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `employment_type` varchar(100) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `currently_working` tinyint(1) DEFAULT 0,
  `start_month` varchar(20) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_month` varchar(20) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `location_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `job_source` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `skills` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `title`, `employment_type`, `company`, `currently_working`, `start_month`, `start_year`, `end_month`, `end_year`, `location`, `location_type`, `description`, `job_source`, `created_at`, `skills`) VALUES
(1, '5', 'test', 'Full-time', 'test', 1, 'January', 2024, '0', 0, '', 'On-site', 'test', 'LinkedIn', '2025-10-13 11:18:29', ''),
(2, '5', 'test', 'Part-time', 'test', 0, 'January', 2023, 'June', 2025, '', 'On-site', '', '', '2025-10-13 12:26:11', '');

-- --------------------------------------------------------

--
-- Table structure for table `former_students`
--

CREATE TABLE `former_students` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `reg_id` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.png',
  `mobile` varchar(15) NOT NULL,
  `study_year` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `nowstatus` enum('study','work','intern','free') NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `github` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `former_students`
--

INSERT INTO `former_students` (`id`, `username`, `reg_id`, `nic`, `email`, `profile_picture`, `mobile`, `study_year`, `course_id`, `nowstatus`, `facebook`, `github`, `blog`, `linkedin`, `password`, `status`, `created_at`, `updated_at`, `last_login`) VALUES
(5, 'Malitha Tishamal', 'GAL/IT/2324/F/0009', '200302202615', 'malithatishamal@email.com', 'uploads/profile_pictures/default.png', '7855309992', 2024, 6, 'work', '', '', '', '', '$2y$10$YXFBhdSJM2uv9vAFmdvHqOIvPE4FyCPYxxabG9YmHtJWtiyoDHyM.', 'approved', '2025-10-04 14:49:20', '2025-10-14 10:50:13', '2025-10-14 16:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `former_students_achievements`
--

CREATE TABLE `former_students_achievements` (
  `id` int(11) NOT NULL,
  `former_student_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_name` varchar(255) NOT NULL,
  `organized_by` varchar(255) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_students_certifications`
--

CREATE TABLE `former_students_certifications` (
  `id` int(11) NOT NULL,
  `former_student_id` int(11) NOT NULL,
  `certification_name` varchar(255) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `certification_description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_student_projects`
--

CREATE TABLE `former_student_projects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_student_project_links`
--

CREATE TABLE `former_student_project_links` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `link_type` varchar(50) NOT NULL,
  `link_url` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_student_project_photos`
--

CREATE TABLE `former_student_project_photos` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_student_project_skills`
--

CREATE TABLE `former_student_project_skills` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` enum('IT','Engineering','Management','Finance','HR','Accountant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `former_student_skills`
--

CREATE TABLE `former_student_skills` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hndit_company_categories`
--

CREATE TABLE `hndit_company_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_datetime` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hndit_company_categories`
--

INSERT INTO `hndit_company_categories` (`id`, `category_name`, `created_datetime`) VALUES
(1, 'Software Engineering', '2025-10-15 21:59:47'),
(2, 'Network Engineering', '2025-10-15 21:59:47'),
(3, 'Cyber Security', '2025-10-15 21:59:47'),
(4, 'Education', '2025-10-15 21:59:47'),
(5, 'Data Science', '2025-10-15 21:59:47'),
(6, 'Artificial Intelligence', '2025-10-15 21:59:47'),
(7, 'Machine Learning', '2025-10-15 21:59:47'),
(8, 'Blockchain Technology', '2025-10-15 21:59:47'),
(9, 'Cloud Computing', '2025-10-15 21:59:47'),
(10, 'DevOps', '2025-10-15 21:59:47'),
(11, 'Mobile Development', '2025-10-15 21:59:47'),
(12, 'Web Development', '2025-10-15 21:59:47'),
(13, 'Game Development', '2025-10-15 21:59:47'),
(14, 'UI/UX Design', '2025-10-15 21:59:47'),
(15, 'Digital Marketing', '2025-10-15 21:59:47'),
(16, 'Product Management', '2025-10-15 21:59:47'),
(17, 'Business Analysis', '2025-10-15 21:59:47'),
(18, 'Cybersecurity Research', '2025-10-15 21:59:47'),
(19, 'System Administration', '2025-10-15 21:59:47'),
(20, 'Data Engineering', '2025-10-15 21:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_accountancy_skills`
--

CREATE TABLE `hnd_accountancy_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_accountancy_skills`
--

INSERT INTO `hnd_accountancy_skills` (`id`, `skill_name`, `category`) VALUES
(2001, 'Financial Accounting', 'Accounting'),
(2002, 'Managerial Accounting', 'Accounting'),
(2003, 'Cost Accounting', 'Accounting'),
(2004, 'Financial Statement Analysis', 'Accounting'),
(2005, 'Accounting Principles & Standards', 'Accounting'),
(2006, 'Accounts Receivable & Payable Management', 'Accounting'),
(2007, 'Bank Reconciliation', 'Accounting'),
(2008, 'Payroll Accounting', 'Accounting'),
(2009, 'Accounting Ethics & Professional Standards', 'Accounting'),
(2010, 'Accounting for Non-Profit Organizations', 'Accounting'),
(2011, 'Corporate Finance Basics', 'Finance'),
(2012, 'Investment Appraisal & Capital Budgeting', 'Finance'),
(2013, 'Budgeting & Forecasting', 'Finance'),
(2014, 'Working Capital Management', 'Finance'),
(2015, 'Financial Risk Management', 'Finance'),
(2016, 'Financial Modelling', 'Finance'),
(2017, 'Treasury & Cash Flow Management', 'Finance'),
(2018, 'Mergers & Acquisitions Accounting', 'Finance'),
(2019, 'Fundamentals of Corporate Governance', 'Finance'),
(2020, 'Internal Control & Compliance', 'Finance'),
(2021, 'Principles of Auditing', 'Auditing'),
(2022, 'Internal Auditing Techniques', 'Auditing'),
(2023, 'External Audit Procedures', 'Auditing'),
(2024, 'Audit Planning & Risk Assessment', 'Auditing'),
(2025, 'Audit Report Preparation', 'Auditing'),
(2026, 'Statutory Compliance Audit', 'Auditing'),
(2027, 'Forensic Accounting Basics', 'Auditing'),
(2028, 'Audit Evidence & Documentation', 'Auditing'),
(2029, 'Fraud Detection & Prevention', 'Auditing'),
(2030, 'Ethical Standards in Auditing', 'Auditing'),
(2031, 'Income Tax Principles', 'Taxation'),
(2032, 'Corporate Tax Accounting', 'Taxation'),
(2033, 'Value Added Tax (VAT) Accounting', 'Taxation'),
(2034, 'Tax Planning & Compliance', 'Taxation'),
(2035, 'International Taxation Basics', 'Taxation'),
(2036, 'Tax Filing & Reporting', 'Taxation'),
(2037, 'Payroll Tax Management', 'Taxation'),
(2038, 'Tax Audit Preparation', 'Taxation'),
(2039, 'Tax Law Interpretation', 'Taxation'),
(2040, 'Indirect Tax Accounting', 'Taxation'),
(2041, 'Excel for Accounting', 'Software'),
(2042, 'Tally ERP Accounting', 'Software'),
(2043, 'QuickBooks Accounting Software', 'Software'),
(2044, 'SAP FICO Basics', 'Software'),
(2045, 'ERP Software for Finance', 'Software'),
(2046, 'Accounting Information Systems', 'Software'),
(2047, 'Financial Analytics Tools', 'Software'),
(2048, 'Database Management for Accounting', 'Software'),
(2049, 'Accounting Automation Tools', 'Software'),
(2050, 'Data Analysis for Accountants', 'Software'),
(2051, 'Financial Statement Interpretation', 'Analytical'),
(2052, 'Variance Analysis', 'Analytical'),
(2053, 'Decision Making using Financial Data', 'Analytical'),
(2054, 'Business Performance Analysis', 'Analytical'),
(2055, 'Problem Solving in Accounting', 'Analytical'),
(2056, 'Critical Thinking for Accountants', 'Analytical'),
(2057, 'Ethical Decision Making', 'Analytical'),
(2058, 'Professional Communication Skills', 'Professional'),
(2059, 'Report Writing for Finance', 'Professional'),
(2060, 'Presentation of Financial Data', 'Professional'),
(2061, 'Accounting Project Planning', 'Project-Based'),
(2062, 'Financial Analysis Project', 'Project-Based'),
(2063, 'Audit Simulation Project', 'Project-Based'),
(2064, 'Tax Filing & Compliance Project', 'Project-Based'),
(2065, 'ERP Implementation Accounting Project', 'Project-Based'),
(2066, 'Budgeting & Forecasting Project', 'Project-Based'),
(2067, 'Cost Control & Analysis Project', 'Project-Based'),
(2068, 'Capstone Accountancy Internship Project', 'Project-Based'),
(2069, 'Consolidated Financial Statements', 'Accounting'),
(2070, 'International Financial Reporting Standards (IFRS)', 'Accounting'),
(2071, 'Accounting for Mergers & Acquisitions', 'Accounting'),
(2072, 'Accounting for Leases & Rentals', 'Accounting'),
(2073, 'Accounting for Foreign Currency Transactions', 'Accounting'),
(2074, 'Advanced Cash Flow Analysis', 'Accounting'),
(2075, 'Accounting for Investments & Securities', 'Accounting'),
(2076, 'Accounting for Intangible Assets', 'Accounting'),
(2077, 'Revenue Recognition Standards', 'Accounting'),
(2078, 'Advanced Fixed Asset Accounting', 'Accounting'),
(2079, 'Activity-Based Costing (ABC)', 'Accounting'),
(2080, 'Target Costing Techniques', 'Accounting'),
(2081, 'Standard Costing Systems', 'Accounting'),
(2082, 'Cost-Volume-Profit (CVP) Analysis', 'Accounting'),
(2083, 'Budgetary Control & Reporting', 'Accounting'),
(2084, 'Responsibility Accounting', 'Accounting'),
(2085, 'Variance Investigation & Analysis', 'Accounting'),
(2086, 'Pricing & Profitability Analysis', 'Accounting'),
(2087, 'Operational Cost Optimization', 'Accounting'),
(2088, 'Cost Accounting for Manufacturing', 'Accounting'),
(2089, 'Advanced Corporate Finance Decision Making', 'Finance'),
(2090, 'Financial Statement Forecasting', 'Finance'),
(2091, 'Capital Structure Analysis', 'Finance'),
(2092, 'Dividend Policy Decisions', 'Finance'),
(2093, 'Investment Appraisal Techniques (NPV, IRR, Payback)', 'Finance'),
(2094, 'Risk Management & Hedging Strategies', 'Finance'),
(2095, 'Working Capital Optimization', 'Finance'),
(2096, 'Corporate Treasury Management', 'Finance'),
(2097, 'Portfolio Management & Securities Analysis', 'Finance'),
(2098, 'Mergers, Acquisitions & Restructuring Accounting', 'Finance'),
(2099, 'International Tax Compliance', 'Taxation'),
(2100, 'Transfer Pricing & Multinational Taxation', 'Taxation'),
(2101, 'Advanced VAT & GST Compliance', 'Taxation'),
(2102, 'Tax Audit & Investigation', 'Taxation'),
(2103, 'Corporate Tax Planning & Advisory', 'Taxation'),
(2104, 'Personal Income Tax Planning', 'Taxation'),
(2105, 'Indirect Taxes & Customs Duties', 'Taxation'),
(2106, 'Deferred Tax Accounting', 'Taxation'),
(2107, 'Tax Risk Management', 'Taxation'),
(2108, 'Tax Accounting for International Business', 'Taxation'),
(2109, 'Forensic Accounting & Fraud Detection', 'Auditing'),
(2110, 'Internal Control System Design', 'Auditing'),
(2111, 'Audit Sampling Techniques', 'Auditing'),
(2112, 'IT Auditing & Cyber Risk Assessment', 'Auditing'),
(2113, 'Compliance & Regulatory Audits', 'Auditing'),
(2114, 'Audit Report Advanced Writing', 'Auditing'),
(2115, 'Continuous Auditing Techniques', 'Auditing'),
(2116, 'Operational Auditing', 'Auditing'),
(2117, 'Environmental & CSR Auditing', 'Auditing'),
(2118, 'Corporate Governance Auditing', 'Auditing'),
(2119, 'Advanced Tally ERP Functions', 'Software'),
(2120, 'SAP FICO Advanced Modules', 'Software'),
(2121, 'QuickBooks Advanced Accounting', 'Software'),
(2122, 'MS Excel Advanced Functions (Pivot, VLOOKUP, Macros)', 'Software'),
(2123, 'ERP Integration for Accounting', 'Software'),
(2124, 'Accounting Data Analytics', 'Software'),
(2125, 'Business Intelligence Tools for Finance', 'Software'),
(2126, 'Financial Reporting Automation', 'Software'),
(2127, 'Database Management for Finance', 'Software'),
(2128, 'Cloud Accounting & Online ERP Systems', 'Software'),
(2129, 'Financial Ratio Analysis Advanced', 'Analytical'),
(2130, 'Decision Making using Financial Models', 'Analytical'),
(2131, 'Scenario & Sensitivity Analysis', 'Analytical'),
(2132, 'Variance & Trend Analysis', 'Analytical'),
(2133, 'Risk Assessment & Mitigation in Accounting', 'Analytical'),
(2134, 'Problem Solving in Financial Operations', 'Analytical'),
(2135, 'Professional Ethics in Accounting', 'Professional'),
(2136, 'Business Communication for Accountants', 'Professional'),
(2137, 'Advanced Report Writing', 'Professional'),
(2138, 'Presentation of Financial Data to Stakeholders', 'Professional'),
(2139, 'Financial Audit Simulation Project', 'Project-Based'),
(2140, 'ERP Implementation Accounting Project', 'Project-Based'),
(2141, 'Corporate Finance Analysis Project', 'Project-Based'),
(2142, 'Tax Planning & Compliance Project', 'Project-Based'),
(2143, 'Cost Accounting & Budgeting Project', 'Project-Based'),
(2144, 'Accounting Analytics & Forecasting Project', 'Project-Based'),
(2145, 'Forensic Accounting Case Study', 'Project-Based'),
(2146, 'Financial Modelling & Decision-Making Project', 'Project-Based'),
(2147, 'Advanced Management Accounting Project', 'Project-Based'),
(2148, 'Capstone Accountancy Internship Project', 'Project-Based'),
(2149, 'International Accounting Standards (IAS)', 'Accounting'),
(2150, 'IFRS for SMEs', 'Accounting'),
(2151, 'IFRS Consolidation & Group Accounts', 'Accounting'),
(2152, 'Accounting for Foreign Subsidiaries', 'Accounting'),
(2153, 'International Financial Reporting & Disclosure', 'Accounting'),
(2154, 'Accounting for Derivatives & Hedging', 'Accounting'),
(2155, 'Accounting for Leases & Contracts', 'Accounting'),
(2156, 'Revenue Recognition under IFRS 15', 'Accounting'),
(2157, 'Accounting for Employee Benefits', 'Accounting'),
(2158, 'Fair Value Measurement & Financial Instruments', 'Accounting'),
(2159, 'Performance Auditing', 'Auditing'),
(2160, 'Continuous & Real-Time Auditing', 'Auditing'),
(2161, 'IT & Cybersecurity Auditing', 'Auditing'),
(2162, 'Risk-Based Audit Planning', 'Auditing'),
(2163, 'Audit Analytics & Data Sampling', 'Auditing'),
(2164, 'Forensic Investigation of Fraud', 'Auditing'),
(2165, 'Audit Compliance for Multinationals', 'Auditing'),
(2166, 'Integrated Reporting Audits', 'Auditing'),
(2167, 'Operational & Process Auditing', 'Auditing'),
(2168, 'Sustainability & CSR Auditing', 'Auditing'),
(2169, 'International Tax Compliance', 'Taxation'),
(2170, 'Transfer Pricing & Multinational Taxation', 'Taxation'),
(2171, 'Advanced VAT/GST Planning', 'Taxation'),
(2172, 'Corporate Tax Advisory & Strategy', 'Taxation'),
(2173, 'Indirect Tax Management', 'Taxation'),
(2174, 'Deferred & Provisions Tax Accounting', 'Taxation'),
(2175, 'Tax Risk Assessment', 'Taxation'),
(2176, 'Cross-Border Tax Reporting', 'Taxation'),
(2177, 'Taxation in E-Commerce & Digital Businesses', 'Taxation'),
(2178, 'Tax Auditing & Investigation Techniques', 'Taxation'),
(2179, 'Financial Risk Modelling', 'Finance'),
(2180, 'Derivatives & Hedging Analysis', 'Finance'),
(2181, 'Investment Portfolio Management', 'Finance'),
(2182, 'Capital Market Analysis', 'Finance'),
(2183, 'Corporate Valuation & M&A Finance', 'Finance'),
(2184, 'Advanced Budgetary Control', 'Finance'),
(2185, 'Cost Optimization & Profitability Analysis', 'Finance'),
(2186, 'Strategic Financial Planning', 'Finance'),
(2187, 'Treasury Operations & Liquidity Management', 'Finance'),
(2188, 'Management Reporting & KPIs', 'Finance'),
(2189, 'Advanced SAP FICO Reporting', 'Software'),
(2190, 'ERP Financial Integration', 'Software'),
(2191, 'Cloud Accounting Tools (Xero, QuickBooks Online)', 'Software'),
(2192, 'Financial Data Visualization (Power BI, Tableau)', 'Software'),
(2193, 'Excel Macros & VBA for Accounting', 'Software'),
(2194, 'Financial Modelling in Excel', 'Software'),
(2195, 'Accounting Database Design & SQL', 'Software'),
(2196, 'Big Data Analytics for Finance', 'Software'),
(2197, 'Robotic Process Automation (RPA) for Accounting', 'Software'),
(2198, 'AI Tools for Accounting Forecasting', 'Software'),
(2199, 'Advanced Business Communication', 'Professional'),
(2200, 'Negotiation & Persuasion in Finance', 'Professional'),
(2201, 'Leadership in Financial Teams', 'Professional'),
(2202, 'Ethical Decision Making in Accounting', 'Professional'),
(2203, 'Strategic Thinking for Accountants', 'Professional'),
(2204, 'Presentation of Financial Statements to Board', 'Professional'),
(2205, 'Stakeholder Management in Finance', 'Professional'),
(2206, 'Critical Thinking for Complex Accounting Problems', 'Professional'),
(2207, 'Time Management & Prioritization for Accountants', 'Professional'),
(2208, 'Networking & Professional Relationship Management', 'Professional'),
(2209, 'ERP Implementation Project', 'Project-Based'),
(2210, 'International Accounting Project', 'Project-Based'),
(2211, 'Forensic Accounting Investigation Project', 'Project-Based'),
(2212, 'Financial Modelling & Valuation Project', 'Project-Based'),
(2213, 'Tax Compliance & Planning Project', 'Project-Based'),
(2214, 'Audit Simulation Project', 'Project-Based'),
(2215, 'Cost Management & Budgeting Project', 'Project-Based'),
(2216, 'Corporate Finance Case Study Project', 'Project-Based'),
(2217, 'Management Accounting Analysis Project', 'Project-Based'),
(2218, 'Capstone Accounting Internship Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_agriculture_skills`
--

CREATE TABLE `hnd_agriculture_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_agriculture_skills`
--

INSERT INTO `hnd_agriculture_skills` (`id`, `skill_name`, `category`) VALUES
(3001, 'Plant Physiology', 'Crop Science'),
(3002, 'Crop Production Techniques', 'Crop Science'),
(3003, 'Soil Fertility & Nutrient Management', 'Crop Science'),
(3004, 'Plant Breeding & Genetics', 'Crop Science'),
(3005, 'Horticulture Practices', 'Crop Science'),
(3006, 'Pest & Disease Management', 'Crop Science'),
(3007, 'Organic Farming Techniques', 'Crop Science'),
(3008, 'Precision Agriculture', 'Crop Science'),
(3009, 'Post-Harvest Management', 'Crop Science'),
(3010, 'Greenhouse & Protected Cultivation', 'Crop Science'),
(3011, 'Soil Analysis & Testing', 'Soil Science'),
(3012, 'Soil Conservation Techniques', 'Soil Science'),
(3013, 'Irrigation Systems & Water Management', 'Soil Science'),
(3014, 'Soil Erosion & Sustainable Practices', 'Soil Science'),
(3015, 'Fertilizer Application & Management', 'Soil Science'),
(3016, 'Soil Health Monitoring', 'Soil Science'),
(3017, 'Soil Microbiology', 'Soil Science'),
(3018, 'Land Use Planning', 'Soil Science'),
(3019, 'Hydroponics & Soilless Culture', 'Soil Science'),
(3020, 'Water Quality Management', 'Soil Science'),
(3021, 'Animal Nutrition & Feed Management', 'Animal Husbandry'),
(3022, 'Livestock Breeding & Genetics', 'Animal Husbandry'),
(3023, 'Dairy Farming Techniques', 'Animal Husbandry'),
(3024, 'Poultry Management', 'Animal Husbandry'),
(3025, 'Veterinary Care & Disease Management', 'Animal Husbandry'),
(3026, 'Sheep & Goat Farming', 'Animal Husbandry'),
(3027, 'Aquaculture & Fisheries Management', 'Animal Husbandry'),
(3028, 'Animal Welfare Practices', 'Animal Husbandry'),
(3029, 'Farm Animal Health Monitoring', 'Animal Husbandry'),
(3030, 'Livestock Production Systems', 'Animal Husbandry'),
(3031, 'Agricultural Economics', 'Agribusiness'),
(3032, 'Farm Management & Planning', 'Agribusiness'),
(3033, 'Agricultural Marketing & Sales', 'Agribusiness'),
(3034, 'Supply Chain Management in Agriculture', 'Agribusiness'),
(3035, 'Financial Management for Farms', 'Agribusiness'),
(3036, 'Agri-Entrepreneurship', 'Agribusiness'),
(3037, 'Cooperative Farming Management', 'Agribusiness'),
(3038, 'Agricultural Policy & Legislation', 'Agribusiness'),
(3039, 'Farm Record Keeping', 'Agribusiness'),
(3040, 'Risk Management in Agriculture', 'Agribusiness'),
(3041, 'Farm Machinery & Equipment', 'Technology'),
(3042, 'Precision Agriculture Tools', 'Technology'),
(3043, 'GIS & Remote Sensing in Agriculture', 'Technology'),
(3044, 'Drone Technology for Agriculture', 'Technology'),
(3045, 'Agricultural Software Tools', 'Technology'),
(3046, 'Smart Irrigation Systems', 'Technology'),
(3047, 'Sensor-Based Crop Monitoring', 'Technology'),
(3048, 'Data Analytics for Agriculture', 'Technology'),
(3049, 'Climate-Smart Agriculture Techniques', 'Technology'),
(3050, 'Agri-Tech Innovations', 'Technology'),
(3051, 'Sustainable Agriculture Practices', 'Environment'),
(3052, 'Integrated Pest Management', 'Environment'),
(3053, 'Agroforestry Systems', 'Environment'),
(3054, 'Soil & Water Conservation', 'Environment'),
(3055, 'Environmental Impact Assessment', 'Environment'),
(3056, 'Climate Change Adaptation in Agriculture', 'Environment'),
(3057, 'Biodiversity Management', 'Environment'),
(3058, 'Organic & Eco-Friendly Farming', 'Environment'),
(3059, 'Waste Management in Agriculture', 'Environment'),
(3060, 'Renewable Energy in Agriculture', 'Environment'),
(3061, 'Communication Skills for Farmers & Agribusiness', 'Professional'),
(3062, 'Leadership & Team Management', 'Professional'),
(3063, 'Problem Solving & Decision Making', 'Professional'),
(3064, 'Project Planning & Management', 'Professional'),
(3065, 'Professional Ethics in Agriculture', 'Professional'),
(3066, 'Time Management & Organization', 'Professional'),
(3067, 'Collaboration & Stakeholder Engagement', 'Professional'),
(3068, 'Presentation & Reporting Skills', 'Professional'),
(3069, 'Critical Thinking in Agricultural Projects', 'Professional'),
(3070, 'Networking & Industry Relations', 'Professional'),
(3071, 'Crop Production Project', 'Project-Based'),
(3072, 'Soil Health & Fertility Project', 'Project-Based'),
(3073, 'Livestock Management Project', 'Project-Based'),
(3074, 'Agribusiness Management Project', 'Project-Based'),
(3075, 'Precision Agriculture & Technology Project', 'Project-Based'),
(3076, 'Sustainable Farming Project', 'Project-Based'),
(3077, 'Agri-Tech Innovation Project', 'Project-Based'),
(3078, 'Farm Operations Optimization Project', 'Project-Based'),
(3079, 'Environmental Impact Assessment Project', 'Project-Based'),
(3080, 'Capstone Agricultural Internship Project', 'Project-Based'),
(3081, 'Advanced Plant Breeding Techniques', 'Crop Science'),
(3082, 'Genetically Modified Crops (GMOs) Management', 'Crop Science'),
(3083, 'Tissue Culture & Micropropagation', 'Crop Science'),
(3084, 'Plant Disease Diagnostics & Management', 'Crop Science'),
(3085, 'High Yield Crop Management', 'Crop Science'),
(3086, 'Crop Rotation & Polyculture Systems', 'Crop Science'),
(3087, 'Hydroponics Advanced Techniques', 'Crop Science'),
(3088, 'Vertical Farming Practices', 'Crop Science'),
(3089, 'Agrochemical Application & Safety', 'Crop Science'),
(3090, 'Crop Growth Modelling & Simulation', 'Crop Science'),
(3091, 'Precision Soil Mapping', 'Soil Science'),
(3092, 'Soil Carbon Sequestration Techniques', 'Soil Science'),
(3093, 'Irrigation Scheduling & Automation', 'Soil Science'),
(3094, 'Advanced Fertilizer Management', 'Soil Science'),
(3095, 'Soil Salinity & pH Management', 'Soil Science'),
(3096, 'Soil Health Monitoring Technologies', 'Soil Science'),
(3097, 'Sustainable Land Management', 'Soil Science'),
(3098, 'Rainwater Harvesting & Storage Systems', 'Soil Science'),
(3099, 'Agroecology & Soil Biodiversity', 'Soil Science'),
(3100, 'Soil Erosion Modelling & Control', 'Soil Science'),
(3101, 'Advanced Livestock Genetics', 'Animal Husbandry'),
(3102, 'Precision Feeding & Nutrition', 'Animal Husbandry'),
(3103, 'Dairy Herd Management Systems', 'Animal Husbandry'),
(3104, 'Advanced Poultry Production Techniques', 'Animal Husbandry'),
(3105, 'Veterinary Diagnostic Techniques', 'Animal Husbandry'),
(3106, 'Livestock Disease Surveillance', 'Animal Husbandry'),
(3107, 'Aquaculture Nutrition & Management', 'Animal Husbandry'),
(3108, 'Animal Reproduction & Breeding Management', 'Animal Husbandry'),
(3109, 'Animal Waste Management & Sustainability', 'Animal Husbandry'),
(3110, 'Livestock Performance Analytics', 'Animal Husbandry'),
(3111, 'Global Agribusiness Strategy', 'Agribusiness'),
(3112, 'Agricultural Risk Analysis & Mitigation', 'Agribusiness'),
(3113, 'Agri-Finance & Microfinance Management', 'Agribusiness'),
(3114, 'Export & International Trade in Agriculture', 'Agribusiness'),
(3115, 'Agricultural Supply Chain & Logistics', 'Agribusiness'),
(3116, 'Farm Digital Transformation & ERP', 'Agribusiness'),
(3117, 'Farm Resource Optimization', 'Agribusiness'),
(3118, 'Agri-Marketing & E-Commerce', 'Agribusiness'),
(3119, 'Sustainable Agribusiness Development', 'Agribusiness'),
(3120, 'Agricultural Project Feasibility Studies', 'Agribusiness'),
(3121, 'Drone & UAV Application in Farming', 'Technology'),
(3122, 'IoT-Based Smart Farming', 'Technology'),
(3123, 'Precision Agriculture Analytics', 'Technology'),
(3124, 'Remote Sensing for Crop Monitoring', 'Technology'),
(3125, 'GIS Applications in Agriculture', 'Technology'),
(3126, 'AI & Machine Learning in Agriculture', 'Technology'),
(3127, 'Automated Farm Machinery Operation', 'Technology'),
(3128, 'Sensor-Based Irrigation Systems', 'Technology'),
(3129, 'Data-Driven Crop Management', 'Technology'),
(3130, 'Agri-Tech Startups & Innovation', 'Technology'),
(3131, 'Climate-Smart Agriculture Practices', 'Environment'),
(3132, 'Sustainable Water Management', 'Environment'),
(3133, 'Agroforestry & Biodiversity Conservation', 'Environment'),
(3134, 'Carbon Footprint Reduction in Farming', 'Environment'),
(3135, 'Soil & Water Conservation Planning', 'Environment'),
(3136, 'Environmental Risk Assessment in Agriculture', 'Environment'),
(3137, 'Renewable Energy in Farms', 'Environment'),
(3138, 'Organic & Eco-Friendly Farming Practices', 'Environment'),
(3139, 'Waste to Energy in Agriculture', 'Environment'),
(3140, 'Sustainable Pest Management', 'Environment'),
(3141, 'Leadership in Agricultural Projects', 'Professional'),
(3142, 'Communication Skills for Agripreneurs', 'Professional'),
(3143, 'Problem Solving in Farm Operations', 'Professional'),
(3144, 'Team Management & Collaboration', 'Professional'),
(3145, 'Strategic Decision Making for Agribusiness', 'Professional'),
(3146, 'Professional Ethics in Agriculture', 'Professional'),
(3147, 'Time & Resource Management', 'Professional'),
(3148, 'Presentation & Reporting in Agribusiness', 'Professional'),
(3149, 'Negotiation & Stakeholder Engagement', 'Professional'),
(3150, 'Critical Thinking for Agricultural Challenges', 'Professional'),
(3151, 'Precision Farming Project', 'Project-Based'),
(3152, 'Advanced Crop Production Project', 'Project-Based'),
(3153, 'Livestock & Dairy Management Project', 'Project-Based'),
(3154, 'Agribusiness Strategy & Planning Project', 'Project-Based'),
(3155, 'Agri-Tech Innovation Project', 'Project-Based'),
(3156, 'Sustainable Agriculture & Climate Project', 'Project-Based'),
(3157, 'Soil Health & Fertility Improvement Project', 'Project-Based'),
(3158, 'Farm Operations Optimization Project', 'Project-Based'),
(3159, 'Environmental Impact Assessment in Agriculture Project', 'Project-Based'),
(3160, 'Capstone Agricultural Internship Advanced Project', 'Project-Based'),
(3161, 'CRISPR & Gene Editing in Crops', 'Crop Science'),
(3162, 'Advanced Plant Tissue Culture', 'Crop Science'),
(3163, 'Genomic Selection in Crop Breeding', 'Crop Science'),
(3164, 'Transgenic Crop Development', 'Crop Science'),
(3165, 'Molecular Diagnostics for Plant Diseases', 'Crop Science'),
(3166, 'Plant Phenotyping & High-Throughput Screening', 'Crop Science'),
(3167, 'Biofertilizers & Microbial Applications', 'Crop Science'),
(3168, 'Precision Nutrient Management', 'Crop Science'),
(3169, 'Adaptive Crop Varieties for Climate Change', 'Crop Science'),
(3170, 'Seed Technology & Storage Management', 'Crop Science'),
(3171, 'IoT-Based Farm Monitoring', 'Technology'),
(3172, 'Remote Sensing for Crop Health', 'Technology'),
(3173, 'Drone-Based Crop Surveillance', 'Technology'),
(3174, 'Automated Irrigation Control Systems', 'Technology'),
(3175, 'Sensor-Based Soil & Water Analytics', 'Technology'),
(3176, 'AI & Machine Learning for Crop Prediction', 'Technology'),
(3177, 'Digital Farm Management Platforms', 'Technology'),
(3178, 'Blockchain in Agribusiness', 'Technology'),
(3179, 'Smart Greenhouse Automation', 'Technology'),
(3180, 'Data-Driven Pest Management', 'Technology'),
(3181, 'Climate-Resilient Farming Practices', 'Environment'),
(3182, 'Agroforestry System Design', 'Environment'),
(3183, 'Soil Carbon Sequestration & Organic Matter Management', 'Environment'),
(3184, 'Sustainable Water Use & Rainwater Harvesting', 'Environment'),
(3185, 'Integrated Pest & Disease Management', 'Environment'),
(3186, 'Eco-Friendly Fertilizer Application', 'Environment'),
(3187, 'Renewable Energy Solutions for Farms', 'Environment'),
(3188, 'Waste-to-Resource Circular Farming', 'Environment'),
(3189, 'Carbon Footprint Reduction Techniques', 'Environment'),
(3190, 'Climate-Smart Livestock Practices', 'Environment'),
(3191, 'Genetic Improvement in Livestock', 'Animal Husbandry'),
(3192, 'Precision Feeding & Nutrition Analytics', 'Animal Husbandry'),
(3193, 'Automated Milking Systems', 'Animal Husbandry'),
(3194, 'Aquaponics & Integrated Fish Farming', 'Animal Husbandry'),
(3195, 'Animal Health Monitoring using IoT', 'Animal Husbandry'),
(3196, 'Livestock Behavior & Welfare Monitoring', 'Animal Husbandry'),
(3197, 'Disease Surveillance & Biosecurity in Farms', 'Animal Husbandry'),
(3198, 'Sustainable Feed Production', 'Animal Husbandry'),
(3199, 'Advanced Poultry Housing & Management', 'Animal Husbandry'),
(3200, 'Smart Dairy & Meat Production Management', 'Animal Husbandry'),
(3201, 'Global Agri-Market Analysis', 'Agribusiness'),
(3202, 'International Trade Compliance & Export Management', 'Agribusiness'),
(3203, 'Agribusiness Financial Modelling', 'Agribusiness'),
(3204, 'Supply Chain Optimization in Agriculture', 'Agribusiness'),
(3205, 'Agri-Fintech Applications', 'Agribusiness'),
(3206, 'Strategic Agri-Marketing', 'Agribusiness'),
(3207, 'Farm-to-Market Logistics Planning', 'Agribusiness'),
(3208, 'Agro-Entrepreneurship & Startup Incubation', 'Agribusiness'),
(3209, 'Risk Management in Global Agriculture', 'Agribusiness'),
(3210, 'Agricultural Policy & Regulatory Analysis', 'Agribusiness'),
(3211, 'Leadership in Agribusiness Projects', 'Professional'),
(3212, 'Negotiation with Stakeholders', 'Professional'),
(3213, 'Strategic Decision Making in Agriculture', 'Professional'),
(3214, 'Project Planning & Monitoring in Farms', 'Professional'),
(3215, 'Communication Skills for Agripreneurs', 'Professional'),
(3216, 'Conflict Resolution in Agricultural Teams', 'Professional'),
(3217, 'Time & Resource Management for Farms', 'Professional'),
(3218, 'Team Collaboration & Leadership', 'Professional'),
(3219, 'Professional Ethics in Agribusiness', 'Professional'),
(3220, 'Networking & Industry Collaboration', 'Professional'),
(3221, 'Precision Farming Implementation Project', 'Project-Based'),
(3222, 'Climate-Smart Agriculture Project', 'Project-Based'),
(3223, 'Agri-Tech Innovation Project', 'Project-Based'),
(3224, 'Advanced Crop Biotechnology Project', 'Project-Based'),
(3225, 'Livestock Health & Management Project', 'Project-Based'),
(3226, 'Sustainable Water & Soil Management Project', 'Project-Based'),
(3227, 'Agroforestry & Environmental Project', 'Project-Based'),
(3228, 'Farm Digital Transformation Project', 'Project-Based'),
(3229, 'Agri-Business Strategy & Market Analysis Project', 'Project-Based'),
(3230, 'Capstone Advanced Agriculture Internship Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_building_services_skills`
--

CREATE TABLE `hnd_building_services_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_building_services_skills`
--

INSERT INTO `hnd_building_services_skills` (`id`, `skill_name`, `branch`) VALUES
(4001, 'HVAC Design & Installation', 'Building Services'),
(4002, 'Air Conditioning Systems', 'Building Services'),
(4003, 'Heating Systems Design', 'Building Services'),
(4004, 'Ventilation & Duct Design', 'Building Services'),
(4005, 'Refrigeration Systems', 'Building Services'),
(4006, 'Thermal Comfort Analysis', 'Building Services'),
(4007, 'Energy Efficiency in Buildings', 'Building Services'),
(4008, 'Building Automation Systems', 'Building Services'),
(4009, 'Electrical Wiring & Layout', 'Building Services'),
(4010, 'Lighting Design & Control', 'Building Services'),
(4011, 'Power Distribution Systems', 'Building Services'),
(4012, 'Emergency Power & UPS Systems', 'Building Services'),
(4013, 'Electrical Safety Standards', 'Building Services'),
(4014, 'Fire Alarm & Detection Systems', 'Building Services'),
(4015, 'Building Energy Management Systems', 'Building Services'),
(4016, 'Plumbing Design & Installation', 'Building Services'),
(4017, 'Sanitary Systems', 'Building Services'),
(4018, 'Water Supply & Distribution', 'Building Services'),
(4019, 'Stormwater & Drainage Systems', 'Building Services'),
(4020, 'Fire Suppression & Sprinkler Systems', 'Building Services'),
(4021, 'HVAC Installation Project', 'Project-Based'),
(4022, 'Electrical Wiring Project', 'Project-Based'),
(4023, 'Lighting Design & Simulation Project', 'Project-Based'),
(4024, 'Building Energy Audit Project', 'Project-Based'),
(4025, 'Plumbing & Water System Installation Project', 'Project-Based'),
(4026, 'Fire Safety System Implementation Project', 'Project-Based'),
(4027, 'Smart Building Automation Project', 'Project-Based'),
(4028, 'AutoCAD MEP', 'Software'),
(4029, 'Revit MEP', 'Software'),
(4030, 'Energy Simulation Software', 'Software'),
(4031, 'HVAC Simulation Software', 'Software'),
(4032, 'Plumbing & Piping Design Software', 'Software'),
(4033, 'Electrical Design Software', 'Software'),
(4034, 'Chilled Water System Design', 'Building Services'),
(4035, 'Heat Load Calculations', 'Building Services'),
(4036, 'Ventilation System Optimization', 'Building Services'),
(4037, 'Fan Coil Unit Design', 'Building Services'),
(4038, 'Pump & Piping System Design', 'Building Services'),
(4039, 'Energy Recovery Systems', 'Building Services'),
(4040, 'District Heating & Cooling', 'Building Services'),
(4041, 'Thermal Energy Storage Systems', 'Building Services'),
(4042, 'Smart Lighting Control Systems', 'Building Services'),
(4043, 'Energy Efficient Power Distribution', 'Building Services'),
(4044, 'Low Voltage System Design', 'Building Services'),
(4045, 'Electrical Maintenance Planning', 'Building Services'),
(4046, 'Solar PV Integration', 'Building Services'),
(4047, 'Emergency Lighting Design', 'Building Services'),
(4048, 'Building Electrical Safety Audit', 'Building Services'),
(4049, 'Greywater & Rainwater Systems', 'Building Services'),
(4050, 'Hot & Cold Water System Design', 'Building Services'),
(4051, 'Sanitary Wastewater System Design', 'Building Services'),
(4052, 'Water Pump Selection & Design', 'Building Services'),
(4053, 'Fire Protection Plumbing Systems', 'Building Services'),
(4054, 'Sustainable Water Management', 'Building Services'),
(4055, 'Fire Alarm System Design', 'Building Services'),
(4056, 'Smoke Detection & Control', 'Building Services'),
(4057, 'Sprinkler System Design & Installation', 'Building Services'),
(4058, 'Emergency Evacuation Systems', 'Building Services'),
(4059, 'Fire Safety Compliance & Audit', 'Building Services'),
(4060, 'Building Energy Simulation', 'Building Services'),
(4061, 'Green Building Design', 'Building Services'),
(4062, 'LEED / BREEAM Standards', 'Building Services'),
(4063, 'Smart Building Automation', 'Building Services'),
(4064, 'IoT in Building Management', 'Building Services'),
(4065, 'Energy Monitoring & Reporting', 'Building Services'),
(4066, 'HVAC System Installation Project', 'Project-Based'),
(4067, 'Electrical Wiring & Distribution Project', 'Project-Based'),
(4068, 'Lighting Design Simulation Project', 'Project-Based'),
(4069, 'Plumbing & Water Systems Installation Project', 'Project-Based'),
(4070, 'Fire Safety Implementation Project', 'Project-Based'),
(4071, 'Energy Audit & Optimization Project', 'Project-Based'),
(4072, 'Smart Building Automation Project', 'Project-Based'),
(4073, 'AutoCAD MEP Advanced', 'Software'),
(4074, 'Revit MEP Advanced', 'Software'),
(4075, 'EnergyPlus Simulation', 'Software'),
(4076, 'Carrier HAP HVAC Simulation', 'Software'),
(4077, 'PlumbingCAD Software', 'Software'),
(4078, 'ETAP Electrical Analysis', 'Software'),
(4079, 'Dialux Lighting Simulation', 'Software'),
(4080, 'Variable Refrigerant Flow (VRF) Systems', 'Building Services'),
(4081, 'Chiller Plant Optimization', 'Building Services'),
(4082, 'Cooling Tower Design & Operation', 'Building Services'),
(4083, 'HVAC Commissioning & Testing', 'Building Services'),
(4084, 'Thermal Comfort Modeling', 'Building Services'),
(4085, 'Energy Efficient HVAC Design', 'Building Services'),
(4086, 'District Energy Systems', 'Building Services'),
(4087, 'Air Quality Monitoring', 'Building Services'),
(4088, 'Building Lighting Automation', 'Building Services'),
(4089, 'Energy Storage Integration', 'Building Services'),
(4090, 'Smart Grid Integration', 'Building Services'),
(4091, 'Electrical Load Management', 'Building Services'),
(4092, 'Renewable Energy System Integration', 'Building Services'),
(4093, 'Electrical Fault Diagnosis', 'Building Services'),
(4094, 'Power Quality Analysis', 'Building Services'),
(4095, 'Rainwater Harvesting System Design', 'Building Services'),
(4096, 'Greywater Recycling System Design', 'Building Services'),
(4097, 'Water Pumping & Control Systems', 'Building Services'),
(4098, 'Fire Suppression Hydraulics', 'Building Services'),
(4099, 'Sustainable Plumbing Practices', 'Building Services'),
(4100, 'Hot Water System Optimization', 'Building Services'),
(4101, 'Integrated Fire Safety Systems', 'Building Services'),
(4102, 'Smoke Control System Design', 'Building Services'),
(4103, 'Emergency Evacuation & Alarm Systems', 'Building Services'),
(4104, 'Fire Safety Risk Assessment', 'Building Services'),
(4105, 'Sprinkler System Commissioning', 'Building Services'),
(4106, 'Building Energy Management System (BEMS)', 'Building Services'),
(4107, 'IoT-based Building Monitoring', 'Building Services'),
(4108, 'Smart Sensors & Actuators for Buildings', 'Building Services'),
(4109, 'Building Performance Analysis', 'Building Services'),
(4110, 'Energy Benchmarking & Reporting', 'Building Services'),
(4111, 'Sustainable HVAC System Design', 'Building Services'),
(4112, 'LEED / BREEAM Certification Projects', 'Building Services'),
(4113, 'Building Services Installation Project', 'Project-Based'),
(4114, 'HVAC System Commissioning Project', 'Project-Based'),
(4115, 'Electrical Distribution & Testing Project', 'Project-Based'),
(4116, 'Fire Safety Systems Project', 'Project-Based'),
(4117, 'Renewable Energy Integration Project', 'Project-Based'),
(4118, 'Building Energy Audit & Simulation Project', 'Project-Based'),
(4119, 'Plumbing & Water Systems Field Project', 'Project-Based'),
(4120, 'Smart Building Automation Implementation Project', 'Project-Based'),
(4121, 'Revit MEP Advanced Modeling', 'Software'),
(4122, 'AutoCAD MEP Advanced Drafting', 'Software'),
(4123, 'Carrier HAP HVAC Simulation Advanced', 'Software'),
(4124, 'EnergyPlus Energy Simulation Advanced', 'Software'),
(4125, 'ETAP Power System Analysis Advanced', 'Software'),
(4126, 'Dialux Lighting Simulation Advanced', 'Software'),
(4127, 'PlumbingCAD & Hydraulic Simulation Advanced', 'Software');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_business_admin_skills`
--

CREATE TABLE `hnd_business_admin_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_business_admin_skills`
--

INSERT INTO `hnd_business_admin_skills` (`id`, `skill_name`, `category`) VALUES
(5001, 'Financial Modelling & Forecasting', 'Finance & Accounting'),
(5002, 'Advanced Corporate Finance', 'Finance & Accounting'),
(5003, 'Mergers & Acquisitions Analysis', 'Finance & Accounting'),
(5004, 'Capital Budgeting Techniques', 'Finance & Accounting'),
(5005, 'Derivative & Risk Management', 'Finance & Accounting'),
(5006, 'Investment Portfolio Management', 'Finance & Accounting'),
(5007, 'Financial Statement Consolidation', 'Finance & Accounting'),
(5008, 'Internal Auditing Techniques', 'Finance & Accounting'),
(5009, 'Cost Control & Variance Analysis', 'Finance & Accounting'),
(5010, 'Accounting Software Proficiency (QuickBooks, Tally, SAP FICO)', 'Finance & Accounting'),
(5011, 'Advanced Digital Marketing Analytics', 'Marketing'),
(5012, 'SEO & SEM Strategies', 'Marketing'),
(5013, 'Social Media Marketing Campaigns', 'Marketing'),
(5014, 'Content Marketing Strategy', 'Marketing'),
(5015, 'E-Commerce Operations & Management', 'Marketing'),
(5016, 'Customer Retention & Loyalty Programs', 'Marketing'),
(5017, 'Marketing Automation Tools (HubSpot, Salesforce)', 'Marketing'),
(5018, 'Brand Positioning & Strategy', 'Marketing'),
(5019, 'International Marketing Strategies', 'Marketing'),
(5020, 'Market Segmentation & Targeting', 'Marketing'),
(5021, 'Talent Acquisition Strategy', 'HRM'),
(5022, 'Employee Engagement & Retention Programs', 'HRM'),
(5023, 'Leadership Development Programs', 'HRM'),
(5024, 'Succession Planning', 'HRM'),
(5025, 'HR Analytics & Workforce Planning', 'HRM'),
(5026, 'Compensation Benchmarking', 'HRM'),
(5027, 'Employee Training Needs Assessment', 'HRM'),
(5028, 'Industrial Relations & Dispute Management', 'HRM'),
(5029, 'Performance Appraisal System Design', 'HRM'),
(5030, 'Organizational Culture Development', 'HRM'),
(5031, 'Agile Project Management', 'Operations'),
(5032, 'Lean Six Sigma Methodology', 'Operations'),
(5033, 'Advanced Supply Chain Analytics', 'Operations'),
(5034, 'Procurement Strategy & Vendor Management', 'Operations'),
(5035, 'Inventory Optimization Techniques', 'Operations'),
(5036, 'Operations Risk Management', 'Operations'),
(5037, 'Business Process Reengineering', 'Operations'),
(5038, 'Capacity Planning & Resource Allocation', 'Operations'),
(5039, 'Total Quality Management (TQM)', 'Operations'),
(5040, 'Production & Operations Simulation', 'Operations'),
(5041, 'Business Intelligence & Analytics', 'Strategy'),
(5042, 'Corporate Strategic Planning', 'Strategy'),
(5043, 'Scenario Planning & Forecasting', 'Strategy'),
(5044, 'Mergers & Strategic Alliances', 'Strategy'),
(5045, 'Innovation & Disruptive Strategy', 'Strategy'),
(5046, 'Decision Support Systems', 'Strategy'),
(5047, 'Enterprise Risk Management', 'Strategy'),
(5048, 'Balanced Scorecard Implementation', 'Strategy'),
(5049, 'Change Leadership & Strategy Execution', 'Strategy'),
(5050, 'Stakeholder Analysis & Management', 'Strategy'),
(5051, 'Startup Funding & Venture Capital', 'Entrepreneurship'),
(5052, 'Business Model Innovation & Pivoting', 'Entrepreneurship'),
(5053, 'Scaling Startups & Growth Strategies', 'Entrepreneurship'),
(5054, 'Entrepreneurial Marketing & Branding', 'Entrepreneurship'),
(5055, 'Social Enterprise Development', 'Entrepreneurship'),
(5056, 'Innovation Lab & Ideation Techniques', 'Entrepreneurship'),
(5057, 'Feasibility Studies & Market Validation', 'Entrepreneurship'),
(5058, 'Product Launch & Go-to-Market Strategies', 'Entrepreneurship'),
(5059, 'Business Incubation & Acceleration', 'Entrepreneurship'),
(5060, 'Entrepreneurial Risk Management', 'Entrepreneurship'),
(5061, 'Advanced Excel for Data Analysis', 'IT & Analytics'),
(5062, 'Tableau & Power BI Dashboards', 'IT & Analytics'),
(5063, 'ERP Implementation & Integration', 'IT & Analytics'),
(5064, 'Database Design & SQL for Business', 'IT & Analytics'),
(5065, 'Big Data Analytics & Visualization', 'IT & Analytics'),
(5066, 'Predictive Modelling & Forecasting', 'IT & Analytics'),
(5067, 'CRM Tools Advanced Usage', 'IT & Analytics'),
(5068, 'Business Analytics for Decision Making', 'IT & Analytics'),
(5069, 'Digital Transformation Strategy', 'IT & Analytics'),
(5070, 'Cloud Solutions for Business Operations', 'IT & Analytics'),
(5071, 'Advanced Corporate Governance', 'Legal & Ethics'),
(5072, 'International Business Law', 'Legal & Ethics'),
(5073, 'Contract Negotiation & Drafting', 'Legal & Ethics'),
(5074, 'Intellectual Property Management', 'Legal & Ethics'),
(5075, 'Compliance Auditing', 'Legal & Ethics'),
(5076, 'Anti-Corruption & Business Ethics', 'Legal & Ethics'),
(5077, 'Risk Mitigation Legal Strategies', 'Legal & Ethics'),
(5078, 'Employment Law Advanced', 'Legal & Ethics'),
(5079, 'Consumer Protection & Competition Law', 'Legal & Ethics'),
(5080, 'Environmental Compliance in Business', 'Legal & Ethics'),
(5081, 'Executive Communication Skills', 'Soft Skills'),
(5082, 'Leadership in Multicultural Teams', 'Soft Skills'),
(5083, 'Critical Thinking & Problem Solving', 'Soft Skills'),
(5084, 'Negotiation & Persuasion Advanced', 'Soft Skills'),
(5085, 'Conflict Management Techniques', 'Soft Skills'),
(5086, 'Change Management Communication', 'Soft Skills'),
(5087, 'Presentation Design & Delivery', 'Soft Skills'),
(5088, 'Networking & Relationship Management', 'Soft Skills'),
(5089, 'Professional Etiquette in International Business', 'Soft Skills'),
(5090, 'Decision Making under Uncertainty', 'Soft Skills'),
(5091, 'Business Simulation Project', 'Project-Based'),
(5092, 'Advanced Market Research Project', 'Project-Based'),
(5093, 'Financial Modelling Project', 'Project-Based'),
(5094, 'ERP Implementation Project', 'Project-Based'),
(5095, 'Startup Business Plan Project', 'Project-Based'),
(5096, 'Supply Chain Optimization Project', 'Project-Based'),
(5097, 'Digital Marketing Campaign Project', 'Project-Based'),
(5098, 'HR Analytics & Talent Project', 'Project-Based'),
(5099, 'Business Strategy & Planning Project', 'Project-Based'),
(5100, 'Capstone Business Administration Internship Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_courses`
--

CREATE TABLE `hnd_courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createddatetime` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_courses`
--

INSERT INTO `hnd_courses` (`id`, `name`, `createddatetime`) VALUES
(1, 'Higher National Diploma in Engineering (Mechanical)', '2025-10-04 14:25:50'),
(2, 'Higher National Diploma in English', '2025-10-04 14:25:50'),
(3, 'Higher National Diploma in Agriculture - HNDT (Agri)', '2025-10-04 14:25:50'),
(4, 'Higher National Diploma in Management - (HNDM)', '2025-10-04 14:25:50'),
(5, 'Higher National Diploma in Accountancy - (HNDA)', '2025-10-04 14:25:50'),
(6, 'Higher National Diploma in Information Technology - (HNDIT)', '2025-10-04 14:25:50'),
(7, 'Higher National Diploma in Business Administration - (HNDBA)', '2025-10-04 14:25:50'),
(8, 'Higher National Diploma in Food Technology (HNDFT)', '2025-10-04 14:25:50'),
(9, 'Higher National Diploma in Quantity Survey (HNDQS)', '2025-10-04 14:25:50'),
(10, 'Higher National Diploma in Tourism and Hospitality Management (HNDTHM)', '2025-10-04 14:25:50'),
(11, 'Higher National Diploma in Engineering- (Building Services)', '2025-10-04 14:25:50'),
(12, 'Higher National Diploma in Business Finance - (HNDBF)', '2025-10-04 14:25:50'),
(13, 'Higher National Diploma in Engineering - (HND - Engineering)', '2025-10-04 14:25:50');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_course_categories`
--

CREATE TABLE `hnd_course_categories` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_datetime` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_course_categories`
--

INSERT INTO `hnd_course_categories` (`id`, `course_id`, `category_name`, `created_datetime`) VALUES
(1, 1, 'Mechanical Engineering', '2025-10-15 22:07:31'),
(2, 1, 'Design Engineering', '2025-10-15 22:07:31'),
(3, 1, 'Project Management', '2025-10-15 22:07:31'),
(4, 2, 'Teaching', '2025-10-15 22:07:31'),
(5, 2, 'Content Writing', '2025-10-15 22:07:31'),
(6, 2, 'Editing', '2025-10-15 22:07:31'),
(7, 3, 'Agriculture Technology', '2025-10-15 22:07:31'),
(8, 3, 'Food Production', '2025-10-15 22:07:31'),
(9, 3, 'Agri Business', '2025-10-15 22:07:31'),
(10, 4, 'Management', '2025-10-15 22:07:31'),
(11, 4, 'Business Administration', '2025-10-15 22:07:31'),
(12, 4, 'HR', '2025-10-15 22:07:31'),
(13, 5, 'Accounting', '2025-10-15 22:07:31'),
(14, 5, 'Finance', '2025-10-15 22:07:31'),
(15, 5, 'Taxation', '2025-10-15 22:07:31'),
(16, 6, 'Software Engineering', '2025-10-15 22:07:31'),
(17, 6, 'Network Engineering', '2025-10-15 22:07:31'),
(18, 6, 'Cyber Security', '2025-10-15 22:07:31'),
(19, 6, 'Education', '2025-10-15 22:07:31'),
(20, 6, 'Data Science', '2025-10-15 22:07:31'),
(21, 6, 'Artificial Intelligence', '2025-10-15 22:07:31'),
(22, 6, 'Machine Learning', '2025-10-15 22:07:31'),
(23, 6, 'Blockchain Technology', '2025-10-15 22:07:31'),
(24, 6, 'Cloud Computing', '2025-10-15 22:07:31'),
(25, 6, 'DevOps', '2025-10-15 22:07:31'),
(26, 6, 'Mobile Development', '2025-10-15 22:07:31'),
(27, 6, 'Web Development', '2025-10-15 22:07:31'),
(28, 6, 'Game Development', '2025-10-15 22:07:31'),
(29, 6, 'UI/UX Design', '2025-10-15 22:07:31'),
(30, 6, 'Digital Marketing', '2025-10-15 22:07:31'),
(31, 6, 'Product Management', '2025-10-15 22:07:31'),
(32, 6, 'Business Analysis', '2025-10-15 22:07:31'),
(33, 6, 'Cybersecurity Research', '2025-10-15 22:07:31'),
(34, 6, 'System Administration', '2025-10-15 22:07:31'),
(35, 6, 'Data Engineering', '2025-10-15 22:07:31'),
(36, 7, 'Business Administration', '2025-10-15 22:07:31'),
(37, 7, 'Marketing', '2025-10-15 22:07:31'),
(38, 7, 'Operations', '2025-10-15 22:07:31'),
(39, 8, 'Food Technology', '2025-10-15 22:07:31'),
(40, 8, 'Food Safety', '2025-10-15 22:07:31'),
(41, 8, 'Nutrition', '2025-10-15 22:07:31'),
(42, 9, 'Quantity Surveying', '2025-10-15 22:07:31'),
(43, 9, 'Project Costing', '2025-10-15 22:07:31'),
(44, 9, 'Construction Management', '2025-10-15 22:07:31'),
(45, 10, 'Tourism', '2025-10-15 22:07:31'),
(46, 10, 'Hotel Management', '2025-10-15 22:07:31'),
(47, 10, 'Event Management', '2025-10-15 22:07:31'),
(48, 11, 'Civil Engineering', '2025-10-15 22:07:31'),
(49, 11, 'Construction Management', '2025-10-15 22:07:31'),
(50, 11, 'Structural Design', '2025-10-15 22:07:31'),
(51, 12, 'Finance', '2025-10-15 22:07:31'),
(52, 12, 'Business Analysis', '2025-10-15 22:07:31'),
(53, 12, 'Accounting', '2025-10-15 22:07:31'),
(54, 13, 'Electrical Engineering', '2025-10-15 22:07:31'),
(55, 13, 'Mechanical Engineering', '2025-10-15 22:07:31'),
(56, 13, 'Project Management', '2025-10-15 22:07:31'),
(57, 1, 'Manufacturing', '2025-10-15 22:08:33'),
(58, 1, 'Automotive Engineering', '2025-10-15 22:08:33'),
(59, 1, 'Maintenance Engineering', '2025-10-15 22:08:33'),
(60, 1, 'Robotics', '2025-10-15 22:08:33'),
(61, 1, 'CAD Design', '2025-10-15 22:08:33'),
(62, 2, 'Translation', '2025-10-15 22:08:33'),
(63, 2, 'Journalism', '2025-10-15 22:08:33'),
(64, 2, 'Public Relations', '2025-10-15 22:08:33'),
(65, 2, 'Copywriting', '2025-10-15 22:08:33'),
(66, 2, 'Editing & Proofreading', '2025-10-15 22:08:33'),
(67, 3, 'Soil Science', '2025-10-15 22:08:33'),
(68, 3, 'Agri Marketing', '2025-10-15 22:08:33'),
(69, 3, 'Plant Breeding', '2025-10-15 22:08:33'),
(70, 3, 'Irrigation Management', '2025-10-15 22:08:33'),
(71, 3, 'Livestock Management', '2025-10-15 22:08:33'),
(72, 4, 'Strategic Planning', '2025-10-15 22:08:33'),
(73, 4, 'Business Consulting', '2025-10-15 22:08:33'),
(74, 4, 'Project Coordination', '2025-10-15 22:08:33'),
(75, 4, 'Operations Management', '2025-10-15 22:08:33'),
(76, 4, 'Entrepreneurship', '2025-10-15 22:08:33'),
(77, 5, 'Auditing', '2025-10-15 22:08:33'),
(78, 5, 'Financial Analysis', '2025-10-15 22:08:33'),
(79, 5, 'Budgeting', '2025-10-15 22:08:33'),
(80, 5, 'Payroll Management', '2025-10-15 22:08:33'),
(81, 5, 'Investment Analysis', '2025-10-15 22:08:33'),
(82, 6, 'IT Support', '2025-10-15 22:08:33'),
(83, 6, 'Systems Development', '2025-10-15 22:08:33'),
(84, 6, 'Database Administration', '2025-10-15 22:08:33'),
(85, 6, 'Software Testing', '2025-10-15 22:08:33'),
(86, 6, 'IT Consulting', '2025-10-15 22:08:33'),
(87, 7, 'Logistics', '2025-10-15 22:08:33'),
(88, 7, 'Procurement', '2025-10-15 22:08:33'),
(89, 7, 'Customer Relations', '2025-10-15 22:08:33'),
(90, 7, 'Office Administration', '2025-10-15 22:08:33'),
(91, 7, 'Business Development', '2025-10-15 22:08:33'),
(92, 8, 'Food Packaging', '2025-10-15 22:08:33'),
(93, 8, 'Quality Control', '2025-10-15 22:08:33'),
(94, 8, 'Food Processing', '2025-10-15 22:08:33'),
(95, 8, 'Beverage Technology', '2025-10-15 22:08:33'),
(96, 8, 'Nutrition Consulting', '2025-10-15 22:08:33'),
(97, 9, 'Surveying', '2025-10-15 22:08:33'),
(98, 9, 'Construction Estimation', '2025-10-15 22:08:33'),
(99, 9, 'Site Management', '2025-10-15 22:08:33'),
(100, 9, 'Cost Planning', '2025-10-15 22:08:33'),
(101, 9, 'Contract Administration', '2025-10-15 22:08:33'),
(102, 10, 'Travel Agency', '2025-10-15 22:08:33'),
(103, 10, 'Tour Guiding', '2025-10-15 22:08:33'),
(104, 10, 'Event Coordination', '2025-10-15 22:08:33'),
(105, 10, 'Hotel Front Office', '2025-10-15 22:08:33'),
(106, 10, 'Restaurant Management', '2025-10-15 22:08:33'),
(107, 11, 'Construction Planning', '2025-10-15 22:08:33'),
(108, 11, 'Site Supervision', '2025-10-15 22:08:33'),
(109, 11, 'Building Materials', '2025-10-15 22:08:33'),
(110, 11, 'Structural Analysis', '2025-10-15 22:08:33'),
(111, 11, 'Urban Planning', '2025-10-15 22:08:33'),
(112, 12, 'Financial Planning', '2025-10-15 22:08:33'),
(113, 12, 'Banking', '2025-10-15 22:08:33'),
(114, 12, 'Risk Management', '2025-10-15 22:08:33'),
(115, 12, 'Corporate Finance', '2025-10-15 22:08:33'),
(116, 12, 'Tax Advisory', '2025-10-15 22:08:33'),
(117, 13, 'Electronics Engineering', '2025-10-15 22:08:33'),
(118, 13, 'Instrumentation', '2025-10-15 22:08:33'),
(119, 13, 'Control Systems', '2025-10-15 22:08:33'),
(120, 13, 'Renewable Energy', '2025-10-15 22:08:33'),
(121, 13, 'Automation', '2025-10-15 22:08:33'),
(122, 1, 'Mechanical Engineering', '2025-10-15 22:09:25'),
(123, 1, 'Design Engineering', '2025-10-15 22:09:25'),
(124, 1, 'Project Management', '2025-10-15 22:09:25'),
(125, 1, 'Manufacturing', '2025-10-15 22:09:25'),
(126, 1, 'Automotive Engineering', '2025-10-15 22:09:25'),
(127, 1, 'Maintenance Engineering', '2025-10-15 22:09:25'),
(128, 1, 'Robotics', '2025-10-15 22:09:25'),
(129, 1, 'CAD Design', '2025-10-15 22:09:25'),
(130, 1, 'Industrial Engineering', '2025-10-15 22:09:25'),
(131, 1, 'HVAC Engineering', '2025-10-15 22:09:25'),
(132, 1, 'Mechatronics', '2025-10-15 22:09:25'),
(133, 1, 'Process Engineering', '2025-10-15 22:09:25'),
(134, 1, 'Quality Assurance', '2025-10-15 22:09:25'),
(135, 1, 'Production Planning', '2025-10-15 22:09:25'),
(136, 1, 'Tooling & Die', '2025-10-15 22:09:25'),
(137, 1, 'Materials Science', '2025-10-15 22:09:25'),
(138, 1, 'Thermodynamics', '2025-10-15 22:09:25'),
(139, 1, 'Hydraulics', '2025-10-15 22:09:25'),
(140, 1, 'Pneumatics', '2025-10-15 22:09:25'),
(141, 1, 'Energy Systems', '2025-10-15 22:09:25'),
(142, 1, 'Industrial Automation', '2025-10-15 22:09:25'),
(143, 1, 'Engineering Consultancy', '2025-10-15 22:09:25'),
(144, 1, 'Research & Development', '2025-10-15 22:09:25'),
(145, 1, 'Supply Chain Engineering', '2025-10-15 22:09:25'),
(146, 1, 'Plant Design', '2025-10-15 22:09:25'),
(147, 1, 'Maintenance Planning', '2025-10-15 22:09:25'),
(148, 1, 'Industrial Safety', '2025-10-15 22:09:25'),
(149, 1, 'Testing & Commissioning', '2025-10-15 22:09:25'),
(150, 1, 'Mechanical Drafting', '2025-10-15 22:09:25'),
(151, 1, 'Additive Manufacturing', '2025-10-15 22:09:25'),
(152, 2, 'Teaching', '2025-10-15 22:09:25'),
(153, 2, 'Content Writing', '2025-10-15 22:09:25'),
(154, 2, 'Editing', '2025-10-15 22:09:25'),
(155, 2, 'Translation', '2025-10-15 22:09:25'),
(156, 2, 'Journalism', '2025-10-15 22:09:25'),
(157, 2, 'Public Relations', '2025-10-15 22:09:25'),
(158, 2, 'Copywriting', '2025-10-15 22:09:25'),
(159, 2, 'Proofreading', '2025-10-15 22:09:25'),
(160, 2, 'Technical Writing', '2025-10-15 22:09:25'),
(161, 2, 'Creative Writing', '2025-10-15 22:09:25'),
(162, 2, 'Digital Content', '2025-10-15 22:09:25'),
(163, 2, 'Media Coordination', '2025-10-15 22:09:25'),
(164, 2, 'Language Coaching', '2025-10-15 22:09:25'),
(165, 2, 'Publishing', '2025-10-15 22:09:25'),
(166, 2, 'Communications', '2025-10-15 22:09:25'),
(167, 2, 'Speech Writing', '2025-10-15 22:09:25'),
(168, 2, 'Social Media Management', '2025-10-15 22:09:25'),
(169, 2, 'Academic Writing', '2025-10-15 22:09:25'),
(170, 2, 'Marketing Communications', '2025-10-15 22:09:25'),
(171, 2, 'Corporate Communications', '2025-10-15 22:09:25'),
(172, 2, 'Content Strategy', '2025-10-15 22:09:25'),
(173, 2, 'SEO Writing', '2025-10-15 22:09:25'),
(174, 2, 'Literary Analysis', '2025-10-15 22:09:25'),
(175, 2, 'Editing & Publishing', '2025-10-15 22:09:25'),
(176, 2, 'Teaching English as a Second Language', '2025-10-15 22:09:25'),
(177, 2, 'Creative Direction', '2025-10-15 22:09:25'),
(178, 2, 'Script Writing', '2025-10-15 22:09:25'),
(179, 2, 'Copy Editing', '2025-10-15 22:09:25'),
(180, 2, 'Media Production', '2025-10-15 22:09:25'),
(181, 2, 'Online Content Management', '2025-10-15 22:09:25'),
(182, 2, 'Proofreading & Quality Control', '2025-10-15 22:09:25'),
(183, 2, 'Professional Writing', '2025-10-15 22:09:25'),
(184, 6, 'Software Engineering', '2025-10-15 22:09:25'),
(185, 6, 'Network Engineering', '2025-10-15 22:09:25'),
(186, 6, 'Cyber Security', '2025-10-15 22:09:25'),
(187, 6, 'Education', '2025-10-15 22:09:25'),
(188, 6, 'Data Science', '2025-10-15 22:09:25'),
(189, 6, 'Artificial Intelligence', '2025-10-15 22:09:25'),
(190, 6, 'Machine Learning', '2025-10-15 22:09:25'),
(191, 6, 'Blockchain Technology', '2025-10-15 22:09:25'),
(192, 6, 'Cloud Computing', '2025-10-15 22:09:25'),
(193, 6, 'DevOps', '2025-10-15 22:09:25'),
(194, 6, 'Mobile Development', '2025-10-15 22:09:25'),
(195, 6, 'Web Development', '2025-10-15 22:09:25'),
(196, 6, 'Game Development', '2025-10-15 22:09:25'),
(197, 6, 'UI/UX Design', '2025-10-15 22:09:25'),
(198, 6, 'Digital Marketing', '2025-10-15 22:09:25'),
(199, 6, 'Product Management', '2025-10-15 22:09:25'),
(200, 6, 'Business Analysis', '2025-10-15 22:09:25'),
(201, 6, 'Cybersecurity Research', '2025-10-15 22:09:25'),
(202, 6, 'System Administration', '2025-10-15 22:09:25'),
(203, 6, 'Data Engineering', '2025-10-15 22:09:25'),
(204, 6, 'IT Support', '2025-10-15 22:09:25'),
(205, 6, 'Systems Development', '2025-10-15 22:09:25'),
(206, 6, 'Database Administration', '2025-10-15 22:09:25'),
(207, 6, 'Software Testing', '2025-10-15 22:09:25'),
(208, 6, 'IT Consulting', '2025-10-15 22:09:25'),
(209, 6, 'Network Security', '2025-10-15 22:09:25'),
(210, 6, 'Cloud Architecture', '2025-10-15 22:09:25'),
(211, 6, 'Big Data Analytics', '2025-10-15 22:09:25'),
(212, 6, 'AI Engineering', '2025-10-15 22:09:25'),
(213, 6, 'Machine Learning Operations', '2025-10-15 22:09:25'),
(214, 6, 'Mobile App Development', '2025-10-15 22:09:25'),
(215, 6, 'Web Application Development', '2025-10-15 22:09:25'),
(216, 6, 'DevOps Engineering', '2025-10-15 22:09:25'),
(217, 6, 'Software Project Management', '2025-10-15 22:09:25'),
(218, 6, 'IT Strategy', '2025-10-15 22:09:25'),
(219, 6, 'Server Administration', '2025-10-15 22:09:25'),
(220, 6, 'IT Research & Development', '2025-10-15 22:09:25'),
(221, 6, 'Virtualization Technology', '2025-10-15 22:09:25'),
(222, 6, 'Computer Networking', '2025-10-15 22:09:25'),
(223, 6, 'IT Compliance', '2025-10-15 22:09:25'),
(224, 6, 'Tech Support Services', '2025-10-15 22:09:25'),
(225, 3, 'Agriculture Technology', '2025-10-15 22:10:24'),
(226, 3, 'Food Production', '2025-10-15 22:10:24'),
(227, 3, 'Agri Business', '2025-10-15 22:10:24'),
(228, 3, 'Soil Science', '2025-10-15 22:10:24'),
(229, 3, 'Agri Marketing', '2025-10-15 22:10:24'),
(230, 3, 'Plant Breeding', '2025-10-15 22:10:24'),
(231, 3, 'Irrigation Management', '2025-10-15 22:10:24'),
(232, 3, 'Livestock Management', '2025-10-15 22:10:24'),
(233, 3, 'Horticulture', '2025-10-15 22:10:24'),
(234, 3, 'Agroforestry', '2025-10-15 22:10:24'),
(235, 3, 'Farm Machinery', '2025-10-15 22:10:24'),
(236, 3, 'Sustainable Agriculture', '2025-10-15 22:10:24'),
(237, 3, 'Agro Processing', '2025-10-15 22:10:24'),
(238, 3, 'Agri Policy', '2025-10-15 22:10:24'),
(239, 3, 'Crop Management', '2025-10-15 22:10:24'),
(240, 3, 'Fertilizer Management', '2025-10-15 22:10:24'),
(241, 3, 'Pest Control', '2025-10-15 22:10:24'),
(242, 3, 'Greenhouse Management', '2025-10-15 22:10:24'),
(243, 3, 'Organic Farming', '2025-10-15 22:10:24'),
(244, 3, 'Seed Technology', '2025-10-15 22:10:24'),
(245, 3, 'Aquaculture', '2025-10-15 22:10:24'),
(246, 3, 'Farm Management', '2025-10-15 22:10:24'),
(247, 3, 'Agri-Entrepreneurship', '2025-10-15 22:10:24'),
(248, 3, 'Agro Research', '2025-10-15 22:10:24'),
(249, 3, 'Agri Supply Chain', '2025-10-15 22:10:24'),
(250, 3, 'Post-Harvest Technology', '2025-10-15 22:10:24'),
(251, 3, 'Irrigation Engineering', '2025-10-15 22:10:24'),
(252, 3, 'Soil Fertility', '2025-10-15 22:10:24'),
(253, 3, 'Food Security', '2025-10-15 22:10:24'),
(254, 3, 'Agri Extension Services', '2025-10-15 22:10:24'),
(255, 4, 'Management', '2025-10-15 22:10:24'),
(256, 4, 'Business Administration', '2025-10-15 22:10:24'),
(257, 4, 'HR', '2025-10-15 22:10:24'),
(258, 4, 'Strategic Planning', '2025-10-15 22:10:24'),
(259, 4, 'Business Consulting', '2025-10-15 22:10:24'),
(260, 4, 'Project Coordination', '2025-10-15 22:10:24'),
(261, 4, 'Operations Management', '2025-10-15 22:10:24'),
(262, 4, 'Entrepreneurship', '2025-10-15 22:10:24'),
(263, 4, 'Leadership Development', '2025-10-15 22:10:24'),
(264, 4, 'Organizational Behavior', '2025-10-15 22:10:24'),
(265, 4, 'Supply Chain Management', '2025-10-15 22:10:24'),
(266, 4, 'Performance Management', '2025-10-15 22:10:24'),
(267, 4, 'Change Management', '2025-10-15 22:10:24'),
(268, 4, 'Corporate Strategy', '2025-10-15 22:10:24'),
(269, 4, 'Risk Management', '2025-10-15 22:10:24'),
(270, 4, 'Innovation Management', '2025-10-15 22:10:24'),
(271, 4, 'Business Analytics', '2025-10-15 22:10:24'),
(272, 4, 'Quality Management', '2025-10-15 22:10:24'),
(273, 4, 'Negotiation & Conflict Resolution', '2025-10-15 22:10:24'),
(274, 4, 'Decision Making', '2025-10-15 22:10:24'),
(275, 4, 'Team Leadership', '2025-10-15 22:10:24'),
(276, 4, 'Financial Management', '2025-10-15 22:10:24'),
(277, 4, 'Marketing Management', '2025-10-15 22:10:24'),
(278, 4, 'Customer Relationship Management', '2025-10-15 22:10:24'),
(279, 4, 'Operations Research', '2025-10-15 22:10:24'),
(280, 4, 'Business Intelligence', '2025-10-15 22:10:24'),
(281, 4, 'Corporate Governance', '2025-10-15 22:10:24'),
(282, 4, 'HR Analytics', '2025-10-15 22:10:24'),
(283, 4, 'Event Planning', '2025-10-15 22:10:24'),
(284, 4, 'Sustainability Management', '2025-10-15 22:10:24'),
(285, 5, 'Accounting', '2025-10-15 22:10:24'),
(286, 5, 'Finance', '2025-10-15 22:10:24'),
(287, 5, 'Taxation', '2025-10-15 22:10:24'),
(288, 5, 'Auditing', '2025-10-15 22:10:24'),
(289, 5, 'Financial Analysis', '2025-10-15 22:10:24'),
(290, 5, 'Budgeting', '2025-10-15 22:10:24'),
(291, 5, 'Payroll Management', '2025-10-15 22:10:24'),
(292, 5, 'Investment Analysis', '2025-10-15 22:10:24'),
(293, 5, 'Cost Accounting', '2025-10-15 22:10:24'),
(294, 5, 'Corporate Finance', '2025-10-15 22:10:24'),
(295, 5, 'Banking', '2025-10-15 22:10:24'),
(296, 5, 'Management Accounting', '2025-10-15 22:10:24'),
(297, 5, 'Tax Advisory', '2025-10-15 22:10:24'),
(298, 5, 'Financial Reporting', '2025-10-15 22:10:24'),
(299, 5, 'Bookkeeping', '2025-10-15 22:10:24'),
(300, 5, 'Accounts Payable & Receivable', '2025-10-15 22:10:24'),
(301, 5, 'Internal Audit', '2025-10-15 22:10:24'),
(302, 5, 'Credit Analysis', '2025-10-15 22:10:24'),
(303, 5, 'Financial Planning', '2025-10-15 22:10:24'),
(304, 5, 'Forensic Accounting', '2025-10-15 22:10:24'),
(305, 5, 'Accounting Software Management', '2025-10-15 22:10:24'),
(306, 5, 'Auditing Standards Compliance', '2025-10-15 22:10:24'),
(307, 5, 'Corporate Tax Planning', '2025-10-15 22:10:24'),
(308, 5, 'Accounting Consultancy', '2025-10-15 22:10:24'),
(309, 5, 'Budget Analysis', '2025-10-15 22:10:24'),
(310, 5, 'Financial Modelling', '2025-10-15 22:10:24'),
(311, 5, 'Investment Banking', '2025-10-15 22:10:24'),
(312, 5, 'Bank Reconciliation', '2025-10-15 22:10:24'),
(313, 5, 'Regulatory Compliance', '2025-10-15 22:10:24'),
(314, 5, 'Financial Risk Management', '2025-10-15 22:10:24'),
(315, 7, 'Business Administration', '2025-10-15 22:10:24'),
(316, 7, 'Marketing', '2025-10-15 22:10:24'),
(317, 7, 'Operations', '2025-10-15 22:10:24'),
(318, 7, 'Logistics', '2025-10-15 22:10:24'),
(319, 7, 'Procurement', '2025-10-15 22:10:24'),
(320, 7, 'Customer Relations', '2025-10-15 22:10:24'),
(321, 7, 'Office Administration', '2025-10-15 22:10:24'),
(322, 7, 'Business Development', '2025-10-15 22:10:24'),
(323, 7, 'Strategic Management', '2025-10-15 22:10:24'),
(324, 7, 'Project Management', '2025-10-15 22:10:24'),
(325, 7, 'Entrepreneurship', '2025-10-15 22:10:24'),
(326, 7, 'Sales Management', '2025-10-15 22:10:24'),
(327, 7, 'Supply Chain Management', '2025-10-15 22:10:24'),
(328, 7, 'Team Leadership', '2025-10-15 22:10:24'),
(329, 7, 'Event Management', '2025-10-15 22:10:24'),
(330, 7, 'Market Research', '2025-10-15 22:10:24'),
(331, 7, 'Advertising', '2025-10-15 22:10:24'),
(332, 7, 'Retail Management', '2025-10-15 22:10:24'),
(333, 7, 'Corporate Planning', '2025-10-15 22:10:24'),
(334, 7, 'Digital Marketing', '2025-10-15 22:10:24'),
(335, 7, 'Brand Management', '2025-10-15 22:10:24'),
(336, 7, 'E-commerce Management', '2025-10-15 22:10:24'),
(337, 7, 'Business Consulting', '2025-10-15 22:10:24'),
(338, 7, 'Negotiation Skills', '2025-10-15 22:10:24'),
(339, 7, 'Performance Monitoring', '2025-10-15 22:10:24'),
(340, 7, 'Product Management', '2025-10-15 22:10:24'),
(341, 7, 'Customer Experience', '2025-10-15 22:10:24'),
(342, 7, 'Innovation Management', '2025-10-15 22:10:24'),
(343, 7, 'CRM Implementation', '2025-10-15 22:10:24'),
(344, 7, 'International Business', '2025-10-15 22:10:24'),
(345, 8, 'Food Technology', '2025-10-15 22:10:24'),
(346, 8, 'Food Safety', '2025-10-15 22:10:24'),
(347, 8, 'Nutrition', '2025-10-15 22:10:24'),
(348, 8, 'Food Packaging', '2025-10-15 22:10:24'),
(349, 8, 'Quality Control', '2025-10-15 22:10:24'),
(350, 8, 'Food Processing', '2025-10-15 22:10:24'),
(351, 8, 'Beverage Technology', '2025-10-15 22:10:24'),
(352, 8, 'Nutrition Consulting', '2025-10-15 22:10:24'),
(353, 8, 'Food R&D', '2025-10-15 22:10:24'),
(354, 8, 'HACCP Compliance', '2025-10-15 22:10:24'),
(355, 8, 'Culinary Management', '2025-10-15 22:10:24'),
(356, 8, 'Dietary Planning', '2025-10-15 22:10:24'),
(357, 8, 'Food Innovation', '2025-10-15 22:10:24'),
(358, 8, 'Food Supply Chain', '2025-10-15 22:10:24'),
(359, 8, 'Agro Food Technology', '2025-10-15 22:10:24'),
(360, 8, 'Sensory Analysis', '2025-10-15 22:10:24'),
(361, 8, 'Food Preservation', '2025-10-15 22:10:24'),
(362, 8, 'Food Biotechnology', '2025-10-15 22:10:24'),
(363, 8, 'Recipe Development', '2025-10-15 22:10:24'),
(364, 8, 'Food Safety Auditing', '2025-10-15 22:10:24'),
(365, 8, 'Nutritional Analysis', '2025-10-15 22:10:24'),
(366, 8, 'Food Quality Assurance', '2025-10-15 22:10:24'),
(367, 8, 'Product Development', '2025-10-15 22:10:24'),
(368, 8, 'Food Production Management', '2025-10-15 22:10:24'),
(369, 8, 'Food Regulations Compliance', '2025-10-15 22:10:24'),
(370, 8, 'Food Industry Consulting', '2025-10-15 22:10:24'),
(371, 8, 'Food Process Engineering', '2025-10-15 22:10:24'),
(372, 8, 'Beverage Production', '2025-10-15 22:10:24'),
(373, 8, 'Food Packaging Design', '2025-10-15 22:10:24'),
(374, 8, 'Food Testing Labs', '2025-10-15 22:10:24'),
(375, 9, 'Quantity Surveying', '2025-10-15 22:11:10'),
(376, 9, 'Project Costing', '2025-10-15 22:11:10'),
(377, 9, 'Construction Management', '2025-10-15 22:11:10'),
(378, 9, 'Surveying', '2025-10-15 22:11:10'),
(379, 9, 'Construction Estimation', '2025-10-15 22:11:10'),
(380, 9, 'Site Management', '2025-10-15 22:11:10'),
(381, 9, 'Cost Planning', '2025-10-15 22:11:10'),
(382, 9, 'Contract Administration', '2025-10-15 22:11:10'),
(383, 9, 'Building Materials', '2025-10-15 22:11:10'),
(384, 9, 'Structural Analysis', '2025-10-15 22:11:10'),
(385, 9, 'Project Scheduling', '2025-10-15 22:11:10'),
(386, 9, 'Risk Management', '2025-10-15 22:11:10'),
(387, 9, 'Procurement', '2025-10-15 22:11:10'),
(388, 9, 'Urban Planning', '2025-10-15 22:11:10'),
(389, 9, 'Feasibility Studies', '2025-10-15 22:11:10'),
(390, 9, 'Tendering', '2025-10-15 22:11:10'),
(391, 9, 'Contract Negotiation', '2025-10-15 22:11:10'),
(392, 9, 'Building Codes Compliance', '2025-10-15 22:11:10'),
(393, 9, 'Budget Management', '2025-10-15 22:11:10'),
(394, 9, 'Construction Auditing', '2025-10-15 22:11:10'),
(395, 9, 'Project Monitoring', '2025-10-15 22:11:10'),
(396, 9, 'Client Liaison', '2025-10-15 22:11:10'),
(397, 9, 'Quantity Documentation', '2025-10-15 22:11:10'),
(398, 9, 'Value Engineering', '2025-10-15 22:11:10'),
(399, 9, 'Sustainability Assessment', '2025-10-15 22:11:10'),
(400, 9, 'Construction Technology', '2025-10-15 22:11:10'),
(401, 9, 'Site Surveys', '2025-10-15 22:11:10'),
(402, 9, 'Cost Analysis', '2025-10-15 22:11:10'),
(403, 9, 'Engineering Consultancy', '2025-10-15 22:11:10'),
(404, 9, 'Infrastructure Planning', '2025-10-15 22:11:10'),
(405, 9, 'Material Estimation', '2025-10-15 22:11:10'),
(406, 10, 'Tourism', '2025-10-15 22:11:10'),
(407, 10, 'Hotel Management', '2025-10-15 22:11:10'),
(408, 10, 'Event Management', '2025-10-15 22:11:10'),
(409, 10, 'Travel Agency', '2025-10-15 22:11:10'),
(410, 10, 'Tour Guiding', '2025-10-15 22:11:10'),
(411, 10, 'Event Coordination', '2025-10-15 22:11:10'),
(412, 10, 'Hotel Front Office', '2025-10-15 22:11:10'),
(413, 10, 'Restaurant Management', '2025-10-15 22:11:10'),
(414, 10, 'Catering', '2025-10-15 22:11:10'),
(415, 10, 'Hospitality Marketing', '2025-10-15 22:11:10'),
(416, 10, 'Customer Service', '2025-10-15 22:11:10'),
(417, 10, 'Resort Management', '2025-10-15 22:11:10'),
(418, 10, 'Travel Consultancy', '2025-10-15 22:11:10'),
(419, 10, 'Tour Operations', '2025-10-15 22:11:10'),
(420, 10, 'Tourism Development', '2025-10-15 22:11:10'),
(421, 10, 'Hospitality Training', '2025-10-15 22:11:10'),
(422, 10, 'Convention Management', '2025-10-15 22:11:10'),
(423, 10, 'Recreation Management', '2025-10-15 22:11:10'),
(424, 10, 'Cruise Management', '2025-10-15 22:11:10'),
(425, 10, 'Destination Marketing', '2025-10-15 22:11:10'),
(426, 10, 'Food & Beverage Service', '2025-10-15 22:11:10'),
(427, 10, 'Travel Planning', '2025-10-15 22:11:10'),
(428, 10, 'Sustainable Tourism', '2025-10-15 22:11:10'),
(429, 10, 'Tourism Policy', '2025-10-15 22:11:10'),
(430, 10, 'Hotel Operations', '2025-10-15 22:11:10'),
(431, 10, 'Event Planning & Design', '2025-10-15 22:11:10'),
(432, 10, 'Tourism Research', '2025-10-15 22:11:10'),
(433, 10, 'Hospitality Leadership', '2025-10-15 22:11:10'),
(434, 10, 'Travel Sales & Marketing', '2025-10-15 22:11:10'),
(435, 10, 'Tourism Technology', '2025-10-15 22:11:10'),
(436, 10, 'Eco-Tourism', '2025-10-15 22:11:10'),
(437, 10, 'Tourism Consulting', '2025-10-15 22:11:10'),
(438, 11, 'Civil Engineering', '2025-10-15 22:11:10'),
(439, 11, 'Construction Management', '2025-10-15 22:11:10'),
(440, 11, 'Structural Design', '2025-10-15 22:11:10'),
(441, 11, 'Construction Planning', '2025-10-15 22:11:10'),
(442, 11, 'Site Supervision', '2025-10-15 22:11:10'),
(443, 11, 'Building Materials', '2025-10-15 22:11:10'),
(444, 11, 'Structural Analysis', '2025-10-15 22:11:10'),
(445, 11, 'Urban Planning', '2025-10-15 22:11:10'),
(446, 11, 'Project Management', '2025-10-15 22:11:10'),
(447, 11, 'Surveying', '2025-10-15 22:11:10'),
(448, 11, 'Quantity Estimation', '2025-10-15 22:11:10'),
(449, 11, 'Contract Administration', '2025-10-15 22:11:10'),
(450, 11, 'HVAC Design', '2025-10-15 22:11:10'),
(451, 11, 'Sustainability', '2025-10-15 22:11:10'),
(452, 11, 'Safety Engineering', '2025-10-15 22:11:10'),
(453, 11, 'Road & Bridge Construction', '2025-10-15 22:11:10'),
(454, 11, 'Building Codes Compliance', '2025-10-15 22:11:10'),
(455, 11, 'Infrastructure Design', '2025-10-15 22:11:10'),
(456, 11, 'Geotechnical Engineering', '2025-10-15 22:11:10'),
(457, 11, 'Construction Auditing', '2025-10-15 22:11:10'),
(458, 11, 'Design Review', '2025-10-15 22:11:10'),
(459, 11, 'Project Scheduling', '2025-10-15 22:11:10'),
(460, 11, 'Construction Supervision', '2025-10-15 22:11:10'),
(461, 11, 'Material Testing', '2025-10-15 22:11:10'),
(462, 11, 'Structural Modelling', '2025-10-15 22:11:10'),
(463, 11, 'Cost Planning', '2025-10-15 22:11:10'),
(464, 11, 'Engineering Consultancy', '2025-10-15 22:11:10'),
(465, 11, 'Construction Innovation', '2025-10-15 22:11:10'),
(466, 11, 'Urban Development', '2025-10-15 22:11:10'),
(467, 11, 'Environmental Assessment', '2025-10-15 22:11:10'),
(468, 11, 'Civil Drafting', '2025-10-15 22:11:10'),
(469, 11, 'Survey Coordination', '2025-10-15 22:11:10'),
(470, 11, 'Facility Management', '2025-10-15 22:11:10'),
(471, 12, 'Finance', '2025-10-15 22:11:10'),
(472, 12, 'Business Analysis', '2025-10-15 22:11:10'),
(473, 12, 'Accounting', '2025-10-15 22:11:10'),
(474, 12, 'Financial Planning', '2025-10-15 22:11:10'),
(475, 12, 'Banking', '2025-10-15 22:11:10'),
(476, 12, 'Risk Management', '2025-10-15 22:11:10'),
(477, 12, 'Corporate Finance', '2025-10-15 22:11:10'),
(478, 12, 'Tax Advisory', '2025-10-15 22:11:10'),
(479, 12, 'Investment Management', '2025-10-15 22:11:10'),
(480, 12, 'Audit', '2025-10-15 22:11:10'),
(481, 12, 'Budgeting', '2025-10-15 22:11:10'),
(482, 12, 'Financial Reporting', '2025-10-15 22:11:10'),
(483, 12, 'Wealth Management', '2025-10-15 22:11:10'),
(484, 12, 'Credit Analysis', '2025-10-15 22:11:10'),
(485, 12, 'Payroll Management', '2025-10-15 22:11:10'),
(486, 12, 'Portfolio Management', '2025-10-15 22:11:10'),
(487, 12, 'Financial Modelling', '2025-10-15 22:11:10'),
(488, 12, 'Corporate Treasury', '2025-10-15 22:11:10'),
(489, 12, 'Cost Control', '2025-10-15 22:11:10'),
(490, 12, 'Insurance', '2025-10-15 22:11:10'),
(491, 12, 'Compliance & Governance', '2025-10-15 22:11:10'),
(492, 12, 'Investment Banking', '2025-10-15 22:11:10'),
(493, 12, 'Financial Consulting', '2025-10-15 22:11:10'),
(494, 12, 'Internal Audit', '2025-10-15 22:11:10'),
(495, 12, 'Accounting Software Management', '2025-10-15 22:11:10'),
(496, 12, 'Bank Reconciliation', '2025-10-15 22:11:10'),
(497, 12, 'Credit Risk Assessment', '2025-10-15 22:11:10'),
(498, 12, 'Financial Operations', '2025-10-15 22:11:10'),
(499, 12, 'Economic Analysis', '2025-10-15 22:11:10'),
(500, 12, 'Business Valuation', '2025-10-15 22:11:10'),
(501, 12, 'Mergers & Acquisitions', '2025-10-15 22:11:10'),
(502, 12, 'Fund Management', '2025-10-15 22:11:10'),
(503, 13, 'Electrical Engineering', '2025-10-15 22:11:10'),
(504, 13, 'Mechanical Engineering', '2025-10-15 22:11:10'),
(505, 13, 'Project Management', '2025-10-15 22:11:10'),
(506, 13, 'Electronics Engineering', '2025-10-15 22:11:10'),
(507, 13, 'Instrumentation', '2025-10-15 22:11:10'),
(508, 13, 'Control Systems', '2025-10-15 22:11:10'),
(509, 13, 'Renewable Energy', '2025-10-15 22:11:10'),
(510, 13, 'Automation', '2025-10-15 22:11:10'),
(511, 13, 'Robotics', '2025-10-15 22:11:10'),
(512, 13, 'HVAC Systems', '2025-10-15 22:11:10'),
(513, 13, 'Energy Management', '2025-10-15 22:11:10'),
(514, 13, 'Power Systems', '2025-10-15 22:11:10'),
(515, 13, 'Industrial Engineering', '2025-10-15 22:11:10'),
(516, 13, 'Design Engineering', '2025-10-15 22:11:10'),
(517, 13, 'Maintenance Engineering', '2025-10-15 22:11:10'),
(518, 13, 'Electrical Design', '2025-10-15 22:11:10'),
(519, 13, 'Circuit Analysis', '2025-10-15 22:11:10'),
(520, 13, 'PLC Programming', '2025-10-15 22:11:10'),
(521, 13, 'Embedded Systems', '2025-10-15 22:11:10'),
(522, 13, 'Mechatronics', '2025-10-15 22:11:10'),
(523, 13, 'Power Distribution', '2025-10-15 22:11:10'),
(524, 13, 'Energy Auditing', '2025-10-15 22:11:10'),
(525, 13, 'Instrumentation Control', '2025-10-15 22:11:10'),
(526, 13, 'Signal Processing', '2025-10-15 22:11:10'),
(527, 13, 'Electronics Testing', '2025-10-15 22:11:10'),
(528, 13, 'Electrical Safety Compliance', '2025-10-15 22:11:10'),
(529, 13, 'Automation Systems Design', '2025-10-15 22:11:10'),
(530, 13, 'Control Panel Design', '2025-10-15 22:11:10'),
(531, 13, 'Electrical Project Supervision', '2025-10-15 22:11:10'),
(532, 13, 'Renewable Systems Installation', '2025-10-15 22:11:10'),
(533, 13, 'Industrial Automation Implementation', '2025-10-15 22:11:10'),
(534, 13, 'Power Grid Management', '2025-10-15 22:11:10'),
(535, 13, 'Smart Systems Development', '2025-10-15 22:11:10'),
(536, 13, 'Electrical Maintenance Planning', '2025-10-15 22:11:10'),
(537, 13, 'Electrical System Design', '2025-10-15 22:11:10'),
(538, 1, 'Mechanical Engineering', '2025-10-15 22:11:41'),
(539, 1, 'Design Engineering', '2025-10-15 22:11:41'),
(540, 1, 'Project Management', '2025-10-15 22:11:41'),
(541, 1, 'Manufacturing', '2025-10-15 22:11:41'),
(542, 1, 'Automotive Engineering', '2025-10-15 22:11:41'),
(543, 1, 'Maintenance Engineering', '2025-10-15 22:11:41'),
(544, 1, 'Robotics', '2025-10-15 22:11:41'),
(545, 1, 'CAD Design', '2025-10-15 22:11:41'),
(546, 1, 'Industrial Engineering', '2025-10-15 22:11:41'),
(547, 1, 'HVAC Engineering', '2025-10-15 22:11:41'),
(548, 1, 'Mechatronics', '2025-10-15 22:11:41'),
(549, 1, 'Process Engineering', '2025-10-15 22:11:41'),
(550, 1, 'Quality Assurance', '2025-10-15 22:11:41'),
(551, 1, 'Production Planning', '2025-10-15 22:11:41'),
(552, 1, 'Tooling & Die', '2025-10-15 22:11:41'),
(553, 1, 'Materials Science', '2025-10-15 22:11:41'),
(554, 1, 'Thermodynamics', '2025-10-15 22:11:41'),
(555, 1, 'Hydraulics', '2025-10-15 22:11:41'),
(556, 1, 'Pneumatics', '2025-10-15 22:11:41'),
(557, 1, 'Energy Systems', '2025-10-15 22:11:41'),
(558, 1, 'Industrial Automation', '2025-10-15 22:11:41'),
(559, 1, 'Engineering Consultancy', '2025-10-15 22:11:41'),
(560, 1, 'Research & Development', '2025-10-15 22:11:41'),
(561, 1, 'Supply Chain Engineering', '2025-10-15 22:11:41'),
(562, 1, 'Plant Design', '2025-10-15 22:11:41'),
(563, 1, 'Maintenance Planning', '2025-10-15 22:11:41'),
(564, 1, 'Industrial Safety', '2025-10-15 22:11:41'),
(565, 1, 'Testing & Commissioning', '2025-10-15 22:11:41'),
(566, 1, 'Mechanical Drafting', '2025-10-15 22:11:41'),
(567, 1, 'Additive Manufacturing', '2025-10-15 22:11:41'),
(568, 1, 'Mechatronics Design', '2025-10-15 22:11:41'),
(569, 1, 'Industrial Robotics', '2025-10-15 22:11:41'),
(570, 1, 'Fluid Mechanics', '2025-10-15 22:11:41'),
(571, 1, 'Thermal Systems', '2025-10-15 22:11:41'),
(572, 1, 'Automated Production Systems', '2025-10-15 22:11:41'),
(573, 1, 'Manufacturing Process Design', '2025-10-15 22:11:41'),
(574, 1, 'Mechanical Simulation', '2025-10-15 22:11:41'),
(575, 1, 'Product Lifecycle Management', '2025-10-15 22:11:41'),
(576, 1, 'Design for Manufacturing', '2025-10-15 22:11:41'),
(577, 1, 'Precision Engineering', '2025-10-15 22:11:41'),
(578, 1, 'Maintenance Engineering Planning', '2025-10-15 22:11:41'),
(579, 1, 'Industrial Equipment Design', '2025-10-15 22:11:41'),
(580, 1, 'HVAC System Design', '2025-10-15 22:11:41'),
(581, 1, 'Materials Testing', '2025-10-15 22:11:41'),
(582, 1, 'Mechanical Component Analysis', '2025-10-15 22:11:41'),
(583, 1, 'Mechanical Project Planning', '2025-10-15 22:11:41'),
(584, 1, 'Sustainable Mechanical Systems', '2025-10-15 22:11:41'),
(585, 1, 'Industrial Equipment Maintenance', '2025-10-15 22:11:41'),
(586, 1, 'Mechanical CAD Drafting', '2025-10-15 22:11:41'),
(587, 1, 'Mechanical Innovation', '2025-10-15 22:11:41'),
(588, 1, 'Process Optimization', '2025-10-15 22:11:41'),
(589, 2, 'Teaching', '2025-10-15 22:11:41'),
(590, 2, 'Content Writing', '2025-10-15 22:11:41'),
(591, 2, 'Editing', '2025-10-15 22:11:41'),
(592, 2, 'Translation', '2025-10-15 22:11:41'),
(593, 2, 'Journalism', '2025-10-15 22:11:41'),
(594, 2, 'Public Relations', '2025-10-15 22:11:41'),
(595, 2, 'Copywriting', '2025-10-15 22:11:41'),
(596, 2, 'Proofreading', '2025-10-15 22:11:41'),
(597, 2, 'Technical Writing', '2025-10-15 22:11:41'),
(598, 2, 'Creative Writing', '2025-10-15 22:11:41'),
(599, 2, 'Digital Content', '2025-10-15 22:11:41'),
(600, 2, 'Media Coordination', '2025-10-15 22:11:41'),
(601, 2, 'Language Coaching', '2025-10-15 22:11:41'),
(602, 2, 'Publishing', '2025-10-15 22:11:41'),
(603, 2, 'Communications', '2025-10-15 22:11:41'),
(604, 2, 'Speech Writing', '2025-10-15 22:11:41'),
(605, 2, 'Social Media Management', '2025-10-15 22:11:41'),
(606, 2, 'Academic Writing', '2025-10-15 22:11:41'),
(607, 2, 'Marketing Communications', '2025-10-15 22:11:41'),
(608, 2, 'Corporate Communications', '2025-10-15 22:11:41'),
(609, 2, 'Content Strategy', '2025-10-15 22:11:41'),
(610, 2, 'SEO Writing', '2025-10-15 22:11:41'),
(611, 2, 'Literary Analysis', '2025-10-15 22:11:41'),
(612, 2, 'Editing & Publishing', '2025-10-15 22:11:41'),
(613, 2, 'Teaching English as a Second Language', '2025-10-15 22:11:41'),
(614, 2, 'Creative Direction', '2025-10-15 22:11:41'),
(615, 2, 'Script Writing', '2025-10-15 22:11:41'),
(616, 2, 'Copy Editing', '2025-10-15 22:11:41'),
(617, 2, 'Media Production', '2025-10-15 22:11:41'),
(618, 2, 'Online Content Management', '2025-10-15 22:11:41'),
(619, 2, 'Proofreading & Quality Control', '2025-10-15 22:11:41'),
(620, 2, 'Professional Writing', '2025-10-15 22:11:41'),
(621, 2, 'Content Marketing', '2025-10-15 22:11:41'),
(622, 2, 'Technical Documentation', '2025-10-15 22:11:41'),
(623, 2, 'Communication Training', '2025-10-15 22:11:41'),
(624, 2, 'Journalistic Editing', '2025-10-15 22:11:41'),
(625, 2, 'Multimedia Content', '2025-10-15 22:11:41'),
(626, 2, 'Publishing Consultancy', '2025-10-15 22:11:41'),
(627, 2, 'E-Learning Content Development', '2025-10-15 22:11:41'),
(628, 2, 'Digital Media Strategy', '2025-10-15 22:11:41'),
(629, 2, 'Speech Coaching', '2025-10-15 22:11:41'),
(630, 2, 'Corporate Storytelling', '2025-10-15 22:11:41'),
(631, 2, 'Press Release Writing', '2025-10-15 22:11:41'),
(632, 2, 'Script Development', '2025-10-15 22:11:41'),
(633, 2, 'Translation Services', '2025-10-15 22:11:41'),
(634, 2, 'Online Publishing', '2025-10-15 22:11:41'),
(635, 2, 'Copy Strategy', '2025-10-15 22:11:41'),
(636, 2, 'Editorial Management', '2025-10-15 22:11:41'),
(637, 2, 'Educational Content Creation', '2025-10-15 22:11:41'),
(638, 6, 'Software Engineering', '2025-10-15 22:11:41'),
(639, 6, 'Network Engineering', '2025-10-15 22:11:41'),
(640, 6, 'Cyber Security', '2025-10-15 22:11:41'),
(641, 6, 'Education', '2025-10-15 22:11:41'),
(642, 6, 'Data Science', '2025-10-15 22:11:41'),
(643, 6, 'Artificial Intelligence', '2025-10-15 22:11:41'),
(644, 6, 'Machine Learning', '2025-10-15 22:11:41'),
(645, 6, 'Blockchain Technology', '2025-10-15 22:11:41'),
(646, 6, 'Cloud Computing', '2025-10-15 22:11:41'),
(647, 6, 'DevOps', '2025-10-15 22:11:41'),
(648, 6, 'Mobile Development', '2025-10-15 22:11:41'),
(649, 6, 'Web Development', '2025-10-15 22:11:41'),
(650, 6, 'Game Development', '2025-10-15 22:11:41'),
(651, 6, 'UI/UX Design', '2025-10-15 22:11:41'),
(652, 6, 'Digital Marketing', '2025-10-15 22:11:41'),
(653, 6, 'Product Management', '2025-10-15 22:11:41'),
(654, 6, 'Business Analysis', '2025-10-15 22:11:41'),
(655, 6, 'Cybersecurity Research', '2025-10-15 22:11:41'),
(656, 6, 'System Administration', '2025-10-15 22:11:41'),
(657, 6, 'Data Engineering', '2025-10-15 22:11:41'),
(658, 6, 'IT Support', '2025-10-15 22:11:41'),
(659, 6, 'Systems Development', '2025-10-15 22:11:41'),
(660, 6, 'Database Administration', '2025-10-15 22:11:41'),
(661, 6, 'Software Testing', '2025-10-15 22:11:41'),
(662, 6, 'IT Consulting', '2025-10-15 22:11:41'),
(663, 6, 'Network Security', '2025-10-15 22:11:41'),
(664, 6, 'Cloud Architecture', '2025-10-15 22:11:41'),
(665, 6, 'Big Data Analytics', '2025-10-15 22:11:41'),
(666, 6, 'AI Engineering', '2025-10-15 22:11:41'),
(667, 6, 'Machine Learning Operations', '2025-10-15 22:11:41'),
(668, 6, 'Mobile App Development', '2025-10-15 22:11:41'),
(669, 6, 'Web Application Development', '2025-10-15 22:11:41'),
(670, 6, 'DevOps Engineering', '2025-10-15 22:11:41'),
(671, 6, 'Software Project Management', '2025-10-15 22:11:41'),
(672, 6, 'IT Strategy', '2025-10-15 22:11:41'),
(673, 6, 'Server Administration', '2025-10-15 22:11:41'),
(674, 6, 'IT Research & Development', '2025-10-15 22:11:41'),
(675, 6, 'Virtualization Technology', '2025-10-15 22:11:41'),
(676, 6, 'Computer Networking', '2025-10-15 22:11:41'),
(677, 6, 'IT Compliance', '2025-10-15 22:11:41'),
(678, 6, 'Tech Support Services', '2025-10-15 22:11:41'),
(679, 6, 'IT Infrastructure', '2025-10-15 22:11:41'),
(680, 6, 'Database Design', '2025-10-15 22:11:41'),
(681, 6, 'ERP Implementation', '2025-10-15 22:11:41'),
(682, 6, 'Software Architecture', '2025-10-15 22:11:41'),
(683, 6, 'Application Security', '2025-10-15 22:11:41'),
(684, 6, 'Cloud Security', '2025-10-15 22:11:41'),
(685, 6, 'Business Intelligence Solutions', '2025-10-15 22:11:41'),
(686, 6, 'AI Model Deployment', '2025-10-15 22:11:41'),
(687, 6, 'Digital Transformation Projects', '2025-10-15 22:11:41'),
(688, 6, 'IT Governance', '2025-10-15 22:11:41'),
(689, 6, 'System Integration', '2025-10-15 22:11:41'),
(690, 6, 'IT Operations Management', '2025-10-15 22:11:41'),
(691, 7, 'Business Administration', '2025-10-15 22:12:27'),
(692, 7, 'Marketing', '2025-10-15 22:12:27'),
(693, 7, 'Operations', '2025-10-15 22:12:27'),
(694, 7, 'Logistics', '2025-10-15 22:12:27'),
(695, 7, 'Procurement', '2025-10-15 22:12:27'),
(696, 7, 'Customer Relations', '2025-10-15 22:12:27'),
(697, 7, 'Office Administration', '2025-10-15 22:12:27'),
(698, 7, 'Business Development', '2025-10-15 22:12:27'),
(699, 7, 'Strategic Management', '2025-10-15 22:12:27'),
(700, 7, 'Project Management', '2025-10-15 22:12:27'),
(701, 7, 'Entrepreneurship', '2025-10-15 22:12:27'),
(702, 7, 'Sales Management', '2025-10-15 22:12:27'),
(703, 7, 'Supply Chain Management', '2025-10-15 22:12:27'),
(704, 7, 'Team Leadership', '2025-10-15 22:12:27'),
(705, 7, 'Event Management', '2025-10-15 22:12:27'),
(706, 7, 'Market Research', '2025-10-15 22:12:27'),
(707, 7, 'Advertising', '2025-10-15 22:12:27'),
(708, 7, 'Retail Management', '2025-10-15 22:12:27'),
(709, 7, 'Corporate Planning', '2025-10-15 22:12:27'),
(710, 7, 'Digital Marketing', '2025-10-15 22:12:27'),
(711, 7, 'Brand Management', '2025-10-15 22:12:27'),
(712, 7, 'E-commerce Management', '2025-10-15 22:12:27'),
(713, 7, 'Business Consulting', '2025-10-15 22:12:27'),
(714, 7, 'Negotiation Skills', '2025-10-15 22:12:27'),
(715, 7, 'Performance Monitoring', '2025-10-15 22:12:27'),
(716, 7, 'Product Management', '2025-10-15 22:12:27'),
(717, 7, 'Customer Experience', '2025-10-15 22:12:27'),
(718, 7, 'Innovation Management', '2025-10-15 22:12:27'),
(719, 7, 'CRM Implementation', '2025-10-15 22:12:27'),
(720, 7, 'International Business', '2025-10-15 22:12:27'),
(721, 7, 'Operations Strategy', '2025-10-15 22:12:27'),
(722, 7, 'Change Management', '2025-10-15 22:12:27'),
(723, 7, 'Financial Management', '2025-10-15 22:12:27'),
(724, 7, 'Human Resource Planning', '2025-10-15 22:12:27'),
(725, 7, 'Corporate Communications', '2025-10-15 22:12:27'),
(726, 7, 'Business Intelligence', '2025-10-15 22:12:27'),
(727, 7, 'Supply Chain Analytics', '2025-10-15 22:12:27'),
(728, 7, 'Leadership Development', '2025-10-15 22:12:27'),
(729, 7, 'Procurement Strategy', '2025-10-15 22:12:27'),
(730, 7, 'Process Improvement', '2025-10-15 22:12:27'),
(731, 7, 'Team Development', '2025-10-15 22:12:27'),
(732, 7, 'Customer Service Excellence', '2025-10-15 22:12:27'),
(733, 7, 'Retail Strategy', '2025-10-15 22:12:27'),
(734, 7, 'Event Planning & Coordination', '2025-10-15 22:12:27'),
(735, 7, 'Market Analytics', '2025-10-15 22:12:27'),
(736, 7, 'Corporate Governance', '2025-10-15 22:12:27'),
(737, 7, 'Strategic Partnerships', '2025-10-15 22:12:27'),
(738, 7, 'Business Policy Development', '2025-10-15 22:12:27'),
(739, 7, 'Sales Strategy', '2025-10-15 22:12:27'),
(740, 7, 'Brand Strategy', '2025-10-15 22:12:27'),
(741, 8, 'Food Technology', '2025-10-15 22:12:27'),
(742, 8, 'Food Safety', '2025-10-15 22:12:27'),
(743, 8, 'Nutrition', '2025-10-15 22:12:27'),
(744, 8, 'Food Packaging', '2025-10-15 22:12:27'),
(745, 8, 'Quality Control', '2025-10-15 22:12:27'),
(746, 8, 'Food Processing', '2025-10-15 22:12:27'),
(747, 8, 'Beverage Technology', '2025-10-15 22:12:27'),
(748, 8, 'Nutrition Consulting', '2025-10-15 22:12:27'),
(749, 8, 'Food R&D', '2025-10-15 22:12:27'),
(750, 8, 'HACCP Compliance', '2025-10-15 22:12:27'),
(751, 8, 'Culinary Management', '2025-10-15 22:12:27'),
(752, 8, 'Dietary Planning', '2025-10-15 22:12:27'),
(753, 8, 'Food Innovation', '2025-10-15 22:12:27'),
(754, 8, 'Food Supply Chain', '2025-10-15 22:12:27'),
(755, 8, 'Agro Food Technology', '2025-10-15 22:12:27'),
(756, 8, 'Sensory Analysis', '2025-10-15 22:12:27'),
(757, 8, 'Food Preservation', '2025-10-15 22:12:27'),
(758, 8, 'Food Biotechnology', '2025-10-15 22:12:27'),
(759, 8, 'Recipe Development', '2025-10-15 22:12:27'),
(760, 8, 'Food Safety Auditing', '2025-10-15 22:12:27'),
(761, 8, 'Nutritional Analysis', '2025-10-15 22:12:27'),
(762, 8, 'Food Quality Assurance', '2025-10-15 22:12:27'),
(763, 8, 'Product Development', '2025-10-15 22:12:27'),
(764, 8, 'Food Production Management', '2025-10-15 22:12:27'),
(765, 8, 'Food Regulations Compliance', '2025-10-15 22:12:27'),
(766, 8, 'Food Industry Consulting', '2025-10-15 22:12:27'),
(767, 8, 'Food Process Engineering', '2025-10-15 22:12:27'),
(768, 8, 'Beverage Production', '2025-10-15 22:12:27'),
(769, 8, 'Food Packaging Design', '2025-10-15 22:12:27'),
(770, 8, 'Food Testing Labs', '2025-10-15 22:12:27'),
(771, 8, 'Food Marketing', '2025-10-15 22:12:27'),
(772, 8, 'Food Supply Management', '2025-10-15 22:12:27'),
(773, 8, 'Restaurant Management', '2025-10-15 22:12:27'),
(774, 8, 'Dietary Consulting', '2025-10-15 22:12:27'),
(775, 8, 'Culinary Innovation', '2025-10-15 22:12:27'),
(776, 8, 'Food Entrepreneurship', '2025-10-15 22:12:27'),
(777, 8, 'Food Product Design', '2025-10-15 22:12:27'),
(778, 8, 'Food Analytics', '2025-10-15 22:12:27'),
(779, 8, 'Food Safety Training', '2025-10-15 22:12:27'),
(780, 8, 'Sustainable Food Systems', '2025-10-15 22:12:27'),
(781, 8, 'Nutrition Policy', '2025-10-15 22:12:27'),
(782, 8, 'Food Regulatory Affairs', '2025-10-15 22:12:27'),
(783, 8, 'Food Technology Consultancy', '2025-10-15 22:12:27'),
(784, 8, 'Quality Auditing', '2025-10-15 22:12:27'),
(785, 8, 'Food Processing Equipment', '2025-10-15 22:12:27'),
(786, 8, 'Food Industry Research', '2025-10-15 22:12:27'),
(787, 8, 'Food Science Education', '2025-10-15 22:12:27'),
(788, 9, 'Quantity Surveying', '2025-10-15 22:12:27'),
(789, 9, 'Project Costing', '2025-10-15 22:12:27'),
(790, 9, 'Construction Management', '2025-10-15 22:12:27'),
(791, 9, 'Surveying', '2025-10-15 22:12:27'),
(792, 9, 'Construction Estimation', '2025-10-15 22:12:27'),
(793, 9, 'Site Management', '2025-10-15 22:12:27'),
(794, 9, 'Cost Planning', '2025-10-15 22:12:27'),
(795, 9, 'Contract Administration', '2025-10-15 22:12:27'),
(796, 9, 'Building Materials', '2025-10-15 22:12:27'),
(797, 9, 'Structural Analysis', '2025-10-15 22:12:27'),
(798, 9, 'Project Scheduling', '2025-10-15 22:12:27'),
(799, 9, 'Risk Management', '2025-10-15 22:12:27'),
(800, 9, 'Procurement', '2025-10-15 22:12:27'),
(801, 9, 'Urban Planning', '2025-10-15 22:12:27'),
(802, 9, 'Feasibility Studies', '2025-10-15 22:12:27'),
(803, 9, 'Tendering', '2025-10-15 22:12:27'),
(804, 9, 'Contract Negotiation', '2025-10-15 22:12:27'),
(805, 9, 'Building Codes Compliance', '2025-10-15 22:12:27'),
(806, 9, 'Budget Management', '2025-10-15 22:12:27'),
(807, 9, 'Construction Auditing', '2025-10-15 22:12:27'),
(808, 9, 'Project Monitoring', '2025-10-15 22:12:27'),
(809, 9, 'Client Liaison', '2025-10-15 22:12:27'),
(810, 9, 'Quantity Documentation', '2025-10-15 22:12:27'),
(811, 9, 'Value Engineering', '2025-10-15 22:12:27'),
(812, 9, 'Sustainability Assessment', '2025-10-15 22:12:27'),
(813, 9, 'Construction Technology', '2025-10-15 22:12:27'),
(814, 9, 'Site Surveys', '2025-10-15 22:12:27'),
(815, 9, 'Cost Analysis', '2025-10-15 22:12:27'),
(816, 9, 'Engineering Consultancy', '2025-10-15 22:12:27'),
(817, 9, 'Infrastructure Planning', '2025-10-15 22:12:27'),
(818, 9, 'Construction Innovation', '2025-10-15 22:12:27'),
(819, 9, 'Contract Risk Management', '2025-10-15 22:12:27'),
(820, 9, 'BIM Coordination', '2025-10-15 22:12:27'),
(821, 9, 'Construction Scheduling', '2025-10-15 22:12:27'),
(822, 9, 'Project Cost Control', '2025-10-15 22:12:27'),
(823, 9, 'Construction Procurement', '2025-10-15 22:12:27'),
(824, 9, 'Contract Law Compliance', '2025-10-15 22:12:27'),
(825, 9, 'Building Surveying', '2025-10-15 22:12:27'),
(826, 9, 'Construction Estimating Software', '2025-10-15 22:12:27'),
(827, 9, 'Quantity Reporting', '2025-10-15 22:12:27'),
(828, 9, 'Construction Planning Analysis', '2025-10-15 22:12:27'),
(829, 9, 'Project Budgeting', '2025-10-15 22:12:27'),
(830, 9, 'Tender Documentation', '2025-10-15 22:12:27'),
(831, 9, 'Cost Risk Assessment', '2025-10-15 22:12:27'),
(832, 9, 'Project Valuation', '2025-10-15 22:12:27'),
(833, 9, 'Construction Operations Management', '2025-10-15 22:12:27'),
(834, 9, 'Contract Strategy Development', '2025-10-15 22:12:27'),
(835, 9, 'Construction Research', '2025-10-15 22:12:27'),
(836, 1, 'Automotive Design', '2025-10-15 22:13:21'),
(837, 1, 'Aerospace Engineering', '2025-10-15 22:13:21'),
(838, 1, 'Marine Engineering', '2025-10-15 22:13:21'),
(839, 1, 'Industrial Safety Engineering', '2025-10-15 22:13:21'),
(840, 1, 'Mechanical Quality Assurance', '2025-10-15 22:13:21'),
(841, 1, 'Mechanical Project Coordination', '2025-10-15 22:13:21'),
(842, 1, 'Thermal Engineering', '2025-10-15 22:13:21'),
(843, 1, 'Hydraulic Systems Design', '2025-10-15 22:13:21'),
(844, 1, 'Pneumatic Systems Design', '2025-10-15 22:13:21'),
(845, 1, 'Mechanical Simulation & Analysis', '2025-10-15 22:13:21'),
(846, 1, 'CAD/CAM Programming', '2025-10-15 22:13:21'),
(847, 1, 'Additive Manufacturing Design', '2025-10-15 22:13:21'),
(848, 1, 'Process Optimization Engineering', '2025-10-15 22:13:21'),
(849, 1, 'Mechanical Systems Integration', '2025-10-15 22:13:21'),
(850, 1, 'Energy Systems Design', '2025-10-15 22:13:21'),
(851, 1, 'Plant Engineering', '2025-10-15 22:13:21'),
(852, 1, 'Industrial Equipment Design & Testing', '2025-10-15 22:13:21'),
(853, 1, 'Mechatronic System Integration', '2025-10-15 22:13:21'),
(854, 1, 'Mechanical Product Innovation', '2025-10-15 22:13:21'),
(855, 1, 'Mechanical Maintenance & Reliability', '2025-10-15 22:13:21'),
(856, 2, 'Academic Editing', '2025-10-15 22:13:21'),
(857, 2, 'Language Assessment', '2025-10-15 22:13:21'),
(858, 2, 'Creative Direction in Media', '2025-10-15 22:13:21'),
(859, 2, 'Speech & Debate Coaching', '2025-10-15 22:13:21'),
(860, 2, 'Translation Project Management', '2025-10-15 22:13:21'),
(861, 2, 'Media Content Strategy', '2025-10-15 22:13:21'),
(862, 2, 'Technical Documentation Specialist', '2025-10-15 22:13:21'),
(863, 2, 'E-learning Content Authoring', '2025-10-15 22:13:21'),
(864, 2, 'Social Media Content Analysis', '2025-10-15 22:13:21'),
(865, 2, 'Corporate Writing Consultancy', '2025-10-15 22:13:21'),
(866, 2, 'Publishing Project Management', '2025-10-15 22:13:21'),
(867, 2, 'Literary Content Development', '2025-10-15 22:13:21'),
(868, 2, 'Proofreading & Style Compliance', '2025-10-15 22:13:21'),
(869, 2, 'Language Teaching Technology', '2025-10-15 22:13:21'),
(870, 2, 'Storytelling & Brand Narrative', '2025-10-15 22:13:21'),
(871, 2, 'Journalism Research Analysis', '2025-10-15 22:13:21'),
(872, 2, 'Communication Skills Training', '2025-10-15 22:13:21'),
(873, 2, 'Multilingual Content Management', '2025-10-15 22:13:21'),
(874, 2, 'Content Localization', '2025-10-15 22:13:21'),
(875, 2, 'Online Education Material Design', '2025-10-15 22:13:21'),
(876, 6, 'IoT Development', '2025-10-15 22:13:21'),
(877, 6, 'Artificial Intelligence Research', '2025-10-15 22:13:21'),
(878, 6, 'Cybersecurity Penetration Testing', '2025-10-15 22:13:21'),
(879, 6, 'Cloud Solutions Architecture', '2025-10-15 22:13:21'),
(880, 6, 'Big Data Strategy', '2025-10-15 22:13:21'),
(881, 6, 'AI & ML Model Optimization', '2025-10-15 22:13:21'),
(882, 6, 'Mobile Game Development', '2025-10-15 22:13:21'),
(883, 6, 'Web Frontend/Backend Engineering', '2025-10-15 22:13:21'),
(884, 6, 'UI/UX Prototyping', '2025-10-15 22:13:21'),
(885, 6, 'Digital Product Strategy', '2025-10-15 22:13:21'),
(886, 6, 'IT Service Management', '2025-10-15 22:13:21'),
(887, 6, 'IT Infrastructure Strategy', '2025-10-15 22:13:21'),
(888, 6, 'Database Performance Tuning', '2025-10-15 22:13:21'),
(889, 6, 'Enterprise Software Development', '2025-10-15 22:13:21'),
(890, 6, 'ERP & CRM Systems Management', '2025-10-15 22:13:21'),
(891, 6, 'IT Security Compliance', '2025-10-15 22:13:21'),
(892, 6, 'Software DevOps Automation', '2025-10-15 22:13:21'),
(893, 6, 'Virtualization & Cloud Migration', '2025-10-15 22:13:21'),
(894, 6, 'IT Innovation Management', '2025-10-15 22:13:21'),
(895, 6, 'Data Analytics & Visualization', '2025-10-15 22:13:21'),
(896, 6, 'AI Model Deployment & Maintenance', '2025-10-15 22:13:21'),
(897, 6, 'Network Architecture Design', '2025-10-15 22:13:21'),
(898, 6, 'Cloud Security Operations', '2025-10-15 22:13:21'),
(899, 6, 'IT Operations Leadership', '2025-10-15 22:13:21'),
(900, 6, 'Application Lifecycle Management', '2025-10-15 22:13:21'),
(901, 6, 'IT Risk Management', '2025-10-15 22:13:21'),
(902, 6, 'Emerging Tech Research', '2025-10-15 22:13:21'),
(903, 6, 'Robotics Software Development', '2025-10-15 22:13:21'),
(904, 6, 'IT Governance & Policy', '2025-10-15 22:13:21'),
(905, 4, 'Management', '2025-10-15 22:14:11'),
(906, 4, 'Business Administration', '2025-10-15 22:14:11'),
(907, 4, 'HR Management', '2025-10-15 22:14:11'),
(908, 4, 'Operations Management', '2025-10-15 22:14:11'),
(909, 4, 'Strategic Planning', '2025-10-15 22:14:11'),
(910, 4, 'Leadership Development', '2025-10-15 22:14:11'),
(911, 4, 'Corporate Governance', '2025-10-15 22:14:11'),
(912, 4, 'Performance Management', '2025-10-15 22:14:11'),
(913, 4, 'Change Management', '2025-10-15 22:14:11'),
(914, 4, 'Project Management', '2025-10-15 22:14:11'),
(915, 4, 'Business Consulting', '2025-10-15 22:14:11'),
(916, 4, 'Team Leadership', '2025-10-15 22:14:11'),
(917, 4, 'Organizational Development', '2025-10-15 22:14:11'),
(918, 4, 'Risk Management', '2025-10-15 22:14:11'),
(919, 4, 'Business Process Improvement', '2025-10-15 22:14:11'),
(920, 4, 'Innovation Management', '2025-10-15 22:14:11'),
(921, 4, 'Corporate Strategy', '2025-10-15 22:14:11'),
(922, 4, 'Resource Management', '2025-10-15 22:14:11'),
(923, 4, 'Quality Management', '2025-10-15 22:14:11'),
(924, 4, 'Decision Making', '2025-10-15 22:14:11'),
(925, 4, 'Business Policy', '2025-10-15 22:14:11'),
(926, 4, 'Process Optimization', '2025-10-15 22:14:11'),
(927, 4, 'Customer Relationship Management', '2025-10-15 22:14:11'),
(928, 4, 'Operational Strategy', '2025-10-15 22:14:11'),
(929, 4, 'Workforce Planning', '2025-10-15 22:14:11'),
(930, 4, 'Management Analytics', '2025-10-15 22:14:11'),
(931, 4, 'Organizational Leadership', '2025-10-15 22:14:11'),
(932, 4, 'Performance Monitoring', '2025-10-15 22:14:11');
INSERT INTO `hnd_course_categories` (`id`, `course_id`, `category_name`, `created_datetime`) VALUES
(933, 4, 'Training & Development', '2025-10-15 22:14:11'),
(934, 4, 'Corporate Communication', '2025-10-15 22:14:11'),
(935, 4, 'Change Leadership', '2025-10-15 22:14:11'),
(936, 4, 'Business Intelligence', '2025-10-15 22:14:11'),
(937, 4, 'Compliance Management', '2025-10-15 22:14:11'),
(938, 4, 'Sustainability Management', '2025-10-15 22:14:11'),
(939, 4, 'Project Risk Assessment', '2025-10-15 22:14:11'),
(940, 4, 'Business Development Strategy', '2025-10-15 22:14:11'),
(941, 4, 'Team Motivation', '2025-10-15 22:14:11'),
(942, 4, 'Employee Engagement', '2025-10-15 22:14:11'),
(943, 4, 'Operational Excellence', '2025-10-15 22:14:11'),
(944, 4, 'Conflict Resolution', '2025-10-15 22:14:11'),
(945, 4, 'Decision Support Systems', '2025-10-15 22:14:11'),
(946, 4, 'Management Reporting', '2025-10-15 22:14:11'),
(947, 4, 'Corporate Planning & Budgeting', '2025-10-15 22:14:11'),
(948, 4, 'Policy Implementation', '2025-10-15 22:14:11'),
(949, 4, 'Entrepreneurship Management', '2025-10-15 22:14:11'),
(950, 4, 'Business Ethics', '2025-10-15 22:14:11'),
(951, 4, 'Crisis Management', '2025-10-15 22:14:11'),
(952, 4, 'Process Reengineering', '2025-10-15 22:14:11'),
(953, 4, 'Management Research', '2025-10-15 22:14:11'),
(954, 4, 'Innovation Leadership', '2025-10-15 22:14:11'),
(955, 5, 'Accounting', '2025-10-15 22:14:11'),
(956, 5, 'Finance', '2025-10-15 22:14:11'),
(957, 5, 'Taxation', '2025-10-15 22:14:11'),
(958, 5, 'Auditing', '2025-10-15 22:14:11'),
(959, 5, 'Management Accounting', '2025-10-15 22:14:11'),
(960, 5, 'Financial Analysis', '2025-10-15 22:14:11'),
(961, 5, 'Corporate Finance', '2025-10-15 22:14:11'),
(962, 5, 'Budget Planning', '2025-10-15 22:14:11'),
(963, 5, 'Cost Accounting', '2025-10-15 22:14:11'),
(964, 5, 'Payroll Management', '2025-10-15 22:14:11'),
(965, 5, 'Financial Reporting', '2025-10-15 22:14:11'),
(966, 5, 'Bank Reconciliation', '2025-10-15 22:14:11'),
(967, 5, 'Accounting Software', '2025-10-15 22:14:11'),
(968, 5, 'Investment Analysis', '2025-10-15 22:14:11'),
(969, 5, 'Internal Audit', '2025-10-15 22:14:11'),
(970, 5, 'Compliance & Governance', '2025-10-15 22:14:11'),
(971, 5, 'Tax Planning', '2025-10-15 22:14:11'),
(972, 5, 'Financial Forecasting', '2025-10-15 22:14:11'),
(973, 5, 'Accounting Standards Implementation', '2025-10-15 22:14:11'),
(974, 5, 'Financial Control', '2025-10-15 22:14:11'),
(975, 5, 'Credit Management', '2025-10-15 22:14:11'),
(976, 5, 'Fund Management', '2025-10-15 22:14:11'),
(977, 5, 'Business Valuation', '2025-10-15 22:14:11'),
(978, 5, 'Corporate Accounting', '2025-10-15 22:14:11'),
(979, 5, 'Financial Strategy', '2025-10-15 22:14:11'),
(980, 5, 'Audit Risk Assessment', '2025-10-15 22:14:11'),
(981, 5, 'Accounting Operations', '2025-10-15 22:14:11'),
(982, 5, 'Financial Data Analysis', '2025-10-15 22:14:11'),
(983, 5, 'Investment Portfolio Management', '2025-10-15 22:14:11'),
(984, 5, 'Treasury Management', '2025-10-15 22:14:11'),
(985, 5, 'Cost Control & Reporting', '2025-10-15 22:14:11'),
(986, 5, 'Mergers & Acquisitions Accounting', '2025-10-15 22:14:11'),
(987, 5, 'Accounting Consultancy', '2025-10-15 22:14:11'),
(988, 5, 'Business Finance Reporting', '2025-10-15 22:14:11'),
(989, 5, 'Accounting & Budget Review', '2025-10-15 22:14:11'),
(990, 5, 'Financial Modelling', '2025-10-15 22:14:11'),
(991, 5, 'Banking Operations', '2025-10-15 22:14:11'),
(992, 5, 'Tax Compliance', '2025-10-15 22:14:11'),
(993, 5, 'Financial Statement Analysis', '2025-10-15 22:14:11'),
(994, 5, 'Accounting Research', '2025-10-15 22:14:11'),
(995, 5, 'Corporate Tax Management', '2025-10-15 22:14:11'),
(996, 5, 'Accounting & Audit Planning', '2025-10-15 22:14:11'),
(997, 5, 'Financial Operations Management', '2025-10-15 22:14:11'),
(998, 5, 'Cost Optimization', '2025-10-15 22:14:11'),
(999, 5, 'Accounting Ethics', '2025-10-15 22:14:11'),
(1000, 5, 'Business Finance Analytics', '2025-10-15 22:14:11'),
(1001, 5, 'Investment Reporting', '2025-10-15 22:14:11'),
(1002, 5, 'Accounting System Design', '2025-10-15 22:14:11'),
(1003, 5, 'Accounting Process Improvement', '2025-10-15 22:14:11'),
(1004, 5, 'Audit Compliance', '2025-10-15 22:14:11'),
(1005, 8, 'Food Technology', '2025-10-15 22:14:11'),
(1006, 8, 'Food Safety', '2025-10-15 22:14:11'),
(1007, 8, 'Nutrition', '2025-10-15 22:14:11'),
(1008, 8, 'Food Processing', '2025-10-15 22:14:11'),
(1009, 8, 'Food Packaging', '2025-10-15 22:14:11'),
(1010, 8, 'Culinary Management', '2025-10-15 22:14:11'),
(1011, 8, 'Food Quality Assurance', '2025-10-15 22:14:11'),
(1012, 8, 'Food Innovation', '2025-10-15 22:14:11'),
(1013, 8, 'Food R&D', '2025-10-15 22:14:11'),
(1014, 8, 'Dietary Planning', '2025-10-15 22:14:11'),
(1015, 8, 'Food Supply Chain Management', '2025-10-15 22:14:11'),
(1016, 8, 'Agro Food Technology', '2025-10-15 22:14:11'),
(1017, 8, 'Food Preservation', '2025-10-15 22:14:11'),
(1018, 8, 'Beverage Technology', '2025-10-15 22:14:11'),
(1019, 8, 'HACCP Compliance', '2025-10-15 22:14:11'),
(1020, 8, 'Food Product Development', '2025-10-15 22:14:11'),
(1021, 8, 'Sensory Analysis', '2025-10-15 22:14:11'),
(1022, 8, 'Food Regulations Compliance', '2025-10-15 22:14:11'),
(1023, 8, 'Food Marketing', '2025-10-15 22:14:11'),
(1024, 8, 'Food Testing Labs', '2025-10-15 22:14:11'),
(1025, 8, 'Nutrition Policy', '2025-10-15 22:14:11'),
(1026, 8, 'Food Analytics', '2025-10-15 22:14:11'),
(1027, 8, 'Food Entrepreneurship', '2025-10-15 22:14:11'),
(1028, 8, 'Food Equipment Management', '2025-10-15 22:14:11'),
(1029, 8, 'Culinary Innovation', '2025-10-15 22:14:11'),
(1030, 8, 'Sustainable Food Systems', '2025-10-15 22:14:11'),
(1031, 8, 'Food Science Education', '2025-10-15 22:14:11'),
(1032, 8, 'Food Packaging Design', '2025-10-15 22:14:11'),
(1033, 8, 'Food Supply Optimization', '2025-10-15 22:14:11'),
(1034, 8, 'Restaurant Management', '2025-10-15 22:14:11'),
(1035, 8, 'Dietary Consulting', '2025-10-15 22:14:11'),
(1036, 8, 'Food Industry Research', '2025-10-15 22:14:11'),
(1037, 8, 'Product Safety Testing', '2025-10-15 22:14:11'),
(1038, 8, 'Food Process Engineering', '2025-10-15 22:14:11'),
(1039, 8, 'Beverage Production', '2025-10-15 22:14:11'),
(1040, 8, 'Food Quality Monitoring', '2025-10-15 22:14:11'),
(1041, 8, 'Food Technology Consultancy', '2025-10-15 22:14:11'),
(1042, 8, 'Culinary Project Management', '2025-10-15 22:14:11'),
(1043, 8, 'Nutrition Program Development', '2025-10-15 22:14:11'),
(1044, 8, 'Food Lab Supervision', '2025-10-15 22:14:11'),
(1045, 8, 'Food Safety Auditing', '2025-10-15 22:14:11'),
(1046, 8, 'Food Innovation Leadership', '2025-10-15 22:14:11'),
(1047, 8, 'Food Science Experimentation', '2025-10-15 22:14:11'),
(1048, 8, 'Food Safety Training', '2025-10-15 22:14:11'),
(1049, 8, 'Nutrition Analysis', '2025-10-15 22:14:11'),
(1050, 8, 'Supply Chain Analytics', '2025-10-15 22:14:11'),
(1051, 8, 'Food Product Launch Planning', '2025-10-15 22:14:11'),
(1052, 8, 'Food Sector Marketing', '2025-10-15 22:14:11'),
(1053, 9, 'Quantity Surveying', '2025-10-15 22:15:02'),
(1054, 9, 'Project Costing', '2025-10-15 22:15:02'),
(1055, 9, 'Construction Management', '2025-10-15 22:15:02'),
(1056, 9, 'Site Supervision', '2025-10-15 22:15:02'),
(1057, 9, 'Contract Administration', '2025-10-15 22:15:02'),
(1058, 9, 'Building Materials', '2025-10-15 22:15:02'),
(1059, 9, 'Structural Analysis', '2025-10-15 22:15:02'),
(1060, 9, 'Construction Planning', '2025-10-15 22:15:02'),
(1061, 9, 'Budget Control', '2025-10-15 22:15:02'),
(1062, 9, 'Feasibility Studies', '2025-10-15 22:15:02'),
(1063, 9, 'Tendering & Bidding', '2025-10-15 22:15:02'),
(1064, 9, 'Value Engineering', '2025-10-15 22:15:02'),
(1065, 9, 'Risk Management', '2025-10-15 22:15:02'),
(1066, 9, 'Procurement', '2025-10-15 22:15:02'),
(1067, 9, 'Surveying & Mapping', '2025-10-15 22:15:02'),
(1068, 9, 'Construction Auditing', '2025-10-15 22:15:02'),
(1069, 9, 'Building Regulations Compliance', '2025-10-15 22:15:02'),
(1070, 9, 'Urban Planning', '2025-10-15 22:15:02'),
(1071, 9, 'Cost Estimation Software', '2025-10-15 22:15:02'),
(1072, 9, 'Project Scheduling', '2025-10-15 22:15:02'),
(1073, 9, 'Infrastructure Planning', '2025-10-15 22:15:02'),
(1074, 9, 'Site Safety Management', '2025-10-15 22:15:02'),
(1075, 9, 'Contract Negotiation', '2025-10-15 22:15:02'),
(1076, 9, 'Construction Technology', '2025-10-15 22:15:02'),
(1077, 9, 'Structural Design Review', '2025-10-15 22:15:02'),
(1078, 9, 'BIM Coordination', '2025-10-15 22:15:02'),
(1079, 9, 'Material Testing', '2025-10-15 22:15:02'),
(1080, 9, 'Construction Quality Assurance', '2025-10-15 22:15:02'),
(1081, 9, 'Project Monitoring', '2025-10-15 22:15:02'),
(1082, 9, 'Construction Risk Assessment', '2025-10-15 22:15:02'),
(1083, 9, 'Building Surveying', '2025-10-15 22:15:02'),
(1084, 9, 'Cost Reporting', '2025-10-15 22:15:02'),
(1085, 9, 'Quantity Documentation', '2025-10-15 22:15:02'),
(1086, 9, 'Engineering Consultancy', '2025-10-15 22:15:02'),
(1087, 9, 'Construction Operations', '2025-10-15 22:15:02'),
(1088, 9, 'Contract Strategy Development', '2025-10-15 22:15:02'),
(1089, 9, 'Project Valuation', '2025-10-15 22:15:02'),
(1090, 9, 'Sustainability Assessment', '2025-10-15 22:15:02'),
(1091, 9, 'Construction Innovation', '2025-10-15 22:15:02'),
(1092, 9, 'Construction Estimating', '2025-10-15 22:15:02'),
(1093, 9, 'Project Cost Control', '2025-10-15 22:15:02'),
(1094, 9, 'Construction Procurement', '2025-10-15 22:15:02'),
(1095, 9, 'Contract Law Compliance', '2025-10-15 22:15:02'),
(1096, 9, 'Infrastructure Project Management', '2025-10-15 22:15:02'),
(1097, 9, 'Construction Project Auditing', '2025-10-15 22:15:02'),
(1098, 9, 'Project Risk Management', '2025-10-15 22:15:02'),
(1099, 9, 'Cost Analysis & Optimization', '2025-10-15 22:15:02'),
(1100, 9, 'Urban Development Projects', '2025-10-15 22:15:02'),
(1101, 9, 'Construction Planning Software', '2025-10-15 22:15:02'),
(1102, 9, 'Site Inspection & Reporting', '2025-10-15 22:15:02'),
(1103, 9, 'Building Project Coordination', '2025-10-15 22:15:02'),
(1104, 9, 'Quantity Surveying Research', '2025-10-15 22:15:02'),
(1105, 10, 'Tourism', '2025-10-15 22:15:02'),
(1106, 10, 'Hotel Management', '2025-10-15 22:15:02'),
(1107, 10, 'Event Management', '2025-10-15 22:15:02'),
(1108, 10, 'Travel Agency Management', '2025-10-15 22:15:02'),
(1109, 10, 'Tour Guiding', '2025-10-15 22:15:02'),
(1110, 10, 'Culinary Arts Management', '2025-10-15 22:15:02'),
(1111, 10, 'Hospitality Marketing', '2025-10-15 22:15:02'),
(1112, 10, 'Resort Operations', '2025-10-15 22:15:02'),
(1113, 10, 'Restaurant Management', '2025-10-15 22:15:02'),
(1114, 10, 'Food & Beverage Service', '2025-10-15 22:15:02'),
(1115, 10, 'Customer Relations', '2025-10-15 22:15:02'),
(1116, 10, 'Event Coordination', '2025-10-15 22:15:02'),
(1117, 10, 'Convention Planning', '2025-10-15 22:15:02'),
(1118, 10, 'Tour Operations', '2025-10-15 22:15:02'),
(1119, 10, 'Travel Consultancy', '2025-10-15 22:15:02'),
(1120, 10, 'Tourism Development', '2025-10-15 22:15:02'),
(1121, 10, 'Sustainable Tourism', '2025-10-15 22:15:02'),
(1122, 10, 'Destination Marketing', '2025-10-15 22:15:02'),
(1123, 10, 'Tourism Research', '2025-10-15 22:15:02'),
(1124, 10, 'Travel Technology Solutions', '2025-10-15 22:15:02'),
(1125, 10, 'Hospitality Leadership', '2025-10-15 22:15:02'),
(1126, 10, 'Hotel Revenue Management', '2025-10-15 22:15:02'),
(1127, 10, 'Eco-Tourism Management', '2025-10-15 22:15:02'),
(1128, 10, 'Guest Relations Management', '2025-10-15 22:15:02'),
(1129, 10, 'Event Logistics Management', '2025-10-15 22:15:02'),
(1130, 10, 'Luxury Hospitality Management', '2025-10-15 22:15:02'),
(1131, 10, 'Tourism Policy Development', '2025-10-15 22:15:02'),
(1132, 10, 'Tour Packages Development', '2025-10-15 22:15:02'),
(1133, 10, 'Hospitality Operations', '2025-10-15 22:15:02'),
(1134, 10, 'Tourism Business Development', '2025-10-15 22:15:02'),
(1135, 10, 'Travel Planning & Coordination', '2025-10-15 22:15:02'),
(1136, 10, 'Hotel Front Office Operations', '2025-10-15 22:15:02'),
(1137, 10, 'Tourism Analytics', '2025-10-15 22:15:02'),
(1138, 10, 'Tourism Quality Assurance', '2025-10-15 22:15:02'),
(1139, 10, 'Restaurant Operations Management', '2025-10-15 22:15:02'),
(1140, 10, 'Hospitality Staff Training', '2025-10-15 22:15:02'),
(1141, 10, 'Event Design & Production', '2025-10-15 22:15:02'),
(1142, 10, 'Customer Experience Management', '2025-10-15 22:15:02'),
(1143, 10, 'Tourism Strategy & Policy', '2025-10-15 22:15:02'),
(1144, 10, 'Hospitality Sustainability Projects', '2025-10-15 22:15:02'),
(1145, 10, 'Travel Risk Management', '2025-10-15 22:15:02'),
(1146, 10, 'Destination Management', '2025-10-15 22:15:02'),
(1147, 10, 'Hospitality Technology Implementation', '2025-10-15 22:15:02'),
(1148, 10, 'Tourism Marketing Research', '2025-10-15 22:15:02'),
(1149, 10, 'Event & Convention Strategy', '2025-10-15 22:15:02'),
(1150, 10, 'Tourism Project Planning', '2025-10-15 22:15:02'),
(1151, 10, 'Hospitality Financial Management', '2025-10-15 22:15:02'),
(1152, 10, 'Travel Sales & Marketing', '2025-10-15 22:15:02'),
(1153, 10, 'Hotel Operations Management', '2025-10-15 22:15:02'),
(1154, 10, 'Tourism Innovation & Development', '2025-10-15 22:15:02'),
(1155, 10, 'Tourism Consultancy', '2025-10-15 22:15:02'),
(1156, 10, 'Hospitality Quality Monitoring', '2025-10-15 22:15:02'),
(1157, 10, 'Tourism & Travel Research', '2025-10-15 22:15:02'),
(1158, 11, 'Civil Engineering', '2025-10-15 22:15:02'),
(1159, 11, 'Construction Management', '2025-10-15 22:15:02'),
(1160, 11, 'Structural Design', '2025-10-15 22:15:02'),
(1161, 11, 'Site Supervision', '2025-10-15 22:15:02'),
(1162, 11, 'Building Materials', '2025-10-15 22:15:02'),
(1163, 11, 'Project Scheduling', '2025-10-15 22:15:02'),
(1164, 11, 'Cost Planning', '2025-10-15 22:15:02'),
(1165, 11, 'Structural Analysis', '2025-10-15 22:15:02'),
(1166, 11, 'Urban Planning', '2025-10-15 22:15:02'),
(1167, 11, 'Contract Administration', '2025-10-15 22:15:02'),
(1168, 11, 'Surveying', '2025-10-15 22:15:02'),
(1169, 11, 'Project Risk Management', '2025-10-15 22:15:02'),
(1170, 11, 'HVAC Design', '2025-10-15 22:15:02'),
(1171, 11, 'Environmental Assessment', '2025-10-15 22:15:02'),
(1172, 11, 'Construction Auditing', '2025-10-15 22:15:02'),
(1173, 11, 'Design Review', '2025-10-15 22:15:02'),
(1174, 11, 'Infrastructure Design', '2025-10-15 22:15:02'),
(1175, 11, 'Geotechnical Engineering', '2025-10-15 22:15:02'),
(1176, 11, 'Construction Quality Assurance', '2025-10-15 22:15:02'),
(1177, 11, 'Safety Engineering', '2025-10-15 22:15:02'),
(1178, 11, 'Road & Bridge Construction', '2025-10-15 22:15:02'),
(1179, 11, 'Project Monitoring', '2025-10-15 22:15:02'),
(1180, 11, 'Material Testing', '2025-10-15 22:15:02'),
(1181, 11, 'Construction Technology', '2025-10-15 22:15:02'),
(1182, 11, 'Structural Modelling', '2025-10-15 22:15:02'),
(1183, 11, 'Facility Management', '2025-10-15 22:15:02'),
(1184, 11, 'BIM Coordination', '2025-10-15 22:15:02'),
(1185, 11, 'Construction Procurement', '2025-10-15 22:15:02'),
(1186, 11, 'Sustainability Assessment', '2025-10-15 22:15:02'),
(1187, 11, 'Building Codes Compliance', '2025-10-15 22:15:02'),
(1188, 11, 'Project Documentation', '2025-10-15 22:15:02'),
(1189, 11, 'Civil Drafting', '2025-10-15 22:15:02'),
(1190, 11, 'Construction Supervision', '2025-10-15 22:15:02'),
(1191, 11, 'Contract Negotiation', '2025-10-15 22:15:02'),
(1192, 11, 'Project Valuation', '2025-10-15 22:15:02'),
(1193, 11, 'Engineering Consultancy', '2025-10-15 22:15:02'),
(1194, 11, 'Structural Integrity Testing', '2025-10-15 22:15:02'),
(1195, 11, 'Site Inspection', '2025-10-15 22:15:02'),
(1196, 11, 'Urban Development Projects', '2025-10-15 22:15:02'),
(1197, 11, 'Construction Planning Software', '2025-10-15 22:15:02'),
(1198, 11, 'Project Cost Management', '2025-10-15 22:15:02'),
(1199, 11, 'Structural Engineering Consultancy', '2025-10-15 22:15:02'),
(1200, 11, 'Building Information Modeling (BIM)', '2025-10-15 22:15:02'),
(1201, 11, 'Construction Operations Management', '2025-10-15 22:15:02'),
(1202, 11, 'Engineering Project Supervision', '2025-10-15 22:15:02'),
(1203, 11, 'Sustainable Building Design', '2025-10-15 22:15:02'),
(1204, 11, 'Civil Engineering Research', '2025-10-15 22:15:02'),
(1205, 11, 'Construction Innovation', '2025-10-15 22:15:02'),
(1206, 11, 'Facility Operations Management', '2025-10-15 22:15:02'),
(1207, 11, 'Structural Project Planning', '2025-10-15 22:15:02'),
(1208, 11, 'Infrastructure Project Coordination', '2025-10-15 22:15:02'),
(1209, 12, 'Finance', '2025-10-15 22:15:10'),
(1210, 12, 'Business Analysis', '2025-10-15 22:15:10'),
(1211, 12, 'Accounting', '2025-10-15 22:15:10'),
(1212, 12, 'Financial Planning', '2025-10-15 22:15:10'),
(1213, 12, 'Investment Management', '2025-10-15 22:15:10'),
(1214, 12, 'Corporate Finance', '2025-10-15 22:15:10'),
(1215, 12, 'Risk Management', '2025-10-15 22:15:10'),
(1216, 12, 'Tax Advisory', '2025-10-15 22:15:10'),
(1217, 12, 'Banking Operations', '2025-10-15 22:15:10'),
(1218, 12, 'Audit', '2025-10-15 22:15:10'),
(1219, 12, 'Budgeting', '2025-10-15 22:15:10'),
(1220, 12, 'Financial Reporting', '2025-10-15 22:15:10'),
(1221, 12, 'Wealth Management', '2025-10-15 22:15:10'),
(1222, 12, 'Credit Analysis', '2025-10-15 22:15:10'),
(1223, 12, 'Payroll Management', '2025-10-15 22:15:10'),
(1224, 12, 'Portfolio Management', '2025-10-15 22:15:10'),
(1225, 12, 'Financial Modelling', '2025-10-15 22:15:10'),
(1226, 12, 'Corporate Treasury', '2025-10-15 22:15:10'),
(1227, 12, 'Cost Control', '2025-10-15 22:15:10'),
(1228, 12, 'Insurance', '2025-10-15 22:15:10'),
(1229, 12, 'Compliance & Governance', '2025-10-15 22:15:10'),
(1230, 12, 'Investment Banking', '2025-10-15 22:15:10'),
(1231, 12, 'Financial Consulting', '2025-10-15 22:15:10'),
(1232, 12, 'Internal Audit', '2025-10-15 22:15:10'),
(1233, 12, 'Accounting Software Management', '2025-10-15 22:15:10'),
(1234, 12, 'Bank Reconciliation', '2025-10-15 22:15:10'),
(1235, 12, 'Credit Risk Assessment', '2025-10-15 22:15:10'),
(1236, 12, 'Financial Operations', '2025-10-15 22:15:10'),
(1237, 12, 'Economic Analysis', '2025-10-15 22:15:10'),
(1238, 12, 'Business Valuation', '2025-10-15 22:15:10'),
(1239, 12, 'Mergers & Acquisitions', '2025-10-15 22:15:10'),
(1240, 12, 'Fund Management', '2025-10-15 22:15:10'),
(1241, 12, 'Tax Planning', '2025-10-15 22:15:10'),
(1242, 12, 'Corporate Accounting', '2025-10-15 22:15:10'),
(1243, 12, 'Financial Risk Assessment', '2025-10-15 22:15:10'),
(1244, 12, 'Investment Portfolio Analysis', '2025-10-15 22:15:10'),
(1245, 12, 'Budget Forecasting', '2025-10-15 22:15:10'),
(1246, 12, 'Financial Strategy Development', '2025-10-15 22:15:10'),
(1247, 12, 'Accounting Standards Compliance', '2025-10-15 22:15:10'),
(1248, 12, 'Financial Systems Implementation', '2025-10-15 22:15:10'),
(1249, 12, 'Management Reporting', '2025-10-15 22:15:10'),
(1250, 12, 'Capital Budgeting', '2025-10-15 22:15:10'),
(1251, 12, 'Treasury Management', '2025-10-15 22:15:10'),
(1252, 12, 'Financial Data Analysis', '2025-10-15 22:15:10'),
(1253, 12, 'Corporate Performance Monitoring', '2025-10-15 22:15:10'),
(1254, 12, 'Audit Compliance', '2025-10-15 22:15:10'),
(1255, 12, 'Financial Advisory Services', '2025-10-15 22:15:10'),
(1256, 12, 'Business Finance Research', '2025-10-15 22:15:10'),
(1257, 12, 'Investment Advisory', '2025-10-15 22:15:10'),
(1258, 12, 'Corporate Finance Strategy', '2025-10-15 22:15:10'),
(1259, 12, 'Financial Technology (FinTech)', '2025-10-15 22:15:10'),
(1260, 12, 'Risk Analytics', '2025-10-15 22:15:10'),
(1261, 12, 'Cash Flow Management', '2025-10-15 22:15:10'),
(1262, 12, 'Debt Management', '2025-10-15 22:15:10'),
(1263, 12, 'Financial Policy Implementation', '2025-10-15 22:15:10'),
(1264, 12, 'Financial Governance', '2025-10-15 22:15:10'),
(1265, 12, 'Corporate Investment Analysis', '2025-10-15 22:15:10'),
(1266, 13, 'Electrical Engineering', '2025-10-15 22:15:10'),
(1267, 13, 'Mechanical Engineering', '2025-10-15 22:15:10'),
(1268, 13, 'Project Management', '2025-10-15 22:15:10'),
(1269, 13, 'Electronics Engineering', '2025-10-15 22:15:10'),
(1270, 13, 'Instrumentation', '2025-10-15 22:15:10'),
(1271, 13, 'Control Systems', '2025-10-15 22:15:10'),
(1272, 13, 'Renewable Energy', '2025-10-15 22:15:10'),
(1273, 13, 'Automation', '2025-10-15 22:15:10'),
(1274, 13, 'Robotics', '2025-10-15 22:15:10'),
(1275, 13, 'HVAC Systems', '2025-10-15 22:15:10'),
(1276, 13, 'Energy Management', '2025-10-15 22:15:10'),
(1277, 13, 'Power Systems', '2025-10-15 22:15:10'),
(1278, 13, 'Industrial Engineering', '2025-10-15 22:15:10'),
(1279, 13, 'Design Engineering', '2025-10-15 22:15:10'),
(1280, 13, 'Maintenance Engineering', '2025-10-15 22:15:10'),
(1281, 13, 'Electrical Design', '2025-10-15 22:15:10'),
(1282, 13, 'Circuit Analysis', '2025-10-15 22:15:10'),
(1283, 13, 'PLC Programming', '2025-10-15 22:15:10'),
(1284, 13, 'Embedded Systems', '2025-10-15 22:15:10'),
(1285, 13, 'Mechatronics', '2025-10-15 22:15:10'),
(1286, 13, 'Power Distribution', '2025-10-15 22:15:10'),
(1287, 13, 'Energy Auditing', '2025-10-15 22:15:10'),
(1288, 13, 'Instrumentation Control', '2025-10-15 22:15:10'),
(1289, 13, 'Signal Processing', '2025-10-15 22:15:10'),
(1290, 13, 'Electronics Testing', '2025-10-15 22:15:10'),
(1291, 13, 'Electrical Safety Compliance', '2025-10-15 22:15:10'),
(1292, 13, 'Automation Systems Design', '2025-10-15 22:15:10'),
(1293, 13, 'Control Panel Design', '2025-10-15 22:15:10'),
(1294, 13, 'Electrical Project Supervision', '2025-10-15 22:15:10'),
(1295, 13, 'Renewable Systems Installation', '2025-10-15 22:15:10'),
(1296, 13, 'Industrial Automation Implementation', '2025-10-15 22:15:10'),
(1297, 13, 'Power Grid Management', '2025-10-15 22:15:10'),
(1298, 13, 'Smart Systems Development', '2025-10-15 22:15:10'),
(1299, 13, 'Electrical Maintenance Planning', '2025-10-15 22:15:10'),
(1300, 13, 'Electrical System Design', '2025-10-15 22:15:10'),
(1301, 13, 'Instrumentation Maintenance', '2025-10-15 22:15:10'),
(1302, 13, 'Automation Troubleshooting', '2025-10-15 22:15:10'),
(1303, 13, 'Industrial Control Systems', '2025-10-15 22:15:10'),
(1304, 13, 'Electromechanical Systems', '2025-10-15 22:15:10'),
(1305, 13, 'Energy Efficiency Solutions', '2025-10-15 22:15:10'),
(1306, 13, 'Electrical Modelling', '2025-10-15 22:15:10'),
(1307, 13, 'PLC System Design', '2025-10-15 22:15:10'),
(1308, 13, 'Embedded Hardware Design', '2025-10-15 22:15:10'),
(1309, 13, 'Robotics System Design', '2025-10-15 22:15:10'),
(1310, 13, 'Renewable Energy Systems Engineering', '2025-10-15 22:15:10'),
(1311, 13, 'Automation Project Management', '2025-10-15 22:15:10'),
(1312, 13, 'Electrical Engineering Research', '2025-10-15 22:15:10'),
(1313, 13, 'Smart Grid Engineering', '2025-10-15 22:15:10'),
(1314, 13, 'Industrial IoT Systems', '2025-10-15 22:15:10'),
(1315, 13, 'Electrical System Simulation', '2025-10-15 22:15:10'),
(1316, 13, 'Power Electronics Design', '2025-10-15 22:15:10'),
(1317, 13, 'Automation Software Development', '2025-10-15 22:15:10'),
(1318, 13, 'Control Systems Optimization', '2025-10-15 22:15:10'),
(1319, 13, 'Industrial Robotics Integration', '2025-10-15 22:15:10'),
(1320, 13, 'Electrical Engineering Consultancy', '2025-10-15 22:15:10'),
(1321, 10, 'Hospitality Technology Solutions', '2025-10-15 22:15:35'),
(1322, 10, 'Tourism Risk Management', '2025-10-15 22:15:35'),
(1323, 10, 'Travel Insurance Services', '2025-10-15 22:15:35'),
(1324, 10, 'Event Production', '2025-10-15 22:15:35'),
(1325, 10, 'Luxury Resort Management', '2025-10-15 22:15:35'),
(1326, 10, 'Destination Development', '2025-10-15 22:15:35'),
(1327, 10, 'Hospitality Project Management', '2025-10-15 22:15:35'),
(1328, 10, 'Tourism Policy Advisory', '2025-10-15 22:15:35'),
(1329, 10, 'Travel Experience Design', '2025-10-15 22:15:35'),
(1330, 10, 'Tourism Analytics & Forecasting', '2025-10-15 22:15:35'),
(1331, 10, 'Sustainable Hospitality Practices', '2025-10-15 22:15:35'),
(1332, 10, 'Customer Experience Design', '2025-10-15 22:15:35'),
(1333, 10, 'Culinary Tourism', '2025-10-15 22:15:35'),
(1334, 10, 'Tourism Digital Marketing', '2025-10-15 22:15:35'),
(1335, 10, 'Hospitality E-Learning Training', '2025-10-15 22:15:35'),
(1336, 10, 'Event Logistics & Planning', '2025-10-15 22:15:35'),
(1337, 10, 'Travel Technology Innovation', '2025-10-15 22:15:35'),
(1338, 10, 'Hotel Revenue Optimization', '2025-10-15 22:15:35'),
(1339, 10, 'Tourism Operations Research', '2025-10-15 22:15:35'),
(1340, 10, 'Food & Beverage Management Strategy', '2025-10-15 22:15:35'),
(1341, 9, 'Construction Law Compliance', '2025-10-15 22:15:35'),
(1342, 9, 'Sustainable Construction Planning', '2025-10-15 22:15:35'),
(1343, 9, 'Advanced BIM Implementation', '2025-10-15 22:15:35'),
(1344, 9, 'Infrastructure Cost Management', '2025-10-15 22:15:35'),
(1345, 9, 'Construction Technology Innovation', '2025-10-15 22:15:35'),
(1346, 9, 'Project Risk Mitigation', '2025-10-15 22:15:35'),
(1347, 9, 'Construction Quality Control', '2025-10-15 22:15:35'),
(1348, 9, 'Advanced Quantity Estimation', '2025-10-15 22:15:35'),
(1349, 9, 'Mega Project Surveying', '2025-10-15 22:15:35'),
(1350, 9, 'Urban Infrastructure Development', '2025-10-15 22:15:35'),
(1351, 9, 'Construction Contract Strategy', '2025-10-15 22:15:35'),
(1352, 9, 'Material Procurement Optimization', '2025-10-15 22:15:35'),
(1353, 9, 'Project Cost Forecasting', '2025-10-15 22:15:35'),
(1354, 9, 'Construction Supply Chain Analytics', '2025-10-15 22:15:35'),
(1355, 9, 'Construction Productivity Analysis', '2025-10-15 22:15:35'),
(1356, 9, 'Digital Surveying Solutions', '2025-10-15 22:15:35'),
(1357, 9, 'Smart Building Design Consulting', '2025-10-15 22:15:35'),
(1358, 9, 'Construction Sustainability Assessment', '2025-10-15 22:15:35'),
(1359, 9, 'Structural Project Innovation', '2025-10-15 22:15:35'),
(1360, 9, 'Quantity Surveying Research Projects', '2025-10-15 22:15:35'),
(1361, 11, 'Smart Building Systems', '2025-10-15 22:15:35'),
(1362, 11, 'Green Building Design', '2025-10-15 22:15:35'),
(1363, 11, 'Sustainable Construction Engineering', '2025-10-15 22:15:35'),
(1364, 11, 'Infrastructure Innovation', '2025-10-15 22:15:35'),
(1365, 11, 'Advanced Structural Analysis', '2025-10-15 22:15:35'),
(1366, 11, '3D Modelling & BIM', '2025-10-15 22:15:35'),
(1367, 11, 'Construction Project Digitalization', '2025-10-15 22:15:35'),
(1368, 11, 'Facility Lifecycle Management', '2025-10-15 22:15:35'),
(1369, 11, 'Construction Automation', '2025-10-15 22:15:35'),
(1370, 11, 'Civil Engineering Research Projects', '2025-10-15 22:15:35'),
(1371, 11, 'Smart Infrastructure Planning', '2025-10-15 22:15:35'),
(1372, 11, 'Building Energy Optimization', '2025-10-15 22:15:35'),
(1373, 11, 'Construction Risk Analytics', '2025-10-15 22:15:35'),
(1374, 11, 'Structural Safety Auditing', '2025-10-15 22:15:35'),
(1375, 11, 'Project Performance Monitoring', '2025-10-15 22:15:35'),
(1376, 11, 'Civil Engineering Innovation', '2025-10-15 22:15:35'),
(1377, 11, 'Urban Infrastructure Planning', '2025-10-15 22:15:35'),
(1378, 11, 'Construction Technology R&D', '2025-10-15 22:15:35'),
(1379, 11, 'Facility Management Consulting', '2025-10-15 22:15:35'),
(1380, 11, 'Advanced Construction Materials Testing', '2025-10-15 22:15:35'),
(1381, 12, 'Financial Modelling & Forecasting', '2025-10-15 22:15:35'),
(1382, 12, 'Corporate Risk Advisory', '2025-10-15 22:15:35'),
(1383, 12, 'FinTech Solutions', '2025-10-15 22:15:35'),
(1384, 12, 'Investment Strategy Planning', '2025-10-15 22:15:35'),
(1385, 12, 'Financial Analytics', '2025-10-15 22:15:35'),
(1386, 12, 'Global Finance Management', '2025-10-15 22:15:35'),
(1387, 12, 'Business Valuation & Strategy', '2025-10-15 22:15:35'),
(1388, 12, 'Financial Operations Leadership', '2025-10-15 22:15:35'),
(1389, 12, 'Portfolio Risk Management', '2025-10-15 22:15:35'),
(1390, 12, 'Capital Market Research', '2025-10-15 22:15:35'),
(1391, 12, 'Financial Compliance & Ethics', '2025-10-15 22:15:35'),
(1392, 12, 'Credit Strategy', '2025-10-15 22:15:35'),
(1393, 12, 'Corporate Investment Planning', '2025-10-15 22:15:35'),
(1394, 12, 'Financial Policy & Governance', '2025-10-15 22:15:35'),
(1395, 12, 'Business Performance Analytics', '2025-10-15 22:15:35'),
(1396, 12, 'Financial Technology Research', '2025-10-15 22:15:35'),
(1397, 12, 'Treasury Strategy', '2025-10-15 22:15:35'),
(1398, 12, 'Economic Policy Analysis', '2025-10-15 22:15:35'),
(1399, 12, 'Debt & Equity Advisory', '2025-10-15 22:15:35'),
(1400, 12, 'Corporate Treasury Optimization', '2025-10-15 22:15:35'),
(1401, 13, 'Industrial IoT Integration', '2025-10-15 22:15:35'),
(1402, 13, 'Smart Grid Design', '2025-10-15 22:15:35'),
(1403, 13, 'Energy Efficiency Solutions', '2025-10-15 22:15:35'),
(1404, 13, 'Advanced Robotics Systems', '2025-10-15 22:15:35'),
(1405, 13, 'Embedded Systems Research', '2025-10-15 22:15:35'),
(1406, 13, 'Automation & Control Optimization', '2025-10-15 22:15:35'),
(1407, 13, 'Mechatronic System Design', '2025-10-15 22:15:35'),
(1408, 13, 'Renewable Energy System Engineering', '2025-10-15 22:15:35'),
(1409, 13, 'Power Electronics & Smart Systems', '2025-10-15 22:15:35'),
(1410, 13, 'Electrical Project Research', '2025-10-15 22:15:35'),
(1411, 13, 'Industrial Automation Research', '2025-10-15 22:15:35'),
(1412, 13, 'Control Systems Innovation', '2025-10-15 22:15:35'),
(1413, 13, 'Electromechanical System Integration', '2025-10-15 22:15:35'),
(1414, 13, 'Smart Factory Engineering', '2025-10-15 22:15:35'),
(1415, 13, 'Industrial Process Automation', '2025-10-15 22:15:35'),
(1416, 13, 'Robotics Research & Development', '2025-10-15 22:15:35'),
(1417, 13, 'Advanced Electrical Simulation', '2025-10-15 22:15:35'),
(1418, 13, 'Renewable Power Systems Optimization', '2025-10-15 22:15:35'),
(1419, 13, 'Embedded Hardware Innovation', '2025-10-15 22:15:35'),
(1420, 13, 'Automation Software Development Research', '2025-10-15 22:15:35'),
(1421, 10, 'Hospitality Technology Solutions', '2025-10-15 22:27:23'),
(1422, 10, 'Tourism Risk Management', '2025-10-15 22:27:23'),
(1423, 10, 'Travel Insurance Services', '2025-10-15 22:27:23'),
(1424, 10, 'Event Production', '2025-10-15 22:27:23'),
(1425, 10, 'Luxury Resort Management', '2025-10-15 22:27:23'),
(1426, 10, 'Destination Development', '2025-10-15 22:27:23'),
(1427, 10, 'Hospitality Project Management', '2025-10-15 22:27:23'),
(1428, 10, 'Tourism Policy Advisory', '2025-10-15 22:27:23'),
(1429, 10, 'Travel Experience Design', '2025-10-15 22:27:23'),
(1430, 10, 'Tourism Analytics & Forecasting', '2025-10-15 22:27:23'),
(1431, 10, 'Sustainable Hospitality Practices', '2025-10-15 22:27:23'),
(1432, 10, 'Customer Experience Design', '2025-10-15 22:27:23'),
(1433, 10, 'Culinary Tourism', '2025-10-15 22:27:23'),
(1434, 10, 'Tourism Digital Marketing', '2025-10-15 22:27:23'),
(1435, 10, 'Hospitality E-Learning Training', '2025-10-15 22:27:23'),
(1436, 10, 'Event Logistics & Planning', '2025-10-15 22:27:23'),
(1437, 10, 'Travel Technology Innovation', '2025-10-15 22:27:23'),
(1438, 10, 'Hotel Revenue Optimization', '2025-10-15 22:27:23'),
(1439, 10, 'Tourism Operations Research', '2025-10-15 22:27:23'),
(1440, 10, 'Food & Beverage Management Strategy', '2025-10-15 22:27:23'),
(1441, 9, 'Construction Law Compliance', '2025-10-15 22:27:23'),
(1442, 9, 'Sustainable Construction Planning', '2025-10-15 22:27:23'),
(1443, 9, 'Advanced BIM Implementation', '2025-10-15 22:27:23'),
(1444, 9, 'Infrastructure Cost Management', '2025-10-15 22:27:23'),
(1445, 9, 'Construction Technology Innovation', '2025-10-15 22:27:23'),
(1446, 9, 'Project Risk Mitigation', '2025-10-15 22:27:23'),
(1447, 9, 'Construction Quality Control', '2025-10-15 22:27:23'),
(1448, 9, 'Advanced Quantity Estimation', '2025-10-15 22:27:23'),
(1449, 9, 'Mega Project Surveying', '2025-10-15 22:27:23'),
(1450, 9, 'Urban Infrastructure Development', '2025-10-15 22:27:23'),
(1451, 9, 'Construction Contract Strategy', '2025-10-15 22:27:23'),
(1452, 9, 'Material Procurement Optimization', '2025-10-15 22:27:23'),
(1453, 9, 'Project Cost Forecasting', '2025-10-15 22:27:23'),
(1454, 9, 'Construction Supply Chain Analytics', '2025-10-15 22:27:23'),
(1455, 9, 'Construction Productivity Analysis', '2025-10-15 22:27:23'),
(1456, 9, 'Digital Surveying Solutions', '2025-10-15 22:27:23'),
(1457, 9, 'Smart Building Design Consulting', '2025-10-15 22:27:23'),
(1458, 9, 'Construction Sustainability Assessment', '2025-10-15 22:27:23'),
(1459, 9, 'Structural Project Innovation', '2025-10-15 22:27:23'),
(1460, 9, 'Quantity Surveying Research Projects', '2025-10-15 22:27:23'),
(1461, 11, 'Smart Building Systems', '2025-10-15 22:27:23'),
(1462, 11, 'Green Building Design', '2025-10-15 22:27:23'),
(1463, 11, 'Sustainable Construction Engineering', '2025-10-15 22:27:23'),
(1464, 11, 'Infrastructure Innovation', '2025-10-15 22:27:23'),
(1465, 11, 'Advanced Structural Analysis', '2025-10-15 22:27:23'),
(1466, 11, '3D Modelling & BIM', '2025-10-15 22:27:23'),
(1467, 11, 'Construction Project Digitalization', '2025-10-15 22:27:23'),
(1468, 11, 'Facility Lifecycle Management', '2025-10-15 22:27:23'),
(1469, 11, 'Construction Automation', '2025-10-15 22:27:23'),
(1470, 11, 'Civil Engineering Research Projects', '2025-10-15 22:27:23'),
(1471, 11, 'Smart Infrastructure Planning', '2025-10-15 22:27:23'),
(1472, 11, 'Building Energy Optimization', '2025-10-15 22:27:23'),
(1473, 11, 'Construction Risk Analytics', '2025-10-15 22:27:23'),
(1474, 11, 'Structural Safety Auditing', '2025-10-15 22:27:23'),
(1475, 11, 'Project Performance Monitoring', '2025-10-15 22:27:23'),
(1476, 11, 'Civil Engineering Innovation', '2025-10-15 22:27:23'),
(1477, 11, 'Urban Infrastructure Planning', '2025-10-15 22:27:23'),
(1478, 11, 'Construction Technology R&D', '2025-10-15 22:27:23'),
(1479, 11, 'Facility Management Consulting', '2025-10-15 22:27:23'),
(1480, 11, 'Advanced Construction Materials Testing', '2025-10-15 22:27:23'),
(1481, 12, 'Financial Modelling & Forecasting', '2025-10-15 22:27:23'),
(1482, 12, 'Corporate Risk Advisory', '2025-10-15 22:27:23'),
(1483, 12, 'FinTech Solutions', '2025-10-15 22:27:23'),
(1484, 12, 'Investment Strategy Planning', '2025-10-15 22:27:23'),
(1485, 12, 'Financial Analytics', '2025-10-15 22:27:23'),
(1486, 12, 'Global Finance Management', '2025-10-15 22:27:23'),
(1487, 12, 'Business Valuation & Strategy', '2025-10-15 22:27:23'),
(1488, 12, 'Financial Operations Leadership', '2025-10-15 22:27:23'),
(1489, 12, 'Portfolio Risk Management', '2025-10-15 22:27:23'),
(1490, 12, 'Capital Market Research', '2025-10-15 22:27:23'),
(1491, 12, 'Financial Compliance & Ethics', '2025-10-15 22:27:23'),
(1492, 12, 'Credit Strategy', '2025-10-15 22:27:23'),
(1493, 12, 'Corporate Investment Planning', '2025-10-15 22:27:23'),
(1494, 12, 'Financial Policy & Governance', '2025-10-15 22:27:23'),
(1495, 12, 'Business Performance Analytics', '2025-10-15 22:27:23'),
(1496, 12, 'Financial Technology Research', '2025-10-15 22:27:23'),
(1497, 12, 'Treasury Strategy', '2025-10-15 22:27:23'),
(1498, 12, 'Economic Policy Analysis', '2025-10-15 22:27:23'),
(1499, 12, 'Debt & Equity Advisory', '2025-10-15 22:27:23'),
(1500, 12, 'Corporate Treasury Optimization', '2025-10-15 22:27:23'),
(1501, 13, 'Industrial IoT Integration', '2025-10-15 22:27:23'),
(1502, 13, 'Smart Grid Design', '2025-10-15 22:27:23'),
(1503, 13, 'Energy Efficiency Solutions', '2025-10-15 22:27:23'),
(1504, 13, 'Advanced Robotics Systems', '2025-10-15 22:27:23'),
(1505, 13, 'Embedded Systems Research', '2025-10-15 22:27:23'),
(1506, 13, 'Automation & Control Optimization', '2025-10-15 22:27:23'),
(1507, 13, 'Mechatronic System Design', '2025-10-15 22:27:23'),
(1508, 13, 'Renewable Energy System Engineering', '2025-10-15 22:27:23'),
(1509, 13, 'Power Electronics & Smart Systems', '2025-10-15 22:27:23'),
(1510, 13, 'Electrical Project Research', '2025-10-15 22:27:23'),
(1511, 13, 'Industrial Automation Research', '2025-10-15 22:27:23'),
(1512, 13, 'Control Systems Innovation', '2025-10-15 22:27:23'),
(1513, 13, 'Electromechanical System Integration', '2025-10-15 22:27:23'),
(1514, 13, 'Smart Factory Engineering', '2025-10-15 22:27:23'),
(1515, 13, 'Industrial Process Automation', '2025-10-15 22:27:23'),
(1516, 13, 'Robotics Research & Development', '2025-10-15 22:27:23'),
(1517, 13, 'Advanced Electrical Simulation', '2025-10-15 22:27:23'),
(1518, 13, 'Renewable Power Systems Optimization', '2025-10-15 22:27:23'),
(1519, 13, 'Embedded Hardware Innovation', '2025-10-15 22:27:23'),
(1520, 13, 'Automation Software Development Research', '2025-10-15 22:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_english_skills`
--

CREATE TABLE `hnd_english_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_english_skills`
--

INSERT INTO `hnd_english_skills` (`id`, `skill_name`, `category`) VALUES
(6001, 'Advanced Grammar & Syntax', 'Language'),
(6002, 'English Vocabulary Enhancement', 'Language'),
(6003, 'Phonetics & Pronunciation Skills', 'Language'),
(6004, 'Spoken English Fluency', 'Language'),
(6005, 'Academic Writing Skills', 'Language'),
(6006, 'Business English Communication', 'Language'),
(6007, 'Technical Writing Skills', 'Language'),
(6008, 'Report Writing', 'Language'),
(6009, 'Formal & Informal Correspondence', 'Language'),
(6010, 'Essay & Article Writing', 'Language'),
(6011, 'English Literature Analysis', 'Literature'),
(6012, 'Poetry Analysis & Interpretation', 'Literature'),
(6013, 'Prose & Fiction Studies', 'Literature'),
(6014, 'Drama & Theatre Studies', 'Literature'),
(6015, 'Literary Criticism Techniques', 'Literature'),
(6016, 'Modern & Classical Literature', 'Literature'),
(6017, 'Comparative Literature', 'Literature'),
(6018, 'Shakespeare Studies', 'Literature'),
(6019, 'Creative Literature Writing', 'Literature'),
(6020, 'Literature Research Skills', 'Literature'),
(6021, 'Public Speaking Skills', 'Communication'),
(6022, 'Presentation & Speech Delivery', 'Communication'),
(6023, 'Debate & Argumentation Skills', 'Communication'),
(6024, 'Interpersonal Communication', 'Communication'),
(6025, 'Cross-Cultural Communication', 'Communication'),
(6026, 'Interview Skills & Techniques', 'Communication'),
(6027, 'Professional Communication Etiquette', 'Communication'),
(6028, 'Media & Journalism Basics', 'Communication'),
(6029, 'Digital Communication Tools', 'Communication'),
(6030, 'Persuasive Communication Skills', 'Communication'),
(6031, 'English to Native Language Translation', 'Translation'),
(6032, 'Native Language to English Translation', 'Translation'),
(6033, 'Simultaneous & Consecutive Interpretation', 'Translation'),
(6034, 'Technical Translation', 'Translation'),
(6035, 'Literary Translation', 'Translation'),
(6036, 'Translation Software & Tools', 'Translation'),
(6037, 'Subtitling & Captioning Techniques', 'Translation'),
(6038, 'Translation Project Management', 'Translation'),
(6039, 'Proofreading & Editing Translations', 'Translation'),
(6040, 'Localization & Cultural Adaptation', 'Translation'),
(6041, 'English Language Teaching (ELT) Methods', 'Teaching'),
(6042, 'Curriculum Development for English', 'Teaching'),
(6043, 'Lesson Planning & Instruction Techniques', 'Teaching'),
(6044, 'Assessment & Evaluation Techniques', 'Teaching'),
(6045, 'Classroom Management Skills', 'Teaching'),
(6046, 'Teaching English as a Second Language (ESL)', 'Teaching'),
(6047, 'Teaching Writing & Reading Skills', 'Teaching'),
(6048, 'Educational Technology for English Teaching', 'Teaching'),
(6049, 'Student Engagement & Motivation Techniques', 'Teaching'),
(6050, 'Academic Mentoring & Support', 'Teaching'),
(6051, 'Creative Writing Techniques', 'Writing'),
(6052, 'Storytelling & Script Writing', 'Writing'),
(6053, 'Poetry Composition', 'Writing'),
(6054, 'Content Writing for Digital Media', 'Writing'),
(6055, 'Copywriting Skills', 'Writing'),
(6056, 'Editing & Proofreading Skills', 'Writing'),
(6057, 'Technical & Business Writing', 'Writing'),
(6058, 'Research Paper Writing', 'Writing'),
(6059, 'Grant & Proposal Writing', 'Writing'),
(6060, 'Blogging & Social Media Content Creation', 'Writing'),
(6061, 'English Language Teaching Internship', 'Project-Based'),
(6062, 'Translation Project', 'Project-Based'),
(6063, 'Creative Writing Project', 'Project-Based'),
(6064, 'Literature Research Project', 'Project-Based'),
(6065, 'Content Writing Project', 'Project-Based'),
(6066, 'Public Speaking & Communication Project', 'Project-Based'),
(6067, 'Media & Journalism Internship', 'Project-Based'),
(6068, 'Editing & Proofreading Project', 'Project-Based'),
(6069, 'Digital Communication Campaign Project', 'Project-Based'),
(6070, 'Capstone English Language Project', 'Project-Based'),
(6071, 'Postcolonial Literature Studies', 'Literature'),
(6072, 'Feminist Literary Criticism', 'Literature'),
(6073, 'Literary Theory & Criticism', 'Literature'),
(6074, 'Modernist & Contemporary Literature', 'Literature'),
(6075, 'Comparative Cultural Literature', 'Literature'),
(6076, 'Narrative & Genre Analysis', 'Literature'),
(6077, 'Advanced Shakespeare Studies', 'Literature'),
(6078, 'Literature Seminar & Workshop Skills', 'Literature'),
(6079, 'Literary Research Methodology', 'Literature'),
(6080, 'Textual Analysis for Academic Publishing', 'Literature'),
(6081, 'Executive Communication Skills', 'Communication'),
(6082, 'Advanced Debate Techniques', 'Communication'),
(6083, 'Persuasive & Influential Speaking', 'Communication'),
(6084, 'Professional Presentation Design', 'Communication'),
(6085, 'Cross-Cultural Negotiation Skills', 'Communication'),
(6086, 'Conflict Resolution through Communication', 'Communication'),
(6087, 'Media Interview Handling Techniques', 'Communication'),
(6088, 'Crisis Communication Management', 'Communication'),
(6089, 'Speechwriting for Public & Corporate Events', 'Communication'),
(6090, 'Advanced Digital Communication Strategies', 'Communication'),
(6091, 'Specialized Technical Translation', 'Translation'),
(6092, 'Legal & Contract Translation', 'Translation'),
(6093, 'Medical & Scientific Translation', 'Translation'),
(6094, 'Simultaneous Interpretation Techniques', 'Translation'),
(6095, 'Consecutive Interpretation Techniques', 'Translation'),
(6096, 'Localization for Software & Websites', 'Translation'),
(6097, 'Advanced Subtitling & Captioning', 'Translation'),
(6098, 'Translation Project Management Tools', 'Translation'),
(6099, 'Multilingual Editing & Proofreading', 'Translation'),
(6100, 'Professional Terminology Management', 'Translation'),
(6101, 'Advanced Academic Writing & Publishing', 'Teaching'),
(6102, 'Research Proposal Writing', 'Teaching'),
(6103, 'Dissertation & Thesis Guidance', 'Teaching'),
(6104, 'Curriculum Design for ESL/EFL', 'Teaching'),
(6105, 'Assessment Rubric Development', 'Teaching'),
(6106, 'Instructional Design for Digital Platforms', 'Teaching'),
(6107, 'Pedagogical Technology Integration', 'Teaching'),
(6108, 'Language Testing & Evaluation Techniques', 'Teaching'),
(6109, 'Teacher Mentoring & Professional Development', 'Teaching'),
(6110, 'Educational Policy & Language Planning', 'Teaching'),
(6111, 'Advanced Creative Storytelling', 'Writing'),
(6112, 'Screenwriting & Script Development', 'Writing'),
(6113, 'Poetic Composition & Workshop', 'Writing'),
(6114, 'Copywriting for Advertising & Marketing', 'Writing'),
(6115, 'Content Strategy for Social Media', 'Writing'),
(6116, 'Digital Journalism & Multimedia Reporting', 'Writing'),
(6117, 'Grant & Proposal Writing for Organizations', 'Writing'),
(6118, 'Technical Documentation & Manuals', 'Writing'),
(6119, 'Blogging & Digital Publishing Advanced', 'Writing'),
(6120, 'Editing & Proofreading for Publications', 'Writing'),
(6121, 'Podcast Scriptwriting & Production', 'Digital Media'),
(6122, 'Video Content Creation & Editing', 'Digital Media'),
(6123, 'Social Media Analytics & Strategy', 'Digital Media'),
(6124, 'Online Course Development in English', 'Digital Media'),
(6125, 'E-learning Content Authoring', 'Digital Media'),
(6126, 'Virtual Communication & Remote Collaboration', 'Digital Media'),
(6127, 'Professional Blogging Platforms Management', 'Digital Media'),
(6128, 'SEO Writing & Digital Optimization', 'Digital Media'),
(6129, 'Digital Storytelling Techniques', 'Digital Media'),
(6130, 'Media Literacy & Critical Analysis', 'Digital Media'),
(6131, 'Leadership in Educational & Media Projects', 'Professional'),
(6132, 'Project Planning & Management', 'Professional'),
(6133, 'Time Management & Productivity Enhancement', 'Professional'),
(6134, 'Networking & Industry Relationship Management', 'Professional'),
(6135, 'Business Communication Etiquette', 'Professional'),
(6136, 'Team Collaboration & Leadership', 'Professional'),
(6137, 'Problem-Solving in Professional Contexts', 'Professional'),
(6138, 'Critical Thinking for Decision-Making', 'Professional'),
(6139, 'Professional Ethics & Standards', 'Professional'),
(6140, 'Career Development & Job Readiness', 'Professional'),
(6141, 'Advanced Teaching Internship Project', 'Project-Based'),
(6142, 'Translation & Localization Internship Project', 'Project-Based'),
(6143, 'Creative Writing Publication Project', 'Project-Based'),
(6144, 'Digital Media Campaign Project', 'Project-Based'),
(6145, 'Research & Academic Publication Project', 'Project-Based'),
(6146, 'Cross-Cultural Communication Project', 'Project-Based'),
(6147, 'Corporate & Business Communication Project', 'Project-Based'),
(6148, 'Content Development for E-Learning Project', 'Project-Based'),
(6149, 'Journalism & Reporting Internship Project', 'Project-Based'),
(6150, 'Capstone English Professional Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_food_tech_skills`
--

CREATE TABLE `hnd_food_tech_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_food_tech_skills`
--

INSERT INTO `hnd_food_tech_skills` (`id`, `skill_name`, `category`) VALUES
(7001, 'Food Chemistry Fundamentals', 'Food Science'),
(7002, 'Macronutrient Analysis', 'Food Science'),
(7003, 'Carbohydrates Analysis', 'Food Science'),
(7004, 'Proteins & Amino Acids Analysis', 'Food Science'),
(7005, 'Lipids & Fat Analysis', 'Food Science'),
(7006, 'Vitamins & Minerals Analysis', 'Food Science'),
(7007, 'Food Additives & Preservatives', 'Food Science'),
(7008, 'Functional Foods Study', 'Food Science'),
(7009, 'Enzymology in Food', 'Food Science'),
(7010, 'Food Ingredient Interactions', 'Food Science'),
(7011, 'Thermal Processing Techniques', 'Food Processing'),
(7012, 'Canning & Pasteurization', 'Food Processing'),
(7013, 'Freezing & Cold Storage', 'Food Processing'),
(7014, 'Drying & Dehydration Techniques', 'Food Processing'),
(7015, 'Fermentation Technology', 'Food Processing'),
(7016, 'Food Packaging Techniques', 'Food Processing'),
(7017, 'Extrusion Processing', 'Food Processing'),
(7018, 'Hurdle Technology', 'Food Processing'),
(7019, 'High Pressure Processing', 'Food Processing'),
(7020, 'Irradiation & Novel Preservation Methods', 'Food Processing'),
(7021, 'HACCP Principles', 'Food Safety'),
(7022, 'ISO 22000 Food Safety Management', 'Food Safety'),
(7023, 'GMP Compliance', 'Food Safety'),
(7024, 'Food Quality Control Techniques', 'Food Safety'),
(7025, 'Microbiological Risk Assessment', 'Food Safety'),
(7026, 'Food Contaminants Testing', 'Food Safety'),
(7027, 'Allergen Management', 'Food Safety'),
(7028, 'Sanitation & Hygiene Practices', 'Food Safety'),
(7029, 'Food Traceability Systems', 'Food Safety'),
(7030, 'Sensory Quality Evaluation', 'Food Safety'),
(7031, 'Foodborne Pathogens Identification', 'Food Microbiology'),
(7032, 'Spoilage Microorganisms', 'Food Microbiology'),
(7033, 'Probiotics & Functional Microbes', 'Food Microbiology'),
(7034, 'Fermented Food Microbiology', 'Food Microbiology'),
(7035, 'Microbial Enumeration Techniques', 'Food Microbiology'),
(7036, 'Culture Media Preparation', 'Food Microbiology'),
(7037, 'Aseptic Technique', 'Food Microbiology'),
(7038, 'Molecular Detection Techniques', 'Food Microbiology'),
(7039, 'Microbial Safety Assessment', 'Food Microbiology'),
(7040, 'Antimicrobial Testing in Foods', 'Food Microbiology'),
(7041, 'Food Process Design', 'Food Engineering'),
(7042, 'Unit Operations in Food Processing', 'Food Engineering'),
(7043, 'Heat & Mass Transfer in Foods', 'Food Engineering'),
(7044, 'Food Rheology & Texture Analysis', 'Food Engineering'),
(7045, 'Food Packaging Material Selection', 'Food Engineering'),
(7046, 'Active & Intelligent Packaging', 'Food Engineering'),
(7047, 'Shelf-Life Prediction Models', 'Food Engineering'),
(7048, 'Food Plant Layout Design', 'Food Engineering'),
(7049, 'Automation in Food Processing', 'Food Engineering'),
(7050, 'Process Control & Instrumentation', 'Food Engineering'),
(7051, 'New Product Formulation', 'Product Development'),
(7052, 'Prototype Testing', 'Product Development'),
(7053, 'Shelf-Life Testing', 'Product Development'),
(7054, 'Sensory Evaluation Techniques', 'Product Development'),
(7055, 'Flavor & Aroma Profiling', 'Product Development'),
(7056, 'Texture & Appearance Analysis', 'Product Development'),
(7057, 'Consumer Preference Studies', 'Product Development'),
(7058, 'Food Innovation & Trends', 'Product Development'),
(7059, 'Packaging Design for Products', 'Product Development'),
(7060, 'Nutraceutical Product Development', 'Product Development'),
(7061, 'Nutritional Analysis of Foods', 'Nutrition'),
(7062, 'Diet Planning & Assessment', 'Nutrition'),
(7063, 'Functional Foods & Health Benefits', 'Nutrition'),
(7064, 'Macronutrient & Micronutrient Requirements', 'Nutrition'),
(7065, 'Food Fortification Techniques', 'Nutrition'),
(7066, 'Medical & Clinical Nutrition Basics', 'Nutrition'),
(7067, 'Public Health Nutrition', 'Nutrition'),
(7068, 'Sports & Performance Nutrition', 'Nutrition'),
(7069, 'Nutrition Labeling & Claims', 'Nutrition'),
(7070, 'Dietary Supplements Knowledge', 'Nutrition'),
(7071, 'Food Laws & Regulations', 'Regulation'),
(7072, 'Codex Alimentarius Standards', 'Regulation'),
(7073, 'Labeling Compliance', 'Regulation'),
(7074, 'Food Inspection Procedures', 'Regulation'),
(7075, 'Food Import & Export Regulations', 'Regulation'),
(7076, 'Consumer Protection in Food Industry', 'Regulation'),
(7077, 'Environmental Regulations in Food Industry', 'Regulation'),
(7078, 'Food Certification & Auditing', 'Regulation'),
(7079, 'Risk Communication in Food Industry', 'Regulation'),
(7080, 'Regulatory Compliance Reporting', 'Regulation'),
(7081, 'Analytical Instrumentation', 'Laboratory'),
(7082, 'Spectrophotometry', 'Laboratory'),
(7083, 'Chromatography Techniques (HPLC, GC)', 'Laboratory'),
(7084, 'Moisture & Water Activity Analysis', 'Laboratory'),
(7085, 'pH & Acidity Measurement', 'Laboratory'),
(7086, 'Texture & Viscosity Measurement', 'Laboratory'),
(7087, 'Microbiological Lab Techniques', 'Laboratory'),
(7088, 'Chemical Lab Techniques', 'Laboratory'),
(7089, 'Laboratory Safety & SOPs', 'Laboratory'),
(7090, 'Data Recording & Analysis', 'Laboratory'),
(7091, 'FoodLab Software', 'Software'),
(7092, 'Nutritional Analysis Software', 'Software'),
(7093, 'SPSS / Minitab for Data Analysis', 'Software'),
(7094, 'Microsoft Excel Advanced', 'Software'),
(7095, 'Food Process Simulation Software', 'Software'),
(7096, 'Food Packaging Design Software', 'Software'),
(7097, 'BIM for Food Processing Plants', 'Software'),
(7098, 'ERP for Food Industry', 'Software'),
(7099, 'Inventory & Supply Chain Software', 'Software'),
(7100, 'LIMS (Laboratory Information Management System)', 'Software'),
(7101, 'Teamwork in Food Technology Projects', 'Soft Skills'),
(7102, 'Communication Skills in Industry', 'Soft Skills'),
(7103, 'Problem Solving & Critical Thinking', 'Soft Skills'),
(7104, 'Leadership & Supervision', 'Soft Skills'),
(7105, 'Time Management & Planning', 'Soft Skills'),
(7106, 'Conflict Resolution', 'Soft Skills'),
(7107, 'Research & Report Writing', 'Soft Skills'),
(7108, 'Internship in Food Production Facility', 'Project-Based'),
(7109, 'Food Safety Audit Project', 'Project-Based'),
(7110, 'Product Development Internship', 'Project-Based'),
(7111, 'Freeze Drying & Lyophilization', 'Food Processing'),
(7112, 'Spray Drying Techniques', 'Food Processing'),
(7113, 'High Pressure Processing (HPP)', 'Food Processing'),
(7114, 'Ultrasound & Pulsed Electric Field Processing', 'Food Processing'),
(7115, 'Ohmic Heating Applications', 'Food Processing'),
(7116, 'Membrane Filtration Techniques', 'Food Processing'),
(7117, 'Encapsulation of Bioactive Compounds', 'Food Processing'),
(7118, 'Nanotechnology in Food Processing', 'Food Processing'),
(7119, '3D Food Printing', 'Food Processing'),
(7120, 'Functional Beverage Processing', 'Food Processing'),
(7121, 'Advanced HACCP Risk Analysis', 'Food Safety'),
(7122, 'Food Fraud Detection Techniques', 'Food Safety'),
(7123, 'ISO 9001 Quality Management', 'Food Safety'),
(7124, 'ISO 14001 Environmental Management', 'Food Safety'),
(7125, 'ISO 22000 Advanced Implementation', 'Food Safety'),
(7126, 'GMP Auditing Techniques', 'Food Safety'),
(7127, 'Food Contamination Source Tracking', 'Food Safety'),
(7128, 'Sensory Panel Management', 'Food Safety'),
(7129, 'Advanced Shelf-Life Studies', 'Food Safety'),
(7130, 'Predictive Microbiology Applications', 'Food Safety'),
(7131, 'Molecular Microbiology Techniques', 'Food Microbiology'),
(7132, 'PCR and qPCR in Food Microbiology', 'Food Microbiology'),
(7133, 'Foodborne Pathogen Control', 'Food Microbiology'),
(7134, 'Biofilm Detection in Food Systems', 'Food Microbiology'),
(7135, 'Spoilage Kinetics Analysis', 'Food Microbiology'),
(7136, 'Probiotic Product Development', 'Food Microbiology'),
(7137, 'Fermentation Microbial Optimization', 'Food Microbiology'),
(7138, 'Microbial Risk Modeling', 'Food Microbiology'),
(7139, 'Microbial Genomics in Food Safety', 'Food Microbiology'),
(7140, 'Pathogen Detection Using Biosensors', 'Food Microbiology'),
(7141, 'Nutraceutical Product Formulation', 'Product Development'),
(7142, 'Functional Food Design', 'Product Development'),
(7143, 'Plant-Based Food Product Development', 'Product Development'),
(7144, 'Protein & Alternative Protein Product Development', 'Product Development'),
(7145, 'Flavor Chemistry Optimization', 'Product Development'),
(7146, 'Texture & Rheology Product Optimization', 'Product Development'),
(7147, 'Food Color & Appearance Engineering', 'Product Development'),
(7148, 'Food Packaging Innovation', 'Product Development'),
(7149, 'Food Waste Upcycling Product Design', 'Product Development'),
(7150, 'New Product Market Testing & Consumer Research', 'Product Development'),
(7151, 'Clinical Nutrition Analysis', 'Nutrition'),
(7152, 'Nutrigenomics Basics', 'Nutrition'),
(7153, 'Dietary Supplement Development', 'Nutrition'),
(7154, 'Functional Ingredient Assessment', 'Nutrition'),
(7155, 'Food Fortification & Enrichment Techniques', 'Nutrition'),
(7156, 'Personalized Diet Planning', 'Nutrition'),
(7157, 'Sports Nutrition Product Design', 'Nutrition'),
(7158, 'Public Health Food Policy', 'Nutrition'),
(7159, 'Nutritional Epidemiology', 'Nutrition'),
(7160, 'Advanced Nutrition Label Interpretation', 'Nutrition'),
(7161, 'Advanced Thermal Processing Simulation', 'Food Engineering'),
(7162, 'Mass Transfer Modelling in Foods', 'Food Engineering'),
(7163, 'Rheology and Viscoelastic Analysis', 'Food Engineering'),
(7164, 'Modified Atmosphere Packaging (MAP)', 'Food Engineering'),
(7165, 'Active & Intelligent Packaging Development', 'Food Engineering'),
(7166, 'Packaging Material Barrier Properties', 'Food Engineering'),
(7167, 'Food Process Scale-Up Techniques', 'Food Engineering'),
(7168, 'Automation & Robotics in Food Industry', 'Food Engineering'),
(7169, 'Food Plant Energy Efficiency', 'Food Engineering'),
(7170, 'Smart Sensors for Food Monitoring', 'Food Engineering'),
(7171, 'Sustainable Food Processing', 'Sustainability'),
(7172, 'Renewable Energy in Food Industry', 'Sustainability'),
(7173, 'Water Footprint Analysis', 'Sustainability'),
(7174, 'Life Cycle Assessment of Food Products', 'Sustainability'),
(7175, 'Carbon Footprint Reduction in Food Production', 'Sustainability'),
(7176, 'Zero-Waste Food Production Strategies', 'Sustainability'),
(7177, 'Eco-Friendly Packaging Solutions', 'Sustainability'),
(7178, 'Sustainable Supply Chain Management', 'Sustainability'),
(7179, 'Circular Economy in Food Industry', 'Sustainability'),
(7180, 'Corporate Social Responsibility (CSR) in Food Tech', 'Sustainability'),
(7181, 'Mass Spectrometry Applications in Food', 'Laboratory'),
(7182, 'Chromatography (HPLC, GC, IC) Advanced', 'Laboratory'),
(7183, 'Spectroscopic Techniques (UV-Vis, IR, NMR)', 'Laboratory'),
(7184, 'Rheology & Texture Profile Analysis', 'Laboratory'),
(7185, 'Food Sensory Panel Design', 'Laboratory'),
(7186, 'Food Allergen Detection', 'Laboratory'),
(7187, 'Food Contaminant Quantification', 'Laboratory'),
(7188, 'Rapid Microbiological Testing Methods', 'Laboratory'),
(7189, 'Food Additive Analysis', 'Laboratory'),
(7190, 'Data Analysis & Statistical Modeling in Food Research', 'Laboratory'),
(7191, 'Food Process Simulation Software Advanced', 'Software'),
(7192, 'Advanced Nutritional Analysis Software', 'Software'),
(7193, 'LIMS Advanced Features', 'Software'),
(7194, 'ERP Integration for Food Industry', 'Software'),
(7195, 'Supply Chain Management Software', 'Software'),
(7196, 'SPSS / R / Minitab for Food Data Analysis', 'Software'),
(7197, 'Food Safety Tracking Software', 'Software'),
(7198, 'BIM for Food Plant Design', 'Software'),
(7199, '3D Modeling for Food Equipment', 'Software'),
(7200, 'IoT & Sensors for Food Quality Monitoring', 'Software'),
(7201, 'Project Management for Food Tech Projects', 'Soft Skills'),
(7202, 'Research Proposal Writing', 'Soft Skills'),
(7203, 'Scientific Report Writing', 'Soft Skills'),
(7204, 'Team Leadership in Food Industry', 'Soft Skills'),
(7205, 'Presentation & Communication Skills', 'Soft Skills'),
(7206, 'Problem Solving in Food Product Development', 'Soft Skills'),
(7207, 'Decision Making in Food Safety & Quality', 'Soft Skills'),
(7208, 'Time Management in Food Projects', 'Soft Skills'),
(7209, 'Ethics in Food Technology Research', 'Soft Skills'),
(7210, 'Entrepreneurship & Innovation in Food Industry', 'Soft Skills'),
(7211, 'Food Product Development Internship', 'Project-Based'),
(7212, 'Food Safety Audit Project', 'Project-Based'),
(7213, 'Process Optimization Project', 'Project-Based'),
(7214, 'Quality Control Internship', 'Project-Based'),
(7215, 'Sensory Evaluation Project', 'Project-Based'),
(7216, 'Sustainable Food Processing Project', 'Project-Based'),
(7217, 'Laboratory Research Internship', 'Project-Based'),
(7218, 'Packaging Design & Testing Project', 'Project-Based'),
(7219, 'Functional Food Project', 'Project-Based'),
(7220, 'Capstone Food Technology Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_management_skills`
--

CREATE TABLE `hnd_management_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_management_skills`
--

INSERT INTO `hnd_management_skills` (`id`, `skill_name`, `category`) VALUES
(8001, 'Principles of Management', 'Management'),
(8002, 'Organizational Behaviour', 'Management'),
(8003, 'Strategic Management', 'Management'),
(8004, 'Operations Management', 'Management'),
(8005, 'Project Management Basics', 'Management'),
(8006, 'Business Policy & Planning', 'Management'),
(8007, 'Time Management', 'Management'),
(8008, 'Decision Making & Problem Solving', 'Management'),
(8009, 'Business Process Management', 'Management'),
(8010, 'Quality Management', 'Management'),
(8011, 'Human Resource Planning', 'HRM'),
(8012, 'Recruitment & Selection', 'HRM'),
(8013, 'Training & Development', 'HRM'),
(8014, 'Performance Appraisal Systems', 'HRM'),
(8015, 'Employee Engagement', 'HRM'),
(8016, 'Compensation & Benefits Management', 'HRM'),
(8017, 'Labour Laws & Compliance', 'HRM'),
(8018, 'Organizational Culture Development', 'HRM'),
(8019, 'Conflict Management', 'HRM'),
(8020, 'Leadership & Team Management', 'HRM'),
(8021, 'Marketing Principles', 'Marketing'),
(8022, 'Market Research & Analysis', 'Marketing'),
(8023, 'Consumer Behaviour', 'Marketing'),
(8024, 'Brand Management', 'Marketing'),
(8025, 'Digital Marketing', 'Marketing'),
(8026, 'Sales Management', 'Marketing'),
(8027, 'Advertising & Promotions', 'Marketing'),
(8028, 'Pricing Strategies', 'Marketing'),
(8029, 'E-Commerce Management', 'Marketing'),
(8030, 'Customer Relationship Management', 'Marketing'),
(8031, 'Financial Management Basics', 'Finance'),
(8032, 'Budgeting & Forecasting', 'Finance'),
(8033, 'Cost Control & Analysis', 'Finance'),
(8034, 'Investment & Capital Budgeting', 'Finance'),
(8035, 'Financial Statement Analysis', 'Finance'),
(8036, 'Corporate Finance Basics', 'Finance'),
(8037, 'Risk Management', 'Finance'),
(8038, 'Working Capital Management', 'Finance'),
(8039, 'Accounting for Managers', 'Finance'),
(8040, 'Financial Decision Making', 'Finance'),
(8041, 'Supply Chain Management', 'Operations'),
(8042, 'Logistics & Distribution Management', 'Operations'),
(8043, 'Inventory Management', 'Operations'),
(8044, 'Production Planning', 'Operations'),
(8045, 'Lean Management', 'Operations'),
(8046, 'Six Sigma Basics', 'Operations'),
(8047, 'Process Optimization', 'Operations'),
(8048, 'Operational Risk Management', 'Operations'),
(8049, 'Facility Management', 'Operations'),
(8050, 'Total Quality Management', 'Operations'),
(8051, 'Business Analytics', 'Analytics'),
(8052, 'Data-Driven Decision Making', 'Analytics'),
(8053, 'Excel for Managers', 'Analytics'),
(8054, 'Tableau / Power BI for Managers', 'Analytics'),
(8055, 'ERP Systems for Management', 'Analytics'),
(8056, 'Database Basics for Managers', 'Analytics'),
(8057, 'Digital Transformation in Business', 'Analytics'),
(8058, 'Predictive Analysis', 'Analytics'),
(8059, 'KPIs & Performance Metrics', 'Analytics'),
(8060, 'Management Information Systems', 'Analytics'),
(8061, 'Corporate Strategy', 'Strategy'),
(8062, 'Competitive Analysis', 'Strategy'),
(8063, 'Change Management', 'Strategy'),
(8064, 'Business Model Innovation', 'Strategy'),
(8065, 'Entrepreneurship & Startups', 'Strategy'),
(8066, 'Strategic Planning', 'Strategy'),
(8067, 'Business Growth Strategies', 'Strategy'),
(8068, 'Innovation Management', 'Strategy'),
(8069, 'Sustainability & CSR Strategy', 'Strategy'),
(8070, 'Business Ethics & Governance', 'Strategy'),
(8071, 'Communication Skills', 'Professional'),
(8072, 'Negotiation & Persuasion', 'Professional'),
(8073, 'Leadership & Motivation', 'Professional'),
(8074, 'Presentation Skills', 'Professional'),
(8075, 'Teamwork & Collaboration', 'Professional'),
(8076, 'Critical Thinking & Problem Solving', 'Professional'),
(8077, 'Time & Stress Management', 'Professional'),
(8078, 'Professional Etiquette', 'Professional'),
(8079, 'Decision Making under Uncertainty', 'Professional'),
(8080, 'Networking & Relationship Management', 'Professional'),
(8081, 'Management Simulation Project', 'Project-Based'),
(8082, 'Business Plan Development Project', 'Project-Based'),
(8083, 'Marketing Campaign Project', 'Project-Based'),
(8084, 'Financial Analysis Project', 'Project-Based'),
(8085, 'Supply Chain Optimization Project', 'Project-Based'),
(8086, 'HR & Talent Management Project', 'Project-Based'),
(8087, 'Operations Improvement Project', 'Project-Based'),
(8088, 'Digital Transformation Project', 'Project-Based'),
(8089, 'Entrepreneurship Startup Project', 'Project-Based'),
(8090, 'Capstone Management Internship Project', 'Project-Based'),
(8091, 'Global Business Strategy', 'Strategy'),
(8092, 'International Business Management', 'Strategy'),
(8093, 'Strategic Risk Management', 'Strategy'),
(8094, 'Competitive Intelligence & Analysis', 'Strategy'),
(8095, 'Corporate Governance & Ethics', 'Strategy'),
(8096, 'Change Leadership & Transformation', 'Strategy'),
(8097, 'Mergers & Acquisitions Management', 'Strategy'),
(8098, 'Business Model Innovation', 'Strategy'),
(8099, 'Sustainability & CSR Strategy', 'Strategy'),
(8100, 'Strategic Decision Making', 'Strategy'),
(8101, 'Advanced Leadership Skills', 'HRM'),
(8102, 'Cross-Cultural Team Leadership', 'HRM'),
(8103, 'Talent Acquisition Strategy', 'HRM'),
(8104, 'Employee Engagement & Retention Strategies', 'HRM'),
(8105, 'Succession Planning & Leadership Development', 'HRM'),
(8106, 'Performance Management Systems', 'HRM'),
(8107, 'Organizational Development', 'HRM'),
(8108, 'Conflict Resolution & Negotiation', 'HRM'),
(8109, 'HR Analytics for Decision Making', 'HRM'),
(8110, 'Labour Law Compliance & Policy', 'HRM'),
(8111, 'Advanced Digital Marketing Strategy', 'Marketing'),
(8112, 'Social Media Campaign Management', 'Marketing'),
(8113, 'SEO & SEM Strategy', 'Marketing'),
(8114, 'Brand Positioning & Identity', 'Marketing'),
(8115, 'Customer Experience Management', 'Marketing'),
(8116, 'Market Segmentation & Targeting', 'Marketing'),
(8117, 'E-Commerce Operations & Management', 'Marketing'),
(8118, 'Marketing Analytics & ROI Measurement', 'Marketing'),
(8119, 'Customer Relationship Management (CRM) Tools', 'Marketing'),
(8120, 'Global Marketing Strategy', 'Marketing'),
(8121, 'Corporate Financial Strategy', 'Finance'),
(8122, 'Advanced Budgeting & Forecasting', 'Finance'),
(8123, 'Financial Risk Modelling & Hedging', 'Finance'),
(8124, 'Investment & Portfolio Analysis', 'Finance'),
(8125, 'Working Capital Optimization', 'Finance'),
(8126, 'Capital Structure Decision Making', 'Finance'),
(8127, 'Financial Statement Consolidation', 'Finance'),
(8128, 'Project Finance & Feasibility Analysis', 'Finance'),
(8129, 'Cost-Benefit Analysis for Projects', 'Finance'),
(8130, 'Financial Compliance & Reporting', 'Finance'),
(8131, 'Advanced Supply Chain Analytics', 'Operations'),
(8132, 'Lean & Six Sigma Implementation', 'Operations'),
(8133, 'Inventory Optimization Techniques', 'Operations'),
(8134, 'Logistics & Distribution Strategy', 'Operations'),
(8135, 'Production Planning & Scheduling', 'Operations'),
(8136, 'Operational Risk Management', 'Operations'),
(8137, 'Process Improvement & Business Process Reengineering', 'Operations'),
(8138, 'Facility & Resource Management', 'Operations'),
(8139, 'Quality Management & ISO Standards', 'Operations'),
(8140, 'Operations Performance Metrics', 'Operations'),
(8141, 'Business Intelligence (BI) Tools', 'Analytics'),
(8142, 'Data-Driven Decision Making', 'Analytics'),
(8143, 'Predictive Analytics & Forecasting', 'Analytics'),
(8144, 'Excel Advanced Modelling & Dashboards', 'Analytics'),
(8145, 'Power BI / Tableau for Managers', 'Analytics'),
(8146, 'ERP Systems for Management', 'Analytics'),
(8147, 'Database Management for Managers', 'Analytics'),
(8148, 'Digital Transformation Management', 'Analytics'),
(8149, 'KPI & Performance Metrics Analysis', 'Analytics'),
(8150, 'AI & Automation Tools for Business', 'Analytics'),
(8151, 'Entrepreneurship & Startup Strategy', 'Entrepreneurship'),
(8152, 'Business Model Design & Innovation', 'Entrepreneurship'),
(8153, 'Startup Funding & Venture Capital', 'Entrepreneurship'),
(8154, 'Innovation Lab & Ideation Techniques', 'Entrepreneurship'),
(8155, 'Scaling Businesses & Growth Strategies', 'Entrepreneurship'),
(8156, 'Social Enterprise Development', 'Entrepreneurship'),
(8157, 'Go-To-Market & Product Launch Strategy', 'Entrepreneurship'),
(8158, 'Feasibility Studies & Market Validation', 'Entrepreneurship'),
(8159, 'Entrepreneurial Risk Management', 'Entrepreneurship'),
(8160, 'Business Incubation & Acceleration', 'Entrepreneurship'),
(8161, 'Advanced Communication Skills', 'Professional'),
(8162, 'Negotiation & Persuasion', 'Professional'),
(8163, 'Leadership in Multicultural Teams', 'Professional'),
(8164, 'Critical Thinking & Problem Solving', 'Professional'),
(8165, 'Time Management & Productivity', 'Professional'),
(8166, 'Professional Etiquette & Networking', 'Professional'),
(8167, 'Presentation Design & Delivery', 'Professional'),
(8168, 'Decision Making under Uncertainty', 'Professional'),
(8169, 'Team Collaboration & Management', 'Professional'),
(8170, 'Conflict Management & Mediation', 'Professional'),
(8171, 'Strategic Management Simulation Project', 'Project-Based'),
(8172, 'Business Analytics Project', 'Project-Based'),
(8173, 'Marketing Campaign Project', 'Project-Based'),
(8174, 'Financial Analysis & Planning Project', 'Project-Based'),
(8175, 'HR Analytics & Talent Management Project', 'Project-Based'),
(8176, 'Operations Optimization Project', 'Project-Based'),
(8177, 'Digital Transformation Project', 'Project-Based'),
(8178, 'Entrepreneurship Startup Project', 'Project-Based'),
(8179, 'Supply Chain & Logistics Project', 'Project-Based'),
(8180, 'Capstone Management Internship Project', 'Project-Based'),
(8181, 'Global Supply Chain Strategy', 'Strategy'),
(8182, 'International Trade & Compliance', 'Strategy'),
(8183, 'Cross-Border Mergers & Acquisitions', 'Strategy'),
(8184, 'Global Business Risk Management', 'Strategy'),
(8185, 'International Business Law Basics', 'Strategy'),
(8186, 'Global Market Entry Strategies', 'Strategy'),
(8187, 'Cultural Intelligence & Diversity Management', 'Strategy'),
(8188, 'International Business Negotiation', 'Strategy'),
(8189, 'Global Economic Environment Analysis', 'Strategy'),
(8190, 'Sustainability & CSR in Global Context', 'Strategy'),
(8191, 'Transformational Leadership', 'HRM'),
(8192, 'Servant Leadership', 'HRM'),
(8193, 'Coaching & Mentoring for Managers', 'HRM'),
(8194, 'Change Management & Organizational Transformation', 'HRM'),
(8195, 'Employee Motivation & Engagement Strategies', 'HRM'),
(8196, 'Leadership in Crisis & Risk Management', 'HRM'),
(8197, 'Organizational Design & Restructuring', 'HRM'),
(8198, 'Talent Analytics & Workforce Planning', 'HRM'),
(8199, 'Strategic Human Capital Management', 'HRM'),
(8200, 'Advanced Conflict Resolution Techniques', 'HRM'),
(8201, 'Omni-Channel Marketing Strategy', 'Marketing'),
(8202, 'Customer Experience Design & Management', 'Marketing'),
(8203, 'Marketing Automation Tools', 'Marketing'),
(8204, 'Advanced SEO & SEM Strategy', 'Marketing'),
(8205, 'Global Branding & Positioning', 'Marketing'),
(8206, 'Digital Analytics & Marketing ROI', 'Marketing'),
(8207, 'Consumer Behaviour Analytics', 'Marketing'),
(8208, 'Customer Retention & Loyalty Programs', 'Marketing'),
(8209, 'Product Lifecycle Management', 'Marketing'),
(8210, 'E-Commerce Strategy & Operations', 'Marketing'),
(8211, 'Strategic Financial Planning', 'Finance'),
(8212, 'Corporate Governance & Compliance', 'Finance'),
(8213, 'Mergers & Acquisition Financial Modelling', 'Finance'),
(8214, 'Capital Budgeting & Investment Analysis', 'Finance'),
(8215, 'Financial Risk Assessment & Mitigation', 'Finance'),
(8216, 'Portfolio Management & Asset Allocation', 'Finance'),
(8217, 'Corporate Treasury & Cash Management', 'Finance'),
(8218, 'Advanced Cost Management', 'Finance'),
(8219, 'Financial Forecasting & Scenario Analysis', 'Finance'),
(8220, 'Ethical Financial Decision Making', 'Finance'),
(8221, 'Business Process Reengineering', 'Operations'),
(8222, 'Lean & Six Sigma Advanced Implementation', 'Operations'),
(8223, 'Operational Excellence & Benchmarking', 'Operations'),
(8224, 'Production & Capacity Planning', 'Operations'),
(8225, 'Supply Chain Risk & Resilience Management', 'Operations'),
(8226, 'Inventory Analytics & Optimization', 'Operations'),
(8227, 'Total Quality Management Advanced Techniques', 'Operations'),
(8228, 'Service Operations Management', 'Operations'),
(8229, 'Sustainability in Operations', 'Operations'),
(8230, 'Innovation Management & Product Development', 'Operations'),
(8231, 'Big Data Analytics for Managers', 'Analytics'),
(8232, 'Predictive & Prescriptive Analytics', 'Analytics'),
(8233, 'Dashboard & KPI Development', 'Analytics'),
(8234, 'ERP System Advanced Usage', 'Analytics'),
(8235, 'Digital Transformation Strategy', 'Analytics'),
(8236, 'AI & Automation in Business Processes', 'Analytics'),
(8237, 'Data Visualization for Management', 'Analytics'),
(8238, 'Business Intelligence Advanced Techniques', 'Analytics'),
(8239, 'Decision Science & Quantitative Analysis', 'Analytics'),
(8240, 'Financial & Marketing Analytics Integration', 'Analytics'),
(8241, 'Startup Ecosystem & Funding', 'Entrepreneurship'),
(8242, 'Venture Capital & Angel Investment', 'Entrepreneurship'),
(8243, 'Business Model Canvas Advanced', 'Entrepreneurship'),
(8244, 'Innovation Lab & Ideation Techniques', 'Entrepreneurship'),
(8245, 'Growth Hacking & Scaling Strategies', 'Entrepreneurship'),
(8246, 'Social Entrepreneurship Strategies', 'Entrepreneurship'),
(8247, 'Business Feasibility & Market Validation', 'Entrepreneurship'),
(8248, 'Intellectual Property & Patent Basics', 'Entrepreneurship'),
(8249, 'Entrepreneurial Risk Management', 'Entrepreneurship'),
(8250, 'Lean Startup Methodology', 'Entrepreneurship'),
(8251, 'Executive Communication Skills', 'Professional'),
(8252, 'Influence & Negotiation at Executive Level', 'Professional'),
(8253, 'Strategic Leadership & Vision', 'Professional'),
(8254, 'Ethical Decision Making in Complex Scenarios', 'Professional'),
(8255, 'Presentation & Public Speaking for Leaders', 'Professional'),
(8256, 'Critical Thinking for Strategic Decisions', 'Professional'),
(8257, 'Emotional Intelligence & Leadership', 'Professional'),
(8258, 'Time Management & Productivity Optimization', 'Professional'),
(8259, 'Networking & Professional Relationship Management', 'Professional'),
(8260, 'Conflict Management & Mediation Advanced', 'Professional'),
(8261, 'Global Business Simulation Project', 'Project-Based'),
(8262, 'Digital Transformation Project', 'Project-Based'),
(8263, 'Advanced Marketing Analytics Project', 'Project-Based'),
(8264, 'Finance & Investment Analysis Project', 'Project-Based'),
(8265, 'HR Analytics & Workforce Planning Project', 'Project-Based'),
(8266, 'Operations Optimization Project', 'Project-Based'),
(8267, 'Entrepreneurship Startup Project Advanced', 'Project-Based'),
(8268, 'Supply Chain & Logistics Project Advanced', 'Project-Based'),
(8269, 'Innovation & Product Development Project', 'Project-Based'),
(8270, 'Capstone Management Internship Project Advanced', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_mechanical_skills`
--

CREATE TABLE `hnd_mechanical_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_mechanical_skills`
--

INSERT INTO `hnd_mechanical_skills` (`id`, `skill_name`, `category`) VALUES
(9001, 'Engineering Mechanics', 'Core'),
(9002, 'Strength of Materials', 'Core'),
(9003, 'Fluid Mechanics', 'Core'),
(9004, 'Thermodynamics', 'Core'),
(9005, 'Heat Transfer', 'Core'),
(9006, 'Dynamics & Vibrations', 'Core'),
(9007, 'Material Science & Metallurgy', 'Core'),
(9008, 'Mechanical Measurements & Metrology', 'Core'),
(9009, 'Applied Mechanics', 'Core'),
(9010, 'Mechanical Systems Design', 'Core'),
(9011, 'Manufacturing Processes', 'Manufacturing'),
(9012, 'CNC Machining & Programming', 'Manufacturing'),
(9013, 'Metal Casting & Forming', 'Manufacturing'),
(9014, 'Welding Technology', 'Manufacturing'),
(9015, 'Machining & Tooling', 'Manufacturing'),
(9016, 'Additive Manufacturing / 3D Printing', 'Manufacturing'),
(9017, 'Maintenance & Reliability Engineering', 'Manufacturing'),
(9018, 'Production Planning & Control', 'Manufacturing'),
(9019, 'Quality Assurance & Control', 'Manufacturing'),
(9020, 'Lean Manufacturing Techniques', 'Manufacturing'),
(9021, 'Computer-Aided Design (CAD)', 'Design'),
(9022, 'SolidWorks Design', 'Design'),
(9023, 'CATIA Modeling', 'Design'),
(9024, 'AutoCAD Mechanical Drafting', 'Design'),
(9025, 'Finite Element Analysis (FEA)', 'Design'),
(9026, 'Mechanical Component Design', 'Design'),
(9027, 'Product Lifecycle Management (PLM)', 'Design'),
(9028, 'Assembly Design & Simulation', 'Design'),
(9029, 'HVAC System Design', 'Design'),
(9030, 'Automobile Component Design', 'Design'),
(9031, 'Vehicle Dynamics & Handling', 'Automotive'),
(9032, 'Internal Combustion Engine Design', 'Automotive'),
(9033, 'Powertrain & Transmission Systems', 'Automotive'),
(9034, 'Automotive Electronics', 'Automotive'),
(9035, 'Automotive Safety Systems', 'Automotive'),
(9036, 'Automobile Materials & Manufacturing', 'Automotive'),
(9037, 'Thermal Systems in Vehicles', 'Automotive'),
(9038, 'Automotive Design Principles', 'Automotive'),
(9039, 'Fuel & Emission Systems', 'Automotive'),
(9040, 'CAD for Automotive Engineering', 'Automotive'),
(9041, 'HVAC Systems Analysis', 'Thermofluids'),
(9042, 'Renewable Energy Systems', 'Thermofluids'),
(9043, 'Energy Conversion Systems', 'Thermofluids'),
(9044, 'Refrigeration & Air Conditioning', 'Thermofluids'),
(9045, 'Fluid Power & Hydraulic Systems', 'Thermofluids'),
(9046, 'Heat Exchanger Design', 'Thermofluids'),
(9047, 'Thermal System Optimization', 'Thermofluids'),
(9048, 'Combustion & Engine Thermodynamics', 'Thermofluids'),
(9049, 'Pump & Turbine Analysis', 'Thermofluids'),
(9050, 'Thermal Energy Storage Systems', 'Thermofluids'),
(9051, 'PLC Programming', 'Control'),
(9052, 'SCADA Systems', 'Control'),
(9053, 'Control Systems Engineering', 'Control'),
(9054, 'Sensors & Actuators', 'Control'),
(9055, 'Mechatronics Systems', 'Control'),
(9056, 'Microcontroller-Based Systems', 'Control'),
(9057, 'Automation & Robotics', 'Control'),
(9058, 'Electrical Machines & Drives', 'Control'),
(9059, 'Power Electronics Applications', 'Control'),
(9060, 'Embedded Systems Integration', 'Control'),
(9061, 'Project Planning & Management', 'Professional'),
(9062, 'Engineering Economics', 'Professional'),
(9063, 'Technical Report Writing', 'Professional'),
(9064, 'Teamwork & Leadership Skills', 'Professional'),
(9065, 'Problem Solving & Decision Making', 'Professional'),
(9066, 'Industrial Safety & Standards', 'Professional'),
(9067, 'Engineering Ethics', 'Professional'),
(9068, 'Workshop & Lab Management', 'Professional'),
(9069, 'Internship & Industrial Training', 'Professional'),
(9070, 'Capstone Mechanical Engineering Project', 'Professional'),
(9071, 'Advanced SolidWorks Simulation', 'Design'),
(9072, 'Finite Element Analysis (FEA) Advanced', 'Design'),
(9073, 'Computational Fluid Dynamics (CFD)', 'Design'),
(9074, 'Multibody Dynamics Simulation', 'Design'),
(9075, '3D Modeling & Rendering Techniques', 'Design'),
(9076, 'Topology Optimization in Design', 'Design'),
(9077, 'Stress Analysis & Fatigue Life Prediction', 'Design'),
(9078, 'Kinematics & Mechanism Design', 'Design'),
(9079, 'Ergonomic & Human-Centered Design', 'Design'),
(9080, 'Mechanical Design for Manufacturability', 'Design'),
(9081, 'Industry 4.0 in Manufacturing', 'Manufacturing'),
(9082, 'Additive Manufacturing Advanced Techniques', 'Manufacturing'),
(9083, 'Robotic Welding & Automation', 'Manufacturing'),
(9084, 'Precision Machining & Tooling', 'Manufacturing'),
(9085, 'Lean & Six Sigma Implementation', 'Manufacturing'),
(9086, 'Industrial Maintenance & Reliability Engineering', 'Manufacturing'),
(9087, 'Smart Factory & Automation Systems', 'Manufacturing'),
(9088, 'Quality Control & Advanced Metrology', 'Manufacturing'),
(9089, 'Advanced Casting & Forming Processes', 'Manufacturing'),
(9090, 'Production Scheduling & Optimization', 'Manufacturing'),
(9091, 'Electric Vehicle (EV) Systems', 'Automotive'),
(9092, 'Hybrid Vehicle Design & Integration', 'Automotive'),
(9093, 'Automotive Powertrain Optimization', 'Automotive'),
(9094, 'Vehicle Dynamics Simulation', 'Automotive'),
(9095, 'Advanced Engine Performance Tuning', 'Automotive'),
(9096, 'Automotive Electronics & ECUs', 'Automotive'),
(9097, 'Autonomous Vehicle Systems Basics', 'Automotive'),
(9098, 'Fuel Efficiency & Emission Control', 'Automotive'),
(9099, 'Advanced Transmission Systems', 'Automotive'),
(9100, 'Automotive Safety & Crash Analysis', 'Automotive'),
(9101, 'Renewable Energy Systems Design', 'Thermofluids'),
(9102, 'Advanced HVAC System Simulation', 'Thermofluids'),
(9103, 'Heat Exchanger Network Optimization', 'Thermofluids'),
(9104, 'Turbomachinery Design & Analysis', 'Thermofluids'),
(9105, 'Combustion Analysis & Engine Thermodynamics', 'Thermofluids'),
(9106, 'Solar Thermal & PV System Integration', 'Thermofluids'),
(9107, 'Energy Efficiency & Sustainability in Systems', 'Thermofluids'),
(9108, 'Computational Heat Transfer Modeling', 'Thermofluids'),
(9109, 'Cryogenics & Low-Temperature Engineering', 'Thermofluids'),
(9110, 'Thermal Energy Storage Design', 'Thermofluids'),
(9111, 'Advanced PLC & SCADA Programming', 'Control'),
(9112, 'Robotics & Mechatronics Integration', 'Control'),
(9113, 'Industrial Automation Systems', 'Control'),
(9114, 'IoT-Based Monitoring Systems', 'Control'),
(9115, 'Control System Design & Tuning', 'Control'),
(9116, 'Sensor Networks & Actuator Systems', 'Control'),
(9117, 'Embedded Systems for Mechanical Applications', 'Control'),
(9118, 'Industrial Electrical Drives & Motor Control', 'Control'),
(9119, 'Automation Safety Protocols', 'Control'),
(9120, 'Predictive Maintenance using IoT', 'Control'),
(9121, 'Industrial Project Management', 'Professional'),
(9122, 'Lean & Agile Methodologies in Engineering', 'Professional'),
(9123, 'Technical Report Writing Advanced', 'Professional'),
(9124, 'Engineering Cost Analysis & Budgeting', 'Professional'),
(9125, 'Leadership & Team Management in Industry', 'Professional'),
(9126, 'Problem-Solving & Decision Making in Projects', 'Professional'),
(9127, 'Workshop, Lab & Safety Management', 'Professional'),
(9128, 'Entrepreneurship in Mechanical Engineering', 'Professional'),
(9129, 'Internship & Industrial Training Advanced', 'Professional'),
(9130, 'Capstone Industrial Engineering Project', 'Professional'),
(9131, 'Artificial Intelligence in Mechanical Systems', 'Technology'),
(9132, 'Machine Learning for Predictive Maintenance', 'Technology'),
(9133, 'Digital Twin Technology in Manufacturing', 'Technology'),
(9134, 'Automation & Smart Manufacturing', 'Technology'),
(9135, '3D Printing & Additive Manufacturing Advanced', 'Technology'),
(9136, 'IoT-Based Smart Factory Solutions', 'Technology'),
(9137, 'Sustainable Engineering Practices', 'Technology'),
(9138, 'Advanced Vehicle Electrification', 'Technology'),
(9139, 'Human-Machine Interaction in Robotics', 'Technology'),
(9140, 'Industrial Big Data Analytics', 'Technology');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_quantity_survey_skills`
--

CREATE TABLE `hnd_quantity_survey_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_quantity_survey_skills`
--

INSERT INTO `hnd_quantity_survey_skills` (`id`, `skill_name`, `category`) VALUES
(12001, 'Building Materials Knowledge', 'Construction Technology'),
(12002, 'Construction Methods & Techniques', 'Construction Technology'),
(12003, 'Structural Systems Understanding', 'Construction Technology'),
(12004, 'Concrete Technology', 'Construction Technology'),
(12005, 'Steel Structures & Reinforcement', 'Construction Technology'),
(12006, 'Masonry & Brickwork Techniques', 'Construction Technology'),
(12007, 'Roofing & Flooring Systems', 'Construction Technology'),
(12008, 'Sustainable Construction Practices', 'Construction Technology'),
(12009, 'Building Services Coordination', 'Construction Technology'),
(12010, 'Construction Site Safety', 'Construction Technology'),
(12011, 'Building Measurement Techniques', 'Measurement & Estimating'),
(12012, 'Quantity Take-Off', 'Measurement & Estimating'),
(12013, 'Bill of Quantities Preparation', 'Measurement & Estimating'),
(12014, 'Unit Cost Analysis', 'Measurement & Estimating'),
(12015, 'Rate Analysis', 'Measurement & Estimating'),
(12016, 'Estimating for Civil Works', 'Measurement & Estimating'),
(12017, 'Estimating for Mechanical & Electrical Works', 'Measurement & Estimating'),
(12018, 'Preliminary Cost Estimates', 'Measurement & Estimating'),
(12019, 'Tender Document Analysis', 'Measurement & Estimating'),
(12020, 'Cost Reporting Techniques', 'Measurement & Estimating'),
(12021, 'Project Cost Planning', 'Cost Control'),
(12022, 'Budget Management', 'Cost Control'),
(12023, 'Cost Monitoring & Reporting', 'Cost Control'),
(12024, 'Value Engineering', 'Cost Control'),
(12025, 'Cash Flow Forecasting', 'Cost Control'),
(12026, 'Life Cycle Cost Analysis', 'Cost Control'),
(12027, 'Construction Economics', 'Cost Control'),
(12028, 'Financial Risk Analysis', 'Cost Control'),
(12029, 'Cost-Benefit Analysis', 'Cost Control'),
(12030, 'Cost Optimization Strategies', 'Cost Control'),
(12031, 'Construction Contract Types', 'Contracts & Procurement'),
(12032, 'Contract Administration', 'Contracts & Procurement'),
(12033, 'Procurement Methods', 'Contracts & Procurement'),
(12034, 'Tendering Procedures', 'Contracts & Procurement'),
(12035, 'Subcontractor Management', 'Contracts & Procurement'),
(12036, 'Legal Compliance in Contracts', 'Contracts & Procurement'),
(12037, 'Claims & Dispute Resolution', 'Contracts & Procurement'),
(12038, 'Contract Negotiation Skills', 'Contracts & Procurement'),
(12039, 'FIDIC Contract Knowledge', 'Contracts & Procurement'),
(12040, 'Contract Documentation', 'Contracts & Procurement'),
(12041, 'Construction Project Planning', 'Project Management'),
(12042, 'Project Scheduling (Gantt, CPM, PERT)', 'Project Management'),
(12043, 'Resource Allocation & Management', 'Project Management'),
(12044, 'Project Monitoring & Reporting', 'Project Management'),
(12045, 'Risk Management in Construction', 'Project Management'),
(12046, 'Project Coordination Skills', 'Project Management'),
(12047, 'Time Management for Projects', 'Project Management'),
(12048, 'Project Leadership', 'Project Management'),
(12049, 'Construction Logistics Planning', 'Project Management'),
(12050, 'Stakeholder Management', 'Project Management'),
(12051, 'Building Codes & Regulations', 'Legal & Regulatory'),
(12052, 'Planning Permissions', 'Legal & Regulatory'),
(12053, 'Occupational Safety & Health Regulations', 'Legal & Regulatory'),
(12054, 'Environmental Regulations', 'Legal & Regulatory'),
(12055, 'Construction Law Basics', 'Legal & Regulatory'),
(12056, 'Contract Law in Construction', 'Legal & Regulatory'),
(12057, 'Tendering Law & Compliance', 'Legal & Regulatory'),
(12058, 'Dispute Resolution in Construction', 'Legal & Regulatory'),
(12059, 'Insurance in Construction Projects', 'Legal & Regulatory'),
(12060, 'Health & Safety Audits', 'Legal & Regulatory'),
(12061, 'Site Measurement & Surveying', 'Surveying'),
(12062, 'Topographical Survey', 'Surveying'),
(12063, 'Setting Out & Alignment', 'Surveying'),
(12064, 'Site Inspection & Reporting', 'Surveying'),
(12065, 'Geotechnical Awareness', 'Surveying'),
(12066, 'Monitoring Construction Progress', 'Surveying'),
(12067, 'Site Safety Management', 'Surveying'),
(12068, 'Equipment & Materials Tracking', 'Surveying'),
(12069, 'Site Supervision Skills', 'Surveying'),
(12070, 'Quality Control on Site', 'Surveying'),
(12071, 'AutoCAD for QS', 'Software'),
(12072, 'Revit Quantity Take-Off', 'Software'),
(12073, 'Primavera P6', 'Software'),
(12074, 'Microsoft Project', 'Software'),
(12075, 'CostX Software', 'Software'),
(12076, 'Bluebeam Revu', 'Software'),
(12077, 'Excel for QS Calculations', 'Software'),
(12078, 'BIM for Quantity Surveying', 'Software'),
(12079, 'Project Management Software', 'Software'),
(12080, 'Construction Analytics Tools', 'Software'),
(12081, 'Green Building Standards', 'Sustainability'),
(12082, 'Sustainable Material Selection', 'Sustainability'),
(12083, 'Energy Efficient Building Design', 'Sustainability'),
(12084, 'LEED / BREEAM Certification Knowledge', 'Sustainability'),
(12085, 'Environmental Impact Assessment', 'Sustainability'),
(12086, 'Waste Minimization in Construction', 'Sustainability'),
(12087, 'Sustainable Site Management', 'Sustainability'),
(12088, 'Carbon Footprint Analysis', 'Sustainability'),
(12089, 'Renewable Energy in Buildings', 'Sustainability'),
(12090, 'Sustainable Cost Planning', 'Sustainability'),
(12091, 'Teamwork in Construction Projects', 'Soft Skills'),
(12092, 'Communication Skills', 'Soft Skills'),
(12093, 'Negotiation & Persuasion Skills', 'Soft Skills'),
(12094, 'Problem Solving & Decision Making', 'Soft Skills'),
(12095, 'Leadership & Supervision', 'Soft Skills'),
(12096, 'Time Management', 'Soft Skills'),
(12097, 'Conflict Resolution', 'Soft Skills'),
(12098, 'Professional Ethics', 'Soft Skills'),
(12099, 'Presentation Skills', 'Soft Skills'),
(12100, 'Client Relationship Management', 'Soft Skills'),
(12101, 'Quantity Surveying Internship', 'Project-Based'),
(12102, 'Cost Planning Project', 'Project-Based'),
(12103, 'Construction Estimating Project', 'Project-Based'),
(12104, 'Contract Administration Project', 'Project-Based'),
(12105, 'Site Supervision Project', 'Project-Based'),
(12106, 'BIM Quantity Take-Off Project', 'Project-Based'),
(12107, 'Project Scheduling Simulation', 'Project-Based'),
(12108, 'Tender Documentation Project', 'Project-Based'),
(12109, 'Value Engineering Project', 'Project-Based'),
(12110, 'Sustainability Assessment Project', 'Project-Based'),
(12111, 'Advanced Quantity Take-Off Techniques', 'Measurement & Estimating'),
(12112, 'Civil Works Estimation', 'Measurement & Estimating'),
(12113, 'Mechanical & Electrical Estimation', 'Measurement & Estimating'),
(12114, 'Rate Analysis for Specialized Works', 'Measurement & Estimating'),
(12115, 'Preliminary and Detailed Estimates', 'Measurement & Estimating'),
(12116, 'Cost Plan Preparation', 'Measurement & Estimating'),
(12117, 'Unit Rate Database Management', 'Measurement & Estimating'),
(12118, 'Estimating for High-Rise Buildings', 'Measurement & Estimating'),
(12119, 'Estimating for Industrial Projects', 'Measurement & Estimating'),
(12120, 'Estimating for Infrastructure Projects', 'Measurement & Estimating'),
(12121, 'Life Cycle Costing', 'Cost Control'),
(12122, 'Earned Value Analysis', 'Cost Control'),
(12123, 'Project Financial Performance Analysis', 'Cost Control'),
(12124, 'Cash Flow Analysis for Projects', 'Cost Control'),
(12125, 'Construction Cost Benchmarking', 'Cost Control'),
(12126, 'Cost Risk Assessment', 'Cost Control'),
(12127, 'Contingency Planning', 'Cost Control'),
(12128, 'Value Engineering Applications', 'Cost Control'),
(12129, 'Cost Control in Design Phase', 'Cost Control'),
(12130, 'Cost Control in Construction Phase', 'Cost Control'),
(12131, 'Advanced FIDIC Contracts', 'Contracts & Procurement'),
(12132, 'NEC Contract Management', 'Contracts & Procurement'),
(12133, 'JCT Contract Knowledge', 'Contracts & Procurement'),
(12134, 'Subcontractor Risk Management', 'Contracts & Procurement'),
(12135, 'Claims Preparation & Analysis', 'Contracts & Procurement'),
(12136, 'Contract Variations Management', 'Contracts & Procurement'),
(12137, 'Dispute Resolution Techniques', 'Contracts & Procurement'),
(12138, 'Tender Evaluation & Selection', 'Contracts & Procurement'),
(12139, 'Procurement Planning', 'Contracts & Procurement'),
(12140, 'Contract Audit & Compliance', 'Contracts & Procurement'),
(12141, 'Advanced CPM & PERT Scheduling', 'Project Management'),
(12142, 'Resource Leveling Techniques', 'Project Management'),
(12143, 'Critical Path Analysis', 'Project Management'),
(12144, 'Construction Project Risk Management', 'Project Management'),
(12145, 'Project Progress Monitoring', 'Project Management'),
(12146, 'Time-Cost Trade-Off Analysis', 'Project Management'),
(12147, 'Multi-Project Scheduling', 'Project Management'),
(12148, 'Project Coordination & Integration', 'Project Management'),
(12149, 'Project Reporting & Dashboarding', 'Project Management'),
(12150, 'Stakeholder Engagement Planning', 'Project Management'),
(12151, '3D Laser Scanning for QS', 'Surveying'),
(12152, 'BIM Integration in Quantity Surveying', 'Surveying'),
(12153, 'Topographic & Land Surveying', 'Surveying'),
(12154, 'Geotechnical Site Assessment', 'Surveying'),
(12155, 'Construction Layout & Setting Out', 'Surveying'),
(12156, 'As-Built Surveying', 'Surveying'),
(12157, 'Building Condition Surveying', 'Surveying'),
(12158, 'Monitoring & Measurement of Works', 'Surveying'),
(12159, 'Site Safety Inspections', 'Surveying'),
(12160, 'Site Progress Reporting', 'Surveying'),
(12161, 'CostX Advanced Take-Off', 'Software'),
(12162, 'WinQS Software Proficiency', 'Software'),
(12163, 'PlanSwift Quantity Take-Off', 'Software'),
(12164, 'Vico Office Integration', 'Software'),
(12165, 'BIM360 for QS', 'Software'),
(12166, 'AutoCAD Civil 3D', 'Software'),
(12167, 'Revit for Quantity Surveying', 'Software'),
(12168, 'Microsoft Project Advanced', 'Software'),
(12169, 'Primavera P6 Advanced', 'Software'),
(12170, 'Excel for Advanced QS Calculations', 'Software'),
(12171, 'Green Construction Techniques', 'Sustainability'),
(12172, 'Sustainable Material Assessment', 'Sustainability'),
(12173, 'Carbon Footprint Calculation', 'Sustainability'),
(12174, 'Energy Efficiency Assessment', 'Sustainability'),
(12175, 'LEED Certification Processes', 'Sustainability'),
(12176, 'BREEAM Certification Knowledge', 'Sustainability'),
(12177, 'Sustainable Cost Planning', 'Sustainability'),
(12178, 'Waste Minimization in Construction', 'Sustainability'),
(12179, 'Water Efficiency in Construction', 'Sustainability'),
(12180, 'Environmental Impact Analysis', 'Sustainability'),
(12181, 'Leadership in Construction Projects', 'Soft Skills'),
(12182, 'Team Collaboration in Multi-disciplinary Projects', 'Soft Skills'),
(12183, 'Conflict Resolution in Projects', 'Soft Skills'),
(12184, 'Negotiation for Contracts', 'Soft Skills'),
(12185, 'Effective Presentation Skills', 'Soft Skills'),
(12186, 'Professional Ethics in QS', 'Soft Skills'),
(12187, 'Client Communication & Reporting', 'Soft Skills'),
(12188, 'Decision Making under Uncertainty', 'Soft Skills'),
(12189, 'Problem Solving in Complex Projects', 'Soft Skills'),
(12190, 'Time Management for Project Deadlines', 'Soft Skills'),
(12191, 'BIM Quantity Take-Off Internship Project', 'Project-Based'),
(12192, 'Cost Planning & Estimation Project', 'Project-Based'),
(12193, 'Construction Contract Management Project', 'Project-Based'),
(12194, 'Site Supervision & Reporting Project', 'Project-Based'),
(12195, 'Tender Documentation & Evaluation Project', 'Project-Based'),
(12196, 'Project Scheduling & Monitoring Project', 'Project-Based'),
(12197, 'Value Engineering Project', 'Project-Based'),
(12198, 'Sustainability Assessment Project', 'Project-Based'),
(12199, 'Construction Risk Analysis Project', 'Project-Based'),
(12200, 'Capstone Quantity Surveying Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `hnd_thm_skills`
--

CREATE TABLE `hnd_thm_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnd_thm_skills`
--

INSERT INTO `hnd_thm_skills` (`id`, `skill_name`, `category`) VALUES
(10001, 'Front Office Management', 'Front Office'),
(10002, 'Guest Reception', 'Front Office'),
(10003, 'Check-in & Check-out Procedures', 'Front Office'),
(10004, 'Reservation Systems Management', 'Front Office'),
(10005, 'Concierge Services', 'Front Office'),
(10006, 'Customer Complaint Handling', 'Front Office'),
(10007, 'Guest Relations Management', 'Front Office'),
(10008, 'Room Assignment Procedures', 'Front Office'),
(10009, 'Telephone & Communication Skills', 'Front Office'),
(10010, 'Lobby Operations', 'Front Office'),
(10011, 'Housekeeping Management', 'Housekeeping'),
(10012, 'Cleaning Standards & Procedures', 'Housekeeping'),
(10013, 'Laundry Operations', 'Housekeeping'),
(10014, 'Inventory Management (Linen & Supplies)', 'Housekeeping'),
(10015, 'Room Inspection & Quality Control', 'Housekeeping'),
(10016, 'Sanitation & Hygiene Practices', 'Housekeeping'),
(10017, 'Housekeeping Staff Supervision', 'Housekeeping'),
(10018, 'Pest Control & Safety Measures', 'Housekeeping'),
(10019, 'Floor Management', 'Housekeeping'),
(10020, 'Accommodation Operations Management', 'Housekeeping'),
(10021, 'Restaurant Operations', 'Food & Beverage'),
(10022, 'Kitchen Operations', 'Food & Beverage'),
(10023, 'Menu Planning & Development', 'Food & Beverage'),
(10024, 'Food Preparation & Cooking Skills', 'Food & Beverage'),
(10025, 'Beverage Service', 'Food & Beverage'),
(10026, 'Bar Management', 'Food & Beverage'),
(10027, 'Banquet & Catering Management', 'Food & Beverage'),
(10028, 'Food Safety & Hygiene', 'Food & Beverage'),
(10029, 'Inventory & Stock Management', 'Food & Beverage'),
(10030, 'Customer Service in F&B', 'Food & Beverage'),
(10031, 'Event Planning & Coordination', 'Event Management'),
(10032, 'Conference Management', 'Event Management'),
(10033, 'Banquet Operations', 'Event Management'),
(10034, 'Exhibition & Trade Show Planning', 'Event Management'),
(10035, 'Event Budgeting & Cost Control', 'Event Management'),
(10036, 'Vendor & Supplier Management', 'Event Management'),
(10037, 'Event Marketing & Promotion', 'Event Management'),
(10038, 'Guest & VIP Management', 'Event Management'),
(10039, 'Audio-Visual Coordination', 'Event Management'),
(10040, 'Post-Event Evaluation', 'Event Management'),
(10041, 'Tourism Planning & Development', 'Tourism'),
(10042, 'Travel Agency Operations', 'Tourism'),
(10043, 'Tour Packaging & Itinerary Planning', 'Tourism'),
(10044, 'Tour Guiding & Customer Engagement', 'Tourism'),
(10045, 'Transport & Logistics Management', 'Tourism'),
(10046, 'Tourism Marketing', 'Tourism'),
(10047, 'Tourist Safety & Risk Management', 'Tourism'),
(10048, 'Inbound & Outbound Tourism', 'Tourism'),
(10049, 'Cultural & Heritage Tourism', 'Tourism'),
(10050, 'Adventure & Eco-Tourism Operations', 'Tourism'),
(10051, 'Hospitality Marketing', 'Marketing & Sales'),
(10052, 'Sales & Revenue Management', 'Marketing & Sales'),
(10053, 'Digital Marketing for Tourism', 'Marketing & Sales'),
(10054, 'Brand Management', 'Marketing & Sales'),
(10055, 'Customer Relationship Management', 'Marketing & Sales'),
(10056, 'Public Relations & Communication', 'Marketing & Sales'),
(10057, 'Social Media Marketing', 'Marketing & Sales'),
(10058, 'Promotions & Campaigns', 'Marketing & Sales'),
(10059, 'Market Research & Analysis', 'Marketing & Sales'),
(10060, 'Loyalty Programs Management', 'Marketing & Sales'),
(10061, 'Hospitality Accounting', 'Finance & HR'),
(10062, 'Cost Control in F&B', 'Finance & HR'),
(10063, 'Budgeting & Financial Planning', 'Finance & HR'),
(10064, 'Payroll & HR Management', 'Finance & HR'),
(10065, 'Procurement & Vendor Payments', 'Finance & HR'),
(10066, 'Financial Reporting', 'Finance & HR'),
(10067, 'Revenue Forecasting', 'Finance & HR'),
(10068, 'Expense Analysis', 'Finance & HR'),
(10069, 'Audit & Compliance', 'Finance & HR'),
(10070, 'Staff Scheduling & Management', 'Finance & HR'),
(10071, 'Sustainable Hospitality Practices', 'Sustainability'),
(10072, 'Energy & Resource Management', 'Sustainability'),
(10073, 'Waste Management & Recycling', 'Sustainability'),
(10074, 'Eco-Friendly Operations', 'Sustainability'),
(10075, 'Green Certifications (LEED, Green Key)', 'Sustainability'),
(10076, 'CSR in Hospitality', 'Sustainability'),
(10077, 'Community-Based Tourism', 'Sustainability'),
(10078, 'Carbon Footprint Reduction', 'Sustainability'),
(10079, 'Sustainable Event Management', 'Sustainability'),
(10080, 'Responsible Tourism Practices', 'Sustainability'),
(10081, 'Leadership in Hospitality', 'Soft Skills'),
(10082, 'Team Management & Collaboration', 'Soft Skills'),
(10083, 'Conflict Resolution', 'Soft Skills'),
(10084, 'Effective Communication', 'Soft Skills'),
(10085, 'Negotiation Skills', 'Soft Skills'),
(10086, 'Time Management', 'Soft Skills'),
(10087, 'Problem Solving & Decision Making', 'Soft Skills'),
(10088, 'Professional Etiquette', 'Soft Skills'),
(10089, 'Multicultural Awareness', 'Soft Skills'),
(10090, 'Customer Empathy', 'Soft Skills'),
(10091, 'Property Management Systems (PMS)', 'Software'),
(10092, 'Hotel Reservation Software', 'Software'),
(10093, 'POS Systems', 'Software'),
(10094, 'Inventory Management Software', 'Software'),
(10095, 'Financial Software for Hospitality', 'Software'),
(10096, 'Event Management Software', 'Software'),
(10097, 'CRM Software', 'Software'),
(10098, 'Digital Marketing Tools', 'Software'),
(10099, 'Travel Booking Software', 'Software'),
(10100, 'Hospitality Analytics Tools', 'Software'),
(10101, 'Front Office Internship Project', 'Project-Based'),
(10102, 'Housekeeping Internship Project', 'Project-Based'),
(10103, 'F&B Operations Internship Project', 'Project-Based'),
(10104, 'Event Management Internship Project', 'Project-Based'),
(10105, 'Tourism Operations Internship Project', 'Project-Based'),
(10106, 'Marketing & Sales Internship Project', 'Project-Based'),
(10107, 'Finance & HR Internship Project', 'Project-Based'),
(10108, 'Sustainable Hospitality Project', 'Project-Based'),
(10109, 'Hotel Management Simulation Project', 'Project-Based'),
(10110, 'Capstone Tourism & Hospitality Project', 'Project-Based'),
(10111, 'VIP Guest Services', 'Front Office'),
(10112, 'Front Office Revenue Management', 'Front Office'),
(10113, 'Front Desk Operations Audit', 'Front Office'),
(10114, 'Guest Feedback Analysis', 'Front Office'),
(10115, 'Lobby Management Strategies', 'Front Office'),
(10116, 'Telephone Etiquette', 'Front Office'),
(10117, 'Concierge Itinerary Planning', 'Front Office'),
(10118, 'Room Upgrading & Selling', 'Front Office'),
(10119, 'Reservation Forecasting', 'Front Office'),
(10120, 'Lost & Found Management', 'Front Office'),
(10121, 'Room Styling & Interior Design', 'Housekeeping'),
(10122, 'Housekeeping Quality Audits', 'Housekeeping'),
(10123, 'Deep Cleaning Techniques', 'Housekeeping'),
(10124, 'Guest Room Turn-Down Services', 'Housekeeping'),
(10125, 'Inventory Optimization', 'Housekeeping'),
(10126, 'Housekeeping Budget Management', 'Housekeeping'),
(10127, 'Housekeeping SOP Development', 'Housekeeping'),
(10128, 'Laundry Quality Control', 'Housekeeping'),
(10129, 'Eco-Friendly Cleaning Practices', 'Housekeeping'),
(10130, 'Pest Control Management', 'Housekeeping'),
(10131, 'Food Costing & Pricing Strategies', 'Food & Beverage'),
(10132, 'Advanced Wine & Beverage Knowledge', 'Food & Beverage'),
(10133, 'Restaurant Layout Planning', 'Food & Beverage'),
(10134, 'Barista & Coffee Art Skills', 'Food & Beverage'),
(10135, 'Menu Engineering & Analysis', 'Food & Beverage'),
(10136, 'Buffet & Banquet Service Management', 'Food & Beverage'),
(10137, 'Kitchen Hygiene Management', 'Food & Beverage'),
(10138, 'Advanced Culinary Techniques', 'Food & Beverage'),
(10139, 'Food Presentation & Plating', 'Food & Beverage'),
(10140, 'Beverage Inventory Management', 'Food & Beverage'),
(10141, 'Wedding & Social Event Planning', 'Event Management'),
(10142, 'Corporate Event Planning', 'Event Management'),
(10143, 'MICE (Meetings, Incentives, Conferences, Exhibitions) Management', 'Event Management'),
(10144, 'Audio-Visual Equipment Management', 'Event Management'),
(10145, 'Event Security & Safety Planning', 'Event Management'),
(10146, 'Event Sponsorship Management', 'Event Management'),
(10147, 'Exhibition Booth Design', 'Event Management'),
(10148, 'Event Staff Coordination', 'Event Management'),
(10149, 'Event Evaluation & Reporting', 'Event Management'),
(10150, 'Event Budget Optimization', 'Event Management'),
(10151, 'Tour Guiding Techniques', 'Tourism'),
(10152, 'Tourism Policy & Regulations', 'Tourism'),
(10153, 'Destination Marketing', 'Tourism'),
(10154, 'Adventure Tourism Operations', 'Tourism'),
(10155, 'Eco-Tourism Planning', 'Tourism'),
(10156, 'Cultural Tourism Management', 'Tourism'),
(10157, 'Travel Risk Management', 'Tourism'),
(10158, 'Inbound Travel Coordination', 'Tourism'),
(10159, 'Outbound Travel Coordination', 'Tourism'),
(10160, 'Tourism Product Development', 'Tourism'),
(10161, 'Hotel & Resort Branding', 'Marketing & Sales'),
(10162, 'Customer Loyalty Program Development', 'Marketing & Sales'),
(10163, 'Social Media Strategy', 'Marketing & Sales'),
(10164, 'Email Marketing Campaigns', 'Marketing & Sales'),
(10165, 'Search Engine Optimization (SEO) for Hospitality', 'Marketing & Sales'),
(10166, 'Advertising Campaign Planning', 'Marketing & Sales'),
(10167, 'Sales Funnel Management', 'Marketing & Sales'),
(10168, 'Promotional Event Planning', 'Marketing & Sales'),
(10169, 'Reputation Management', 'Marketing & Sales'),
(10170, 'Customer Experience Design', 'Marketing & Sales'),
(10171, 'Hotel Financial Analysis', 'Finance & HR'),
(10172, 'Revenue Management & Forecasting', 'Finance & HR'),
(10173, 'F&B Budget Analysis', 'Finance & HR'),
(10174, 'Payroll Software Management', 'Finance & HR'),
(10175, 'HR Recruitment & Training', 'Finance & HR'),
(10176, 'Cost Control Audits', 'Finance & HR'),
(10177, 'Procurement Optimization', 'Finance & HR'),
(10178, 'Hotel Performance Metrics Analysis', 'Finance & HR'),
(10179, 'Hospitality Taxation', 'Finance & HR'),
(10180, 'Financial Risk Assessment', 'Finance & HR'),
(10181, 'Carbon Footprint Analysis', 'Sustainability'),
(10182, 'Sustainable Supply Chain in Hospitality', 'Sustainability'),
(10183, 'Green Hotel Certification', 'Sustainability'),
(10184, 'Energy Efficient Facility Management', 'Sustainability'),
(10185, 'Sustainable Event Planning', 'Sustainability'),
(10186, 'CSR Project Planning', 'Sustainability'),
(10187, 'Community Engagement in Tourism', 'Sustainability'),
(10188, 'Environmental Compliance', 'Sustainability'),
(10189, 'Waste Minimization Strategies', 'Sustainability'),
(10190, 'Water Conservation Techniques', 'Sustainability'),
(10191, 'Interpersonal Skills', 'Soft Skills'),
(10192, 'Team Leadership & Motivation', 'Soft Skills'),
(10193, 'Cross-Cultural Communication', 'Soft Skills'),
(10194, 'Conflict Management', 'Soft Skills'),
(10195, 'Negotiation & Persuasion Skills', 'Soft Skills'),
(10196, 'Critical Thinking & Problem Solving', 'Soft Skills'),
(10197, 'Professional Writing Skills', 'Soft Skills'),
(10198, 'Presentation & Public Speaking', 'Soft Skills'),
(10199, 'Decision Making in Hospitality', 'Soft Skills'),
(10200, 'Time & Priority Management', 'Soft Skills'),
(10201, 'Oracle OPERA PMS', 'Software'),
(10202, 'Fidelio PMS', 'Software'),
(10203, 'Micros POS System', 'Software'),
(10204, 'Amadeus Global Distribution System', 'Software'),
(10205, 'Sabre Travel Software', 'Software'),
(10206, 'Hotel Inventory Management Software', 'Software'),
(10207, 'Financial Accounting Software', 'Software'),
(10208, 'Digital Event Management Tools', 'Software'),
(10209, 'CRM & Loyalty Program Software', 'Software'),
(10210, 'Hospitality Analytics Tools', 'Software'),
(10211, 'Hotel Operations Internship', 'Project-Based'),
(10212, 'F&B Operations Internship', 'Project-Based'),
(10213, 'Front Office Internship', 'Project-Based'),
(10214, 'Housekeeping Internship', 'Project-Based'),
(10215, 'Event Management Internship', 'Project-Based'),
(10216, 'Tourism Operations Internship', 'Project-Based'),
(10217, 'Sustainable Hospitality Project', 'Project-Based'),
(10218, 'Capstone Project in Hotel Management', 'Project-Based'),
(10219, 'Marketing & Sales Project', 'Project-Based'),
(10220, 'Finance & HR Project', 'Project-Based'),
(10221, 'VIP Guest Handling Techniques', 'Front Office'),
(10222, 'Advanced Reservation Management', 'Front Office'),
(10223, 'Upselling & Revenue Maximization', 'Front Office'),
(10224, 'Guest Loyalty Program Management', 'Front Office'),
(10225, 'Cultural Sensitivity in Guest Services', 'Front Office'),
(10226, 'Multilingual Communication', 'Front Office'),
(10227, 'Front Desk Automation', 'Front Office'),
(10228, 'Check-in & Check-out Software Management', 'Front Office'),
(10229, 'Front Office Performance Reporting', 'Front Office'),
(10230, 'Guest Service Recovery Strategies', 'Front Office'),
(10231, 'Hotel Room Ergonomics', 'Housekeeping'),
(10232, 'Luxury Room Preparation', 'Housekeeping'),
(10233, 'Special Cleaning Techniques', 'Housekeeping'),
(10234, 'Textile & Linen Management', 'Housekeeping'),
(10235, 'Inventory Forecasting for Housekeeping', 'Housekeeping'),
(10236, 'SOP Implementation in Housekeeping', 'Housekeeping'),
(10237, 'Eco-Friendly Housekeeping Techniques', 'Housekeeping'),
(10238, 'Laundry Chemical Management', 'Housekeeping'),
(10239, 'Housekeeping Safety Management', 'Housekeeping'),
(10240, 'Accommodation Quality Standards Audit', 'Housekeeping'),
(10241, 'Advanced Culinary Techniques', 'Food & Beverage'),
(10242, 'Global Cuisine Preparation', 'Food & Beverage'),
(10243, 'Molecular Gastronomy Basics', 'Food & Beverage'),
(10244, 'Garde Manger Techniques', 'Food & Beverage'),
(10245, 'Food & Beverage Cost Control', 'Food & Beverage'),
(10246, 'Advanced Beverage Management', 'Food & Beverage'),
(10247, 'Wine Pairing Techniques', 'Food & Beverage'),
(10248, 'Buffet & Banquet Planning', 'Food & Beverage'),
(10249, 'Kitchen Operations Supervision', 'Food & Beverage'),
(10250, 'Bar & Beverage Analytics', 'Food & Beverage'),
(10251, 'Corporate Event Budgeting', 'Event Management'),
(10252, 'Wedding Planning & Coordination', 'Event Management'),
(10253, 'MICE Event Planning', 'Event Management'),
(10254, 'Exhibition Planning & Management', 'Event Management'),
(10255, 'Event Sponsorship Management', 'Event Management'),
(10256, 'Audio-Visual Coordination', 'Event Management'),
(10257, 'Event Safety & Risk Management', 'Event Management'),
(10258, 'Post-Event Reporting & Evaluation', 'Event Management'),
(10259, 'Virtual & Hybrid Event Management', 'Event Management'),
(10260, 'Event Marketing & PR', 'Event Management'),
(10261, 'Adventure Tourism Planning', 'Tourism'),
(10262, 'Cultural & Heritage Tourism', 'Tourism'),
(10263, 'Tour Guiding Techniques', 'Tourism'),
(10264, 'Inbound & Outbound Tour Operations', 'Tourism'),
(10265, 'Transport & Logistics in Tourism', 'Tourism'),
(10266, 'Tourism Marketing & Promotion', 'Tourism'),
(10267, 'Travel Documentation & Visa Processing', 'Tourism'),
(10268, 'Tourism Risk Management', 'Tourism'),
(10269, 'Tourism Product Development', 'Tourism'),
(10270, 'Sustainable Tourism Practices', 'Tourism'),
(10271, 'Hospitality Digital Marketing', 'Marketing & Sales'),
(10272, 'SEO & Social Media for Hospitality', 'Marketing & Sales'),
(10273, 'CRM System Management', 'Marketing & Sales'),
(10274, 'Customer Retention Strategies', 'Marketing & Sales'),
(10275, 'Loyalty Program Development', 'Marketing & Sales'),
(10276, 'Public Relations in Hospitality', 'Marketing & Sales'),
(10277, 'Brand Management & Positioning', 'Marketing & Sales'),
(10278, 'Advertising & Promotions', 'Marketing & Sales'),
(10279, 'Market Analysis & Research', 'Marketing & Sales'),
(10280, 'Revenue Optimization Techniques', 'Marketing & Sales'),
(10281, 'Hotel Accounting & Reporting', 'Finance & HR'),
(10282, 'Cost Control in F&B Operations', 'Finance & HR'),
(10283, 'Budget Planning & Forecasting', 'Finance & HR'),
(10284, 'Payroll Management', 'Finance & HR'),
(10285, 'HR Recruitment & Training', 'Finance & HR'),
(10286, 'Financial Risk Assessment', 'Finance & HR'),
(10287, 'Vendor Payment Management', 'Finance & HR'),
(10288, 'Audit & Compliance', 'Finance & HR'),
(10289, 'Revenue & Expense Analysis', 'Finance & HR'),
(10290, 'Financial Software in Hospitality', 'Finance & HR'),
(10291, 'Sustainable Hotel Management', 'Sustainability'),
(10292, 'Energy Efficiency Management', 'Sustainability'),
(10293, 'Water & Waste Management', 'Sustainability'),
(10294, 'Green Certifications (LEED, Green Key)', 'Sustainability'),
(10295, 'Community-Based Tourism', 'Sustainability'),
(10296, 'CSR Project Planning', 'Sustainability'),
(10297, 'Sustainable Event Planning', 'Sustainability'),
(10298, 'Carbon Footprint Reduction', 'Sustainability'),
(10299, 'Eco-Friendly Tourism Practices', 'Sustainability'),
(10300, 'Environmental Compliance in Hospitality', 'Sustainability'),
(10301, 'Team Leadership & Motivation', 'Soft Skills'),
(10302, 'Conflict Resolution Strategies', 'Soft Skills'),
(10303, 'Cross-Cultural Communication', 'Soft Skills'),
(10304, 'Professional Etiquette', 'Soft Skills'),
(10305, 'Critical Thinking in Hospitality', 'Soft Skills'),
(10306, 'Problem-Solving Skills', 'Soft Skills'),
(10307, 'Decision-Making Skills', 'Soft Skills'),
(10308, 'Time & Priority Management', 'Soft Skills'),
(10309, 'Negotiation Skills', 'Soft Skills'),
(10310, 'Emotional Intelligence', 'Soft Skills'),
(10311, 'Oracle OPERA PMS', 'Software'),
(10312, 'Fidelio PMS', 'Software'),
(10313, 'Micros POS System', 'Software'),
(10314, 'Amadeus GDS Software', 'Software'),
(10315, 'Sabre Global Distribution System', 'Software'),
(10316, 'Trams Hotel Management Software', 'Software'),
(10317, 'Digital Event Management Tools', 'Software'),
(10318, 'CRM & Loyalty Software', 'Software'),
(10319, 'Inventory Management Software', 'Software'),
(10320, 'Hospitality Analytics Tools', 'Software'),
(10321, 'Front Office Internship Project', 'Project-Based'),
(10322, 'Housekeeping Internship Project', 'Project-Based'),
(10323, 'F&B Operations Internship Project', 'Project-Based'),
(10324, 'Event Management Internship Project', 'Project-Based'),
(10325, 'Tourism Operations Internship Project', 'Project-Based'),
(10326, 'Marketing & Sales Internship Project', 'Project-Based'),
(10327, 'Finance & HR Internship Project', 'Project-Based'),
(10328, 'Sustainable Hospitality Project', 'Project-Based'),
(10329, 'Capstone Tourism & Hospitality Project', 'Project-Based'),
(10330, 'Hotel Simulation Project', 'Project-Based');

-- --------------------------------------------------------

--
-- Table structure for table `it_student_skills`
--

CREATE TABLE `it_student_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `it_student_skills`
--

INSERT INTO `it_student_skills` (`id`, `skill_name`, `category`) VALUES
(11001, 'C', 'Programming'),
(11002, 'C++', 'Programming'),
(11003, 'Java', 'Programming'),
(11004, 'Python', 'Programming'),
(11005, 'C#', 'Programming'),
(11006, 'JavaScript', 'Programming'),
(11007, 'TypeScript', 'Programming'),
(11008, 'Dart', 'Programming'),
(11009, 'PHP', 'Programming'),
(11010, 'Go', 'Programming'),
(11011, 'Kotlin', 'Programming'),
(11012, 'Swift', 'Programming'),
(11013, 'Rust', 'Programming'),
(11014, 'R', 'Programming'),
(11015, 'MATLAB', 'Programming'),
(11016, 'HTML', 'Web Development'),
(11017, 'CSS', 'Web Development'),
(11018, 'JavaScript', 'Web Development'),
(11019, 'React.js', 'Web Development'),
(11020, 'Next.js', 'Web Development'),
(11021, 'Angular', 'Web Development'),
(11022, 'Vue.js', 'Web Development'),
(11023, 'Node.js', 'Web Development'),
(11024, 'Express.js', 'Web Development'),
(11025, 'Laravel', 'Web Development'),
(11026, 'Django', 'Web Development'),
(11027, 'Flask', 'Web Development'),
(11028, 'Bootstrap', 'Web Development'),
(11029, 'Tailwind CSS', 'Web Development'),
(11030, 'Flutter', 'Mobile Development'),
(11031, 'React Native', 'Mobile Development'),
(11032, 'Android Studio', 'Mobile Development'),
(11033, 'Kotlin', 'Mobile Development'),
(11034, 'Swift (iOS)', 'Mobile Development'),
(11035, 'MySQL', 'Database'),
(11036, 'PostgreSQL', 'Database'),
(11037, 'MongoDB', 'Database'),
(11038, 'SQLite', 'Database'),
(11039, 'Firebase', 'Database'),
(11040, 'Oracle Database', 'Database'),
(11041, 'Microsoft SQL Server', 'Database'),
(11042, 'AWS', 'Cloud & DevOps'),
(11043, 'Google Cloud', 'Cloud & DevOps'),
(11044, 'Microsoft Azure', 'Cloud & DevOps'),
(11045, 'Docker', 'Cloud & DevOps'),
(11046, 'Kubernetes', 'Cloud & DevOps'),
(11047, 'Git', 'Cloud & DevOps'),
(11048, 'GitHub', 'Cloud & DevOps'),
(11049, 'CI/CD', 'Cloud & DevOps'),
(11050, 'Jenkins', 'Cloud & DevOps'),
(11051, 'Computer Networking', 'Networking'),
(11052, 'Cisco Packet Tracer', 'Networking'),
(11053, 'Network Configuration', 'Networking'),
(11054, 'Firewall Management', 'Networking'),
(11055, 'Cyber Security', 'Security'),
(11056, 'Ethical Hacking', 'Security'),
(11057, 'Penetration Testing', 'Security'),
(11058, 'Wireshark', 'Security'),
(11059, 'Machine Learning', 'AI & Data Science'),
(11060, 'Deep Learning', 'AI & Data Science'),
(11061, 'TensorFlow', 'AI & Data Science'),
(11062, 'PyTorch', 'AI & Data Science'),
(11063, 'Pandas', 'AI & Data Science'),
(11064, 'NumPy', 'AI & Data Science'),
(11065, 'Data Visualization', 'AI & Data Science'),
(11066, 'OpenCV', 'AI & Data Science'),
(11067, 'VS Code', 'Software Tools'),
(11068, 'IntelliJ IDEA', 'Software Tools'),
(11069, 'Eclipse', 'Software Tools'),
(11070, 'PyCharm', 'Software Tools'),
(11071, 'XAMPP', 'Software Tools'),
(11072, 'Figma', 'Software Tools'),
(11073, 'Adobe XD', 'Software Tools'),
(11074, 'Postman', 'Software Tools'),
(11075, 'JIRA', 'Software Tools'),
(11076, 'Windows', 'Operating Systems'),
(11077, 'Linux', 'Operating Systems'),
(11078, 'Ubuntu', 'Operating Systems'),
(11079, 'MacOS', 'Operating Systems'),
(11080, 'Arduino', 'Hardware & IoT'),
(11081, 'Raspberry Pi', 'Hardware & IoT'),
(11082, 'IoT Systems', 'Hardware & IoT'),
(11083, 'Sensor Integration', 'Hardware & IoT'),
(11084, 'Agile Methodologies', 'Other'),
(11085, 'Scrum', 'Other'),
(11086, 'Software Testing', 'Other'),
(11087, 'Unit Testing', 'Other'),
(11088, 'UI/UX Design', 'Other'),
(11089, 'Version Control', 'Other'),
(11090, 'Project Management', 'Other'),
(11091, 'Assembly', 'Programming'),
(11092, 'Bash / Shell Scripting', 'Programming'),
(11093, 'Julia', 'Programming'),
(11094, 'Perl', 'Programming'),
(11095, 'Ruby', 'Programming'),
(11096, 'Objective-C', 'Programming'),
(11097, 'Visual Basic', 'Programming'),
(11098, 'Solidity', 'Programming'),
(11099, 'Svelte', 'Web Development'),
(11100, 'Astro', 'Web Development'),
(11101, 'Nuxt.js', 'Web Development'),
(11102, 'Remix', 'Web Development'),
(11103, 'Strapi', 'Web Development'),
(11104, 'WordPress Development', 'Web Development'),
(11105, 'Webflow', 'Web Development'),
(11106, 'RESTful APIs', 'Web Development'),
(11107, 'GraphQL', 'Web Development'),
(11108, 'WebSocket', 'Web Development'),
(11109, 'Progressive Web Apps (PWA)', 'Web Development'),
(11110, 'Frontend Performance Optimization', 'Web Development'),
(11111, 'Ionic', 'Mobile Development'),
(11112, 'Xamarin', 'Mobile Development'),
(11113, 'SwiftUI', 'Mobile Development'),
(11114, 'Jetpack Compose', 'Mobile Development'),
(11115, 'Mobile UI/UX Design', 'Mobile Development'),
(11116, 'Firebase Cloud Messaging', 'Mobile Development'),
(11117, 'App Store Deployment', 'Mobile Development'),
(11118, 'Redis', 'Database'),
(11119, 'Cassandra', 'Database'),
(11120, 'CouchDB', 'Database'),
(11121, 'Neo4j (Graph Database)', 'Database'),
(11122, 'DynamoDB', 'Database'),
(11123, 'Database Design & Normalization', 'Database'),
(11124, 'Database Optimization & Indexing', 'Database'),
(11125, 'Terraform', 'Cloud & DevOps'),
(11126, 'Ansible', 'Cloud & DevOps'),
(11127, 'Puppet', 'Cloud & DevOps'),
(11128, 'CloudFormation', 'Cloud & DevOps'),
(11129, 'AWS Lambda', 'Cloud & DevOps'),
(11130, 'Cloud Security', 'Cloud & DevOps'),
(11131, 'Cloud Monitoring (Prometheus, Grafana)', 'Cloud & DevOps'),
(11132, 'Nginx', 'Cloud & DevOps'),
(11133, 'Apache', 'Cloud & DevOps'),
(11134, 'Bash Automation', 'Cloud & DevOps'),
(11135, 'Serverless Architecture', 'Cloud & DevOps'),
(11136, 'Network Troubleshooting', 'Networking'),
(11137, 'LAN/WAN Setup', 'Networking'),
(11138, 'VPN Configuration', 'Networking'),
(11139, 'IP Addressing / Subnetting', 'Networking'),
(11140, 'Network Security Monitoring', 'Networking'),
(11141, 'Routing & Switching', 'Networking'),
(11142, 'Cyber Forensics', 'Security'),
(11143, 'Network Security', 'Security'),
(11144, 'Malware Analysis', 'Security'),
(11145, 'Security Auditing', 'Security'),
(11146, 'OWASP Top 10', 'Security'),
(11147, 'Secure Coding Practices', 'Security'),
(11148, 'Cloud Security', 'Security'),
(11149, 'Data Encryption & Decryption', 'Security'),
(11150, 'Scikit-learn', 'AI & Data Science'),
(11151, 'Jupyter Notebook', 'AI & Data Science'),
(11152, 'Big Data Analytics', 'AI & Data Science'),
(11153, 'NLP (Natural Language Processing)', 'AI & Data Science'),
(11154, 'Computer Vision', 'AI & Data Science'),
(11155, 'Reinforcement Learning', 'AI & Data Science'),
(11156, 'AI Model Deployment (ONNX, TensorFlow Serving)', 'AI & Data Science'),
(11157, 'Data Preprocessing & Feature Engineering', 'AI & Data Science'),
(11158, 'Microsoft Power BI', 'Data Analytics'),
(11159, 'Tableau', 'Data Analytics'),
(11160, 'Excel Advanced (Formulas, Pivot Tables, Macros)', 'Data Analytics'),
(11161, 'Google Data Studio', 'Data Analytics'),
(11162, 'Data Cleaning', 'Data Analytics'),
(11163, 'Business Intelligence (BI) Concepts', 'Data Analytics'),
(11164, 'NetBeans', 'Software Tools'),
(11165, 'Sublime Text', 'Software Tools'),
(11166, 'Notepad++', 'Software Tools'),
(11167, 'GitLab', 'Software Tools'),
(11168, 'Bitbucket', 'Software Tools'),
(11169, 'Slack', 'Software Tools'),
(11170, 'Trello', 'Software Tools'),
(11171, 'Asana', 'Software Tools'),
(11172, 'VS Code Extensions', 'Software Tools'),
(11173, 'API Testing Tools (Insomnia, Newman)', 'Software Tools'),
(11174, 'Kali Linux', 'Operating Systems'),
(11175, 'CentOS', 'Operating Systems'),
(11176, 'Fedora', 'Operating Systems'),
(11177, 'Debian', 'Operating Systems'),
(11178, 'Android OS', 'Operating Systems'),
(11179, 'iOS System Management', 'Operating Systems'),
(11180, 'Microcontrollers', 'Hardware & IoT'),
(11181, 'Embedded C', 'Hardware & IoT'),
(11182, 'PCB Design (Proteus, EasyEDA)', 'Hardware & IoT'),
(11183, 'Home Automation', 'Hardware & IoT'),
(11184, 'IoT Cloud Platforms (Blynk, ThingsBoard)', 'Hardware & IoT'),
(11185, 'Sensor Calibration', 'Hardware & IoT'),
(11186, 'Design Thinking', 'Other'),
(11187, 'Software Documentation', 'Other'),
(11188, 'Requirement Analysis', 'Other'),
(11189, 'Version Control (Git branching, Git flow)', 'Other'),
(11190, 'Continuous Integration', 'Other'),
(11191, 'Communication Skills for IT Professionals', 'Other'),
(11192, 'Leadership & Team Collaboration', 'Other'),
(11193, 'Generative AI', 'AI & Data Science'),
(11194, 'ChatGPT API', 'AI & Data Science'),
(11195, 'LangChain', 'AI & Data Science'),
(11196, 'OpenAI API Integration', 'AI & Data Science'),
(11197, 'Hugging Face Transformers', 'AI & Data Science'),
(11198, 'LLM Fine-Tuning', 'AI & Data Science'),
(11199, 'Model Evaluation Metrics', 'AI & Data Science'),
(11200, 'AI Ethics & Explainability', 'AI & Data Science'),
(11201, 'Data Annotation & Labeling', 'AI & Data Science'),
(11202, 'MLOps', 'AI & Data Science'),
(11203, 'Apache Hadoop', 'Data Analytics'),
(11204, 'Apache Spark', 'Data Analytics'),
(11205, 'ETL (Extract, Transform, Load)', 'Data Analytics'),
(11206, 'Airflow', 'Data Analytics'),
(11207, 'Snowflake', 'Data Analytics'),
(11208, 'Data Warehousing', 'Data Analytics'),
(11209, 'Kafka', 'Data Analytics'),
(11210, 'Data Lake Design', 'Data Analytics'),
(11211, 'Blockchain Fundamentals', 'Other'),
(11212, 'Ethereum Development', 'Other'),
(11213, 'Smart Contract Auditing', 'Other'),
(11214, 'Web3.js', 'Other'),
(11215, 'NFT Development', 'Other'),
(11216, 'Decentralized Apps (DApps)', 'Other'),
(11217, 'Metamask Integration', 'Other'),
(11218, 'Solana Development', 'Other'),
(11219, 'AWS EC2', 'Cloud & DevOps'),
(11220, 'AWS S3', 'Cloud & DevOps'),
(11221, 'AWS CloudWatch', 'Cloud & DevOps'),
(11222, 'Google Cloud Functions', 'Cloud & DevOps'),
(11223, 'Azure DevOps', 'Cloud & DevOps'),
(11224, 'Load Balancing', 'Cloud & DevOps'),
(11225, 'Auto Scaling', 'Cloud & DevOps'),
(11226, 'Kubernetes Helm Charts', 'Cloud & DevOps'),
(11227, 'Container Orchestration', 'Cloud & DevOps'),
(11228, 'Burp Suite', 'Security'),
(11229, 'Metasploit Framework', 'Security'),
(11230, 'Social Engineering Awareness', 'Security'),
(11231, 'Phishing Attack Simulation', 'Security'),
(11232, 'Cryptography', 'Security'),
(11233, 'Vulnerability Assessment', 'Security'),
(11234, 'Incident Response', 'Security'),
(11235, 'Digital Forensics', 'Security'),
(11236, 'SIEM Tools (Splunk, ELK)', 'Security'),
(11237, 'Threat Intelligence', 'Security'),
(11238, 'User Research', 'Other'),
(11239, 'Wireframing', 'Other'),
(11240, 'Prototyping', 'Other'),
(11241, 'Design Systems', 'Other'),
(11242, 'Accessibility (A11y)', 'Other'),
(11243, 'Motion Design', 'Other'),
(11244, 'Color Theory', 'Other'),
(11245, 'Typography for Web', 'Other'),
(11246, 'Usability Testing', 'Other'),
(11247, 'Microservices Architecture', 'Other'),
(11248, 'Monolithic vs Modular Systems', 'Other'),
(11249, 'Software Deployment', 'Other'),
(11250, 'Testing Automation', 'Other'),
(11251, 'API Documentation (Swagger, Postman)', 'Other'),
(11252, 'Agile Sprint Planning', 'Other'),
(11253, 'Code Review Practices', 'Other'),
(11254, 'Version Release Management', 'Other'),
(11255, 'Time Management', 'Other'),
(11256, 'Problem-Solving', 'Other'),
(11257, 'Critical Thinking', 'Other'),
(11258, 'Team Collaboration', 'Other'),
(11259, 'Presentation Skills', 'Other'),
(11260, 'Leadership', 'Other'),
(11261, 'Creative Thinking', 'Other'),
(11262, 'Project Planning', 'Other'),
(11263, 'Unity 3D', 'Other'),
(11264, 'Unreal Engine', 'Other'),
(11265, 'ARCore', 'Other'),
(11266, 'ARKit', 'Other'),
(11267, 'Mixed Reality Development', 'Other'),
(11268, '3D Modeling (Blender)', 'Other'),
(11269, 'Robotics Process Automation (RPA)', 'Hardware & IoT'),
(11270, 'ROS (Robot Operating System)', 'Hardware & IoT'),
(11271, 'Industrial IoT', 'Hardware & IoT'),
(11272, 'Automation Control Systems', 'Hardware & IoT'),
(11273, 'PLC Programming', 'Hardware & IoT'),
(11274, 'CNC Programming', 'Hardware & IoT'),
(11275, 'Drone Technology', 'Hardware & IoT'),
(11276, 'Discrete Mathematics', 'Programming'),
(11277, 'Linear Algebra', 'Programming'),
(11278, 'Probability & Statistics', 'Programming'),
(11279, 'Computational Thinking', 'Programming'),
(11280, 'Docker Compose', 'Cloud & DevOps'),
(11281, 'Shell Scripting Automation', 'Cloud & DevOps'),
(11282, 'YAML Configuration', 'Cloud & DevOps'),
(11283, 'CI/CD Pipeline Management', 'Cloud & DevOps'),
(11284, 'Monitoring with Grafana', 'Cloud & DevOps'),
(11285, 'Quantum Computing Basics', 'Other'),
(11286, 'Edge Computing', 'Other'),
(11287, 'Digital Twin Technology', 'Other'),
(11288, '5G Technology', 'Other'),
(11289, 'Green Computing', 'Other'),
(11290, 'Human-Computer Interaction (HCI)', 'Other'),
(11291, 'No-Code / Low-Code Platforms', 'Other'),
(11292, 'Chatbot Development', 'Other'),
(11293, 'AWS ECS', 'Cloud & DevOps'),
(11294, 'AWS CloudTrail', 'Cloud & DevOps'),
(11295, 'Azure Kubernetes Service (AKS)', 'Cloud & DevOps'),
(11296, 'Google Kubernetes Engine (GKE)', 'Cloud & DevOps'),
(11297, 'Cloud Networking', 'Cloud & DevOps'),
(11298, 'Infrastructure as Code (IaC)', 'Cloud & DevOps'),
(11299, 'Monitoring & Logging', 'Cloud & DevOps'),
(11300, 'Cloud Backup & Disaster Recovery', 'Cloud & DevOps'),
(11301, 'Secrets Management (Vault)', 'Cloud & DevOps'),
(11302, 'DevSecOps', 'Cloud & DevOps'),
(11303, 'Container Security', 'Cloud & DevOps'),
(11304, 'D3.js', 'Data Analytics'),
(11305, 'Plotly', 'Data Analytics'),
(11306, 'Matplotlib', 'Data Analytics'),
(11307, 'Seaborn', 'Data Analytics'),
(11308, 'Google Charts', 'Data Analytics'),
(11309, 'Qlik Sense', 'Data Analytics'),
(11310, 'Looker Studio', 'Data Analytics'),
(11311, 'Data Storytelling', 'Data Analytics'),
(11312, 'Dashboard Design', 'Data Analytics'),
(11313, 'ISO 27001', 'Security'),
(11314, 'GDPR Compliance', 'Security'),
(11315, 'NIST Framework', 'Security'),
(11316, 'SOC 2 Compliance', 'Security'),
(11317, 'Vulnerability Management', 'Security'),
(11318, 'Penetration Testing Tools', 'Security'),
(11319, 'Security Incident Management', 'Security'),
(11320, 'Identity and Access Management (IAM)', 'Security'),
(11321, 'Zero Trust Architecture', 'Security'),
(11322, 'MERN Stack', 'Web Development'),
(11323, 'MEAN Stack', 'Web Development'),
(11324, 'LAMP Stack', 'Web Development'),
(11325, 'JAMstack', 'Web Development'),
(11326, 'API Integration', 'Web Development'),
(11327, 'WebSockets', 'Web Development'),
(11328, 'Server-Side Rendering (SSR)', 'Web Development'),
(11329, 'Static Site Generation (SSG)', 'Web Development'),
(11330, 'Cross-Browser Compatibility', 'Web Development'),
(11331, 'Frontend State Management (Redux, Zustand)', 'Web Development'),
(11332, 'Selenium', 'Other'),
(11333, 'Cypress', 'Other'),
(11334, 'Appium', 'Other'),
(11335, 'JUnit', 'Other'),
(11336, 'TestNG', 'Other'),
(11337, 'Postman Test Collections', 'Other'),
(11338, 'QA Automation', 'Other'),
(11339, 'Performance Testing (JMeter)', 'Other'),
(11340, 'Load Testing', 'Other'),
(11341, 'Bug Tracking Systems', 'Other'),
(11342, 'Adobe Photoshop', 'Software Tools'),
(11343, 'Adobe Illustrator', 'Software Tools'),
(11344, 'Canva', 'Software Tools'),
(11345, 'After Effects', 'Software Tools'),
(11346, 'Premiere Pro', 'Software Tools'),
(11347, 'Video Editing', 'Software Tools'),
(11348, 'Animation (2D/3D)', 'Software Tools'),
(11349, 'Motion Graphics', 'Software Tools'),
(11350, 'DNS Management', 'Networking'),
(11351, 'Network Load Balancing', 'Networking'),
(11352, 'Routing Protocols (OSPF, BGP)', 'Networking'),
(11353, 'Wi-Fi Configuration', 'Networking'),
(11354, 'Network Virtualization (SDN)', 'Networking'),
(11355, 'Cloud Networking (VPC)', 'Networking'),
(11356, 'Network Automation (Python, Ansible)', 'Networking'),
(11357, 'Clean Code Principles', 'Programming'),
(11358, 'Design Patterns', 'Programming'),
(11359, 'Object-Oriented Analysis & Design (OOAD)', 'Programming'),
(11360, 'Functional Programming', 'Programming'),
(11361, 'Test-Driven Development (TDD)', 'Programming'),
(11362, 'Version Control Workflows', 'Programming'),
(11363, 'Software Scalability', 'Programming'),
(11364, 'Performance Optimization', 'Programming'),
(11365, 'Debugging & Profiling', 'Programming'),
(11366, 'Midjourney', 'AI & Data Science'),
(11367, 'Stable Diffusion', 'AI & Data Science'),
(11368, 'Runway ML', 'AI & Data Science'),
(11369, 'Google Vertex AI', 'AI & Data Science'),
(11370, 'AutoML', 'AI & Data Science'),
(11371, 'AI-driven Automation', 'AI & Data Science'),
(11372, 'AI Chatbot Development', 'AI & Data Science'),
(11373, 'AI Model Optimization', 'AI & Data Science'),
(11374, 'Bioinformatics Basics', 'AI & Data Science'),
(11375, 'Genomic Data Analysis', 'AI & Data Science'),
(11376, 'Computational Biology', 'AI & Data Science'),
(11377, 'Protein Structure Prediction', 'AI & Data Science'),
(11378, 'Biomedical Image Analysis', 'AI & Data Science'),
(11379, 'Scrum Master Skills', 'Other'),
(11380, 'Kanban', 'Other'),
(11381, 'Risk Management', 'Other'),
(11382, 'Agile Metrics & Reporting', 'Other'),
(11383, 'Change Management', 'Other'),
(11384, 'Stakeholder Management', 'Other'),
(11385, 'Business Analysis', 'Other'),
(11386, 'Resource Allocation', 'Other'),
(11387, 'Neural Interface Technology', 'Other'),
(11388, 'Extended Reality (XR)', 'Other'),
(11389, 'Metaverse Development', 'Other'),
(11390, 'Digital Identity Systems', 'Other'),
(11391, 'Smart City Technologies', 'Other'),
(11392, 'Sustainable Computing', 'Other'),
(11393, 'AI in Healthcare', 'Other'),
(11394, 'AI in Education', 'Other'),
(11395, 'AI in Finance', 'Other'),
(11396, 'IoT in Agriculture', 'Hardware & IoT'),
(11397, 'Smart Wearables', 'Hardware & IoT'),
(11398, 'Edge AI', 'Hardware & IoT'),
(11399, 'Drone Programming', 'Hardware & IoT'),
(11400, 'Smart Home Security', 'Hardware & IoT'),
(11401, 'Ethical Hacking Fundamentals', ''),
(11402, 'Penetration Testing', ''),
(11403, 'Kali Linux Tools', ''),
(11404, 'Metasploit Framework', ''),
(11405, 'Burp Suite', ''),
(11406, 'Wireshark Packet Analysis', ''),
(11407, 'Snort IDS/IPS', ''),
(11408, 'Nmap Scanning', ''),
(11409, 'Social Engineering', ''),
(11410, 'Cryptography', ''),
(11411, 'Hash Cracking (John the Ripper, Hashcat)', ''),
(11412, 'Incident Response', ''),
(11413, 'Digital Forensics', ''),
(11414, 'Threat Intelligence', ''),
(11415, 'SIEM Tools (Splunk, QRadar)', ''),
(11416, 'Firewall Configuration', ''),
(11417, 'IDS/IPS Configuration', ''),
(11418, 'Endpoint Protection', ''),
(11419, 'Phishing Simulation', ''),
(11420, 'Jenkins Pipelines', ''),
(11421, 'Docker Swarm', ''),
(11422, 'Kubernetes Helm Charts', ''),
(11423, 'Continuous Delivery (CD)', ''),
(11424, 'Infrastructure as Code (IaC)', ''),
(11425, 'GitOps', ''),
(11426, 'CI/CD Workflow Automation', ''),
(11427, 'Cloud Cost Optimization', ''),
(11428, 'Container Orchestration', ''),
(11429, 'Load Balancing', ''),
(11430, 'Monitoring & Logging (ELK Stack)', ''),
(11431, 'Secrets Management (Vault, AWS Secrets Manager)', ''),
(11432, 'Blue-Green Deployment', ''),
(11433, 'Canary Deployment', '');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `linkedin` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  `github` varchar(200) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `username`, `nic`, `email`, `mobile`, `linkedin`, `blog`, `github`, `facebook`, `password`, `profile_picture`, `created_at`, `status`, `last_login`) VALUES
(1, 'testLecture', '20002202615', 'testlecture@email.com', '7855309992', '', '', '', '', '$2y$10$/O9H918kgCrK1tKYBQ75QOabj926aEChVzDU3n2u1fDd0v8aC2EnC', 'uploads/profile_pictures/default.png', '2025-10-07 17:00:20', 'approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lectures_assignment`
--

CREATE TABLE `lectures_assignment` (
  `id` int(11) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures_assignment`
--

INSERT INTO `lectures_assignment` (`id`, `lecturer_id`, `subject_id`) VALUES
(1, 1, 6),
(2, 1, 8),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `year` varchar(4) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `practical_marks` int(11) NOT NULL,
  `paper_marks` int(11) NOT NULL,
  `special_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `entered_by_id` int(11) DEFAULT NULL,
  `entered_by_role` enum('admin','lecturer') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `year`, `subject`, `semester`, `practical_marks`, `paper_marks`, `special_notes`, `created_at`, `entered_by_id`, `entered_by_role`) VALUES
(1, 'GAL/IT/2324/F/0014', '2023', 'Visual Application Programming', 'Semester I', 93, 100, '', '2025-05-09 06:21:57', 6, 'lecturer'),
(2, 'GAL/IT/2324/F/0014', '2023', 'Fundamentals of Programming', 'Semester II', 20, 30, '', '2025-05-09 06:22:29', 6, 'lecturer'),
(3, 'gal-it-2023-f-0000', '2023', 'Visual Application Programming', 'Semester I', 90, 90, '', '2025-06-24 07:21:49', 1, 'admin'),
(4, 'gal-it-2023-f-0000', '2023', 'Web Design', 'Semester I', 20, 10, '', '2025-06-24 07:22:09', 1, 'admin'),
(5, 'gal-it-2023-f-0000', '2023', 'Computer and Network Systems', 'Semester I', 50, 40, '', '2025-06-24 07:22:27', 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(255) DEFAULT NULL,
  `report_date` date DEFAULT NULL,
  `report_title` varchar(255) DEFAULT NULL,
  `issue_type` varchar(100) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `reference_link` varchar(255) DEFAULT NULL,
  `priority_level` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `priority` varchar(20) NOT NULL DEFAULT 'low'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reporter_name`, `report_date`, `report_title`, `issue_type`, `issue_description`, `location`, `reference_link`, `priority_level`, `created_at`, `description`, `priority`) VALUES
(1, 'test', '2025-10-17', 'test', 'bug', NULL, 'Sri Lanka', '', NULL, '2025-10-17 08:15:09', 'test', 'high');

-- --------------------------------------------------------

--
-- Table structure for table `report_photos`
--

CREATE TABLE `report_photos` (
  `id` int(11) NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `report_photos`
--

INSERT INTO `report_photos` (`id`, `report_id`, `photo_path`) VALUES
(1, 1, '1760688908_Screenshot 2025-08-15 163452.png'),
(2, 1, '1760688908_Screenshot 2025-08-14 212529.png');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `reg_id` varchar(100) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `study_year` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `github` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'approved',
  `last_login` datetime DEFAULT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `username`, `reg_id`, `nic`, `study_year`, `email`, `mobile`, `facebook`, `github`, `blog`, `linkedin`, `password`, `profile_picture`, `created_at`, `status`, `last_login`, `course_id`) VALUES
(2, 'Malitha Tishamal', 'GAL/IT/2324/F/0009', '200302202615', 2024, 'malithatishamal@gmail.com', '7855309992', '', '', '', '', '$2y$10$3J3aMqUnA9OmkdZcgEVxieCVQdZ/uR/WSuwZ5M1wOPZ1VT9.3bgs6', 'uploads/profile_pictures/default.png', '2025-10-04 15:33:23', 'approved', '2025-10-17 13:28:20', 6);

-- --------------------------------------------------------

--
-- Table structure for table `students_about`
--

CREATE TABLE `students_about` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `about_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students_about`
--

INSERT INTO `students_about` (`id`, `user_id`, `about_text`, `created_at`, `updated_at`) VALUES
(1, 2, 'test2', '2025-10-13 11:11:28', '2025-10-13 11:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `students_achievements`
--

CREATE TABLE `students_achievements` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_name` varchar(255) NOT NULL,
  `organized_by` varchar(255) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_certifications`
--

CREATE TABLE `students_certifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `certification_name` varchar(255) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `certification_description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_education`
--

CREATE TABLE `students_education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school` varchar(255) NOT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_month` varchar(20) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_month` varchar(20) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `activities` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_education`
--

INSERT INTO `students_education` (`id`, `user_id`, `school`, `degree`, `field_of_study`, `start_month`, `start_year`, `end_month`, `end_year`, `grade`, `activities`, `description`, `updated_at`) VALUES
(9, 2, 'SLIATE', 'HNDIT', 'Infromation Technology', 'January', 2025, NULL, NULL, '', '', '', '2025-10-13 14:20:52'),
(10, 2, 'SLIATE', 'test', 'Infromation Technology', 'January', 2024, 'November', 2025, '', '', '', '2025-10-13 14:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `students_experiences`
--

CREATE TABLE `students_experiences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `employment_type` enum('Full-time','Part-time','Internship','Freelance','Volunteer') NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `currently_working` tinyint(1) DEFAULT 0,
  `start_month` varchar(20) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_month` varchar(20) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `job_source` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students_experiences`
--

INSERT INTO `students_experiences` (`id`, `user_id`, `title`, `employment_type`, `company`, `location`, `currently_working`, `start_month`, `start_year`, `end_month`, `end_year`, `description`, `job_source`, `created_at`, `updated_at`) VALUES
(2, 2, 'test', 'Full-time', 'test', 'Sri Lanka', 0, 'January', 2024, 'February', 2025, 'test', 'Referral', '2025-10-13 11:24:18', '2025-10-13 12:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `students_summaries`
--

CREATE TABLE `students_summaries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `summary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students_summaries`
--

INSERT INTO `students_summaries` (`id`, `user_id`, `summary`, `created_at`, `updated_at`) VALUES
(1, 2, 'test2', '2025-10-13 11:11:34', '2025-10-13 11:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `course` varchar(255) NOT NULL DEFAULT 'Higher National Diploma in Information Technology - (HNDIT)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `semester`, `code`, `name`, `description`, `course`) VALUES
(1, 'Semester I', 'HNDIT1012', 'Visual Application Programming', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(2, 'Semester I', 'HNDIT1022', 'Web Design', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(3, 'Semester I', 'HNDIT1032', 'Computer and Network Systems', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(4, 'Semester I', 'HNDIT1042', 'Information Management and Information Systems', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(5, 'Semester I', 'HNDIT1052', 'ICT Project (Individual)', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(6, 'Semester I', 'HNDIT1062', 'Communication Skills', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(7, 'Semester II', 'HNDIT2012', 'Fundamentals of Programming', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(8, 'Semester II', 'HNDIT2022', 'Software Development', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(9, 'Semester II', 'HNDIT2032', 'System Analysis and Design', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(10, 'Semester II', 'HNDIT2042', 'Data communication and Computer Networks', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(11, 'Semester II', 'HNDIT2052', 'Principles of User Interface Design', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(12, 'Semester II', 'HNDIT2062', 'ICT Project (Group)', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(13, 'Semester II', 'HNDIT2072', 'Technical Writing', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(14, 'Semester II', 'HNDIT2082', 'Human Value & Professional Ethics', 'Core | NGPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(15, 'Semester III', 'HNDIT3012', 'Object Oriented Programming', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(16, 'Semester III', 'HNDIT3022', 'Web Programming', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(17, 'Semester III', 'HNDIT3032', 'Data Structures and Algorithms', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(18, 'Semester III', 'HNDIT3042', 'Database Management Systems', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(19, 'Semester III', 'HNDIT3052', 'Operating Systems', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(20, 'Semester III', 'HNDIT3062', 'Information and Computer Security', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(21, 'Semester III', 'HNDIT3072', 'Statistics for IT', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(22, 'Semester IV', 'HNDIT4012', 'Software Engineering', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(23, 'Semester IV', 'HNDIT4022', 'Software Quality Assurance', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(24, 'Semester IV', 'HNDIT4032', 'IT Project Management', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(25, 'Semester IV', 'HNDIT4042', 'Professional World', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(26, 'Semester IV', 'HNDIT4052', 'Programming Individual Project', 'Core | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(27, 'Semester IV', 'HNDIT4212', 'Machine Learning', 'Elective | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(28, 'Semester IV', 'HNDIT4222', 'Business Analysis Practice', 'Elective | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(29, 'Semester IV', 'HNDIT4232', 'Enterprise Architecture', 'Elective | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(30, 'Semester IV', 'HNDIT4242', 'Computer Services Management', 'Elective | GPA', 'Higher National Diploma in Information Technology - (HNDIT)'),
(31, 'Semester I', 'EN 1111', 'Reading & Vocabulary Development', 'GPA', 'Higher National Diploma in English'),
(32, 'Semester I', 'EN 1112', 'Effective Communication Skills I', 'GPA', 'Higher National Diploma in English'),
(33, 'Semester I', 'EN 1113', 'Listening Skills I', 'GPA', 'Higher National Diploma in English'),
(34, 'Semester I', 'EN 1114', 'Language Structure, Usage & Linguistics I', 'GPA', 'Higher National Diploma in English'),
(35, 'Semester I', 'EN 1115', 'Introduction to Literature', 'GPA', 'Higher National Diploma in English'),
(36, 'Semester I', 'EN 1116', 'Professional Writing I', 'GPA', 'Higher National Diploma in English'),
(37, 'Semester I', 'EN 1117', 'Computer Assisted Language Learning & Study Skills I', 'NGPA', 'Higher National Diploma in English'),
(38, 'Semester II', 'EN 1211', 'Intermediate Reading & Vocabulary Development', 'GPA', 'Higher National Diploma in English'),
(39, 'Semester II', 'EN 1212', 'Effective Communication Skills II', 'GPA', 'Higher National Diploma in English'),
(40, 'Semester II', 'EN 1213', 'Listening Skills II', 'GPA', 'Higher National Diploma in English'),
(41, 'Semester II', 'EN 1214', 'Language Structure, Usage & Linguistics II', 'GPA', 'Higher National Diploma in English'),
(42, 'Semester II', 'EN 1215', 'British & American Literature', 'GPA', 'Higher National Diploma in English'),
(43, 'Semester II', 'EN 1216', 'Professional Writing II', 'GPA', 'Higher National Diploma in English'),
(44, 'Semester II', 'EN 1217', 'Computer Assisted Language Learning & Study Skills II', 'NGPA', 'Higher National Diploma in English'),
(45, 'Semester III', 'EN 2111', 'Advanced Reading & Vocabulary Development I', 'GPA', 'Higher National Diploma in English'),
(46, 'Semester III', 'EN 2112', 'Technology based Communication Skills', 'GPA', 'Higher National Diploma in English'),
(47, 'Semester III', 'EN 2113', 'Language Structure, Usage & Linguistics III', 'GPA', 'Higher National Diploma in English'),
(48, 'Semester III', 'EN 2114', 'Commonwealth Literature', 'GPA', 'Higher National Diploma in English'),
(49, 'Semester III', 'EN 2115', 'Professional Writing III', 'GPA', 'Higher National Diploma in English'),
(50, 'Semester III', 'EN 2116', 'Research Methodology', 'GPA', 'Higher National Diploma in English'),
(51, 'Semester III', 'EN 2117', 'English Language Teaching Methodology I', 'GPA', 'Higher National Diploma in English'),
(52, 'Semester III', 'EN 2118', 'Fundamental Business English I', 'GPA', 'Higher National Diploma in English'),
(53, 'Semester III', 'EN 2119', 'Fundamental Journalism I', 'GPA', 'Higher National Diploma in English'),
(54, 'Semester IV', 'EN 2211', 'Advanced Reading & Vocabulary Development II', 'GPA', 'Higher National Diploma in English'),
(55, 'Semester IV', 'EN 2212', 'Language Structure, Usage & Linguistics IV', 'GPA', 'Higher National Diploma in English'),
(56, 'Semester IV', 'EN 2213', 'Sri Lankan Literature', 'GPA', 'Higher National Diploma in English'),
(57, 'Semester IV', 'EN 2214', 'Advanced Professional Writing', 'GPA', 'Higher National Diploma in English'),
(58, 'Semester IV', 'EN 2215', 'English Language Teaching Methodology II', 'GPA', 'Higher National Diploma in English'),
(59, 'Semester IV', 'EN 2216', 'Fundamental Business English II', 'GPA', 'Higher National Diploma in English'),
(60, 'Semester IV', 'EN 2217', 'Fundamental Journalism II', 'GPA', 'Higher National Diploma in English'),
(61, 'Semester IV', 'EN 2218', 'Principles of Education', 'GPA', 'Higher National Diploma in English'),
(62, 'Semester IV', 'EN 2219', 'Intermediate Business English', 'GPA', 'Higher National Diploma in English'),
(63, 'Semester IV', 'EN 2220', 'Intermediate Journalism', 'GPA', 'Higher National Diploma in English'),
(64, 'Semester IV', 'EN 2221', 'Educational Measurement', 'GPA', 'Higher National Diploma in English'),
(65, 'Semester IV', 'EN 2222', 'Advanced Business English I', 'GPA', 'Higher National Diploma in English'),
(66, 'Semester IV', 'EN 2223', 'Advanced Journalism I', 'GPA', 'Higher National Diploma in English'),
(67, 'Semester IV', 'EN 2224', 'Educational Psychology', 'GPA', 'Higher National Diploma in English'),
(68, 'Semester IV', 'EN 2225', 'Advanced Business English II', 'GPA', 'Higher National Diploma in English'),
(69, 'Semester IV', 'EN 2226', 'Advanced Journalism II', 'GPA', 'Higher National Diploma in English'),
(70, 'Semester V', 'EN 3111', 'Implant Training/Project', 'GPA', 'Higher National Diploma in English'),
(71, 'Semester I', 'MAN 1101', 'Writing Business Documents', 'Core | GPA', 'Higher National Diploma in Management'),
(72, 'Semester I', 'MAN 1102', 'Introduction to Computing', 'Core | GPA', 'Higher National Diploma in Management'),
(73, 'Semester I', 'MAN 1103', 'Management', 'Core | GPA', 'Higher National Diploma in Management'),
(74, 'Semester I', 'MAN 1104', 'Maintaining Financial Records', 'Core | GPA', 'Higher National Diploma in Management'),
(75, 'Semester I', 'MAN 1105', 'Applying Statistical Techniques For Business Decision Making', 'Core | GPA', 'Higher National Diploma in Management'),
(76, 'Semester I', 'MAN 1106', 'Fundamentals of Marketing Management', 'Core | GPA', 'Higher National Diploma in Management'),
(77, 'Semester II', 'MAN 1207', 'Making Presentations', 'Core | GPA', 'Higher National Diploma in Management'),
(78, 'Semester II', 'MAN 1208', 'Introduction to Information Technology', 'Core | GPA', 'Higher National Diploma in Management'),
(79, 'Semester II', 'MAN 1210', 'Cost and Management Accounting', 'Core | GPA', 'Higher National Diploma in Management'),
(80, 'Semester II', 'MAN 1209', 'Fundamentals of Human Resource Management', 'Core | GPA', 'Higher National Diploma in Management'),
(81, 'Semester II', 'MAN 1211', 'Business Economics', 'Core | GPA', 'Higher National Diploma in Management'),
(82, 'Semester II', 'MAN 1212', 'Business Law', 'Core | GPA', 'Higher National Diploma in Management'),
(83, 'Semester III', 'MAN 2113', 'Writing Specialized Business Documents', 'Core | GPA', 'Higher National Diploma in Management'),
(84, 'Semester III', 'MAN 2114', 'Understanding Individual Behavior at Work', 'Core | GPA', 'Higher National Diploma in Management'),
(85, 'Semester III', 'MAN 2115', 'Information Technology Application', 'Core | GPA', 'Higher National Diploma in Management'),
(86, 'Semester III', 'MAN 2121', 'Employee Resourcing', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(87, 'Semester III', 'MAN 2131', 'Promotional Marketing', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(88, 'Semester III', 'MAN 2122', 'Managing Human Resources Training and Development', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(89, 'Semester III', 'MAN 2132', 'Marketing Research', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(90, 'Semester III', 'MAN 2123', 'Labor Law', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(91, 'Semester III', 'MAN 2133', 'Planning and Conducting Electronic Marketing Communications', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(92, 'Semester IV', 'MAN 2216', 'Managing Organizational Change', 'Core | GPA', 'Higher National Diploma in Management'),
(93, 'Semester IV', 'MAN 2217', 'Teamwork and Diversity Management', 'Core | GPA', 'Higher National Diploma in Management'),
(94, 'Semester IV', 'MAN 2224', 'Ensuring a Safe Workplace', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(95, 'Semester IV', 'MAN 2234', 'Merchandising and Logistics Management', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(96, 'Semester IV', 'MAN 2225', 'Managing Industrial Relations', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(97, 'Semester IV', 'MAN 2235', 'Implementing and Monitoring Marketing Activities', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(98, 'Semester IV', 'MAN 2226', 'Reward Management', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(99, 'Semester IV', 'MAN 2236', 'Analyzing Consumer Behavior for Specific Markets', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(100, 'Semester IV', 'MAN 4001', 'Optional Core Unit *', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(101, 'Semester V', 'MAN 3118', 'Research Methodology', 'Core | GPA', 'Higher National Diploma in Management'),
(102, 'Semester V', 'MAN 3119', 'Managerial Economics', 'Core | GPA', 'Higher National Diploma in Management'),
(103, 'Semester V', 'MAN 3120', 'Strategic Management', 'Core | GPA', 'Higher National Diploma in Management'),
(104, 'Semester V', 'MAN 3228', 'Contemporary HRM Issues', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(105, 'Semester V', 'MAN 3237', 'Small Business Marketing', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(106, 'Semester VI', 'MAN 3221', 'Research Project', 'Core | GPA', 'Higher National Diploma in Management'),
(107, 'Semester VI', 'MAN 3222', 'Total Quality Management', 'Core | GPA', 'Higher National Diploma in Management'),
(108, 'Semester VI', 'MAN 3227', 'Managing International HRM Policy and Processes', 'Specialization / HRM | GPA', 'Higher National Diploma in Management'),
(109, 'Semester VI', 'MAN 3238', 'Evaluating and Managing International Marketing Programs', 'Specialization / Marketing | GPA', 'Higher National Diploma in Management'),
(110, 'Semester VI', 'MAN 4002', 'Optional Core Unit *', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(111, 'Elective', 'MAN 4101', 'Managing Workplace Information and Knowledge Management Systems', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(112, 'Elective', 'MAN 4102', 'Researching International Business Opportunities', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(113, 'Elective', 'MAN 4103', 'Managing Risk', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(114, 'Elective', 'MAN 4104', 'Leadership', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(115, 'Elective', 'MAN 4105', 'Managing a Small Business', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(116, 'Elective', 'MAN 4106', 'Project Management', 'Optional Core | GPA', 'Higher National Diploma in Management'),
(117, 'Semester I', 'AG 1101', 'Agro-meteorology and Principles of Crop Production', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(118, 'Semester I', 'AG 1102', 'Principles of Soil Science and Soil Properties', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(119, 'Semester I', 'AG 1103', 'Crop Production Technologies – Paddy and Cereal Crops', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(120, 'Semester I', 'AG 1104', 'Non Ruminant Animal Production - Poultry', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(121, 'Semester I', 'AG 1105', 'Animal Disease Control and Prevention', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(122, 'Semester I', 'AG 1106', 'Agricultural Economics', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(123, 'Semester I', 'AG 1107', 'Farm Power, Energy and Mechanization', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(124, 'Semester I', 'AG 1108', 'Food and Human Nutrition', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(125, 'Semester I', 'AG 1109', 'Principles of Plant Protection', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(126, 'Semester I', 'CC 1101', 'English 1', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(127, 'Semester I', 'CC 1102', 'Information and Communication Technology 1', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(128, 'Semester II', 'AG 1201', 'Principles of Horticulture', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(129, 'Semester II', 'AG 1202', 'Crop Production Technologies – Other Field Crops', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(130, 'Semester II', 'AG 1203', 'Vegetable Production', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(131, 'Semester II', 'AG 1204', 'Fruit Production', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(132, 'Semester II', 'AG 1205', 'Ruminant Animal Production - Cattle', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(133, 'Semester II', 'AG 1206', 'Agriculture Extension Education', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(134, 'Semester II', 'AG 1207', 'Agricultural Implements and Machines', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(135, 'Semester II', 'AG 1208', 'Surveying and Land Development', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(136, 'Semester II', 'AG 1209', 'Pests of Crops and their Management', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(137, 'Semester II', 'CC 1201', 'English 2', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(138, 'Semester II', 'CC 1202', 'Basic Mathematics and Statistics', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(139, 'Semester III', 'AG 2101', 'Plantation Crop Production', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(140, 'Semester III', 'AG 2102', 'Export Agriculture Crop and Medicinal Plant Production', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(141, 'Semester III', 'AG 2103', 'Non Ruminant Animal Production - Swine', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(142, 'Semester III', 'AG 2104', 'Developmental Extension', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(143, 'Semester III', 'AG 2105', 'Soil and Water Management', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(144, 'Semester III', 'AG 2106', 'Diseases of Crops and their Management', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(145, 'Semester III', 'AG 2107', 'Farm and Resource Management', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(146, 'Semester III', 'AG 2108', 'Post Harvest Technology', 'Core | GPA', 'Higher National Diploma in Agriculture'),
(147, 'Semester III', 'CC 2101', 'English 3', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(148, 'Semester III', 'CC 2102', 'Information and Communication Technology 2', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(149, 'Semester IV', 'AG 2201', 'Landscaping and Turf Management', 'Compulsory for Crop Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(150, 'Semester IV', 'AG 2202', 'Human Resource Management', 'Compulsory | GPA', 'Higher National Diploma in Agriculture'),
(151, 'Semester IV', 'AG 2203', 'Agricultural Marketing', 'Compulsory | GPA', 'Higher National Diploma in Agriculture'),
(152, 'Semester IV', 'AG 2204', 'Applied Agribusiness', 'Compulsory | GPA', 'Higher National Diploma in Agriculture'),
(153, 'Semester IV', 'AG 2205', 'Goat and Rabbit Production', 'Compulsory for Animal Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(154, 'Semester IV', 'AG 2206', 'Aquaculture', 'Compulsory for Animal Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(155, 'Semester IV', 'AG 2207', 'Energy and Waste Management', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(156, 'Semester IV', 'AG 2208', 'Manufacturing Technology', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(157, 'Semester IV', 'AG 2209', 'Protected Agriculture and Floriculture', 'Compulsory for Crop Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(158, 'Semester IV', 'AG 2210', 'Food Processing and Preservation', 'Compulsory | GPA', 'Higher National Diploma in Agriculture'),
(159, 'Semester IV', 'AG 2211', 'Field Experimentation and Design', 'Compulsory | GPA', 'Higher National Diploma in Agriculture'),
(160, 'Semester IV', 'AG 2212', 'Agricultural Product Quality Maintenance', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(161, 'Semester IV', 'AG 2213', 'Principles of Biotechnology', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(162, 'Semester IV', 'AG 2214', 'Integrated Farming Systems and Agro-forestry', 'Compulsory for Crop Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(163, 'Semester IV', 'AG 2215', 'Animal Feed Technology', 'Compulsory for Animal Science Advanced Program | GPA', 'Higher National Diploma in Agriculture'),
(164, 'Semester IV', 'AG 2216', 'Building Construction and Farm Electrification', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(165, 'Semester IV', 'AG 2217', 'Engineering Drawing', 'Optional | GPA', 'Higher National Diploma in Agriculture'),
(166, 'Semester IV', 'CC 2201', 'English 4', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(167, 'Semester IV', 'CC 2202', 'Project Proposal Formulation and Reporting', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(168, 'Semester IV', 'CC 2203', 'Personality and Career Development', 'Compulsory | NGPA', 'Higher National Diploma in Agriculture'),
(169, 'Semester I', 'HNDA 1101', 'Fundamentals of Financial Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(170, 'Semester I', 'HNDA 1102', 'Business Mathematics', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(171, 'Semester I', 'HNDA 1103', 'Commercial Awareness', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(172, 'Semester I', 'HNDA 1104', 'Business Communication I', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(173, 'Semester I', 'HNDA 1105', 'Introduction to Computers', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(174, 'Semester II', 'HNDA 1201', 'Intermediate Financial Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(175, 'Semester II', 'HNDA 1202', 'Statistical Analysis for Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(176, 'Semester II', 'HNDA 1203', 'Micro & Macro Economics', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(177, 'Semester II', 'HNDA 1204', 'Business Communication II', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(178, 'Semester II', 'HNDA 1205', 'Computer Applications', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(179, 'Semester III', 'HNDA 2101', 'Advanced Financial Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(180, 'Semester III', 'HNDA 2102', 'Operations Research', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(181, 'Semester III', 'HNDA 2103', 'Principles of Auditing & Taxation', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(182, 'Semester III', 'HNDA 2104', 'Business Communication III', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(183, 'Semester III', 'HNDA 2105', 'Database Management Systems & Data Analysis', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(184, 'Semester IV', 'HNDA 2201', 'Cost & Management Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(185, 'Semester IV', 'HNDA 2202', 'Computer Applications for Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(186, 'Semester IV', 'HNDA 2203', 'Marketing Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(187, 'Semester IV', 'HNDA 2204', 'Business Communication IV', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(188, 'Semester IV', 'HNDA 2205', 'Project Management Tools & Programming', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(189, 'Semester V', 'HNDA 3101', 'Advanced Management Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(190, 'Semester V', 'HNDA 3102', 'Financial Reporting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(191, 'Semester V', 'HNDA 3103', 'Business Law', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(192, 'Semester V', 'HNDA 3104', 'Advanced Taxation', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(193, 'Semester VI', 'HNDA 3201', 'Advanced Financial Reporting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(194, 'Semester VI', 'HNDA 3202', 'Corporate Law', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(195, 'Semester VI', 'HNDA 3203', 'Organizational Behaviour and Human Resources Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(196, 'Semester VI', 'HNDA 3204', 'Business System I', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(197, 'Semester VII', 'HNDA 4101', 'Financial Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(198, 'Semester VII', 'HNDA 4102', 'Strategic Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(199, 'Semester VII', 'HNDA 4103', 'Business System II', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(200, 'Semester VII', 'HNDA 4104', 'Computer Based Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(201, 'Semester VIII', 'HNDA 4201', 'Strategic Management Accounting', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(202, 'Semester VIII', 'HNDA 4202', 'Financial Statement Analysis', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(203, 'Semester VIII', 'HNDA 4203', 'Strategic Financial Management', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(204, 'Semester VIII', 'HNDA 4204', 'Advanced Auditing & Assurance', 'Core | GPA', 'Higher National Diploma in Accountancy'),
(205, 'Semester I', 'BA 1113', 'Business Economics', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(206, 'Semester I', 'BA 1123', 'Management Process', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(207, 'Semester I', 'BA 1133', 'Business Mathematics and Statistics', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(208, 'Semester I', 'BA 1143', 'Business English I', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(209, 'Semester I', 'BA 1153', 'Financial Accounting', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(210, 'Semester II', 'BA 1213', 'Managerial Accounting', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(211, 'Semester II', 'BA 1223', 'Information Technology', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(212, 'Semester II', 'BA 1233', 'Business Law', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(213, 'Semester II', 'BA 1243', 'Business English II', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(214, 'Semester II', 'BA 1253', 'Marketing Management', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(215, 'Semester III', 'BA 2113', 'Business Finance', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(216, 'Semester III', 'BA 2122', 'Computer Application for Business', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(217, 'Semester III', 'BA 2133', 'Operations Management', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(218, 'Semester III', 'BA 2143', 'Professional Communication', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(219, 'Semester III', 'BA 2153', 'Organizational Behavior', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(220, 'Semester IV', 'BA 2212', 'Project Management', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(221, 'Semester IV', 'BA 2222', 'Management of Technology for Business', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(222, 'Semester IV', 'BA 2233', 'Banking and Insurance', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(223, 'Semester IV', 'BA 2243', 'Human Resource Management', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(224, 'Semester IV', 'BA 2253', 'Business Strategy and Entrepreneurship', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(225, 'Semester V', 'BA 3113', 'Internship', 'Core | GPA', 'Higher National Diploma in Business Administration'),
(226, 'Semester I', 'FT 1101', 'Fundamentals of Chemistry', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(227, 'Semester I', 'FT 1102', 'Microbiology', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(228, 'Semester I', 'FT 1103', 'Nutrition', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(229, 'Semester I', 'FT 1104', 'Introduction to Computer', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(230, 'Semester I', 'FT 1105', 'Mathematics', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(231, 'Semester I', 'FT 1107', 'English for Technology I', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(232, 'Semester II', 'FT 1201', 'Food Engineering', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(233, 'Semester II', 'FT 1202', 'Food Microbiology', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(234, 'Semester II', 'FT 1203', 'Food Sanitation', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(235, 'Semester II', 'FT 1204', 'Product Development and Sensory Evaluation', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(236, 'Semester II', 'FT 1205', 'Computer Application I', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(237, 'Semester II', 'FT 1206', 'Applied Statistics', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(238, 'Semester II', 'FT 1207', 'English for Technology II', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(239, 'Semester III', 'FT 2101', 'Food Chemistry', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(240, 'Semester III', 'FT 2102', 'Food Processing I', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(241, 'Semester III', 'FT 2103', 'Food Processing II', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(242, 'Semester III', 'FT 2104', 'Food Packaging', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(243, 'Semester III', 'FT 2105', 'Computer Application II', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(244, 'Semester III', 'FT 2107', 'English for Technology III', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(245, 'Semester IV', 'FT 2201', 'Food Law', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(246, 'Semester IV', 'FT 2202', 'Food Analysis & Quality Assurance', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(247, 'Semester IV', 'FT 2203', 'Food Processing III', 'Core | GPA', 'Higher National Diploma in Food Technology'),
(248, 'Semester IV', 'FT 2204', 'Computer Application III', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(249, 'Semester IV', 'FT 2205', 'English for Technology IV', 'Compulsory | GPA', 'Higher National Diploma in Food Technology'),
(250, 'Semester I', 'QS 11014', 'Engineering Mathematics and Statistics', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(251, 'Semester I', 'QS 11022', 'Economics', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(252, 'Semester I', 'QS 11033', 'Fundamentals of Engineering Surveying', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(253, 'Semester I', 'QS 11043', 'English for Professional I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(254, 'Semester I', 'QS 11053', 'Information Technology I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(255, 'Semester I', 'QS 11062', 'Workshop Engineering', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(256, 'Semester I', 'QS 11072', 'Engineering Drawing', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(257, 'Semester II', 'QS 12013', 'Measurement I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(258, 'Semester II', 'QS 12022', 'Construction Material', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(259, 'Semester II', 'QS 12033', 'Surveying and Leveling', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(260, 'Semester II', 'QS 12044', 'Civil Engineering Construction I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(261, 'Semester II', 'QS 12052', 'Structures I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(262, 'Semester II', 'QS 12062', 'Engineering Graphics & AutoCAD', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(263, 'Semester II', 'QS 12073', 'English for Professionals II', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(264, 'Semester III', 'QS 21013', 'Measurement II', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(265, 'Semester III', 'QS 21023', 'Building Economics I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(266, 'Semester III', 'QS 21032', 'Contract Law I', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(267, 'Semester III', 'QS 21043', 'Principles of Management', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(268, 'Semester III', 'QS 21054', 'Civil Engineering Construction II for QS', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(269, 'Semester III', 'QS 21063', 'Information Technology II', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(270, 'Semester III', 'QS 21072', 'Technical Communication Skills', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(271, 'Semester IV', 'QS 22013', 'Procurement', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(272, 'Semester IV', 'QS 22023', 'Building Economics II', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(273, 'Semester IV', 'QS 22032', 'Contract Law II', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(274, 'Semester IV', 'QS 22043', 'Project', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(275, 'Semester IV', 'QS 22053', 'AutoCAD', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(276, 'Semester IV', 'QS 22063', 'Accounting & Finance for QS Profession', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(277, 'Semester IV', 'QS 22073', 'Structures II (Structural Design & Detailing)', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(278, 'Semester IV', 'QS 22082', 'Technical Communication Skills', 'GPA', 'Higher National Diploma in Quantity Surveying'),
(279, 'Semester I', 'THM 11013', 'Principals of Tourism Studies', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(280, 'Semester I', 'THM 11023', 'Principals of Tourism Studies', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(281, 'Semester I', 'THM 11033', 'Legal Framework for Tourism Industry', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(282, 'Semester I', 'THM 11043', 'Heritage Tourism', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(283, 'Semester I', 'THM 11053', 'Information Technology I', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(284, 'Semester I', 'THM 11063', 'Professional Communication II', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(285, 'Semester II', 'THM 12063', 'Introduction to the Hospitality', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(286, 'Semester II', 'THM 12073', 'Tourism Policy, Planning and Development', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(287, 'Semester II', 'THM 12083', 'Information Technology II', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(288, 'Semester II', 'THM 12093', 'Professional Communication II', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(289, 'Semester II', 'THM 12113', 'German Language Proficiency Level', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(290, 'Semester II', 'THM 12123', 'Japanese Language Proficiency Level', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(291, 'Semester II', 'THM 12133', 'French Language Proficiency Level', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(292, 'Semester III', 'THM 21153', 'House Keeping Management', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(293, 'Semester III', 'THM 21163', 'Front Office Management', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(294, 'Semester III', 'THM 21173', 'Restaurant Operation Management', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(295, 'Semester III', 'THM 21183', 'Information Technology III', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(296, 'Semester III', 'THM 21193', 'Professional Communication III', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(297, 'Semester III', 'THM 21203', 'German Language Proficiency Level II', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(298, 'Semester III', 'THM 21214', 'Japanese Language Proficiency Level', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(299, 'Semester III', 'THM 21214', 'French Language Proficiency Level', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(300, 'Semester IV', 'THM 22233', 'Human Resource Management in Hospitality', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(301, 'Semester IV', 'THM 22243', 'Hospitality and Catering', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(302, 'Semester IV', 'THM 22253', 'Accounting for Hotel Management', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(303, 'Semester IV', 'THM 22263', 'Information Technology IV', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(304, 'Semester IV', 'THM 22273', 'Professional Communication', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(305, 'Semester IV', 'THM 22283', 'German Language Proficiency Level III', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(306, 'Semester IV', 'THM 22293', 'Japanese Language Proficiency Level III', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(307, 'Semester IV', 'THM 22303', 'French Language Proficiency Level III', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(308, 'Semester V', 'THM 31313', 'Food & Beverage Management', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(309, 'Semester V', 'THM 31323', 'Marketing for Hospitality & Tourism', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(310, 'Semester V', 'THM 31333', 'Advertising in Tourism & Leisure', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(311, 'Semester V', 'THM 31343', 'Information Technology V', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(312, 'Semester V', 'THM 31353', 'Professional Communication V', 'GPA', 'Higher National Diploma in Tourism and Hospitality Management'),
(313, 'Semester V', 'THM 31363', 'German Language Proficiency Level IV', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(314, 'Semester V', 'THM 31373', 'Japanese Language Proficiency Level IV', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(315, 'Semester V', 'THM 31383', 'French Language Proficiency Level IV', 'Optional', 'Higher National Diploma in Tourism and Hospitality Management'),
(316, 'Semester I', 'MA1101', 'Engineering Mathematics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(317, 'Semester I', 'EN1101', 'English', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(318, 'Semester I', 'IT1101', 'Information Technology I', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(319, 'Semester I', 'ME1101', 'Workshop Engineering I', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(320, 'Semester I', 'ME1102', 'Engineering Drawing', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(321, 'Semester I', 'ME1103', 'Engineering Mechanics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(322, 'Semester I', 'CE1102', 'Fluid Mechanics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(323, 'Semester I', 'EE1101', 'Basic Electricity and Electronics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(324, 'Semester II', 'MA1202', 'Applied Engineering Mathematics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(325, 'Semester II', 'EN1202', 'English for Professionals', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(326, 'Semester II', 'ME1204', 'Workshop Engineering II', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(327, 'Semester II', 'ME1204', 'Engineering Graphics & AutoCAD', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(328, 'Semester II', 'ME1206', 'Fundamentals of Thermodynamics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(329, 'Semester II', 'CE1207', 'Strength of Materials I', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(330, 'Semester II', 'ME1207', 'Properties of Engineering Materials', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(331, 'Semester II', 'ME1208', 'Introduction to Automobile Technology', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(332, 'Semester II', 'ME1209', 'Introduction to Refrigeration & Air Conditioning', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(333, 'Semester III', 'MA2103', 'Engineering Mathematics with Matlab', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(334, 'Semester III', 'EN2103', 'Essentials of Communication Skills', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(335, 'Semester III', 'IT2102', 'Information Technology IIA', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(336, 'Semester III', 'THERMO1', 'Applied Thermo Fluids', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(337, 'Semester III', 'HEAT1', 'Basic Heat Transfer', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(338, 'Semester III', 'REF1', 'Refrigeration Systems & Applications', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(339, 'Semester III', 'AC1', 'Principles of Air Conditioning', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(340, 'Semester III', 'SBE1', 'Sustainable Built Environment', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(341, 'Semester IV', 'EN2204', 'Technical Communication Skills', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(342, 'Semester IV', 'MA2204', 'Advanced Engineering Mathematics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(343, 'Semester IV', 'HEX1', 'Heat Exchangers in Buildings', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(344, 'Semester IV', 'HGD1', 'Heat Generation & Distribution Systems', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(345, 'Semester IV', 'FTD1', 'Fluid Transfer Devices', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(346, 'Semester IV', 'ELEC1', 'Electrical Distribution in Buildings', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(347, 'Semester IV', 'LIGHT1', 'Buildings Lighting Systems', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(348, 'Semester IV', 'CAD1', 'CAD Applications', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(349, 'Semester V', 'PIP1', 'Piped Distribution Services', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(350, 'Semester V', 'ACC1', 'Accounting & Finance', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(351, 'Semester V', 'ACV1', 'Air Conditioning & Ventilation', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(352, 'Semester V', 'BC1', 'Building Codes/Standards & Appliance Labeling', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(353, 'Semester V', 'ASB1', 'Ancillary Services of Buildings', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(354, 'Semester V', 'BA1', 'Building Acoustics', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(355, 'Semester VI', 'MM1', 'Maintenance Management', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(356, 'Semester VI', 'BCI1', 'Building Controls & Instrumentation', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(357, 'Semester VI', 'EEB1', 'Energy Efficiency in Buildings', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(358, 'Semester VI', 'RET1', 'Renewable Energy Technologies for Buildings', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(359, 'Semester VI', 'FM1', 'Introduction to Facilities Management', 'GPA', 'Higher National Diploma in Engineering (Building Services)'),
(360, 'Semester I', 'BF1113', 'Business Economics', 'GPA', 'Higher National Diploma in Business Finance'),
(361, 'Semester I', 'BF1123', 'Management Process', 'GPA', 'Higher National Diploma in Business Finance'),
(362, 'Semester I', 'BF1133', 'Business Mathematics and Statistics', 'GPA', 'Higher National Diploma in Business Finance'),
(363, 'Semester I', 'BF1143', 'Business English I', 'GPA', 'Higher National Diploma in Business Finance'),
(364, 'Semester I', 'BF1153', 'Financial Accounting', 'GPA', 'Higher National Diploma in Business Finance'),
(365, 'Semester II', 'BF2113', 'Cost and Management Accounting', 'GPA', 'Higher National Diploma in Business Finance'),
(366, 'Semester II', 'BF2123', 'Information Technology', 'GPA', 'Higher National Diploma in Business Finance'),
(367, 'Semester II', 'BF2133', 'Business Law', 'GPA', 'Higher National Diploma in Business Finance'),
(368, 'Semester II', 'BF2143', 'Business English II', 'GPA', 'Higher National Diploma in Business Finance'),
(369, 'Semester II', 'BF2153', 'Advanced Financial Accounting', 'GPA', 'Higher National Diploma in Business Finance'),
(370, 'Semester III', 'BF2113', 'Advanced Management Accounting', 'GPA', 'Higher National Diploma in Business Finance'),
(371, 'Semester III', 'BF2122', 'Computer Application for Business', 'GPA', 'Higher National Diploma in Business Finance'),
(372, 'Semester III', 'BF2133', 'Financial Management', 'GPA', 'Higher National Diploma in Business Finance'),
(373, 'Semester III', 'BF2143', 'Professional Communication', 'GPA', 'Higher National Diploma in Business Finance'),
(374, 'Semester III', 'BF2153', 'Enterprise Operation', 'GPA', 'Higher National Diploma in Business Finance'),
(375, 'Semester IV', 'BF2213', 'Strategic Management', 'GPA', 'Higher National Diploma in Business Finance'),
(376, 'Semester IV', 'BF2223', 'Financial Modelling', 'GPA', 'Higher National Diploma in Business Finance'),
(377, 'Semester IV', 'BF2233', 'Advanced Financial Management', 'GPA', 'Higher National Diploma in Business Finance'),
(378, 'Semester IV', 'BF2244', 'Tax and Auditing', 'GPA', 'Higher National Diploma in Business Finance'),
(379, 'Semester V', 'BF2253', 'Internship', 'GPA', 'Higher National Diploma in Business Finance');

-- --------------------------------------------------------

--
-- Table structure for table `summaries`
--

CREATE TABLE `summaries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `summary` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `active_student_projects`
--
ALTER TABLE `active_student_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `active_student_project_links`
--
ALTER TABLE `active_student_project_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `active_student_project_photos`
--
ALTER TABLE `active_student_project_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `active_student_skills`
--
ALTER TABLE `active_student_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_skill` (`student_id`,`skill_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `business_finance_skills`
--
ALTER TABLE `business_finance_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `engineering_skills`
--
ALTER TABLE `engineering_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `former_students`
--
ALTER TABLE `former_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `former_students_achievements`
--
ALTER TABLE `former_students_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `former_student_id` (`former_student_id`);

--
-- Indexes for table `former_students_certifications`
--
ALTER TABLE `former_students_certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `former_student_id` (`former_student_id`);

--
-- Indexes for table `former_student_projects`
--
ALTER TABLE `former_student_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `former_student_project_links`
--
ALTER TABLE `former_student_project_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `former_student_project_photos`
--
ALTER TABLE `former_student_project_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `former_student_project_skills`
--
ALTER TABLE `former_student_project_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `former_student_skills`
--
ALTER TABLE `former_student_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `hndit_company_categories`
--
ALTER TABLE `hndit_company_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_accountancy_skills`
--
ALTER TABLE `hnd_accountancy_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_agriculture_skills`
--
ALTER TABLE `hnd_agriculture_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_building_services_skills`
--
ALTER TABLE `hnd_building_services_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_business_admin_skills`
--
ALTER TABLE `hnd_business_admin_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_courses`
--
ALTER TABLE `hnd_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_course_categories`
--
ALTER TABLE `hnd_course_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `hnd_english_skills`
--
ALTER TABLE `hnd_english_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_food_tech_skills`
--
ALTER TABLE `hnd_food_tech_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_management_skills`
--
ALTER TABLE `hnd_management_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_mechanical_skills`
--
ALTER TABLE `hnd_mechanical_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_quantity_survey_skills`
--
ALTER TABLE `hnd_quantity_survey_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hnd_thm_skills`
--
ALTER TABLE `hnd_thm_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `it_student_skills`
--
ALTER TABLE `it_student_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lectures_assignment`
--
ALTER TABLE `lectures_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecturer_id` (`lecturer_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_subject_semester` (`student_id`,`subject`,`semester`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_photos`
--
ALTER TABLE `report_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_id` (`reg_id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students_about`
--
ALTER TABLE `students_about`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_about` (`user_id`);

--
-- Indexes for table `students_achievements`
--
ALTER TABLE `students_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students_certifications`
--
ALTER TABLE `students_certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students_education`
--
ALTER TABLE `students_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students_experiences`
--
ALTER TABLE `students_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students_summaries`
--
ALTER TABLE `students_summaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_summary` (`user_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summaries`
--
ALTER TABLE `summaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_student_projects`
--
ALTER TABLE `active_student_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `active_student_project_links`
--
ALTER TABLE `active_student_project_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `active_student_project_photos`
--
ALTER TABLE `active_student_project_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `active_student_skills`
--
ALTER TABLE `active_student_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `business_finance_skills`
--
ALTER TABLE `business_finance_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1110;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `engineering_skills`
--
ALTER TABLE `engineering_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `former_students`
--
ALTER TABLE `former_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `former_students_achievements`
--
ALTER TABLE `former_students_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `former_students_certifications`
--
ALTER TABLE `former_students_certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `former_student_projects`
--
ALTER TABLE `former_student_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `former_student_project_links`
--
ALTER TABLE `former_student_project_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `former_student_project_photos`
--
ALTER TABLE `former_student_project_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `former_student_project_skills`
--
ALTER TABLE `former_student_project_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `former_student_skills`
--
ALTER TABLE `former_student_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hndit_company_categories`
--
ALTER TABLE `hndit_company_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hnd_accountancy_skills`
--
ALTER TABLE `hnd_accountancy_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2219;

--
-- AUTO_INCREMENT for table `hnd_agriculture_skills`
--
ALTER TABLE `hnd_agriculture_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3231;

--
-- AUTO_INCREMENT for table `hnd_building_services_skills`
--
ALTER TABLE `hnd_building_services_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4128;

--
-- AUTO_INCREMENT for table `hnd_business_admin_skills`
--
ALTER TABLE `hnd_business_admin_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5101;

--
-- AUTO_INCREMENT for table `hnd_courses`
--
ALTER TABLE `hnd_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hnd_course_categories`
--
ALTER TABLE `hnd_course_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1521;

--
-- AUTO_INCREMENT for table `hnd_english_skills`
--
ALTER TABLE `hnd_english_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6151;

--
-- AUTO_INCREMENT for table `hnd_food_tech_skills`
--
ALTER TABLE `hnd_food_tech_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7221;

--
-- AUTO_INCREMENT for table `hnd_management_skills`
--
ALTER TABLE `hnd_management_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8271;

--
-- AUTO_INCREMENT for table `hnd_mechanical_skills`
--
ALTER TABLE `hnd_mechanical_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9141;

--
-- AUTO_INCREMENT for table `hnd_quantity_survey_skills`
--
ALTER TABLE `hnd_quantity_survey_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12201;

--
-- AUTO_INCREMENT for table `hnd_thm_skills`
--
ALTER TABLE `hnd_thm_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10331;

--
-- AUTO_INCREMENT for table `it_student_skills`
--
ALTER TABLE `it_student_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11434;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lectures_assignment`
--
ALTER TABLE `lectures_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_photos`
--
ALTER TABLE `report_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students_about`
--
ALTER TABLE `students_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students_achievements`
--
ALTER TABLE `students_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_certifications`
--
ALTER TABLE `students_certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_education`
--
ALTER TABLE `students_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students_experiences`
--
ALTER TABLE `students_experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_summaries`
--
ALTER TABLE `students_summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;

--
-- AUTO_INCREMENT for table `summaries`
--
ALTER TABLE `summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about`
--
ALTER TABLE `about`
  ADD CONSTRAINT `about_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `former_students` (`id`);

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `former_students` (`id`);

--
-- Constraints for table `former_students_achievements`
--
ALTER TABLE `former_students_achievements`
  ADD CONSTRAINT `former_students_achievements_ibfk_1` FOREIGN KEY (`former_student_id`) REFERENCES `former_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `former_students_certifications`
--
ALTER TABLE `former_students_certifications`
  ADD CONSTRAINT `former_students_certifications_ibfk_1` FOREIGN KEY (`former_student_id`) REFERENCES `former_students` (`id`);

--
-- Constraints for table `former_student_projects`
--
ALTER TABLE `former_student_projects`
  ADD CONSTRAINT `former_student_projects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `former_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `former_student_project_photos`
--
ALTER TABLE `former_student_project_photos`
  ADD CONSTRAINT `former_student_project_photos_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `former_student_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `former_student_project_skills`
--
ALTER TABLE `former_student_project_skills`
  ADD CONSTRAINT `former_student_project_skills_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `former_student_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lectures_assignment`
--
ALTER TABLE `lectures_assignment`
  ADD CONSTRAINT `lectures_assignment_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lectures` (`id`),
  ADD CONSTRAINT `lectures_assignment_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `students_achievements`
--
ALTER TABLE `students_achievements`
  ADD CONSTRAINT `students_achievements_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students_certifications`
--
ALTER TABLE `students_certifications`
  ADD CONSTRAINT `students_certifications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `summaries`
--
ALTER TABLE `summaries`
  ADD CONSTRAINT `summaries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `former_students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
