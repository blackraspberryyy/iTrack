-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2018 at 06:19 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_number` varchar(9) NOT NULL,
  `admin_firstname` varchar(256) NOT NULL,
  `admin_lastname` varchar(256) NOT NULL,
  `admin_middlename` varchar(256) DEFAULT NULL,
  `admin_password` varchar(256) NOT NULL,
  `admin_picture` varchar(256) NOT NULL,
  `admin_title` varchar(256) NOT NULL,
  `admin_isactive` tinyint(1) NOT NULL DEFAULT '1',
  `admin_added_at` int(11) NOT NULL,
  `admin_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_number`, `admin_firstname`, `admin_lastname`, `admin_middlename`, `admin_password`, `admin_picture`, `admin_title`, `admin_isactive`, `admin_added_at`, `admin_updated_at`) VALUES
(1, '1', 'Admin', 'Admin', 'Admin', 'D033E22AE348AEB5660FC2140AEC35850C4DA997', 'images/admin/200900001.gif', 'Discipline Unit Coordinator', 1, 1531205487, 1531205487);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `incident_report_id` int(11) NOT NULL,
  `attendance_dept` varchar(255) NOT NULL,
  `attendance_supervisor` varchar(255) NOT NULL,
  `attendance_hours_rendered` int(11) NOT NULL,
  `attendance_status` int(11) NOT NULL DEFAULT '1',
  `attendance_starttime` int(11) NOT NULL,
  `attendance_endtime` int(11) NOT NULL,
  `attendance_created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='1 record = 1 attendance in dussap for his incident report';

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `incident_report_id`, `attendance_dept`, `attendance_supervisor`, `attendance_hours_rendered`, `attendance_status`, `attendance_starttime`, `attendance_endtime`, `attendance_created_at`) VALUES
(1, 2, 'Admissions', 'John Doe', 1, 1, 1539392400, 1539396060, 1539528072),
(4, 2, 'ITE Dept.', 'John Doe', 12, 1, 1539533760, 1539576960, 1539533829),
(10, 3, 'Admissions', 'John Doe', 12, 1, 1540353060, 1540396260, 1540396274),
(13, 3, '-', '-', 88, 1, 0, 0, 1540398197),
(14, 4, 'dsa', 'dsa', 24, 1, 1544797740, 1544884140, 1544711439);

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `cms_id` int(11) NOT NULL,
  `dusap_title` text NOT NULL,
  `dusap_text` text NOT NULL,
  `incident_report_title` text NOT NULL,
  `incident_report_text` text NOT NULL,
  `email_title` text NOT NULL,
  `email_text` text NOT NULL,
  `audit_trail_title` text NOT NULL,
  `audit_trail_text` text NOT NULL,
  `student_handbook_title` text NOT NULL,
  `student_handbook_text` text NOT NULL,
  `cms_title` text NOT NULL,
  `cms_text` text NOT NULL,
  `monthly_report_title` text NOT NULL,
  `monthly_report_text` text NOT NULL,
  `google_drive_title` text NOT NULL,
  `google_drive_text` text NOT NULL,
  `user_logs_title` text NOT NULL,
  `user_logs_text` text NOT NULL,
  `user_title` text NOT NULL,
  `user_text` text NOT NULL,
  `faq_title` text NOT NULL,
  `faq_text` text NOT NULL,
  `offense_report_title` text NOT NULL,
  `offense_report_text` text NOT NULL,
  `announcement_title` text NOT NULL,
  `announcement_text` text NOT NULL,
  `minor_reports_title` text NOT NULL,
  `minor_reports_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`cms_id`, `dusap_title`, `dusap_text`, `incident_report_title`, `incident_report_text`, `email_title`, `email_text`, `audit_trail_title`, `audit_trail_text`, `student_handbook_title`, `student_handbook_text`, `cms_title`, `cms_text`, `monthly_report_title`, `monthly_report_text`, `google_drive_title`, `google_drive_text`, `user_logs_title`, `user_logs_text`, `user_title`, `user_text`, `faq_title`, `faq_text`, `offense_report_title`, `offense_report_text`, `announcement_title`, `announcement_text`, `minor_reports_title`, `minor_reports_text`) VALUES
(1, 'DUSAP', 'Discipline Unit Student Assistant Program', 'Incident Report', 'File an incident report to a student who committed an offense.', 'Send Email', 'Send Email to someone', 'Audit Trail', 'Track the changes made in iTrack System', 'Student Handbook', 'PDF Version of the FEU Institute of Technology Student Handbook', 'CMS', 'Content Management System for iTrack\'s Web Application', 'Monthly Report', 'Monitor iTrack with this monthly report page.', 'Google Drive', 'Access iTrack\'s Google Drive files here.', 'User Logs', 'Monitor iTrack\'s user logs here.', 'Users Profile', 'See user\'s profile here.', 'FAQ', 'Frequently Asked Question<div><br></div><div><br></div><div><br></div><span style=\"color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" background-color:=\"\" rgb(241,=\"\" 240,=\"\" 240);\"=\"\"><b>1. How many minor violations does it take to have 1 major violation?</b></span><div><span style=\"color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" background-color:=\"\" rgb(241,=\"\" 240,=\"\" 240);\"=\"\">       - 15 minor violations.\r\n</span><div><span style=\"background-color: rgb(241, 240, 240); color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><b>2. How many hours does a student need to serve for the DUSAP?</b></span></div><div><span style=\"background-color: rgb(241, 240, 240); color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><b>      </b> - It usually around 100hrs and above depending on the violation type and count.</span></div><div><span style=\"background-color: rgb(241, 240, 240); color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><b>3. What if my guardian/ parent cannot come to the Discipline Unit personally?</b></span></div></div><div><span style=\"background-color: rgb(241, 240, 240); color: rgb(0, 0, 0); font-family: \" helvetica=\"\" neue\",=\"\" \"segoe=\"\" ui\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" white-space:=\"\" pre-wrap;=\"\" letter-spacing:=\"\" 0px;\"=\"\">     - Lorem ipsum dolor sit amet consectatur adipiscing elit.</span></div>', 'Offense Report', 'Summarized Report of the incident report.', 'Announcement', 'All violators must complete their DUSAP  Attendance as stated in the Student Handbook.', 'Minor Reports', 'Here are the minor reports from the iTrack App');

-- --------------------------------------------------------

--
-- Table structure for table `effects`
--

CREATE TABLE `effects` (
  `effect_id` int(11) NOT NULL,
  `effect_name` varchar(255) NOT NULL,
  `effect_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `effects`
--

INSERT INTO `effects` (`effect_id`, `effect_name`, `effect_hours`) VALUES
(1, 'DUSAP', 100),
(2, 'Suspension', 0),
(3, 'Non Readmission', 0),
(4, 'Expulsion', 0);

-- --------------------------------------------------------

--
-- Table structure for table `incident_report`
--

CREATE TABLE `incident_report` (
  `incident_report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `user_reported_by` int(11) DEFAULT NULL,
  `violation_id` int(11) NOT NULL,
  `effects_id` int(11) NOT NULL,
  `incident_report_ref_id` int(11) DEFAULT NULL,
  `incident_report_datetime` int(11) NOT NULL,
  `incident_report_place` varchar(256) NOT NULL,
  `incident_report_age` int(3) NOT NULL,
  `incident_report_section_year` varchar(256) DEFAULT NULL,
  `incident_report_message` text NOT NULL,
  `incident_report_status` tinyint(1) NOT NULL DEFAULT '1',
  `incident_report_isAccepted` tinyint(1) NOT NULL DEFAULT '0',
  `incident_report_added_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incident_report`
--

INSERT INTO `incident_report` (`incident_report_id`, `user_id`, `user_reported_by`, `violation_id`, `effects_id`, `incident_report_ref_id`, `incident_report_datetime`, `incident_report_place`, `incident_report_age`, `incident_report_section_year`, `incident_report_message`, `incident_report_status`, `incident_report_isAccepted`, `incident_report_added_at`) VALUES
(1, 3, 4, 18, 1, NULL, 1530611400, 'F1202 FIT', 19, 'W31/2018', 'Student has been disrespectful since the day we met.', 1, 1, 1531802826),
(2, 2, NULL, 24, 1, NULL, 1535781302, 'somwehere', 19, 'W31/3rd', 'asd', 1, 1, 1535781302),
(3, 1, NULL, 24, 1, NULL, 1537502785, 'F1206', 19, 'W41', 'ASD', 0, 1, 1537502785);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log_type` enum('log','trail') NOT NULL,
  `log_desc` text NOT NULL,
  `log_added_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `user_id`, `log_type`, `log_desc`, `log_added_at`) VALUES
(1, 5, 'log', 'Logged in', 1535815617),
(2, 5, 'log', 'Logged Out', 1535815620),
(3, 5, 'log', 'Logged in', 1535816041),
(4, 5, 'log', 'Logged out', 1535816059),
(5, 2, 'log', 'Logged in', 1538664748),
(6, 2, 'log', 'Logged out', 1538664804),
(7, 4, 'log', 'Logged in', 1538664887),
(8, 4, 'log', 'Logged out', 1538664901),
(9, 4, 'log', 'Logged in', 1538665611),
(12, NULL, 'trail', 'Made changes to the CMS', 1538666585),
(13, 4, 'log', 'Logged out', 1538671940),
(14, NULL, 'log', 'Logged out', 1538671941),
(15, NULL, 'log', 'Logged out', 1538671942),
(16, 2, 'log', 'Logged in', 1539500486),
(17, 2, 'log', 'Logged out', 1539500553),
(19, NULL, 'trail', 'Edited attendance in DUSAP', 1539523626),
(20, NULL, 'trail', 'Edited attendance in DUSAP', 1539525579),
(21, NULL, 'trail', 'Edited attendance in DUSAP', 1539528038),
(22, NULL, 'trail', 'Edited attendance in DUSAP', 1539528063),
(23, NULL, 'trail', 'Edited attendance in DUSAP', 1539528072),
(24, NULL, 'trail', 'Edited attendance in DUSAP', 1539533730),
(25, NULL, 'trail', 'Add attendance in DUSAP', 1539533829),
(26, NULL, 'trail', 'Made changes to the CMS', 1539706258),
(27, NULL, 'trail', 'Admin made changes to the CMS', 1539706408),
(28, NULL, 'trail', 'Add attendance in DUSAP', 1540392895),
(29, NULL, 'trail', 'Add attendance in DUSAP', 1540392983),
(30, NULL, 'trail', 'Finish attendance in DUSAP', 1540394653),
(31, NULL, 'trail', 'Finish attendance in DUSAP', 1540394791),
(32, NULL, 'trail', 'Add attendance in DUSAP', 1540396274),
(33, NULL, 'trail', 'Finish attendance in DUSAP', 1540397178),
(34, NULL, 'trail', 'Finish attendance in DUSAP', 1540397251),
(35, NULL, 'trail', 'Admin made changes to the CMS', 1540397565),
(36, 2, 'log', 'Logged in', 1540397654),
(37, NULL, 'trail', 'Admin made changes to the CMS', 1540397993),
(38, NULL, 'trail', 'Admin made changes to the CMS', 1540398008),
(39, NULL, 'trail', 'Finish attendance in DUSAP', 1540398197),
(40, 2, 'log', 'Logged out', 1540398500),
(41, NULL, 'trail', 'Admin made changes to the CMS', 1540398965),
(42, NULL, 'trail', 'Admin made changes to the CMS', 1540480304),
(43, 4, 'log', 'Logged in', 1541325738),
(44, NULL, 'log', 'Logged out', 1541333343),
(45, NULL, 'trail', 'Add attendance in DUSAP', 1544711439),
(46, NULL, 'trail', 'Filed an incident report', 1544713063);

-- --------------------------------------------------------

--
-- Table structure for table `minor_reports`
--

CREATE TABLE `minor_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `violation_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `tapped_at` int(11) NOT NULL,
  `grouped_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `deleted_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minor_reports`
--

INSERT INTO `minor_reports` (`id`, `user_id`, `reporter_id`, `violation_id`, `group_id`, `location`, `message`, `tapped_at`, `grouped_at`, `created_at`, `deleted_at`) VALUES
(1, 1, 4, 1, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(2, 1, 4, 13, 1, '', '', 1541718000, 1541693309, 1541718000, 0),
(3, 1, 4, 1, 1, '', '', 1541718000, 1541693309, 1541718000, 0),
(4, 1, 4, 1, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(5, 2, 4, 1, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(6, 2, 4, 2, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(7, 2, 4, 1, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(8, 1, 4, 2, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(9, 1, 4, 2, 1, '', '', 1541718000, 1541693309, 1541718000, 0),
(10, 1, 4, 2, 1, '', '', 1541779200, 1541693309, 1541779200, 0),
(11, 1, 4, 3, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(12, 1, 4, 4, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(13, 2, 4, 4, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(14, 2, 4, 3, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(15, 2, 4, 2, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(16, 1, 4, 5, 1, '', '', 1541779200, 1541693309, 1541779200, 0),
(17, 1, 4, 5, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(18, 1, 4, 3, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(19, 2, 4, 6, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(20, 2, 4, 4, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(21, 1, 4, 2, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(22, 1, 4, 6, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(23, 1, 4, 8, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(24, 2, 4, 8, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(25, 2, 4, 7, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(26, 2, 4, 6, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(27, 1, 4, 9, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(28, 1, 4, 9, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(29, 1, 4, 7, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(30, 2, 4, 11, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(31, 2, 4, 8, 2, '', '', 1541685270, 1541693309, 1541685270, 0),
(32, 1, 4, 9, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(33, 1, 4, 10, 1, '', '', 1541685270, 1541693309, 1541685270, 0),
(34, 1, 4, 1, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(35, 1, 4, 2, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(36, 1, 4, 3, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(37, 1, 4, 4, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(38, 1, 4, 5, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(39, 1, 4, 6, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(40, 1, 4, 7, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(41, 1, 4, 8, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(42, 1, 4, 9, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(43, 1, 4, 10, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(44, 1, 4, 11, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(45, 1, 4, 12, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(46, 1, 4, 13, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(47, 1, 4, 14, 1, '', '', 1541865600, 1541693309, 1541865600, 0),
(48, 2, 4, 1, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(49, 2, 4, 2, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(50, 2, 4, 3, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(51, 2, 4, 4, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(52, 2, 4, 5, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(53, 2, 4, 6, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(54, 2, 4, 7, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(55, 2, 4, 8, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(56, 2, 4, 9, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(57, 2, 4, 10, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(58, 2, 4, 11, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(59, 2, 4, 12, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(60, 2, 4, 13, 2, '', '', 1541865600, 1541693309, 1541865600, 0),
(61, 2, 4, 14, 2, '', '', 1541865600, 1541693309, 1541865600, 0);

-- --------------------------------------------------------

--
-- Table structure for table `minor_reports_quota`
--

CREATE TABLE `minor_reports_quota` (
  `id` int(11) NOT NULL,
  `resolved_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minor_reports_quota`
--

INSERT INTO `minor_reports_quota` (`id`, `resolved_at`, `created_at`) VALUES
(1, 0, 1541693309),
(2, 0, 1541693309);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_number` varchar(9) NOT NULL,
  `user_serial_no` varchar(255) NOT NULL,
  `user_firstname` varchar(256) NOT NULL,
  `user_lastname` varchar(256) NOT NULL,
  `user_middlename` varchar(256) DEFAULT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_fcm_token` text NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_picture` varchar(256) NOT NULL,
  `user_course` varchar(256) DEFAULT NULL,
  `user_access` enum('student','teacher') NOT NULL,
  `user_isactive` tinyint(1) NOT NULL DEFAULT '1',
  `user_added_at` int(11) NOT NULL,
  `user_updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_number`, `user_serial_no`, `user_firstname`, `user_lastname`, `user_middlename`, `user_password`, `user_fcm_token`, `user_email`, `user_picture`, `user_course`, `user_access`, `user_isactive`, `user_added_at`, `user_updated_at`) VALUES
(1, '201511961', '72ADAFC4', 'Cham', 'Coscos', 'Mosquito', '8B5382D8441C3B21679FA89D75833E60888C49F8', '', 'hanzcoscos@gmail.com', 'images/student/dca2f1b853a2b0233c9a9f0983eab084.jpg', 'BSITWMA', 'student', 1, 1531202862, 1531623977),
(2, '201512570', '498590A4', 'Meryll', 'Rodriguez', 'Ponce De Leon', '5EBFFD12F0A9184A3D623016B860CCAE820FC35C', '', 'mirayrodriguez21@gmail.com', 'images/student/1d71346309099d931fa2fb9fdbf8cb60.jpg', 'BSITWMA', 'student', 1, 1531329730, 1531624031),
(3, '201510592', '735EE1D4', 'Ralph Adrian', 'Buen', NULL, 'D6424ECC823CA663BDCBAEA8E2D9DF58A4D0E2B8', '', 'rabuen@fit.edu.ph', 'images/student/c28aeafdba8274a90dba7e4072286433.jpg', 'BSITWMA', 'student', 1, 1531380182, 1531624066),
(4, '200812161', '', 'Jane', 'Doe', 'Allison', '4a82cb6db537ef6c5b53d144854e146de79502e8', 'duqCoAe6srQ:APA91bHCzB5ZAjacrMEoRWRafi07Q6Wpay8SZsMRfMXr1zzyqSwac8hReMjQzc7IIXcc8lE4Taq9p10f-liUdD8BRSLJzywBqUwBireZ6Nf75R_8N580Y0APSkah2jyXMvY6np1qQZt6', 'jda@fit.edu.ph', 'images/teacher/f63c2792c8d1553e7dd418a064e932ea.png', NULL, 'teacher', 1, 1531555055, 1535794831),
(5, '201512030', 'DB99AFC4', 'Trisha', 'Cunanan', 'Balingit', 'B4C644ED8FA2EB260BA20F361E02BCF05C312D14', '', 'trishikim@gmail.com', 'images/student/27c88789c0d90160620c3502ab66586a.jpg', 'BSITWMA', 'student', 1, 1535793953, 1535794002);

-- --------------------------------------------------------

--
-- Table structure for table `violation`
--

CREATE TABLE `violation` (
  `violation_id` int(11) NOT NULL,
  `violation_name` varchar(197) DEFAULT NULL,
  `violation_type` enum('minor','major') DEFAULT NULL,
  `violation_category` enum('default','other') NOT NULL,
  `violation_added_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `violation`
--

INSERT INTO `violation` (`violation_id`, `violation_name`, `violation_type`, `violation_category`, `violation_added_at`) VALUES
(1, 'not wearing proper uniform', 'minor', 'default', 1531446357),
(2, 'multiple entry without ID', 'minor', 'default', 1531446357),
(3, 'possession of offensive/subversive materials', 'minor', 'default', 1531446357),
(4, 'possession of pornographic materials', 'minor', 'default', 1531446357),
(5, 'possession of stun gun or any harmful electronic gadget', 'minor', 'default', 1531446357),
(6, 'possession of cigarette and e-cigarette', 'minor', 'default', 1531446357),
(7, 'simple misconduct', 'minor', 'default', 1531446357),
(8, 'smoking', 'minor', 'default', 1531446357),
(9, 'loitering', 'minor', 'default', 1531446357),
(10, 'cutting of classes', 'minor', 'default', 1531446357),
(11, 'eating in restricted areas', 'minor', 'default', 1531446357),
(12, 'unauthorized use of school facilities', 'minor', 'default', 1531446357),
(13, 'unauthorized use of electronic gadgets', 'minor', 'default', 1531446357),
(14, 'lending/borrowing of Identification Card', 'minor', 'default', 1531446357),
(15, 'possession of alcoholic drink/prohibited drug', 'major', 'default', 1531446357),
(16, 'being under the influence of liquor/prohibited drugs', 'major', 'default', 1531446357),
(17, 'possession of deadly weapon', 'major', 'default', 1531446357),
(18, 'disrespect', 'major', 'default', 1531446357),
(19, 'vandalism', 'major', 'default', 1531446357),
(20, 'dishonesty', 'major', 'default', 1531446357),
(21, 'behavior outside the campus specially during internship which bring dishonor to the Institute', 'major', 'default', 1531446357),
(22, 'creating barricades/obstruction', 'major', 'default', 1531446357),
(23, 'destruction of school facilities or properties', 'major', 'default', 1531446357),
(24, 'assault/physical injury', 'major', 'default', 1531446357),
(25, 'hazing', 'major', 'default', 1531446357),
(26, 'harassment', 'major', 'default', 1531446357),
(27, 'possession of explosive materials', 'major', 'default', 1531446357),
(28, 'sexual abuse', 'major', 'default', 1531446357),
(29, 'use of unauthorized electronic software/program', 'major', 'default', 1531446357),
(30, 'involvement in fraternity-related disorders', 'major', 'default', 1531446357),
(31, 'multiple minor offenses', 'major', 'default', 1531446357),
(32, 'gambling', 'major', 'default', 1531446357),
(33, 'public display of intimacy', 'major', 'default', 1531446357),
(34, 'distribution of offensive/subversive materials', 'major', 'default', 1531446357),
(35, 'grave threat by any means', 'major', 'default', 1531446357),
(36, 'inciting to fight', 'major', 'default', 1531446357),
(37, 'indecent or immoral conduct', 'major', 'default', 1531446357),
(38, 'conducting and/or representing the Institute in any student activity without the endorsement of SACSO and approval of the Institute.', 'major', 'default', 1531446357),
(39, 'cheating', 'major', 'default', 1531446357),
(40, 'stealing', 'major', 'default', 1531446357),
(41, 'violence against women (RA 9262: An act defining violence against women and their children, providing for protective measures for victims, prescribing penalties therefore and for other Institution)', 'major', 'default', 1531446357),
(42, 'plagiarism (as covered by policy code P504014003 of QAO)', 'major', 'default', 1531446357),
(43, 'maligning the Institute through any means including social media', 'major', 'default', 1531446357),
(44, 'falsification of documents', 'major', 'default', 1531446357),
(45, 'misrepresentation', 'major', 'default', 1531446357),
(46, 'illegal recruitment', 'major', 'default', 1531446357);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `fk_dussap_incident_report_id` (`incident_report_id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`cms_id`);

--
-- Indexes for table `effects`
--
ALTER TABLE `effects`
  ADD PRIMARY KEY (`effect_id`);

--
-- Indexes for table `incident_report`
--
ALTER TABLE `incident_report`
  ADD PRIMARY KEY (`incident_report_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_violation_id_2` (`violation_id`),
  ADD KEY `fk_student_reported_by` (`user_reported_by`),
  ADD KEY `fk_ir_ref_id` (`incident_report_ref_id`),
  ADD KEY `fk_effects_id` (`effects_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_audit_trail_user_id` (`user_id`);

--
-- Indexes for table `minor_reports`
--
ALTER TABLE `minor_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minor_reports_quota`
--
ALTER TABLE `minor_reports_quota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `violation`
--
ALTER TABLE `violation`
  ADD PRIMARY KEY (`violation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `cms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `effects`
--
ALTER TABLE `effects`
  MODIFY `effect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incident_report`
--
ALTER TABLE `incident_report`
  MODIFY `incident_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `minor_reports`
--
ALTER TABLE `minor_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `minor_reports_quota`
--
ALTER TABLE `minor_reports_quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `violation`
--
ALTER TABLE `violation`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incident_report`
--
ALTER TABLE `incident_report`
  ADD CONSTRAINT `fk_effects_id` FOREIGN KEY (`effects_id`) REFERENCES `effects` (`effect_id`),
  ADD CONSTRAINT `fk_ir_ref_id` FOREIGN KEY (`incident_report_ref_id`) REFERENCES `incident_report` (`incident_report_id`),
  ADD CONSTRAINT `fk_student_reported_by` FOREIGN KEY (`user_reported_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_violation_id_2` FOREIGN KEY (`violation_id`) REFERENCES `violation` (`violation_id`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_audit_trail_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
