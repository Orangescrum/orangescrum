

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orangescrum`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `action` text COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_group` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
(1, '88a0ef43b19c03aa6d17a91080ccf193', 1, 'Create Task', 'Create', 1, '2017-03-15 04:41:20', '2017-03-15 04:41:20'),
(2, '29f5ef81468b813a1c1856c200bf50e7', 1, 'Edit Task', 'Edit My Task', 1, '2017-03-15 04:50:20', '2017-03-15 04:50:20'),
(3, '71de5ef0880310a7e2b2593ee6292973', 1, 'Reply on Task', 'Reply', 1, '2017-03-15 05:14:24', '2017-03-15 05:14:24'),
(4, 'd2d535876ba366a1045c08b5e3438d23', 1, 'Delete Task', 'Delete My Task', 2, '2017-03-16 03:54:45', '2017-03-16 03:54:45'),
(5, '7a184221ad371e56dfc955d64d8e4bdc', 1, 'Move to Milestone', 'Move to Taskgroup/Sprint', 1, '2017-03-16 03:58:43', '2017-03-16 03:58:43'),
(6, '83f311f3cda05a2170c4be30bc01caf4', 1, 'Move to Project', 'Move to Project', 1, '2017-03-16 03:59:01', '2017-03-16 03:59:01'),
(7, '028d11d076ceeada460765cce617a05b', 1, 'Change Assigned to', 'Change Assign to', 1, '2017-03-16 03:59:22', '2017-03-16 03:59:22'),
(8, 'add14f1ef72f8086f9e3b74c331eb461', 1, 'Change Status of Task', 'Update Task Status', 1, '2017-03-16 03:59:47', '2017-03-16 03:59:47'),
(9, 'a4d02d07ef2da4666ecb231f88048214', 1, 'Change Other Details of Task', 'Update Other Details', 1, '2017-03-16 04:01:12', '2017-03-16 04:01:12'),
(10, '71ad7936b4d64aa912e47f26d36cc2a8', 1, 'Archive Task', 'Archive My Task', 2, '2017-03-16 04:01:45', '2017-03-16 04:01:45'),
(11, '9da30cd8ece12fc783be9153c244920b', 1, 'Download Task', 'Download Tasks', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(12, '0c16733ba363ce3a60261f2ad46f161a', 2, 'Upload File to Task', 'Upload', 1, '2017-03-16 04:07:13', '2017-03-16 04:07:13'),
(13, 'c75ba6399e01301198440001cee31426', 2, 'View File', 'View', 0, '2017-03-16 04:07:31', '2017-03-16 04:07:31'),
(14, '3bbe643120d9ef8b0dce477023a08b03', 2, 'Delete File', 'Delete', 2, '2017-03-16 04:07:56', '2017-03-16 04:07:56'),
(15, 'a3a43c0509667c28d328396bb4dc5f99', 2, 'Archive File', 'Archive', 2, '2017-03-16 04:08:17', '2017-03-16 04:08:17'),
(16, '490b32b19c4dbd7a472d8ceb6a468193', 2, 'Download File', 'Download', 1, '2017-03-16 04:08:55', '2017-03-16 04:08:55'),
(17, '8d503535080301d79795afe068018cb5', 5, 'Create Project', 'Create', 1, '2017-03-16 04:09:46', '2017-03-16 04:09:46'),
(18, 'e20003ba22fd5fb53bd1a0e5cd4c775c', 5, 'Edit Project', 'Edit', 1, '2017-03-16 04:10:04', '2017-03-16 04:10:04'),
(20, 'adfb9b97fbae43ae8e4b6a1612fe0e8d', 5, 'Add Users to Project', 'Add User', 1, '2017-03-16 04:11:21', '2017-03-16 04:11:21'),
(21, 'c1ce5e22a8e70841a658510e33c55b0a', 5, 'Remove Users from Project', 'Remove User', 1, '2017-03-16 04:11:45', '2017-03-16 04:11:45'),
(22, 'd143ad0e7db7c7b909710e3c970f5e48', 6, 'Add New User', 'Add/Invite', 1, '2017-03-16 04:12:14', '2017-03-16 04:12:14'),
(23, '6e42c1fdd74726634aa4668b00f547ec', 6, 'Disable Users', 'Disable', 1, '2017-03-16 04:12:45', '2017-03-16 04:12:45'),
(24, 'f56b2d328327a37b7631f0d504b9e5a0', 6, 'Delete User', 'Delete', 2, '2017-03-16 04:13:16', '2017-03-16 04:13:16'),
(25, '2533053bd50837ad04bbc8140af8cb2a', 8, 'View Dashboard', 'View', 0, '2017-03-16 04:14:02', '2017-03-16 04:14:02'),
(26, 'cb98b48eb7249fb65e3148ca747259d9', 10, 'Create Milestone', 'Create', 1, '2017-03-16 04:14:32', '2017-03-16 04:14:32'),
(27, 'e491f3d9f36cbac3b3f026613cc66525', 10, 'Edit Milestone', 'Edit', 1, '2017-03-16 04:15:12', '2017-03-16 04:15:12'),
(28, '2542d2a6872171391049fa4baa91848a', 10, 'View Milestones', 'View', 0, '2017-03-16 04:15:43', '2017-03-16 04:15:43'),
(29, 'feec1df0ed2e386fc0d74e8133262303', 10, 'Mark Milestone as Completed', 'Mark as Completed', 1, '2017-03-16 04:17:47', '2017-03-16 04:17:47'),
(30, 'c472d95119165768abe7cb5d8e081df9', 10, 'Delete Milestone', 'Delete', 2, '2017-03-16 04:18:23', '2017-03-16 04:18:23'),
(31, 'aede0fd63f707235cb702a7c4c0dcac0', 10, 'Assign Milestone to User', 'Assign to User', 1, '2017-03-16 04:19:48', '2017-03-16 04:19:48'),
(32, '8970492a7dc1323d81f638c120f3b630', 10, 'Add Tasks to MIlestone', 'Add Task', 1, '2017-03-16 04:20:22', '2017-03-16 04:20:22'),
(34, '81cb8c20a9e8a4b536a3c77227807b83', 6, 'Assign Project', 'Assign Project', 1, '2017-03-16 10:57:35', '2017-03-16 10:57:35'),
(35, '3614e89ea6b7c5f0739cbf4a46ba47b5', 6, 'Remove Project', 'Remove Project', 1, '2017-03-16 10:58:05', '2017-03-16 10:58:05'),
(36, '0979a8fb4f44cf1b782ae08988c68bec', 6, 'View Users', 'View', 0, '2017-03-16 11:02:20', '2017-03-16 11:02:20'),
(37, '1def05f812231bb6e854b73de0dd9673', 6, 'Enable User', 'Enable', 1, '2017-03-16 11:20:39', '2017-03-16 11:20:39'),
(41, '541c2ebbd0185def982d78035fb9a87b', 1, 'View Kanban', 'Kanban', 0, '2017-03-23 05:35:47', '2017-03-23 05:35:47'),
(42, 'acbc1dad47ae0653405e4cec534c6c92', 11, 'Set Daily Catch-Up', NULL, 0, '2017-03-23 05:38:31', '2017-03-23 05:38:31'),
(43, 'b6f17e07d7975ae5916802606b3db138', 1, 'View Calendar', 'Calendar', 0, '2017-03-23 05:41:12', '2017-03-23 05:41:12'),
(48, '88a0ef43b19c03aa6d17a91080ccf19j', 3, 'Manual Time Entry', 'Manual Time Entry', 1, '2017-03-15 04:41:20', '2017-03-15 04:41:20'),
(49, '29f5ef81468b813a1c1856c200bf50ef', 3, 'Start Timer', 'Start Timer', 1, '2017-03-15 04:50:20', '2017-03-15 04:50:20'),
(50, '71de5ef0880310a7e2b2593ee6292979', 3, 'Edit Timelog Entry', 'Edit Timelog Entry', 1, '2017-03-15 05:14:24', '2017-03-15 05:14:24'),
(51, 'd2d535876ba366a1045c08b5e3438d28', 3, 'Delete Timelog Entry', 'Time Log', 2, '2017-03-16 03:54:45', '2017-03-16 03:54:45'),
(52, '7a184221ad371e56dfc955d64d8e4bdi', 4, 'Create Invoice', 'Create', 1, '2017-03-16 03:58:43', '2017-03-16 03:58:43'),
(53, '83f311f3cda05a2170c4be30bc01cafv', 4, 'Edit Invoice', 'Edit', 1, '2017-03-16 03:59:01', '2017-03-16 03:59:01'),
(54, '028d11d076ceeada460765cce617a05u', 4, 'View Invoices', 'View', 0, '2017-03-16 03:59:22', '2017-03-16 03:59:22'),
(55, 'add14f1ef72f8086f9e3b74c331eb46h', 4, 'Download or Print Invoice', 'Download or Print', 1, '2017-03-16 03:59:47', '2017-03-16 03:59:47'),
(56, 'a4d02d07ef2da4666ecb231f8804821d', 4, 'Add Customer', 'Add Customer', 1, '2017-03-16 04:01:12', '2017-03-16 04:01:12'),
(57, '71ad7936b4d64aa912e47f26d36cc2a7', 4, 'Edit Customer', 'Edit Customer', 1, '2017-03-16 04:01:45', '2017-03-16 04:01:45'),
(59, '9da30cd8ece12fc783be9153c244920g', 7, 'View Gantt Chart', 'View', 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(60, '9da30cd8ece12fc783be9153c2423ty8', 15, 'Add Expense', NULL, 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(61, '9da30cd8ece12fc783be9153c2423hu5', 15, 'View Expense', NULL, 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(62, '9da30cd8ece12fc783be9153c242oi6n', 16, 'Add Wiki', 'Create', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(63, '9da30cd8ece12fc783be9153c24ju2u7', 16, 'View Wiki', 'View', 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(64, '9da30cd8ece12fc783be9153c24ui8f3', 16, 'Comment On Wiki', 'Comment on Wiki', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(65, '9da30cd8ece12fc783be9153c240o33i', 7, 'View And Edit Gantt Chart', 'Edit', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(66, '88a0ef43b19c03aa6d17a91080c32jkl', 3, 'View Resource Utilization', 'Resource Utilization', 0, '2018-03-15 04:41:20', '2018-03-15 04:41:20'),
(67, '29f5ef81468b813a1c1856c200bokm25', 3, 'View Resource Availability', 'Resource Availability', 0, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(68, '96df5f81468b813a1c1856c200bokm25', 3, 'Add Leave', 'Add Leave', 1, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(69, '88a0ef43b19c03aa6d17a91080c896kh', 17, 'View Daily Catchup', 'View Daily Catchup', 0, '2018-03-15 04:41:20', '2018-03-15 04:41:20'),
(79, '88a0ef43b19c03aa6d17a91080c96df3', 4, 'Archive Invoice', 'Archive', 2, '2018-03-15 04:41:20', '2018-03-15 04:41:20'),
(80, '88a0ef43b19c03aa6d17a91080copyh5', 4, 'Restore Invoice', 'Restore', 1, '2018-03-15 04:41:20', '2018-03-15 04:41:20'),
(81, '29f5ef81468b813a1c1856c200bopl65', 4, 'Delete Invoice', 'Delete', 2, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(82, '29f5ef81468b813a1c1856c200b96lkn', 4, 'Mark paid Invoice', 'Mark as Paid', 1, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(83, '29f5ef81468b813a1c1856c200bopj65', 4, 'Mark unpaid Invoice', 'Mark as Unpaid', 1, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(84, '29f5ef81468b813a1c1856c200b632ng', 4, 'Email Invoice', 'Email', 1, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(85, '88a0ef43b19c03aa6d17a91080ciuw85', 4, 'View Invoice Setting', 'Invoice Setting', 0, '2018-03-15 04:41:20', '2018-03-15 04:41:20'),
(86, '29f5ef81468b813a1c1856c200bwqsd5', 4, 'Edit Invoice Setting', 'Edit Invoice Setting', 1, '2018-03-15 04:50:20', '2018-03-15 04:50:20'),
(92, 'p07vrcd8ece12fc783be9153c24olkj5', 1, 'View All Task', 'All Task', 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(93, 'p07vrcd8ece12fc783be9153c24olkj6', 1, 'Link Task', 'Link Task', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(94, 'p07vrcd8ece12fc783be9153c24olkj7', 1, 'Est Hours', 'Update Est. Hours', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(95, 'p07vrcd8ece12fc783be9153c24olkj8', 1, 'Add Label', 'Add Label', 1, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(96, 'p07vrcd8ece12fc783be9153c24olkj9', 1, 'Remove Archive Task', 'Delete Archive Tasks', 2, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(97, 'p07vrcd8ece12fc783be9153c24olkk1', 1, 'Restore Archive Task', 'Restore Archive Tasks', 2, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(98, 'p07vrcd8ece12fc783be9153c24olkk2', 0, 'Notcomplete Project', NULL, 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(99, 'p07vrcd8ece12fc783be9153c24olkk5', 0, 'Complete Project', NULL, 0, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(100, 'p07vrcd8ece12fc783be9153c24olk33', 1, 'Remove Link Task', 'Delete Link Tasks', 2, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(101, 'p07vrcd8ece12fc783be9153c24olk44', 1, 'Remove Label', 'Label', 2, '2017-03-16 04:02:05', '2017-03-16 04:02:05'),
(102, 'p07vrcd8ece12fc983ce9153c24olkk2', 5, 'View Project', 'View', 0, '2019-04-15 02:09:25', '2019-04-15 02:09:25'),
(103, 'p08vrcd8ece12fc983ce9153c24olkk3', 1, 'Edit All Task', 'Edit All Task', 1, '2019-04-17 01:00:00', '2019-04-17 01:00:00'),
(104, 'p0dvrcd8ece12fc983ce9153c24olkk3', 1, 'Delete All Task', 'Delete All Task', 2, '2019-04-17 01:00:00', '2019-04-17 01:00:00'),
(105, 'p0evrcd8ece12fc983ce9153c24olkk4', 1, 'Archive All Task', 'Archive All Task', 2, '2019-04-17 01:00:00', '2019-04-17 01:00:00'),
(106, 'p0evrcd8ece12fc983ce9153c24olkk5', 3, 'View All Timelog', 'View All Timelog', 0, '2019-04-17 01:00:00', '2019-04-17 01:00:00'),
(107, 'p0evrcd8ece12fc983ce9153c24olkk6', 3, 'View All Resource', 'View All Resource', 0, '2019-04-17 01:00:00', '2019-04-17 01:00:00'),
(108, '88a0ef43b16d53aa6d17a91080ccf193', 1, 'Status change except Close', 'Close Task', 1, '2019-03-15 04:41:20', '2019-03-15 04:41:20'),
(109, '88a0ef63b19c03aa6d16a91080ccf193', 1, 'Update Task Duedate', 'Change Due date', 1, '2019-08-16 00:00:00', '2019-08-16 00:00:00'),
(110, '88a0egt6b19c03aa6d17a91080ccf000', 5, 'Customer Name', 'Customer Name', 0, '2020-11-25 04:41:20', '2020-11-25 04:41:20'),
(111, '29f5ef27668b813a1c1856c200bf5110', 5, 'Budget', 'Budget', 0, '2020-11-25 04:50:20', '2020-11-25 04:50:20'),
(112, '71de5ef9800310a7e2b2593ee62929ws', 5, 'Default Rate', 'Default Rate', 0, '2020-11-25 05:14:24', '2020-11-25 05:14:24'),
(113, 'd2d533496ba366a1045c08b5e3438dxe', 5, 'Maximum Tolerance', 'Maximum Tolerance', 0, '2020-11-25 03:54:45', '0000-00-00 00:00:00'),
(114, '7cf54221ad371e56dfc955d64d8e4bpc', 5, 'Minimum Tolerance', 'Minimum Tolerance', 0, '2020-11-25 03:58:43', '2020-11-25 03:58:43'),
(115, '45t0egt6b19c03aa6d17a91080ccf000', 5, 'Cost Appr', 'Cost Approved', 0, '2020-11-25 03:58:43', '2020-11-25 03:58:43'),
(116, '88a0ef43b19c03aa6d17a91080cr45bg', 3, 'Time Entry On Closed Task', 'Time Entry On Closed Task', 1, '2020-12-19 11:35:13', '2020-12-19 11:35:13'),
(117, '88a0ef43b19c03aa6d17a91080nhud4n', 3, 'Time Entry Greater Than Estimated Hour', 'Time Entry Greater Than Estimated Hour', 1, '2020-12-19 11:35:13', '2020-12-19 11:35:13'),
(118, '88a0ef43b20c03aa6d17a91080nhud4n', 3, 'Edit Time Log For All', 'Edit Time Log For All Users', 1, '2021-02-05 11:35:13', '2021-02-05 11:35:13'),
(119, '88a0ef43b19c03aa6d17a91080chgfc8', 3, 'View Resource Allocation Report', 'View Resource Allocation Report', 0, '2021-07-21 10:56:05', '2021-07-21 10:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `approve_wikis`
--

CREATE TABLE `approve_wikis` (
  `id` int(11) NOT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `wiki_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `archives`
--

CREATE TABLE `archives` (
  `id` int(250) NOT NULL,
  `easycase_id` int(250) NOT NULL,
  `case_file_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1-archive,2-move,3-delete',
  `company_id` int(11) NOT NULL,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `beta_users`
--

CREATE TABLE `beta_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invit_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_approve` tinyint(2) NOT NULL DEFAULT 0,
  `is_admin_invited` tinyint(1) NOT NULL DEFAULT 0,
  `registered_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_actions`
--

CREATE TABLE `case_actions` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `action` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1-Close, 2-Start',
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_activities`
--

CREATE TABLE `case_activities` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `comment_id` int(11) NOT NULL COMMENT 'Foreign key of "comments"',
  `case_no` smallint(6) NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `type` tinyint(4) NOT NULL COMMENT '1-New 2-Opened, 3-Closed, 4-Start, 5-Resolve, 7-Comments, 8-Deleted,10->Modified',
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active',
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_comments`
--

CREATE TABLE `case_comments` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `comments` text CHARACTER SET latin1 NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `dt_created` datetime NOT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_editor_files`
--

CREATE TABLE `case_editor_files` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(64) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `easycase_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT 0 COMMENT 'in kb',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0-new, 1-deleted, 2- exist',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case_files`
--

CREATE TABLE `case_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `comment_id` int(11) NOT NULL COMMENT 'Foreign key of "case_comments"',
  `file` varchar(222) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `upload_name` varchar(255) DEFAULT NULL,
  `thumb` varchar(222) NOT NULL,
  `file_size` decimal(7,1) NOT NULL,
  `count` smallint(6) NOT NULL,
  `downloadurl` text DEFAULT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_file_drives`
--

CREATE TABLE `case_file_drives` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `file_info` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_filters`
--

CREATE TABLE `case_filters` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL COMMENT 'Foreign Key of "Users"',
  `order` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_recents`
--

CREATE TABLE `case_recents` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_reminders`
--

CREATE TABLE `case_reminders` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `reminder_datetime` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `is_emailed` tinyint(2) NOT NULL DEFAULT 0,
  `user_ids` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_removed_files`
--

CREATE TABLE `case_removed_files` (
  `id` int(11) NOT NULL,
  `case_file_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `case_file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case_settings`
--

CREATE TABLE `case_settings` (
  `id` int(250) NOT NULL,
  `project_id` int(250) NOT NULL,
  `project_uniqid` varchar(250) NOT NULL,
  `type_id` int(250) NOT NULL,
  `assign_to` int(250) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `due_date` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_templates`
--

CREATE TABLE `case_templates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `case_templates`
--

INSERT INTO `case_templates` (`id`, `user_id`, `company_id`, `name`, `description`, `is_active`, `created`) VALUES
(2, 19, 1, 'Status update', '<p><strong>Today\'s accomplishment:</strong></p>\r\n<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\r\n<ul>\r\n<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\r\n<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\r\n<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp;<strong>Task no: 125</strong></p>\r\n<ul>\r\n<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\r\n<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\r\n<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\r\n</ul>\r\n<p><br /> <strong>List of files changed:</strong></p>\r\n<ol>\r\n<li>index.html</li>\r\n<li>style.css</li>\r\n<li>contact-us.html</li>\r\n</ol>\r\n<p>Is code checked in Repository: <strong>Y/N</strong><br /> Is code available in Stager: <strong>Y/N</strong> </p>\r\n<p><strong>Blocker/Testing Issues:</strong></p>\r\n<p><strong>Milestone Update: &lt; Specify Milestone name here &gt;</strong></p>\r\n<p>&nbsp; &nbsp;1. Total tasks:</p>\r\n<p>&nbsp; &nbsp;2. # of Work in Progress tasks:</p>\r\n<p>&nbsp; &nbsp;3. # of Resolve tasks:</p>\r\n<p>&nbsp; &nbsp;4. # of tasks not started:</p>\r\n<p><br /> <strong>Next Day\'s Plan:</strong></p>', 1, '0000-00-00 00:00:00'),
(8, 515, 2, 'New', 'New Template', 1, '2013-02-12 06:54:28'),
(9, 615, 30, 'NEW TEMPLATE', 'TO DO<br />1.<br />2.', 1, '2013-09-29 06:51:13'),
(10, 487, 404, 'Bug', '<b>Browser version:</b>\n			<br/>\n			<b>OS version:</b>\n			<br/><br/>\n			<b>Url:</b>\n			<br/><br/>\n			<b>What is the test case:</b><br/>\n			<b>What is the expected result:</b><br/>\n			<b>What is the actual result:</b><br/><br/>\n\n			<b>Is it happening all the time or intermittently:</b><br/>\n			<br/>\n			<b>Attach screenshots:</b>', 1, '2013-11-06 12:42:47'),
(11, 487, 404, 'Change Request', '<p><strong>Change Requested:</strong></p>\n		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\n		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 125</strong></p>\n		<p><strong>Today\'s accomplishment:</strong></p>\n		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\n		<ul>\n		<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n		<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n		<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n		</ul>\n		<p>&nbsp; &nbsp; &nbsp;<strong>Task no: 125</strong></p>\n		<ul>\n		<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n		<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n		<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n		</ul>\n		<p><br /> <strong>List of files changed:</strong></p>\n		<ol>\n		<li>index.html</li>\n		<li>style.css</li>\n		<li>contact-us.html</li>\n		</ol>\n		<p>Is code checked in Repository: <strong>Y/N</strong><br /> Is code available in Stager: <strong>Y/N</strong> </p>\n		<p><strong>Blocker/Testing Issues:</strong></p>\n		<p><strong>Milestone Update: &lt; Specify Milestone name here &gt;</strong></p>\n		<p>&nbsp; &nbsp;1. Total tasks:</p>\n		<p>&nbsp; &nbsp;2. # of Work in Progress tasks:</p>\n		<p>&nbsp; &nbsp;3. # of Resolve tasks:</p>\n		<p>&nbsp; &nbsp;4. # of tasks not started:</p>\n		<p><br /> <strong>Next Day\'s Plan:</strong></p>', 1, '2013-11-06 12:42:47'),
(12, 487, 404, 'Meeting Minute', '<b>Attendees:</b>  John, Micheal<br/>\n				<b>Date and Time:</b> July 11th 11 am PST<br/>\n				<b>Purpose:</b><br/>\n				<br/>\n				<b>Agenda:</b> \n				<o>\n				    <li>Discuss Layout </li>\n				    <li>Discuss on Design</li>\n				</ol>\n				<br/>\n				<b>Discussion:</b><br/>', 1, '2013-11-06 12:42:47'),
(14, 487, 404, 'Status update', '<b>Today\'s accomplishment</b><br/>\n		<ul>\n		    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n		    <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n		    <li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n		    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n		    <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n		    <li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n		</ul>\n		<br/>\n		<b>List of files changed:</b> \n		<ol>\n		    <li>index.html</li>\n		    <li>style.css</li>\n		    <li>contact-us.html</li>\n		</ol>\n		Is  code checked in Repository: <b>Y/N</b><br/>\n		Is code available in Stager: <b>Y/N</b>\n		<br/><br/>\n		<b>Blocker/Testing Issues:</b> \n		<br/><br/>\n		<b>Next Day\'s Plan:</b>', 1, '2013-11-06 12:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `case_user_emails`
--

CREATE TABLE `case_user_emails` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `ismail` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Stop Mailing, 1-Email Me'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `case_user_views`
--

CREATE TABLE `case_user_views` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL COMMENT 'Foreign key of "easycases"',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `istype` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-New, 2-Reply, 3-Closed, 4-Start, 5-Edit',
  `isviewed` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0-Not Viewed, 1-Viewed',
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--

--
-- Table structure for table `check_lists`
--

CREATE TABLE `check_lists` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT 0,
  `sequence` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `uniq_id` mediumtext DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `seo_url` varchar(250) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `contact_phone` varchar(100) NOT NULL,
  `referrer` mediumtext DEFAULT NULL,
  `industry_id` int(11) NOT NULL DEFAULT 0,
  `work_hour` int(11) NOT NULL DEFAULT 8,
  `week_ends` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_last_login` datetime NOT NULL,
  `is_beta` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1->Beta company , 0-> Default',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:Active , 2: Cancelled ',
  `is_deactivated` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1-> Auto Deactivated , 2-> Deactivated by admin,3->Disable By admin,0-> Default ',
  `is_skipped` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0:No, 1: Yes',
  `twitted` tinyint(2) NOT NULL DEFAULT 0,
  `refering_plan_id` int(11) NOT NULL DEFAULT 0,
  `country_name` varchar(150) NOT NULL DEFAULT 'no',
  `new_layout_no` tinyint(2) NOT NULL DEFAULT 0,
  `is_per_user` tinyint(2) NOT NULL DEFAULT 0,
  `plan_user_count` tinyint(3) NOT NULL DEFAULT 0,
  `is_delete_checked` tinyint(2) NOT NULL DEFAULT 0,
  `add_defect_master` tinyint(2) DEFAULT 0,
  `auth_token` varchar(255) DEFAULT NULL,
  `api_access_code` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_apis`
--

CREATE TABLE `company_apis` (
  `id` int(12) NOT NULL,
  `company_id` int(12) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `is_active` smallint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `user_id` int(12) NOT NULL DEFAULT 0,
  `project_id` int(12) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for table `company_holidays`
--

CREATE TABLE `company_holidays` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `holiday` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

CREATE TABLE `company_users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_uniq_id` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1-owner,2-Admin,3-member',
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active,2- Not confirmed , 3- Deleted user',
  `is_access_change` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-email changed, 2-password changed, 3-user to admin, 4-user to client, 5 - Admin to client, 6 - client to user, 7 - client to admin, 8 - disable user',
  `change_timestamp` bigint(20) NOT NULL DEFAULT 0,
  `is_client` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1:client',
  `role_id` int(11) NOT NULL DEFAULT 0,
  `est_billing_amt` float(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Keep the estimated billing amount for the period',
  `act_date` datetime DEFAULT NULL,
  `billing_start_date` datetime DEFAULT NULL,
  `billing_end_date` datetime DEFAULT NULL,
  `company_trial_expired` tinyint(2) NOT NULL DEFAULT 0,
  `google_token` text DEFAULT NULL,
  `is_dummy` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `ccode` varchar(2) NOT NULL DEFAULT '',
  `country` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `ccode`, `country`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AX', 'Aland Islands'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Anguilla'),
(9, 'AQ', 'Antarctica'),
(10, 'AG', 'Antigua and Barbuda'),
(11, 'AR', 'Argentina'),
(12, 'AM', 'Armenia'),
(13, 'AW', 'Aruba'),
(14, 'AU', 'Australia'),
(15, 'AT', 'Austria'),
(16, 'AZ', 'Azerbaijan'),
(17, 'BS', 'Bahamas'),
(18, 'BH', 'Bahrain'),
(19, 'BD', 'Bangladesh'),
(20, 'BB', 'Barbados'),
(21, 'BY', 'Belarus'),
(22, 'BE', 'Belgium'),
(23, 'BZ', 'Belize'),
(24, 'BJ', 'Benin'),
(25, 'BM', 'Bermuda'),
(26, 'BT', 'Bhutan'),
(27, 'BO', 'Bolivia'),
(28, 'BA', 'Bosnia and Herzegovina'),
(29, 'BW', 'Botswana'),
(30, 'BV', 'Bouvet Island'),
(31, 'BR', 'Brazil'),
(32, 'IO', 'British Indian Ocean Territory'),
(33, 'BN', 'Brunei Darussalam'),
(34, 'BG', 'Bulgaria'),
(35, 'BF', 'Burkina Faso'),
(36, 'BI', 'Burundi'),
(37, 'KH', 'Cambodia'),
(38, 'CM', 'Cameroon'),
(39, 'CA', 'Canada'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CD', 'Congo, The Democratic Republic of the'),
(52, 'CK', 'Cook Islands'),
(53, 'CR', 'Costa Rica'),
(54, 'CI', 'Cote D''Ivoire'),
(55, 'HR', 'Croatia'),
(56, 'CU', 'Cuba'),
(57, 'CY', 'Cyprus'),
(58, 'CZ', 'Czech Republic'),
(59, 'DK', 'Denmark'),
(60, 'DJ', 'Djibouti'),
(61, 'DM', 'Dominica'),
(62, 'DO', 'Dominican Republic'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equatorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'FK', 'Falkland Islands (Malvinas)'),
(71, 'FO', 'Faroe Islands'),
(72, 'FJ', 'Fiji'),
(73, 'FI', 'Finland'),
(74, 'FR', 'France'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GG', 'Guernsey'),
(91, 'GN', 'Guinea'),
(92, 'GW', 'Guinea-Bissau'),
(93, 'GY', 'Guyana'),
(94, 'HT', 'Haiti'),
(95, 'HM', 'Heard Island and McDonald Islands'),
(96, 'VA', 'Holy See (Vatican City State)'),
(97, 'HN', 'Honduras'),
(98, 'HK', 'Hong Kong'),
(99, 'HU', 'Hungary'),
(100, 'IS', 'Iceland'),
(101, 'IN', 'India'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran, Islamic Republic of'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IM', 'Isle of Man'),
(107, 'IL', 'Israel'),
(108, 'IT', 'Italy'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JE', 'Jersey'),
(112, 'JO', 'Jordan'),
(113, 'KZ', 'Kazakhstan'),
(114, 'KE', 'Kenya'),
(115, 'KI', 'Kiribati'),
(116, 'KP', 'Korea, Democratic People''s Republic of'),
(117, 'KR', 'Korea, Republic of'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People''s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macao'),
(130, 'MK', 'Macedonia, The Former Yugoslav Republic of'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'YT', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestinian Territory, Occupied'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'BL', 'Saint Barthelemy'),
(185, 'SH', 'Saint Helena'),
(186, 'KN', 'Saint Kitts and Nevis'),
(187, 'LC', 'Saint Lucia'),
(188, 'MF', 'Saint Martin'),
(189, 'PM', 'Saint Pierre and Miquelon'),
(190, 'VC', 'Saint Vincent and the Grenadines'),
(191, 'WS', 'Samoa'),
(192, 'SM', 'San Marino'),
(193, 'ST', 'Sao Tome and Principe'),
(194, 'SA', 'Saudi Arabia'),
(195, 'SN', 'Senegal'),
(196, 'RS', 'Serbia'),
(197, 'SC', 'Seychelles'),
(198, 'SL', 'Sierra Leone'),
(199, 'SG', 'Singapore'),
(200, 'SK', 'Slovakia'),
(201, 'SI', 'Slovenia'),
(202, 'SB', 'Solomon Islands'),
(203, 'SO', 'Somalia'),
(204, 'ZA', 'South Africa'),
(205, 'GS', 'South Georgia and the South Sandwich Islands'),
(206, 'ES', 'Spain'),
(207, 'LK', 'Sri Lanka'),
(208, 'SD', 'Sudan'),
(209, 'SR', 'Suriname'),
(210, 'SJ', 'Svalbard and Jan Mayen'),
(211, 'SZ', 'Swaziland'),
(212, 'SE', 'Sweden'),
(213, 'CH', 'Switzerland'),
(214, 'SY', 'Syrian Arab Republic'),
(215, 'TW', 'Taiwan, Province Of China'),
(216, 'TJ', 'Tajikistan'),
(217, 'TZ', 'Tanzania, United Republic of'),
(218, 'TH', 'Thailand'),
(219, 'TL', 'Timor-Leste'),
(220, 'TG', 'Togo'),
(221, 'TK', 'Tokelau'),
(222, 'TO', 'Tonga'),
(223, 'TT', 'Trinidad and Tobago'),
(224, 'TN', 'Tunisia'),
(225, 'TR', 'Turkey'),
(226, 'TM', 'Turkmenistan'),
(227, 'TC', 'Turks and Caicos Islands'),
(228, 'TV', 'Tuvalu'),
(229, 'UG', 'Uganda'),
(230, 'UA', 'Ukraine'),
(231, 'AE', 'United Arab Emirates'),
(232, 'GB', 'United Kingdom'),
(233, 'US', 'United States'),
(234, 'UM', 'United States Minor Outlying Islands'),
(235, 'UY', 'Uruguay'),
(236, 'UZ', 'Uzbekistan'),
(237, 'VU', 'Vanuatu'),
(238, 'VE', 'Venezuela'),
(239, 'VN', 'Viet Nam'),
(240, 'VG', 'Virgin Islands, British'),
(241, 'VI', 'Virgin Islands, U.S.'),
(242, 'WF', 'Wallis And Futuna'),
(243, 'EH', 'Western Sahara'),
(244, 'YE', 'Yemen'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED DEFAULT 0 COMMENT 'company using',
  `code` varchar(50) NOT NULL,
  `discount` float(7,2) DEFAULT NULL COMMENT 'bootstrap.php -> DISCOUNT',
  `discount_type` tinyint(2) NOT NULL DEFAULT 2 COMMENT '1=flat, 2=percentage',
  `expires` date DEFAULT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `ip` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `code` char(3) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `status`) VALUES
(1, 'Andorran Peseta', 'ADP', 'Active'),
(2, 'United Arab Emirates Dirham', 'AED', 'Active'),
(3, 'Afghanistan Afghani', 'AFA', 'Active'),
(4, 'Albanian Lek', 'ALL', 'Active'),
(5, 'Netherlands Antillian Guilder', 'ANG', 'Active'),
(6, 'Angolan Kwanza', 'AOK', 'Active'),
(7, 'Argentine Peso', 'ARS', 'Active'),
(9, 'Australian Dollar', 'AUD', 'Active'),
(10, 'Aruban Florin', 'AWG', 'Active'),
(11, 'Barbados Dollar', 'BBD', 'Active'),
(12, 'Bangladeshi Taka', 'BDT', 'Active'),
(14, 'Bulgarian Lev', 'BGN', 'Active'),
(15, 'Bahraini Dinar', 'BHD', 'Active'),
(16, 'Burundi Franc', 'BIF', 'Active'),
(17, 'Bermudian Dollar', 'BMD', 'Active'),
(18, 'Brunei Dollar', 'BND', 'Active'),
(19, 'Bolivian Boliviano', 'BOB', 'Active'),
(20, 'Brazilian Real', 'BRL', 'Active'),
(21, 'Bahamian Dollar', 'BSD', 'Active'),
(22, 'Bhutan Ngultrum', 'BTN', 'Active'),
(23, 'Burma Kyat', 'BUK', 'Active'),
(24, 'Botswanian Pula', 'BWP', 'Active'),
(25, 'Belize Dollar', 'BZD', 'Active'),
(26, 'Canadian Dollar', 'CAD', 'Active'),
(27, 'Swiss Franc', 'CHF', 'Active'),
(28, 'Chilean Unidades de Fomento', 'CLF', 'Active'),
(29, 'Chilean Peso', 'CLP', 'Active'),
(30, 'Yuan (Chinese) Renminbi', 'CNY', 'Active'),
(31, 'Colombian Peso', 'COP', 'Active'),
(32, 'Costa Rican Colon', 'CRC', 'Active'),
(33, 'Czech Republic Koruna', 'CZK', 'Active'),
(34, 'Cuban Peso', 'CUP', 'Active'),
(35, 'Cape Verde Escudo', 'CVE', 'Active'),
(36, 'Cyprus Pound', 'CYP', 'Active'),
(40, 'Danish Krone', 'DKK', 'Active'),
(41, 'Dominican Peso', 'DOP', 'Active'),
(42, 'Algerian Dinar', 'DZD', 'Active'),
(43, 'Ecuador Sucre', 'ECS', 'Active'),
(44, 'Egyptian Pound', 'EGP', 'Active'),
(45, 'Estonian Kroon (EEK)', 'EEK', 'Active'),
(46, 'Ethiopian Birr', 'ETB', 'Active'),
(47, 'Euro', 'EUR', 'Active'),
(49, 'Fiji Dollar', 'FJD', 'Active'),
(50, 'Falkland Islands Pound', 'FKP', 'Active'),
(52, 'British Pound', 'GBP', 'Active'),
(53, 'Ghanaian Cedi', 'GHC', 'Active'),
(54, 'Gibraltar Pound', 'GIP', 'Active'),
(55, 'Gambian Dalasi', 'GMD', 'Active'),
(56, 'Guinea Franc', 'GNF', 'Active'),
(58, 'Guatemalan Quetzal', 'GTQ', 'Active'),
(59, 'Guinea-Bissau Peso', 'GWP', 'Active'),
(60, 'Guyanan Dollar', 'GYD', 'Active'),
(61, 'Hong Kong Dollar', 'HKD', 'Active'),
(62, 'Honduran Lempira', 'HNL', 'Active'),
(63, 'Haitian Gourde', 'HTG', 'Active'),
(64, 'Hungarian Forint', 'HUF', 'Active'),
(65, 'Indonesian Rupiah', 'IDR', 'Active'),
(66, 'Irish Punt', 'IEP', 'Active'),
(67, 'Israeli Shekel', 'ILS', 'Active'),
(68, 'Indian Rupee', 'INR', 'Active'),
(69, 'Iraqi Dinar', 'IQD', 'Active'),
(70, 'Iranian Rial', 'IRR', 'Active'),
(73, 'Jamaican Dollar', 'JMD', 'Active'),
(74, 'Jordanian Dinar', 'JOD', 'Active'),
(75, 'Japanese Yen', 'JPY', 'Active'),
(76, 'Kenyan Schilling', 'KES', 'Active'),
(77, 'Kampuchean (Cambodian) Riel', 'KHR', 'Active'),
(78, 'Comoros Franc', 'KMF', 'Active'),
(79, 'North Korean Won', 'KPW', 'Active'),
(80, '(South) Korean Won', 'KRW', 'Active'),
(81, 'Kuwaiti Dinar', 'KWD', 'Active'),
(82, 'Cayman Islands Dollar', 'KYD', 'Active'),
(83, 'Lao Kip', 'LAK', 'Active'),
(84, 'Lebanese Pound', 'LBP', 'Active'),
(85, 'Sri Lanka Rupee', 'LKR', 'Active'),
(86, 'Liberian Dollar', 'LRD', 'Active'),
(87, 'Lesotho Loti', 'LSL', 'Active'),
(89, 'Libyan Dinar', 'LYD', 'Active'),
(90, 'Moroccan Dirham', 'MAD', 'Active'),
(91, 'Malagasy Franc', 'MGF', 'Active'),
(92, 'Mongolian Tugrik', 'MNT', 'Active'),
(93, 'Macau Pataca', 'MOP', 'Active'),
(94, 'Mauritanian Ouguiya', 'MRO', 'Active'),
(95, 'Maltese Lira', 'MTL', 'Active'),
(96, 'Mauritius Rupee', 'MUR', 'Active'),
(97, 'Maldive Rufiyaa', 'MVR', 'Active'),
(98, 'Malawi Kwacha', 'MWK', 'Active'),
(99, 'Mexican Peso', 'MXP', 'Active'),
(100, 'Malaysian Ringgit', 'MYR', 'Active'),
(101, 'Mozambique Metical', 'MZM', 'Active'),
(102, 'Namibian Dollar', 'NAD', 'Active'),
(103, 'Nigerian Naira', 'NGN', 'Active'),
(104, 'Nicaraguan Cordoba', 'NIO', 'Active'),
(105, 'Norwegian Kroner', 'NOK', 'Active'),
(106, 'Nepalese Rupee', 'NPR', 'Active'),
(107, 'New Zealand Dollar', 'NZD', 'Active'),
(108, 'Omani Rial', 'OMR', 'Active'),
(109, 'Panamanian Balboa', 'PAB', 'Active'),
(110, 'Peruvian Nuevo Sol', 'PEN', 'Active'),
(111, 'Papua New Guinea Kina', 'PGK', 'Active'),
(112, 'Philippine Peso', 'PHP', 'Active'),
(113, 'Pakistan Rupee', 'PKR', 'Active'),
(114, 'Polish Zloty', 'PLN', 'Active'),
(116, 'Paraguay Guarani', 'PYG', 'Active'),
(117, 'Qatari Rial', 'QAR', 'Active'),
(118, 'Romanian Leu', 'RON', 'Active'),
(119, 'Rwanda Franc', 'RWF', 'Active'),
(120, 'Saudi Arabian Riyal', 'SAR', 'Active'),
(121, 'Solomon Islands Dollar', 'SBD', 'Active'),
(122, 'Seychelles Rupee', 'SCR', 'Active'),
(123, 'Sudanese Pound', 'SDP', 'Active'),
(124, 'Swedish Krona', 'SEK', 'Active'),
(125, 'Singapore Dollar', 'SGD', 'Active'),
(126, 'St. Helena Pound', 'SHP', 'Active'),
(127, 'Sierra Leone Leone', 'SLL', 'Active'),
(128, 'Somali Schilling', 'SOS', 'Active'),
(129, 'Suriname Guilder', 'SRG', 'Active'),
(130, 'Sao Tome and Principe Dobra', 'STD', 'Active'),
(131, 'Russian Ruble', 'RUB', 'Active'),
(132, 'El Salvador Colon', 'SVC', 'Active'),
(133, 'Syrian Potmd', 'SYP', 'Active'),
(134, 'Swaziland Lilangeni', 'SZL', 'Active'),
(135, 'Thai Baht', 'THB', 'Active'),
(136, 'Tunisian Dinar', 'TND', 'Active'),
(137, 'Tongan Paanga', 'TOP', 'Active'),
(138, 'East Timor Escudo', 'TPE', 'Active'),
(139, 'Turkish Lira', 'TRY', 'Active'),
(140, 'Trinidad and Tobago Dollar', 'TTD', 'Active'),
(141, 'Taiwan Dollar', 'TWD', 'Active'),
(142, 'Tanzanian Schilling', 'TZS', 'Active'),
(143, 'Uganda Shilling', 'UGX', 'Active'),
(144, 'US Dollar', 'USD', 'Active'),
(145, 'Uruguayan Peso', 'UYU', 'Active'),
(146, 'Venezualan Bolivar', 'VEF', 'Active'),
(147, 'Vietnamese Dong', 'VND', 'Active'),
(148, 'Vanuatu Vatu', 'VUV', 'Active'),
(149, 'Samoan Tala', 'WST', 'Active'),
(150, 'CommunautÃ© FinanciÃ¨re Africaine BEAC, Francs', 'XAF', 'Active'),
(151, 'Silver, Ounces', 'XAG', 'Active'),
(152, 'Gold, Ounces', 'XAU', 'Active'),
(153, 'East Caribbean Dollar', 'XCD', 'Active'),
(154, 'International Monetary Fund (IMF) Special Drawing Rights', 'XDR', 'Active'),
(155, 'CommunautÃ© FinanciÃ¨re Africaine BCEAO - Francs', 'XOF', 'Active'),
(156, 'Palladium Ounces', 'XPD', 'Active'),
(157, 'Comptoirs FranÃ§ais du Pacifique Francs', 'XPF', 'Active'),
(158, 'Platinum, Ounces', 'XPT', 'Active'),
(159, 'Democratic Yemeni Dinar', 'YDD', 'Active'),
(160, 'Yemeni Rial', 'YER', 'Active'),
(161, 'New Yugoslavia Dinar', 'YUD', 'Active'),
(162, 'South African Rand', 'ZAR', 'Active'),
(163, 'Zambian Kwacha', 'ZMK', 'Active'),
(164, 'Zaire Zaire', 'ZRZ', 'Active'),
(165, 'Zimbabwe Dollar', 'ZWD', 'Active'),
(166, 'Slovak Koruna', 'SKK', 'Active'),
(167, 'Armenian Dram', 'AMD', 'Active');

-- --------------------------------------------------------
CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `associated_to` smallint(4) NOT NULL COMMENT '1 - Project, 2 - Task',
  `label` varchar(255) NOT NULL,
  `field_type` varchar(100) NOT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `is_multiple` tinyint(2) NOT NULL DEFAULT 0,
  `is_active` tinyint(2) NOT NULL DEFAULT 1,
  `is_advanced` tinyint(2) NOT NULL DEFAULT 0,
  `seq` smallint(6) NOT NULL DEFAULT 0,
  `is_required` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `company_id`, `project_id`, `user_id`, `associated_to`, `label`, `field_type`, `placeholder`, `default_value`, `is_multiple`, `is_active`, `is_advanced`, `seq`, `is_required`, `created`, `updated`) VALUES
(1, 0, 0, 0, 2, 'Actual Completion Date', '1', 'taskCmplDate', '', 0, 0, 1, 0, 0, '2022-03-21 10:57:10', '2022-03-21 10:57:10'),
(2, 0, 0, 0, 2, 'Duration Of Task', '1', 'taskDuration', '', 0, 0, 1, 0, 0, '2022-03-21 10:57:10', '2022-03-21 10:57:10'),
(3, 0, 0, 0, 2, 'Variation', '1', 'variation', '', 0, 0, 1, 0, 0, '2022-03-21 10:57:11', '2022-03-21 10:57:11'),
(4, 0, 0, 0, 2, 'Time Balance Remaining', '1', 'timeBalance', '', 0, 0, 1, 0, 0, '2022-03-21 10:57:11', '2022-03-21 10:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_options`
--

CREATE TABLE `custom_field_options` (
  `id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_values`
--

CREATE TABLE `custom_field_values` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `ref_type` tinyint(2) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `custom_filters`
--

CREATE TABLE `custom_filters` (
  `id` mediumint(9) NOT NULL,
  `project_uniq_id` varchar(64) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filter_name` varchar(100) NOT NULL,
  `filter_date` mediumtext DEFAULT NULL,
  `filter_duedate` datetime DEFAULT NULL,
  `filter_type_id` mediumtext NOT NULL,
  `filter_status` mediumtext NOT NULL,
  `filter_member_id` mediumtext NOT NULL,
  `filter_priority` mediumtext NOT NULL,
  `filter_assignto` mediumtext NOT NULL,
  `filter_search` mediumtext NOT NULL,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_statuses`
--

CREATE TABLE `custom_statuses` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `progress` int(10) NOT NULL,
  `color` varchar(25) NOT NULL,
  `status_master_id` int(11) NOT NULL,
  `status_group_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custom_statuses`
--

INSERT INTO `custom_statuses` (`id`, `company_id`, `name`, `progress`, `color`, `status_master_id`, `status_group_id`, `seq`, `created`, `modified`) VALUES
(20, 0, 'New', 0, 'F08E83', 1, 1, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(21, 0, 'In Progress', 0, '6BA8DE', 2, 1, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(22, 0, 'Resolve', 100, 'FAB858', 2, 1, 3, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(23, 0, 'Close', 100, '72CA8D', 3, 1, 4, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(24, 0, 'Backlog', 0, 'F08E83', 1, 2, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(25, 0, 'Ready', 0, 'C55447', 2, 2, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(26, 0, 'In Progress', 30, '6BA8DE', 2, 2, 3, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(27, 0, 'Done', 100, '72CA8D', 3, 2, 4, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(28, 0, 'Open', 0, 'F08E83', 1, 3, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(29, 0, 'In Progress', 30, '6BA8DE', 2, 3, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(30, 0, 'Approved', 100, '72CA8D', 3, 3, 5, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(31, 0, 'Cancelled', 50, 'C75863', 2, 3, 3, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(32, 0, 'Rejected', 0, 'E42135', 2, 3, 4, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(33, 0, 'To Do', 0, 'F08E83', 1, 4, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(34, 0, 'Done', 100, '72CA8D', 3, 4, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(35, 0, 'Application', 0, 'F08E83', 1, 5, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(36, 0, 'Screening', 10, '6BA8DE', 2, 5, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(37, 0, 'Interviewing', 30, '0F69A9', 2, 5, 3, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(38, 0, 'Interview offer', 50, '00F3FF', 2, 5, 4, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(39, 0, 'Offer discussion', 70, '2EC74A', 2, 5, 5, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(40, 0, 'Accepted', 100, '045E1F', 3, 5, 7, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(41, 0, 'Rejected', 100, 'FF0000', 3, 5, 6, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(42, 0, 'Requested', 0, 'F08E83', 1, 6, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(43, 0, 'In Review', 30, '6BA8DE', 2, 6, 2, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(44, 0, 'Approved', 100, '50B36E', 3, 6, 3, '2019-11-25 00:00:00', '2019-11-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dailyupdate_notifications`
--

CREATE TABLE `dailyupdate_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `dly_update` tinyint(2) NOT NULL,
  `notification_time` varchar(100) NOT NULL,
  `proj_name` varchar(200) NOT NULL,
  `mail_sent` datetime DEFAULT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_updates`
--

CREATE TABLE `daily_updates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `post_by` int(11) NOT NULL COMMENT 'user id : who create or update alert settings.',
  `user_id` mediumtext NOT NULL COMMENT 'user_ids are separated by comma(,)',
  `timezone_id` int(11) NOT NULL,
  `notification_time` time NOT NULL,
  `days` int(11) NOT NULL DEFAULT 5 COMMENT 'default:5',
  `cron_email_date` date DEFAULT NULL COMMENT 'When email is sent , this field is going to update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `default_project_templates`
--

CREATE TABLE `default_project_templates` (
  `id` int(11) NOT NULL,
  `user_id` int(250) NOT NULL,
  `company_id` int(250) NOT NULL,
  `module_name` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `default_project_templates`
--

INSERT INTO `default_project_templates` (`id`, `user_id`, `company_id`, `module_name`, `created`, `modified`) VALUES
(1, 1, 0, 'ecommerce', '2012-11-07 08:42:11', '2012-11-07 08:42:11'),
(2, 1, 0, 'CMS', '2012-11-07 08:47:18', '2012-11-07 08:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `default_project_template_cases`
--

CREATE TABLE `default_project_template_cases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(250) NOT NULL,
  `template_id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `default_project_template_cases`
--

INSERT INTO `default_project_template_cases` (`id`, `user_id`, `company_id`, `template_id`, `title`, `description`, `created`, `modified`) VALUES
(1, 1, 0, 1, 'Project Kick off', '', '2012-11-07 08:43:27', '2012-11-07 08:43:27'),
(2, 1, 0, 1, 'Communication Plan', '<p>when and how ofter team will meet</p>', '2012-11-07 08:43:49', '2012-11-07 08:43:49'),
(3, 1, 0, 1, 'Requirment Spec', '', '2012-11-07 08:44:03', '2012-11-07 08:44:03'),
(4, 1, 0, 1, 'Mock Up design', '', '2012-11-07 08:44:14', '2012-11-07 08:44:14'),
(5, 1, 0, 1, 'PSD conversion to html/css', '', '2012-11-07 08:44:25', '2012-11-07 08:44:25'),
(6, 1, 0, 1, 'Set up Development Environment', '', '2012-11-07 08:44:37', '2012-11-07 08:44:37'),
(7, 1, 0, 1, 'Set up repository', '', '2012-11-07 08:44:47', '2012-11-07 08:44:47'),
(8, 1, 0, 1, 'Registration page', '<p>development</p>', '2012-11-07 08:45:03', '2012-11-07 08:45:03'),
(9, 1, 0, 1, 'Login page', '<p>development</p>', '2012-11-07 08:45:23', '2012-11-07 08:45:23'),
(10, 1, 0, 1, 'User Dashboard', '<p>&nbsp; development</p>', '2012-11-07 08:45:46', '2012-11-07 08:45:46'),
(11, 1, 0, 1, 'user profile', '<p>Edit user profile development</p>', '2012-11-07 08:46:11', '2012-11-07 08:46:11'),
(12, 1, 0, 1, 'Password/forget password', '<p>Change Password/forget password development</p>', '2012-11-07 08:46:56', '2012-11-07 08:46:56'),
(13, 1, 0, 2, 'Project Kick off ', '', '2012-11-07 08:47:21', '2012-11-07 08:47:21'),
(14, 1, 0, 2, 'Communication Plan', '', '2012-11-07 08:47:33', '2012-11-07 08:47:33'),
(15, 1, 0, 2, 'Login page', '', '2012-11-07 08:47:42', '2012-11-07 08:47:42'),
(16, 1, 0, 2, 'Mock Up design', '', '2012-11-07 08:48:12', '2012-11-07 08:48:12'),
(17, 1, 0, 2, 'Password/forget password', '', '2012-11-07 08:48:22', '2012-11-07 08:48:22'),
(18, 1, 0, 2, 'co ordinating', '', '2012-11-07 08:48:32', '2012-11-07 08:48:32'),
(19, 1, 0, 2, 'Set up Development Environment', '', '2012-11-07 08:48:41', '2012-11-07 08:48:41'),
(20, 1, 0, 2, 'Requirment Spec', '', '2012-11-07 08:48:50', '2012-11-07 08:48:50'),
(21, 1, 0, 2, 'Set up repository', '', '2012-11-07 08:49:05', '2012-11-07 08:49:05'),
(22, 1, 0, 2, 'User Dashboard', '', '2012-11-07 08:49:14', '2012-11-07 08:49:14'),
(23, 1, 0, 2, 'add a database', '', '2012-11-07 08:49:24', '2012-11-07 08:49:24'),
(24, 1, 0, 2, 'create a check box to remember me.', '', '2012-11-07 08:49:33', '2012-11-07 08:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `default_tasks`
--

CREATE TABLE `default_tasks` (
  `id` int(11) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `default_tasks`
--

INSERT INTO `default_tasks` (`id`, `task`, `description`) VALUES
(1, 'How to Add a Task?', '<ul>\r\n	<li>Click on "+ New Task", there you can add a new task.</li>\r\n	<li>Add a quick Task within a second. Press [N], enter a task Title and hit [Enter].</li>\r\n	<li>Select memebrs to send email notification.</li>\r\n	<li>Click on "More" to Assign Taskm set Due Date, select Task Type, Description, File attachment.</li>\r\n	<li>If you have multiple projects, you can switch to another project and create a task for that project.</li>\r\n</ul>'),
(2, 'How to reply on a Task?', '<ul>\r\n	<li>Click on a Task Title on dashboard Task listing.</li>\r\n	<li>You can see the Task details with all the replies on that tasks.</li>\r\n	<li>There is a reply icon on all the reply at the right top section of the reply box.</li>\r\n	<li>Or, you can go directly to the bottom of the thread and there you can see a text editor to reply on that Task.</li>\r\n	<li>Same as Add new Task, here can click on "More Options" to send Email Notification, set status, Assign To, % completion, Hours spent and file attachment.</li>\r\n</ul>'),
(3, 'How to attach sync Google Drive and Dropbox files?', '<h3>Filter</h3>\r\n<ul>\r\n<li>There is a status widget below the project name, where all statuses are listed with #of tasks. Click on any status to filter tasks.</li>\r\n<li>Also, you can set multiple filters by clicking on the "Showing tasks of Status, Type, Priority, Members". This section is just below the status widget aligned to right side of the page</li>\r\n</ul>\r\n<h3>Search</h3>\r\n<ul>\r\n<li>Type your search keyword in the search box "jump to tasks" and it will filter and display the relevant tasks.</li>\r\n<li>Click on any tasks to view details of that task or, click on the blue arrow image to list all search tasks.</li>\r\n</ul>'),
(4, 'How to Filter & Search Tasks?', '<h3>Filter</h3>\r\n<ul>\r\n	<li>Menu Filters\r\n		<ul>\r\n			<li>Recent - Tasks of Last 24 hours</li>\r\n			<li>Assigned To Me - All the Task assigned to you (including the Tasks you assigned to youself)</li>\r\n			<li>Delegated to Others - All the Task you assigned to others</li>\r\n			<li>Bug - All the Task set as Bug Task Type while creating a Task</li>\r\n			<li>Closed - All the closed Tasks</li>\r\n		</ul>\r\n	</li>\r\n	<li>Project Filters\r\n		<ul>\r\n			<li>When you have multiple projects, you can switch difefrent projects on Dashboard.</li>\r\n			<li>You can also see Tasks of All projects by selecting All on the switch project section on Dashboard</li>\r\n			<li>You can also search a Project on the switch project section</li>\r\n		</ul>\r\n	</li>\r\n	<li>Widget Filters\r\n		<ul>\r\n			<li>You can see the the widgets on dashboard showing the #of New, WIP, Resolved and Closed tasks.</li>\r\n			<li>Each widgets are filters.</li>\r\n			<li>You can click on the widgets to see the filetered tasks.</li>\r\n		</ul>\r\n	</li>\r\n	<li>Task Filters\r\n		<ul>\r\n			<li>Below the Task widget, you can see a list of filters. Saying Showing tasks of Date, Status, Types, Priority, Memebrs & Assign To</li>\r\n			<li>Select multiple values to filter the tasks</li>\r\n		</ul>\r\n	</li>\r\n</ul>\r\n\r\n<h3>Search</h3>\r\n<ul>\r\n	<li>Search a tasks by entering a search phrase on the top of the page.</li>\r\n	<li>You will see a list of matching results (max. 6) from them you can select one Task to see the details.</li>\r\n	<li>Or, You hit enter on the search box to see all the matching results in a list.</li>\r\n</ul>'),
(5, 'How to manage Team?', '<ul>\r\n	<li>How do I add new Member to my Company?</li>\r\n		<ul>\r\n		    <li>Go to the Team menu and you see there is "Invite" on the sub-menu.</li>\r\n		    <li>Click on the <b>Invite</b> link to invite new Memebr</li>\r\n			<li>The invited memebr will get an email and a link in the email to activate her account.</li>\r\n			<li>You can also Invite the members those have already an account in OrangeScrum (may be as a Memebr or Admin of another company).</li>\r\n		</ul>\r\n	<li>How do I manage user?</li>\r\n		<ul>\r\n		    <li>Go to <b>Manage</b> link of Team menu, there you can see the listed users.</li>\r\n		</ul>\r\n	<li>What is Active/Inactive User?</li>\r\n		<ul>\r\n		    <li><b>Inactive User:</b></li>\r\n		    <ul>\r\n			<li>If a user is invited and not yet signed up.</li>\r\n			<li>If an Active user is disabled/inactivated.</li>\r\n		    </ul>\r\n		</ul>\r\n	<li>How do I delete a User?</li>\r\n		<ul>\r\n		    <li>An existing user cannot be deleted; you can only inactivate the user.</li>\r\n		    <li>The inactive user <b>cannot login</b>. But all his related data (tasks, milestone etc.) will remain there in the application.</li>\r\n		</ul>\r\n	<li>How do I assign multiple users  to multiple projects?</li>\r\n    		<ul>\r\n    		    <li>Go to "Manage" option Under "Projects" menu. Clicking on project name, the user names will be shown below it.</li>\r\n    		    <li>To remove this project from any users it needs to un- check the check box opposite to the user name.</li>\r\n    		    <li>In order to add a new user, click the icon "Add User" in the right-most column.</li>\r\n    		    <li>A pop-up will appear showing the list of user names, where multiple users can be selected and assigned to the particular project.</li>\r\n    		</ul>\r\n</ul>'),
(6, 'How to manage Projects?', '<ul>\r\n	<li>How do I add new project?</li>\r\n		<ul>\r\n		    <li>Similar to User, click on the <b>"+ New"</b> link of Project menu to add new project.</li>				\r\n		</ul>\r\n	<li>How do I assign/de-assign users to &amp; from a project?</li>\r\n		<ul>\r\n		    <li>Go to <b>Assign User</b> section of Project menu, where you can select a project and drag-n-drop members/customer to that project.</li>\r\n		    <li>Similarly, to de-assign, reverse the assign process.</li>\r\n		</ul>\r\n	<li>How do I manage and delete/edit project?</li>\r\n		<ul>\r\n		    <li>Go to <b>Manage</b> link of Project menu, where the projects are listed under two different view "Grid View" &amp; "Classic View"</li>\r\n		</ul>\r\n	<li>How do I assign multiple projects to multiple users?</li>\r\n		<ul>\r\n		    <li>Go to "Manage" option Under "Users" menu. Clicking on user name, the project names will be shown below it.</li>\r\n		    <li>To remove the user from any project, by un- checking the check box opposite to the project name.</li>\r\n		    <li>In order to add a new project, click the icon "Add Project" in the right-most column.</li>\r\n		</ul>\r\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `default_task_views`
--

CREATE TABLE `default_task_views` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_view_id` tinyint(2) NOT NULL DEFAULT 1,
  `kanban_view_id` tinyint(2) NOT NULL DEFAULT 7,
  `timelog_view_id` tinyint(2) NOT NULL DEFAULT 5,
  `project_view_id` tinyint(2) NOT NULL DEFAULT 8,
  `default_view_id` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `default_templates`
--

CREATE TABLE `default_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `default_templates`
--

INSERT INTO `default_templates` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Meeting Minute', '<b>Attendees:</b>  John, Michael<br/>\n				<b>Date and Time:</b> July 11th 11 am PST<br/>\n				<b>Purpose:</b><br/>\n				\n				<br/>\n				<b>Agenda:</b> \n				<o>\n					<li>Discuss Layout </li>\n					<li>Discuss on Design</li>\n				</ol>\n				<br/>\n				<b>Discussion:</b><br/>', '2014-01-24 12:58:24', '2014-01-24 12:58:24'),
(2, 'Status update', '<p><strong>Today''s accomplishment:</strong></p>\n				<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\n				<ul>\n				<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n				<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n				<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n				</ul>\n				<p>&nbsp; &nbsp; &nbsp;<strong>Task no: 125</strong></p>\n				<ul>\n				<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n				<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n				<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n				</ul>\n				<p><br /> <strong>List of files changed:</strong></p>\n				<ol>\n				<li>index.html</li>\n				<li>style.css</li>\n				<li>contact-us.html</li>\n				</ol>\n				<p>Is code checked in Repository: <strong>Y/N</strong><br /> Is code available in Stager: <strong>Y/N</strong> </p>\n				<p><strong>Blocker/Testing Issues:</strong></p>\n				<p><strong>Milestone Update: &lt; Specify Milestone name here &gt;</strong></p>\n				<p>&nbsp; &nbsp;1. Total tasks:</p>\n				<p>&nbsp; &nbsp;2. # of Work in Progress tasks:</p>\n				<p>&nbsp; &nbsp;3. # of Resolve tasks:</p>\n				<p>&nbsp; &nbsp;4. # of tasks not started:</p>\n				<p><br /> <strong>Next Day''s Plan:</strong></p>', '2014-01-24 12:58:24', '2014-01-24 12:58:24'),
(3, 'Change Request', '<p><strong>Change Requested:</strong></p>\n				<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\n				<p><strong>&nbsp; &nbsp; &nbsp; Task no: 125</strong></p>\n				<p><strong>Today''s accomplishment:</strong></p>\n				<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>\n				<ul>\n				<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n				<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n				<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n				</ul>\n				<p>&nbsp; &nbsp; &nbsp;<strong>Task no: 125</strong></p>\n				<ul>\n				<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>\n				<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>\n				<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>\n				</ul>\n				<p><br /> <strong>List of files changed:</strong></p>\n				<ol>\n				<li>index.html</li>\n				<li>style.css</li>\n				<li>contact-us.html</li>\n				</ol>\n				<p>Is code checked in Repository: <strong>Y/N</strong><br /> Is code available in Stager: <strong>Y/N</strong> </p>\n				<p><strong>Blocker/Testing Issues:</strong></p>\n				<p><strong>Milestone Update: &lt; Specify Milestone name here &gt;</strong></p>\n				<p>&nbsp; &nbsp;1. Total tasks:</p>\n				<p>&nbsp; &nbsp;2. # of Work in Progress tasks:</p>\n				<p>&nbsp; &nbsp;3. # of Resolve tasks:</p>\n				<p>&nbsp; &nbsp;4. # of tasks not started:</p>\n				<p><br /> <strong>Next Day''s Plan:</strong></p>', '2014-01-24 12:58:24', '2014-01-24 12:58:24'),
(4, 'Bug', '<b>Browser version:</b>\n				<br/>\n				<b>OS version:</b>\n				<br/><br/>\n				<b>Url:</b>\n				<br/><br/>\n				<b>What is the test case:</b><br/>\n				<b>What is the expected result:</b><br/>\n				<b>What is the actual result:</b><br/><br/>\n				\n				<b>Is it happening all the time or intermittently:</b><br/>\n				<br/>\n				<b>Attach screenshots:</b>', '2014-01-24 12:58:24', '2014-01-24 12:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_companies`
--

CREATE TABLE `deleted_companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_of_user` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0->Free , 1->Paid',
  `reason` varchar(255) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `cancel_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-> Deleted Company , 0-> Cancelled Subscription',
  `crreated` datetime DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `demo_requests`
--

CREATE TABLE `demo_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `timezone_id` decimal(10,2) NOT NULL,
  `message` text DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `easycases`
--

CREATE TABLE `easycases` (
  `id` mediumint(11) NOT NULL,
  `uniq_id` varchar(64) CHARACTER SET utf8 NOT NULL,
  `case_no` int(11) NOT NULL,
  `case_count` int(11) NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `updated_by` int(11) NOT NULL,
  `type_id` int(4) NOT NULL COMMENT 'Foreign key of "case_types"',
  `priority` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `estimated_hours` int(10) NOT NULL DEFAULT 0,
  `hours` decimal(6,1) NOT NULL,
  `completed_task` int(11) NOT NULL DEFAULT 0,
  `assign_to` int(11) NOT NULL COMMENT 'Foreign Key of "users"',
  `gantt_start_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `istype` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-Post, 2-Comment',
  `client_status` tinyint(2) NOT NULL DEFAULT 0,
  `format` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-Files&Details, 2-Details, 3-Files',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-Open, 2-Closed',
  `legend` tinyint(2) NOT NULL COMMENT '1-New 2-Opened, 3-Closed, 4-Start, 5-Resolve, 6- Modified',
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive,1-Active',
  `is_recurring` tinyint(4) NOT NULL DEFAULT 0,
  `dt_created` datetime NOT NULL,
  `actual_dt_created` datetime NOT NULL,
  `reply_type` int(11) NOT NULL DEFAULT 0 COMMENT '1-> Case Type changes, 2-> Assign to , 3 -> Due Date,4 -> Priority ',
  `is_chrome_extension` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `from_email` tinyint(1) NOT NULL DEFAULT 0,
  `depends` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'dependent task ids',
  `children` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_hours` int(10) DEFAULT NULL,
  `temp_est_hours` int(10) NOT NULL DEFAULT 0,
  `seq_id` smallint(5) NOT NULL DEFAULT 0,
  `parent_task_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom_status_id` int(11) NOT NULL DEFAULT 0,
  `story_point` smallint(6) NOT NULL DEFAULT 0,
  `thread_count` int(11) NOT NULL DEFAULT 0,
  `git_sync` tinyint(2) NOT NULL DEFAULT 0,
  `git_issue_id` bigint(18) NOT NULL DEFAULT 0,
  `real_git_issue_id` bigint(18) NOT NULL DEFAULT 0,
  `is_zapaction` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_favourites`
--

CREATE TABLE `easycase_favourites` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `easycase_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_labels`
--

CREATE TABLE `easycase_labels` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `label_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_linkings`
--

CREATE TABLE `easycase_linkings` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_relate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_links`
--

CREATE TABLE `easycase_links` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'project id',
  `source` varchar(50) NOT NULL COMMENT 'source task id',
  `target` varchar(50) NOT NULL COMMENT 'target task id',
  `type` tinyint(2) NOT NULL COMMENT '0 FL, 1 LL, 2 FF, 3 LF',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_milestones`
--

CREATE TABLE `easycase_milestones` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `m_order` int(11) NOT NULL,
  `id_seq` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_recurring_tracks`
--

CREATE TABLE `easycase_recurring_tracks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `easycase_relates`
--

CREATE TABLE `easycase_relates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `seq_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `easycase_relates`
--

INSERT INTO `easycase_relates` (`id`, `title`, `status`, `seq_id`) VALUES
(1, 'Related to', 1, 0),
(2, 'Duplicated by ', 1, 0),
(3, 'Derived from', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_reminders`
--

CREATE TABLE `email_reminders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_type` int(11) NOT NULL COMMENT '1:Aaccount Activation, 2:login, 3:Project Creation, 4:User Add, 5:Task Add',
  `cron_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `is_smtp` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `reply_email` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `company_id`, `user_id`, `host`, `port`, `is_smtp`, `email`, `password`, `from_email`, `reply_email`, `status`, `is_default`, `is_verified`, `created`, `modified`) VALUES
(1, 1, 1, 'host', '25', 3, NULL, NULL, '', '', 1, 1, NULL, '2018-09-07 09:29:46', '2018-10-03 06:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `feature_settings`
--

CREATE TABLE `feature_settings` (
  `id` int(11) NOT NULL COMMENT '1-RA,2-tsheet,3-wiki,4-gcal, 5-custom status',
  `company_id` int(11) NOT NULL,
  `subscription_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `feature_settings`
--

INSERT INTO `feature_settings` (`id`, `company_id`, `subscription_id`, `is_active`, `dt_created`) VALUES
(1, 1, '5,11,12,14,22,23,24,25,26,27,28,29,30,31,32', 1, '2017-09-04 05:31:59'),
(2, 1, '5,12,14,22,23,24,25,26,27,28,29,30,11,31,32', 1, '2017-12-12 00:00:00'),
(3, 1, '12,14,23,24,25,26,27,28,29,30,11,31,32,43,44', 1, '2018-09-14 00:00:00'),
(4, 1, '5,12,14,22,23,24,11,43,44', 1, '2019-05-20 00:00:00'),
(5, 1, '5,11,12,14,16,22,23,24,43,44', 1, '2019-05-20 00:00:00'),
(6, 1, '5,10,12,14,21,22,23,24,43,44,11', 1, '2019-06-24 00:00:00'),
(7, 1, '12,14,23,24,43,44,11', 1, '2019-08-05 00:00:00');

-- --------------------------------------------------------

--

-- Table structure for table `google_calendar_settings`
--

CREATE TABLE `google_calendar_settings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `calendar_name` varchar(255) NOT NULL,
  `resource_id` varchar(255) DEFAULT NULL,
  `channel_id` varchar(255) DEFAULT NULL,
  `nextSyncToken` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `calendar_id` varchar(255) NOT NULL,
  `sync` tinyint(1) NOT NULL COMMENT '0: All project, 1 : Specific Project',
  `project_id` int(11) NOT NULL,
  `interval_time` int(5) NOT NULL,
  `removeCmpl` tinyint(2) NOT NULL COMMENT '0:leave,1 remove',
  `due_time` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:all-day,1:no sync',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_event_settings`
--

CREATE TABLE `google_event_settings` (
  `id` int(11) NOT NULL,
  `google_event_id` varchar(255) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `helps`
--

CREATE TABLE `helps` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL COMMENT 'Foreign key for the subjects table',
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `keywords` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '2013-10-10 00:00:00',
  `is_admin` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helps`
--

INSERT INTO `helps` (`id`, `subject_id`, `title`, `description`, `image`, `keywords`, `created`, `is_admin`) VALUES
(1, 1, 'How to create a new Task?', '<li>Click on "Create Task" button or click Task from "+Add" menu. This will open up create task page. Enter Title of the task.</li><li>By default, current project selected in project list box, you can always choose different project. Then choose Task Type, Priority and Assigned to from the respective list box.</li><li>Attach file or link your files from Google Drive or DropBox.</li><li>To create a detailed task: Set the due date and choose which task group it will be belong to, Enter estimated hours, choose start time and end time from a list box, enter break time  and spent hours will be calculated automatically.</li><li>Select the users from drop down, you want to notify the new task details via email notification<a href="http://www.easyagile.us/img/help/task/creat_task.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(2, 1, 'Can I see tasks of all projects?', '<li>Please select an "All" from the project drop down and you can see all the tasks in a single page.<a href="http://www.easyagile.us/img/help/task/creat_seeall.jpg"><img src="http://www.easyagile.us/img/help/task/creat_seeall.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(3, 1, 'How to filter Tasks?', '<li>Click on the "Filters" <span class="db-filter-icon_help"></span> present at the top right corner of "Task Page".</li><li>Click on the filter type to get the filter options.</li><li>You can select multiple filters there.</li><li>You can close the filters one by one or reset them all.<a href="http://www.easyagile.us/img/help/task/creat_task_filter.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_filter.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(5, 1, 'How to view Task details and reply on a task?', '<li>Please click on a task to view the details.</li><li>Put the task details, where you can specify Status (as In Progress or Resolve or Close), Assign to, Set the priority, start time, end time, break time and select the option "Is Billable?" while replying on a Task.</li><li>Share your documents (if required) using your Google Drive or DropBox account</li><li>Select concerned members to send email notification and hit "Post" to reply.<a href="http://www.easyagile.us/img/help/task/creat_task_detail.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_detail.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(6, 1, 'How to edit a Task?', '<li>There are two ways you can edit a task;\r\n<ol><li>On the task listing page, click the drop down icon <span class="sett_help"></span> and select edit <span class="act_edit_task_help"></span> to edit the task.</li></ol><a href="http://www.easyagile.us/img/help/task/creat_task_edit1.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_edit1.jpg"/></a></li><li>In the task detail page, on the top right hand corner you will be able to see the edit icon <span class="act_edit_task_help"></span>. Click on it to edit the task.<a href="http://www.easyagile.us/img/help/task/creat_task_edit2.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_edit2.jpg"/></a></li><li>Note: A task can only be modified if the status is "NEW" <color code: red> and the user who would have created the task.</li>', '', '', '2013-12-12 00:00:00', 0),
(7, 1, 'Can I resolve or close a Task without any reply?', '<li>Sure, there is an option icon <span class="sett_help"></span> on left side of each Task, choose from option to resolve or close the task.</li><li>Also, you can check multiple tasks and do the same by selecting Close or Resolve on the top of the list.<a href="http://www.easyagile.us/img/help/task/creat_task_resolve.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_resolve.jpg"/></a></li><li>You can resolve or close task from the task detail page.<a href="http://www.easyagile.us/img/help/task/creat_task_resolve_detail.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_resolve_detail.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(8, 1, 'How to change the "task type", "assign to", & "due date" on the task listing page?', '<li>You can change task type from the left side option of each task.</li><li>You can change assign to and due date on the right side of each task listing.<a href="http://www.easyagile.us/img/help/task/creat_task_type.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_type.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(9, 1, 'How can I set different tabs above task listing?', '<li>Click "+" on the tab section, Select/Deselect the checkboxes and click save.<a href="http://www.easyagile.us/img/help/task/creat_task_tab1.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_tab1.jpg"/></a></li><li>You can view the tabs on the tab section.<a href="http://www.easyagile.us/img/help/task/creat_task_tab2.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_tab2.jpg"/></a></li>', '', '', '2013-12-12 00:00:00', 0),
(10, 1, 'How to archive or delete a task?', '<li>Click the option icon <span class="sett_help"></span> on the task listing; select "Archive" to archive the task.<li>You can later restore or remove the archive permanently from the "Archive" icon <span class="act_arcv_task_help"></span> in the left.<a href="http://www.easyagile.us/img/help/task/creat_task_delete.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_delete.jpg"/></a><a href="http://www.easyagile.us/img/help/task/creat_task_archive.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_archive.jpg"/></a></li><li>Note: Only new tasks created by you can be archived.</li>', '', '', '2013-12-12 00:00:00', 0),
(11, 2, 'Can I upload Files without creating a task?', '<li>Now we have only option to upload files while creating or replying on a task.</li>', '', '', '2013-12-12 00:00:00', 0),
(12, 2, 'How can I see all Files of my projects?', '<li>Click "<strong>Files</strong>" present on the left panel, Here, all uploaded and shared files of the current project are listed.</li>', '', '', '2013-12-12 00:00:00', 0),
(13, 2, 'Can I archive or delete a file of a task?', '<li>Yes, Click on the archive icon on left side of each file to archive a file of task.</li>\r\n<li>Yes, You can delete a file of task from the archive section.</li>', '', '', '2013-12-12 00:00:00', 0),
(14, 2, 'Can I download all Files in a zip?', '<li>You can download them one by one.</li>', '', '', '2013-12-12 00:00:00', 0),
(15, 3, 'How to create a new Project?', '<li>Click "<strong>Create Project</strong>", Enter a Project Name, Short Name, Email IDs of users and hit "<strong>Create</strong>".</li>', '', '', '2013-12-12 00:00:00', 0),
(16, 3, 'How to add users to Projects?', '<li>Click on the "Projects" menu on the left panel for going to the projects listing.</li>\r\n<li>Click "<strong>Add User</strong>", Select the users and hit Add.</li>', '', '', '2013-12-12 00:00:00', 0),
(17, 3, 'How to remove users from Projects?', '<li>Click "Remove User" on a project, Select users and hit Remove.</li>', '', '', '2013-12-12 00:00:00', 0),
(18, 3, 'Can I hide or disable a Project?', '<li>Click "<strong>Disable</strong>" on a project and hit "OK" in the pop-up for disabling the project.</li>', '', '', '2013-12-12 00:00:00', 1),
(19, 3, 'Can I delete a Project?', '<li>In project listing page, Click the "<strong>Inactive</strong>" tab. Click "<strong>Delete</strong>" on a project and hit "OK" in the pop-up.</li>', '', '', '2013-12-12 00:00:00', 1),
(20, 3, 'Can I move a task from one project to another?', '<li>Yes</li>', '', '', '2013-12-12 00:00:00', 1),
(21, 4, 'How to invite a new User to Orangescrum?', '<li>Click "<strong>Invite User</strong>", enter user''s Email ID and hit "<strong>Add</strong>" to send email invitation to the users.</li>', '', '', '2013-12-12 00:00:00', 1),
(22, 4, 'Can a User be in multiple account in orangescrum?', '<li><strong>Yes</strong></li>', '', '', '2013-12-12 00:00:00', 1),
(23, 4, 'How to restrict an User to access?', '<li>In the users listing page, Click "<strong>Disable</strong>" on a user and hit "OK" in the pop-up.', '', '', '2013-12-12 00:00:00', 1),
(24, 4, 'How to delete an User from my account?', '<li>In users listing page, Click the "<strong>Invited</strong>" tab. Click "<strong>Delete</strong>" on a user and hit "OK" in the pop-up.</li>', '', '', '2013-12-12 00:00:00', 1),
(25, 4, 'How to assign projects to Users?', '<li>In users listing page, Click the "<strong>Active</strong>" tab. Click "<strong>Assign Project</strong>" on a user, select projects and hit "<strong>Assign</strong>".</li>', '', '', '2013-12-12 00:00:00', 1),
(26, 4, 'How to remove projects from Users?', '<li>In users listing page, Click the "<strong>Active/Disabled</strong>" tab. Click "<strong>Remove Project</strong>" on a user, select projects and hit "<strong>Remove</strong>".</li>', '', '', '2013-12-12 00:00:00', 1),
(31, 6, 'Can I see the Bug reports?', '<li>Click on <strong>Dashboard</strong>, go to semi circle pie chart, select <strong>bug</strong> from list box.</li> <li>User can view status and statistics of bugs.</li>', '', '', '2013-12-12 00:00:00', 0),
(32, 6, 'Can I get a usage report?', '<li>Yes, Click "<strong>Analytics</strong>" and click "<strong>Usage Report</strong>".</li>', '', '', '2013-12-12 00:00:00', 0),
(33, 6, 'What are different types of analytics on orangescrum?', '<li>"<strong>Weekly Usage</strong>", "<strong>Task Reports</strong>", "<strong>Hour Reports</strong>" are different types of analytics.</li>\r\n<li>Users can also filter the report based on Task type (Bug, Enhancement, development).</li>', '', '', '2013-12-12 00:00:00', 0),
(34, 7, 'Can I restore archived tasks or files?', '<li>Yes, You can check the task and select the Restore option on the top of the list.</li>\r\n<li>Also, you can check multiple tasks and do the same by selecting Restore on the top of the list.</li>', '', '', '2013-12-12 00:00:00', 0),
(35, 7, 'Can I see the archived tasks or files of my team members?', '<li>Yes, you can see in the archive listing.</li>', '', '', '2013-12-12 00:00:00', 0),
(36, 7, 'Can I get the tasks or files once I delete them from Archive section?', '<li>No, After deleting from the archive section the tasks or files will be permanently deleted.</li>', '', '', '2013-12-12 00:00:00', 0),
(39, 9, 'How to change my name, timezone and profile photo?', '<li>Click your profile button at the right top corner of the page; click "<strong>My Profile</strong>" to change your name, timezone and profile photo.</li>\r\n<li><strong>Note:</strong> To update your account with new time zone, you need to log out and log in again.</li>', '', '', '2013-12-12 00:00:00', 0),
(40, 9, 'How can I change my password?', '<li>Go to the "<strong>My Profile</strong>" section.</li>\r\n<li>Click "<strong>Change Password</strong>" to change your account password.</li>', '', '', '2013-12-12 00:00:00', 0),
(43, 11, 'Can I post a reply by replying to the task create email from my Inbox?', '<li>Yes, You can reply to the email for posting reply to the task.</li>', '', '', '2013-12-12 00:00:00', 0),
(44, 11, 'Can I disable the Task create or reply emails I am getting?', '<li>Click the setting icon at the top right corner of the page, click "<strong>Email Notification</strong>" to disable the emails.</li>', '', '', '2013-12-12 00:00:00', 0),
(45, 11, 'What are the other email notifications and settings?', '<li>"Desktop Notification", "Weekly Usage", "Task Status", "Task Due", "Daily Update Report" are different types of email notifications and settings.</li>', '', '', '2013-12-12 00:00:00', 0),
(46, 12, 'How can I upgrade from a free plan to paid plan?', '<li>Click the setting icon at the top right corner of the page, click "<strong>Subscription</strong>".</li>\r\n<li>In the "Subscription" page, click "Change Plan" to upgrade from free to paid plan.</li>', '', '', '2013-12-12 00:00:00', 0),
(47, 12, 'What happens when I upgrade?', '<li>After up gradation, you will get more storage limit as compared to the free account.</li>\r\n<li>You can use more functionality other than free users.</li>', '', '', '2013-12-12 00:00:00', 0),
(48, 12, 'Can I downgrade from a paid plan to free plan?', '<li>You can downgrade to a lower paid plan at any time.</li>\r\n<li>Also you can cancel at any time.</li>\r\n<li>If you are canceling in between the billing period, your card will be charged for that entire month, however your account will be canceled with immediate effect.</li>', '', '', '2013-12-12 00:00:00', 0),
(50, 12, 'Apart from online payment, is there any other way of making payment?', '<li>Yes. The other modes of payment is Wire Transfer.</li>\r\n<li>This mode is accepted only for the yearly subscription.</li>\r\n<li>Contact us for yearly subscription.</li>', '', '', '2013-12-12 00:00:00', 0),
(51, 12, 'How much is the free space available for use? Is it expandable?', '<li>Contact us to get custom plan for your account.</li>', '', '', '2013-12-12 00:00:00', 0),
(52, 13, 'How can I Import my data into Orangescrum?', '<li>Click on the top settings icon near profile image.</li>\r\n<li>You can see the "<strong>Import & Export</strong>" link on the Company Settings section.</li>\r\n<li>Read the instructions on the "<strong>Import & Export</strong>" page.</li>\r\n<li>We accept only data in CSV format.</li>', '', '', '2013-12-12 00:00:00', 0),
(53, 13, 'How can I take backup of my data from Orangescrum?', '<li>Click on the top settings icon near profile image.</li>\r\n<li>You can see the "<strong>Import & Export</strong>" link on the Company Settings section.</li>\r\n<li>There you can find a "<strong>Export to CSV</strong>" button.</li>', '', '', '2013-12-12 00:00:00', 0),
(54, 14, '', '<li>We''d hate to see you go, but it''s very easy to cancel your account.</li>\r\n<li>Select the "Settings" from top and go to "Subscription".</li>\r\n<li>Click "Cancel Account" and you''ll be able to cancel your account.</li>', '', '', '2013-12-23 00:00:00', 0),
(68, 5, 'How do I log time?', '<li>Go to "<b>Time Log</b>" Section , by clicking <a onclick="open_timelog();" href="javascript:void(0);"><span class="timelog_nb smenu"></span></a> this icon on left hand side bar.</li>\r\n	<li>Click on "<b>Log More Time</b>" Button on top right hand side of the grid. This will pop up a window.\r\n	<li>Select Task from task list .</li>\r\n	<li>Select Resource Name from list and pick Date from calendar.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "<b>Add Item</b>", if you want to log more hours for a different resource or same resource different date or different time.</li>\r\n	<li>Enter Summary</li>\r\n	<li>Click on "<b>Log This Time</b>" Button to save data.</li>', 'logtime.jpg', '', '2013-10-10 00:00:00', 0),
(69, 5, 'How do I log time form quick add?', '<li>You can also log time by clicking Log time item from "+Add" from header.  This will pop up a window.</li>\r\n	<li>Select Task from task list .</li>\r\n	<li>Select Resource Name from list and pick Date from calendar.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "Add Item", if you want to log more hours for a different resource or same resource different date or different time.</li>\r\n	<li>Enter Summary</li>\r\n	<li>Click on "Log This Time" Button to save data.</li><li>Please refer to circle numbered 3 in the image given below.</li>', 'time_log.jpg', '', '2013-10-10 00:00:00', 0),
(70, 5, 'How do I log time from task listing page?', '<li>From Task List , select Time Log from down arrow  drop down.</li> \r\n	<li>Click on " Log Time" Button on top right hand side of the grid. This will pop up a window.</li>\r\n	<li>Here task title will be selected.</li>\r\n	<li>Select Resource Name from list and pick Date from calendar.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "Add Item", if you want to log more hours for a different resource or same resource different date or different time.</li>\r\n	<li>Enter Summary.</li>\r\n	<li>Click on "Log This Time" Button to save data.</li><li>Please refer to circle numbered 2 in the image given below.</li>', 'time_log.jpg', '', '2013-10-10 00:00:00', 0),
(71, 5, 'How do I log time while creating task?', '<li>Click on "<b>Create Task</b>" button on the top left hand side of the page.</li>\r\n	<li>Enter Task Title.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "<b>Save & Exit</b>" or "<b>Save & Create</b>" button to save data.</li>', 'create_task_timelog.jpg', '', '2013-10-10 00:00:00', 0),
(72, 5, 'How do I log time while replying a Task?', '<li>Go to task reply section in task detail page.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "<b>Post</b>" button to save data</li>', 'reply_timelog.jpg', '', '2013-10-10 00:00:00', 0),
(73, 5, 'How do I log time from task detail page?', '<li>Go to Task detail page by clicking on a task in task listing page.</li>\r\n	<li>Click on "<b>Log More Time</b>" Button. This will pop up a window.</li>\r\n	<li>By default the task is selected, you can change task by selecting another  task from task list .</li>\r\n	<li>Select Resource Name from list and pick Date from calendar.</li>\r\n	<li>Select Start time and End time from list.</li>\r\n	<li>Enter Break time. Spent Hours will be calculated automatically.</li>\r\n	<li>By Default billable field is checked , you can always unchek in case non-billable hours.</li>\r\n	<li>Click on "<b>Log This Time</b>" Button to save data.</li>', 'fromtaskdetail.jpg', '', '2013-10-10 00:00:00', 0),
(74, 5, 'How do I see all time log records?', '<li>Go to "<b>Time Log</b>" Section , by clicking <a onclick="open_timelog();" href="javascript:void(0);"><span class="timelog_nb smenu"></span></a> this icon on left hand side bar.</li>\r\n	<li>A new page with all records will open.</li>', 'timelog_grid.png', '', '2013-10-10 00:00:00', 0),
(75, 5, 'How do I modify logged time?', '<li>Go to "<b>Time Log</b>" Section , by clicking <a onclick="open_timelog();" href="javascript:void(0);"><span class="timelog_nb smenu"></span></a> this icon on left hand side bar.</li>\r\n	<li>Click on edit icon at the end of each time log record to edit it. </li>\r\n	<li>Click on delete icon at the end ofeach time log record to delete it. </li>\r\n	<li>Note: Owner, admin and the user for whom time is logged, they can modify it.</li>', 'modify_timelog.jpg', '', '2013-10-10 00:00:00', 0),
(76, 5, 'How do I filter time log records?', '<li>Go to "<b>Time Log</b>" Section , by clicking <a onclick="open_timelog();" href="javascript:void(0);"><span class="timelog_nb smenu"></span></a> this icon on left hand side bar.</li>\r\n	<li>Pick Start Date and End date from calendar on top right hand side of the page.</li>\r\n	<li>Select Resource Name from list.</li>\r\n	<li>Click on "<b>Search</b>" Button to view filtered data.</li>', 'filter_timelog.jpg', '', '2013-10-10 00:00:00', 0),
(77, 15, 'How to create Invoice?', '<li>Go to Invoice section by clicking <a onclick="open_invoice();" href="javascript:void(0);"><span class="invoice_nb smenu"></span></a> this icon on left hand side bar. It will display all unbilled time.</li>\r\n	<li>Check one or more "<b>Time log entries</b>" and click on "<b>Create Invoice</b>" button.\r\n	<a href="http://www.easyagile.us/img/Invoice/creat_invoice.jpg"><img src="http://www.easyagile.us/img/Invoice/creat_invoice.jpg"/></a></li> \r\n	<li>It will pop up a window to select either to create a new invoice or add it to existing invoice. Then click on "<b>Update</b>" button.\r\n	<a href="http://www.easyagile.us/img/Invoice/creat_invoice-update.jpg"><img src="http://www.easyagile.us/img/Invoice/creat_invoice-update.jpg"/></a></li>\r\n	<li>It will redirect to create invoice page where you can enter invoice number. It should be alpha numeric. This field is mandatory. And also this number can not be duplicate in one company.</li>\r\n	<li>Then select one term from terms drop down list. Terms is the number of days to pay the bill. According to the term selected, it changes the due date by which customer has to pay the bill. User can also manually change the due date.</li>\r\n	<li>Then pick an invoice date. It is the date for which invoice has been created.</li>  \r\n	<li>Then provide the billing from address. This is the address of the company who is creating the invoice.</li>\r\n	<li>Then select one customer form the customers drop down list. You can also add customer by selecting "+ Add new customer option".</li>\r\n	<li>Then provide the billing to address which is the address of the customer.</li>\r\n	<li>Then in line item pick a date for which date invoice is created.</li>\r\n	<li>Provide the description.</li>\r\n	<li>Then enter the quantity. Here quantity refers to the hour(s) spent on that particular item.</li>\r\n	<li>Then enter rate, which is the unit price per hour.</li>\r\n	<li>If you want to add more line item, you can do so by clicking on "<b>+ Add line-item</b>" button.</li>\r\n	<li>Then selsct the discount mode whether percent or flat and enter discount amount.</li>\r\n	<li>Then enter tax amount in percentage.</li>\r\n	<li>You can also upload your company logo at the top left hand side of the page. The logo must be smaller than 2MB in size. For the first time while creating invoice, if company logo is present it will be shown otherwise it will display no image. While editing image if there is no image for that company it will be stored as company logo. Otherwise it will be stored as that invoice logo.</li>\r\n	<li>Click on "<b>Save & Send</b>" button to save invoice and send email to customer.</li>\r\n	<li>Click on "<b>Save & Download</b>" button to save invoice and download it as pdf.</li>\r\n	<li>Click on "<b>Save and Close</b>" button to save invoice and go to invoice list page.</li>\r\n	<li>Click on "<b>Save and New</b>" button to save invoice and create another invoice.</li>', 'invoice_page.jpg', '', '2013-10-10 00:00:00', 0),
(78, 15, 'How to create Invoice from quick add?', '<li>You can also create invoice by clicking invoice item from "+Add" from header.</li>\r\n	<li>Check one or more "<b>Time log entries</b>" and click on "<b>Create Invoice</b>" button.</li>\r\n	<li>It will pop up a window to select either to create a new invoice or add it to existing invoice. Then click on "Update" button.</li>\r\n	<li>It will redirect to create invoice page where you can enter invoice number. It should be alpha numeric. This field is mandatory. And also this number can not be duplicate in one company.</li>\r\n	<li>Then select one term from terms drop down list. Terms is the number of days to pay the bill. According to the term selected, it changes the due date by which customer has to pay the bill. User can also manually change the due date.</li>\r\n	<li>Then pick an invoice date. Invoice date is the date for which invoice has been created. </li>  \r\n	<li>Then provide the billing from address. This is the address of the company who is creating the invoice.</li>\r\n	<li>Then select one customer form the customers drop down list. You can also add customer by selecting "+ Add new customer option".</li>\r\n	<li>Then provide the billing to address which is the address of the customer.</li>\r\n	<li>Then in line item pick a date for which date invoice is created.</li>\r\n	<li>Provide the description.</li>\r\n	<li>Then enter the quantity. Here quantity refers to the hour(s) spent on that particular item.</li>\r\n	<li>Then enter rate, which is the unit price per hour.</li>\r\n	<li>If you want to add more line item, you can do so by clicking on "<b>+ Add line-item</b>" button.</li>\r\n	<li>Then select the discount mode whether percent or flat and enter discount amount.</li>\r\n	<li>Then enter tax amount in percentage.</li>\r\n	<li>You can also upload your company logo at the top left hand side of the page. The logo must be smaller than 2MB in size.</li> \r\n	<li>Click on "<b>Save & Send</b>" button to save invoice and send email to customer.</li>\r\n	<li>Click on "<b>Save & Download</b>" button to save invoice and download it as pdf.</li>\r\n	<li>Click on "<b>Save and Close</b>" button to save invoice and go to invoice list page.</li>\r\n	<li>Click on "<b>Save and New</b>" button to save invoice and create another invoice.</li>', 'Quick_add.jpg', '', '2013-10-10 00:00:00', 0),
(79, 15, 'How to see unbilled time?', '<li>Click on "<b>Unbilled Time"</b> tab to view all unbilled time.</li>', 'unbilled_time.jpg', '', '2013-10-10 00:00:00', 0),
(80, 15, 'How to see invoice list?', '<li>Click on "<b>Invoice</b>" tab to see invoice list.</li>', 'invoice_list.jpg', '', '2013-10-10 00:00:00', 0),
(81, 15, 'How to see customers?', '<li>Click on "<b>Manage Customers</b>" tab to see all customers of company.</li>', 'Customers.jpg', '', '2013-10-10 00:00:00', 0),
(82, 15, 'How to create Invoice without unbilled time?', '<li>Go to Invoice section by clicking on "<b>Invoice</b>" icon on left hand side bar. It will show all unbilled time.</li>\r\n	<li>Click on right side down arrow of "<b>Create Invoice</b>" button on "<b>Create invoice without unbilled time</b>". It will redirect to create invoice page with an empty form.</li>', 'create_Invoice_without_unbilled_time.jpg', '', '2013-10-10 00:00:00', 0),
(83, 15, 'How to modify an invoice?', '<li>Click on "<b>Invoice<b>" tab and click on any invoice to modify it.</li>', 'modify_an_invoice.jpg', '', '2013-10-10 00:00:00', 0),
(84, 15, 'How to add customer?', '<li>Click on "Manage Customer" tab and then click on "<b>Add Customer</b>" button. It will open the pop-up to add customer details.\r\n	<a href="http://www.easyagile.us/img/Invoice/add_customer.jpg"><img src="http://www.easyagile.us/img/Invoice/add_customer.jpg"/></a></li> \r\n	<li>Enter Customer name, email and select currency and click on "<b>Create</b>" button to add customer.\r\n	<a href="http://www.easyagile.us/img/Invoice/add_customer-create.jpg"><img src="http://www.easyagile.us/img/Invoice/add_customer-create.jpg"/></a></li> \r\n	<li>If you want to add more detail for customer, click on "<b>+ Details</b>" and enter more detail of customer.\r\n	<a href="http://www.easyagile.us/img/Invoice/add-customer-details.jpg"><img src="http://www.easyagile.us/img/Invoice/add-customer-details.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(85, 15, 'How to add customer while creating Invoice?', '<li>While creating invoice, click on "<b>Customer</b>" drop down and select "<b>+ Add new Customer</b>". It will open a pop-up to enter customer details.</li>\r\n	<li>Enter Customer name, email and select currency and click on "<b>Create</b>" button to add customer.</li>\r\n	<li>If you want to add more detail for customer, click on "<b>+ Details</b>" and enter more detail of customer.</li>', 'add_new_Customer.jpg', '', '2013-10-10 00:00:00', 0),
(86, 15, 'How to manage customers?', 'li>Click on "<b>Manage Customer</b>" tab. It will show all existing customers of the company.</li> \r\n	<li>Click on right side edit icon to modify details of an existing customer.</li>', 'manage_customers.jpg', '', '2013-10-10 00:00:00', 0),
(87, 15, 'How to change status of customer?', '<li>While adding or edit of a customer, check "<b>Make Inactive</b>" check box to make a customer inactive and uncheck it to make customer active again.</li>', 'Make_Inactive.jpg', '', '2013-10-10 00:00:00', 0),
(88, 15, 'How do I send invoice to customer?', '<li>While creating invoice click on "<b>Save & Send</b>" button. It will pop-up a window.</li>\r\n	<li>In that pop up window, all the fields except To such as From, Subject and Message are pre-filled. You can also change those.</li>\r\n	<li>Then enter customer''s email address to whom Invoice will be sent in To text box.</li>\r\n	<li>Then click on "Send" button to send Invoice.</li>', 'Send.jpg', '', '2013-10-10 00:00:00', 0),
(89, 15, 'How Do I download Invoice?', '<li>While creating invoice click on "<b>Save & Download</b>" button to download the invoice as pdf.</li>\r\n	<li>Also while sending invoice to customer by clicking on the attachment the invoice will be downloaded as pdf.\r\n	<a href="http://www.easyagile.us/img/Invoice/download.jpg"><img src="http://www.easyagile.us/img/Invoice/download.jpg"/></a></li>', 'invoice_pdf.png', '', '2013-10-10 00:00:00', 0),
(103, 1, 'How to Create or Import Task?', '<li>In the dashboard, go to "+Add" Menu.</li><li>Click on "Import & Export" sub-menu present under Company Settings. The screenshot for "Import & Export" has been shown below.<a href="http://www.easyagile.us/img/help/task/creat_task_import1.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_import1.jpg"/></a></li><li>Click on "Download .csv file" option to downlaod a sample file. Insert you task in the prescribed format of downloaded file.</li><li>Click on "Choose File" to upload the .csv file.</li><li>Click on "Continue" to add multiple tasks from your .csv file.</li><li>You may export your created/uploaded task by clicking this button.<a href="http://www.easyagile.us/img/help/task/creat_task_import2.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_import2.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(104, 1, 'How to create Task Template?', '<li>Click on Task Template icon <span class="template_n_help"></span> from left side navigation. Click on + Create task Template box.<a href="http://www.easyagile.us/img/help/task/creat_task_template1.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_template1.jpg"/></a></li><li>It will pop out a box , You need to enter template name and its content.<a href="http://www.easyagile.us/img/help/task/creat_task_template2.jpg"><img src="http://www.easyagile.us/img/help/task/creat_task_template2.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(122, 10, 'What is Daily Catch-ups?', '<li>To get the update of the assigned project through email.</li>\r\n<li>Click the setting icon at the top right corner of the page, click "<strong> Daily Catch-up</strong>" to change the  Daily Catch-up settings.<a href="http://www.easyagile.us/img/help/Daily_Catchup_click.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/Daily_Catchup_click.jpg"/></a>\r\n<a href="http://www.easyagile.us/img/help/Daily_Catchup_tab.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/Daily_Catchup_tab.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(123, 16, 'How to customize a Task ?', '<li>Click on "How To Customize Task" button on Dashboard page. This will open up Task Type Customization Page.<a href="http://www.easyagile.us/img/help/customize_task.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/customize_task.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(124, 16, 'How to add new task types ?', '<li>You can add custom task types or choose from default available task types listed on task type customizationpage.</li><li>To add new task type ,click on "New Task Type" button.This will open up a form to add custom task type.<a href="http://www.easyagile.us/img/help/task_type.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/task_type.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(125, 16, 'How to view the task type of a task ?', '<li>Go to task listings page see the text next to <span class="act_task_type_tag"></span> icon.This text represents the task type.<a href="http://www.easyagile.us/img/help/view_tast_type.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/view_tast_type.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(126, 16, 'How to change the task type of a task ?', '<li>On the task listing page, click the drop down icon <span class="act_task_type_dropdwn"></span>next to the task type text or click on the tag icon <span class="act_task_type_tag"></span> to view all the available task types in a dropdown.</li>\r\n<li>Click on any available task type from the dropdown to change the task type.<a href="http://www.easyagile.us/img/help/dropdown.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/dropdown.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(127, 10, 'How to get Daily Catch-Up alerts for a project ?', '<li>In the Daily Catch-up Alerts settings page, select the Project from the project drop down to get all settings for daily Catch-up alerts.</li>\r\n<li>Select the user(s) by checking the check boxe(s) to send them Daily catch-up alerts.</li>\r\n<li>Select the Alert time from the drop down options to set a time for the Daily catch-up alerts.</li>\r\n<li>Select your Time zone from drop down List.</li>\r\n<li>Select the frequency to send the Daily catch-up alerts for particular days in a week.<a href="http://www.easyagile.us/img/help/section.jpg"><img alt="Loading..." src="http://www.easyagile.us/img/help/section.jpg"/></a></li>', '', '', '2013-10-10 00:00:00', 0),
(128, 10, 'Can I cancel a Daily Catch-up ?', '<li>Yes, in the "<strong> Daily Catch-up</strong>" section ,select the project in which Daily Catch-up alerts has been set and click on the "Cancel Daily Catch-up" link to cancel daily catch-up alerts.</li>', '', '', '2013-09-03 00:00:00', 0),
(129, 18, 'How to manage company?', '<li>Click on the "User Account Tab" to generate the menu as shown in the figure below.<a href="http://www.easyagile.us/img/help/company-settings-1.PNG">\r\n<img style="max-width:45%" src="http://www.easyagile.us/img/help/company-settings-1.PNG">\r\n</a></li>\r\n<li>From the Menu select "My Company" under "Company Settings".</li>\r\n<li>When you click on "My Company" new window will open which will look like the figure below:<a href="http://www.easyagile.us/img/help/company-settings-2.PNG">\r\n<img style="max-width:45%" src="http://www.easyagile.us/img/help/company-settings-2.PNG">\r\n</a></li>\r\n<li>In the form you will see "5" fill up columns. They are namely:</li>\r\n	<ul><li>Name of your company</li>\r\n	<li>OrangeScrum URL – This does not change. It is fixed</li>\r\n	<li>Company website Contact details</li>\r\n	<li>Company Logo</li></ul>\r\n<li>Having filled up those columns click on "Update" to continue or click on Cancel to go back. When you click on update button, a pop up message will appear which will say "Company Updated Successfully".</li>', '', '', '2015-11-06 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_display` tinyint(3) NOT NULL DEFAULT 1 COMMENT '0:No, 1: Yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`, `is_display`) VALUES
(1, 'Accounting', 1),
(2, 'Automobile', 1),
(3, 'Architecture & Planning', 1),
(4, 'Banking', 1),
(5, 'Broadcasting', 1),
(6, 'Capital Markets', 1),
(7, 'Construction & Manufacturing', 1),
(8, 'Consumer Services', 1),
(9, 'Education', 1),
(10, 'Entertainment', 1),
(11, 'E-Commerce', 1),
(12, 'Financial Services & Insurance', 1),
(13, 'Hospitality', 1),
(14, 'Health Services', 1),
(15, 'Human Resources', 1),
(16, 'Import and Export', 1),
(17, 'Information Technology and Services', 1),
(18, 'Leisure, Travel & Tourism', 1),
(19, 'Logistics and Supply Chain', 1),
(20, 'Marketing and Advertising', 1),
(21, 'Newspaper & Online Media', 1),
(22, 'Online Booking', 1),
(23, 'Pharmaceuticals', 1),
(24, 'Photography', 1),
(25, 'Real Estate', 1),
(26, 'Sports & Gaming', 1),
(27, 'Staffing and Recruiting', 1),
(28, 'Transportation', 1),
(29, 'Venture Capital & Private Equity', 1),
(30, 'Others', 1),
(31, 'wqerqwerqwerqwer', 0),
(32, 'testetewwetwewe', 0),
(33, 'sfasdf', 0),
(34, 'In-house', 0);

-- --------------------------------------------------------


--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `short_code`) VALUES
(1, 'Dutch', 'dum'),
(2, 'English', 'eng'),
(3, 'German', 'ger'),
(4, 'Portuguese', 'por'),
(5, 'Spanish', 'spa'),
(6, 'Turkish', 'tur'),
(7, 'French', 'fre'),
(8, 'Romanian', 'rum'),
(9, 'Chinese', 'chi'),
(10, 'Italian', 'ita');

-- --------------------------------------------------------

--
-- Table structure for table `log_activities`
--

CREATE TABLE `log_activities` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log_type_id` int(11) DEFAULT NULL,
  `json_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_times`
--

CREATE TABLE `log_times` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hours` int(10) NOT NULL COMMENT 'stored in seconds',
  `is_billable` tinyint(2) NOT NULL COMMENT '1-billable,0-not billable',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `task_status` tinyint(4) NOT NULL COMMENT '1-closed, 0-not closed',
  `created` datetime NOT NULL,
  `timesheet_flag` tinyint(2) NOT NULL DEFAULT 0,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `break_time` int(10) NOT NULL DEFAULT 0 COMMENT 'stored in seconds',
  `approver_id` int(11) DEFAULT NULL,
  `pending_status` int(11) NOT NULL DEFAULT 0 COMMENT '1-pending,2-approved,3-rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_types`
--

CREATE TABLE `log_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `log_types`
--

INSERT INTO `log_types` (`id`, `name`, `created`) VALUES
(1, 'Account Created', '2013-07-24 17:20:55'),
(3, 'User Deleted', '2013-07-24 17:20:55'),
(4, 'Plan Upgraded', '2013-07-24 17:24:48'),
(5, 'Braintree Profile Created', '2013-07-24 17:24:48'),
(6, 'Credit Card Updated', '2013-07-24 17:24:48'),
(7, 'Subscription Created', '2013-07-24 17:24:48'),
(8, 'Subscription Updated', '2013-07-24 17:24:48'),
(9, 'Invoice Generated', '2013-07-24 17:24:48'),
(10, 'Invoice Failed', '2013-07-24 17:24:48'),
(11, 'Subscription Expired', '2013-07-24 17:24:48'),
(12, 'Subscription canceled', '2013-07-24 17:24:48'),
(13, 'Subscription trial ended', '2013-07-24 17:24:48'),
(14, 'Subscription went active', '2013-07-24 17:24:48'),
(17, 'Invoice Email Sent', '2013-07-24 17:24:48'),
(18, 'Invoice Email Faild ', '2013-07-24 17:24:48'),
(19, 'Cancel subscription notification mail sent ', '2013-07-24 17:24:48'),
(20, 'Instant payment after cancel subscription', '2013-07-24 17:24:48'),
(21, 'Expiry date notification mail sent', '2013-07-24 17:24:48'),
(22, 'Instant payment invoice mail sent ', '2013-07-24 17:24:48'),
(23, 'Instant payment invoice mail faild ', '2013-07-24 17:24:48'),
(24, 'Account confirmed', '2013-09-05 18:41:14'),
(25, 'User invited', '2013-09-06 10:28:25'),
(26, 'User invitation confirmed', '2013-09-06 11:57:00'),
(27, 'User disabled', '2013-09-06 12:17:00'),
(28, 'User enabled', '2013-09-06 12:17:12'),
(29, 'Cancel subscription notification mail faild', '2013-09-06 16:08:33'),
(30, 'Credit Card expired', '2013-09-14 11:38:31'),
(31, 'Credit Card Reminder mail sent', '2013-09-14 11:38:26'),
(32, 'Subscription Payment Failed', '0000-00-00 00:00:00'),
(33, 'Account Deactivated', '0000-00-00 00:00:00'),
(34, 'Account Disable By Admin', '0000-00-00 00:00:00'),
(35, 'Plan downgraded', '0000-00-00 00:00:00'),
(36, 'Trial Period Extended', '2015-03-31 19:28:14'),
(37, 'Edit User', '2016-05-19 00:00:00'),
(38, 'Task Deleted', '2016-07-15 12:09:02'),
(39, 'Task Created From Mobile', '2017-03-14 00:00:00'),
(40, 'Task Updated From Mobile', '2017-03-14 00:00:00'),
(41, 'Replied On Task From Mobile', '2017-03-14 00:00:00'),
(42, 'Deleted Task From Mobile', '2017-03-14 00:00:00'),
(53, 'Subscription Period Extended  By Admin', '2015-04-14 19:28:14'),
(45, 'Project Created From Mobile', '2017-03-14 00:00:00'),
(46, 'Project Updated From Mobile', '2017-03-14 00:00:00'),
(47, 'Deleted Project From Mobile', '2017-03-14 00:00:00'),
(48, 'Assign/Remove User From Project From Mobile', '2017-03-14 00:00:00'),
(49, 'Invited New User From Mobile', '2017-03-14 00:00:00'),
(50, 'Assign/Remove Project from User From Mobile', '2017-03-14 00:00:00'),
(51, 'Updated User Status From Mobile', '2017-03-14 00:00:00'),
(52, 'Deleted User From Mobile', '2017-03-14 00:00:00'),
(54, 'Company ownership changed By Admin', '2015-04-17 18:50:14'),
(55, 'User Signed From Mobile', '2018-10-11 00:00:00'),
(56, 'Sprint Created', '2018-10-11 00:00:00'),
(57, 'Sprint Completed', '2018-10-11 00:00:00'),
(58, 'Sprint Updated', '2018-10-11 00:00:00'),
(59, 'Sprint Started', '2018-10-11 00:00:00'),
(60, 'Checklist Added', '2019-08-19 00:00:00'),
(61, 'Checklist Updated', '2019-08-19 00:00:00'),
(62, 'Checklist Deleted', '2019-08-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mail_tbls`
--

CREATE TABLE `mail_tbls` (
  `id` int(11) NOT NULL,
  `mail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0:inactive,1:active',
  `menu_type` tinyint(2) NOT NULL,
  `menu_icon` varchar(150) NOT NULL,
  `menu_order` int(11) NOT NULL,
  `default_menu` tinyint(2) NOT NULL COMMENT '0: normal menu,1: default menu',
  `conditional_menu` tinyint(2) NOT NULL COMMENT '0:normal menu,1: conditional menu',
  `meta` text DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `name`, `is_active`, `menu_type`, `menu_icon`, `menu_order`, `default_menu`, `conditional_menu`, `meta`, `created`, `modified`) VALUES
(1, 0, 'Dashboard', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE871;</i>', 1, 1, 0, '{\"url\":\"mydashboard\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"resetAllProjectFromDbd();\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(2, 0, 'Projects', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE8F9;</i>', 2, 1, 0, '{\"url\":\"projects/manage/\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"projectMenuLeft\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(3, 0, 'Tasks', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 3, 1, 0, '{\"url\":\"dashboard#tasks\",\"li_id\":\"\",\"a_id\":\"left_menu_nav_tour\",\"li_class\":\"caseMenuLeft menu-cases hover_arrow_right\",\"a_class\":\"\",\"a_click\":\"return checkHashLoad(\'milestonelist\');\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(4, 3, 'All Tasks', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 1, 1, 0, '{\"url\":\"dashboard#tasks/cases\",\"li_id\":\"cases_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li all-list-glyph\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'cases\'><span id=\'tskTabAllCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All Tasks\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(5, 3, 'Tasks assigned to me', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 2, 1, 0, '{\"url\":\"dashboard#tasks/assigntome\",\"li_id\":\"assigntome_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'assigntome\'><span id=\'tskTabMyCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All tasks assigned to me\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(6, 3, 'Favourites', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 3, 1, 0, '{\"url\":\"dashboard#tasks/favourite\",\"li_id\":\"favourite_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'favourite\'><span id=\'tskTabFavCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All favourite tasks\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(7, 3, 'Overdue', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 4, 1, 0, '{\"url\":\"dashboard#tasks/overdue\",\"li_id\":\"overdue_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'overdue\'><span id=\'tskTabOverdueCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All overdue tasks\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(8, 3, 'Tasks i\'ve created', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 5, 1, 0, '{\"url\":\"dashboard#tasks/delegateto\",\"li_id\":\"delegateto_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'delegateto\'><span id=\'tskTabDegCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All tasks not assinged to me\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(9, 3, 'High Priority', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 6, 1, 0, '{\"url\":\"dashboard#tasks/highpriority\",\"li_id\":\"highpriority_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'highpriority\'><span id=\'tskTabHPriCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All high priority tasks\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(10, 3, 'All Opened', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 7, 1, 0, '{\"url\":\"dashboard#tasks/openedtasks\",\"li_id\":\"openedtasks_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'openedtasks\'><span id=\'tskTabOpenedcnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All tasks having status new, in progress and resolve\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(11, 3, 'All Closed', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE862;</i>', 8, 1, 0, '{\"url\":\"dashboard#tasks/closedtasks\",\"li_id\":\"closedtasks_id\",\"a_id\":\"\",\"li_class\":\"cattab prevent_togl_li\",\"a_class\":\"\",\"a_click\":\"setTabSelection();\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'closedtasks\'><span id=\'tskTabClosedCnt\' class=\'spncls\'>0</span></span>\",\"a_tooltip\":\"All Closed tasks\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(12, 0, 'Reports', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 7, 1, 0, '{\"url\":\"project_reports/dashboard\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"hover_arrow_right projectReportMenuLeft\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(15, 12, 'Average Age Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 3, 1, 0, '{\"url\":\"project_reports/average_age_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Average Age Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(16, 12, 'Created vs. Resolved Tasks Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 4, 1, 0, '{\"url\":\"project_reports/create_resolve_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Created vs. Resolved Tasks Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(17, 12, 'Pie Chart Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 5, 1, 0, '{\"url\":\"project_reports/pie_chart_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Pie Chart Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(18, 12, 'Recently Created Tasks Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 6, 1, 0, '{\"url\":\"project_reports/recent_created_task_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Recently Created Tasks Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(19, 12, 'Resolution Time Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 7, 1, 0, '{\"url\":\"project_reports/resolution_time_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Resolution Time Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(20, 12, 'Time Since Tasks Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 8, 1, 0, '{\"url\":\"project_reports/time_since_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Time Since Tasks Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(21, 12, 'Hours Spent Report', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 9, 1, 0, '{\"url\":\"hours-report/\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Hours Spent Report\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(22, 12, 'Tasks Reports', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 10, 1, 0, '{\"url\":\"task-report/\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Task Reports\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(23, 12, 'Weekly Usage', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE922;</i>', 11, 1, 0, '{\"url\":\"reports/weeklyusage_report\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Weekly Usage\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(28, 0, 'Time Log List View', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE192;</i>', 4, 1, 0, '{\"url\":\"dashboard#timelog\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"menu-logs hover_arrow_right list_miscl relative miscl-icon-li\",\"a_class\":\"\",\"a_click\":\"return checkHashLoad(\'timelog\');\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(30, 28, 'Time Log List View', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE53B;</i>', 1, 1, 0, '{\"url\":\"dashboard#timelog\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"prevent_togl_li list-11 menu_logs_cmn menu_logs_timelog\",\"a_class\":\"\",\"a_click\":\"return checkHashLoad(\'timelog\');\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"Time Log List View\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(37, 0, 'Users', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE7FD;</i>', 6, 1, 0, '{\"url\":\"users/manage\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(38, 0, 'More', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE53B;</i>', 9, 1, 0, '{\"url\":\"#\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(39, 38, 'Files', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE53B;</i>', 4, 1, 0, '{\"url\":\"dashboard#files\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"menu-files\",\"a_class\":\"menu-files\",\"a_click\":\"return checkHashLoad(\'files\');\",\"li_click\":\"\",\"cnt_span\":\"<span class=\'cmn_count_no\' id=\'fileCnt\' style=\'\'>0</span>\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(42, 38, 'Archive', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE53B;</i>', 7, 1, 0, '{\"url\":\"archives/listall#caselist\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(46, 38, 'Kanban', 1, 0, '<i class=\"left-menu-icon material-icons\">&#xE8F0;</i>', 2, 1, 0, '{\"url\":\"dashboard#/milestonelist\",\"li_id\":\"\",\"a_id\":\"\",\"li_class\":\"\",\"a_class\":\"\",\"a_click\":\"\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}\n', '2020-01-10 00:00:00', '2020-01-10 00:00:00'),
(57, 0, 'Mention', 1, 0, '<i class=\"left-menu-icon material-icons\">alternate_email</i>', 2, 1, 0, '{\"url\":\"dashboard#mentioned_list\",\"li_id\":\"\",\"a_id\":\"left_menu_nav_tour\",\"li_class\":\"caseMenuLeft menu-mention \",\"a_class\":\"\",\"a_click\":\"return checkHashLoad(\'mentioned_list\');\",\"li_click\":\"\",\"cnt_span\":\"\",\"a_tooltip\":\"\"}', '2020-11-06 12:53:49', '2020-11-06 12:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `menu_languages`
--

CREATE TABLE `menu_languages` (
  `id` int(11) NOT NULL,
  `string_name` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `spa` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `por` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deu` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fra` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_languages`
--

INSERT INTO `menu_languages` (`id`, `string_name`, `en`, `spa`, `por`, `deu`, `fra`) VALUES
(2, 'Project', 'Project', 'Proyecto', 'Projeto', 'Projekt', 'Projet'),
(3, 'Archive', 'Archive', 'Archivo', 'Arquivo', 'Archiv', 'Archiver'),
(4, 'Gantt Chart', 'Gantt Chart', 'Gr├ífico de gantt', 'Gr├ífico de Gantt', 'Gantt-Diagramm', 'Diagramme de Gantt'),
(5, 'Activities', 'Activities', 'Ocupaciones', 'actividades', 'Aktivit├ñten', 'Activit├®s'),
(6, 'Calendar', 'Calendar', 'Calendario', 'Calend├írio', 'Kalender', 'Calendrier'),
(7, 'My Company', 'My Company', 'Mi empresa', 'Minha compania', 'Meine Firma', 'Mon entreprise'),
(8, 'User', 'User', 'Usuario', 'Do utilizador', 'Nutzer', 'Utilisateur'),
(9, 'Daily catch-Up', 'Daily catch-Up', 'Ponerse al d├¡a', 'Captura di├íria', 'T├ñgliches Aufholen', 'Rattrapage quotidien'),
(10, 'Task', 'Task', 'Tarea', 'Tarefa', 'Aufgabe', 'T├óche'),
(11, 'Task Group', 'Task Group', 'Tarea grupal', 'Grupo de Tarefas', 'Aufgabengruppe', 'Groupe de travail'),
(12, 'Import & Export', 'Import & Export', 'Importaci├│n y exportaci├│n', 'Importa├º├úo e Exporta├º├úo', 'Import Export', 'Import & Export'),
(13, 'Time Entry', 'Time Entry', 'Entrada de tiempo', 'Entrada de tempo', 'Zeiteintrag', 'Entr├®e dans le temps'),
(14, 'Task Type', 'Task Type', 'Tipo de tarea', 'Tipo de Tarefa', 'Aufgabentyp', 'Type de t├óche'),
(15, 'Start Timer', 'Start Timer', 'Temporizador de inicio', 'Iniciar temporizador', 'Timer starten', 'D├®marrer la minuterie'),
(17, 'Hours Spent', 'Hours Spent', 'Horas Pasadas', 'Horas gastas', 'Stunden verbracht', 'Heures pass├®es'),
(18, 'Manage Labels', 'Manage Labels', 'g├®rer les ├®tiquettes', 'gerenciar r├│tulos', 'Labels verwalten', 'g├®rer les ├®tiquettes'),
(20, 'Task Reports', 'Task Reports', 'Informes de tareas', 'Relat├│rios de Tarefas', 'Aufgabenberichte', 'Rapports de t├óches'),
(21, 'Task Setting', 'Task Setting', 'Configuraci├│n de tareas', 'Configura├º├úo de Tarefas', 'Aufgabenstellung', 'R├®glage de la t├óche'),
(22, 'Weekly Usage', 'Weekly Usage', 'Uso semanal', 'Uso Semanal', 'W├Âchentliche Nutzung', 'Usage hebdomadaire'),
(23, 'Resource Setting', 'Resource Setting', 'Configuraci├│n de recursos', 'Configura├º├úo de recursos', 'Ressourceneinstellung', 'Param├®trage des ressources'),
(24, 'My Profile', 'My Profile', 'Mi perfil', 'Meu perfil', 'Mein Profil', 'Mon profil'),
(25, 'Resource Utilization', 'Resource Utilization', 'Utilizaci├│n de recursos', 'Utiliza├º├úo de recursos', 'Ressourcennutzung', 'Utilisation des ressources'),
(26, 'Change Password', 'Change Password', 'Cambia la contrase├▒a', 'Mudar senha', '├ändere das Passwort', 'Changer le mot de passe'),
(27, 'Notifications', 'Notifications', 'Notificaciones', 'Notifica├º├Áes', 'Benachrichtigungen', 'Les notifications'),
(28, 'Email Reports', 'Email Reports', 'Informes de correo electr├│nico', 'Relat├│rios por email', 'E-Mail-Berichte', 'Rapports de messagerie'),
(29, 'Default View', 'Default View', 'Vista predeterminada', 'Visualiza├º├úo padr├úo', 'Standardansicht', 'Vue par d├®faut'),
(30, 'Getting Started', 'Getting Started', 'Empezando', 'Come├ºando', 'Fertig machen', 'Commencer'),
(31, 'Product Updates', 'Product Updates', 'Actualizaciones de Producto', 'Atualiza├º├Áes do produto', 'Produktaktualisierungen', 'Mises ├á jour du produit'),
(32, 'Resource Availability', 'Resource Availability', 'Disponibilidad de recursos', 'Disponibilidade de recursos', 'Ressourcenverf├╝gbarkeit', 'La disponibilit├® des ressources'),
(33, 'Help Desk', 'Help Desk', 'Mesa de ayuda', 'Central de Ajuda', 'Beratungsstelle', 'bureau d''aide'),
(34, 'Chat Setting', 'Chat Setting', 'Configuraci├│n de chat', 'Configura├º├úo de bate-papo', 'Chat-Einstellung', 'Param├¿tres de chat'),
(35, 'Pending Task', 'Pending Task', 'Tarea pendiente', 'Tarefa pendente', 'Ausstehende Aufgabe', 'T├óche en attente'),
(36, 'Weekly Timesheet', 'Weekly Timesheet', 'Hoja de horas semanal', 'Quadro de Hor├írios Semanal', 'W├Âchentliche Stundenzettel', 'Feuille de temps hebdomadaire'),
(37, 'Launchpad', 'Launchpad', 'Rampe de lancement', 'Plataforma de lan├ºamento', 'Launchpad', 'Rampe de lancement'),
(38, 'Companies', 'Companies', 'Compa├▒├¡as', 'Empresas', 'Firmen', 'Entreprises'),
(39, 'Daily Timesheet', 'Daily Timesheet', 'Hoja de horas diaria', 'Quadro de hor├írios di├írio', 'T├ñgliche Stundenzettel', 'Feuille de temps quotidienne'),
(40, 'New', 'New', 'Nuevo', 'Novo', 'Neu', 'Nouveau'),
(41, 'Analytics', 'Analytics', 'Anal├¡tica', 'Analytics', 'Analytics', 'Analytique'),
(42, 'Others', 'Others', 'otros', 'outros', 'Andere', 'autres'),
(43, 'Company Settings', 'Company Settings', 'Ajustes de la empresa', 'Configurações da empresa', 'Unternehmenseinstellungen', 'Paramètres de l\'entreprise'),
(44, 'Personal Settings', 'Personal Settings', 'Configuraciones personales', 'Configurações pessoais', 'Persönliche Einstellungen', 'Paramètres personnels'),
(45, 'Template', 'Template', 'Modelo', 'Modelo', 'Vorlage', 'Modèle'),
(46, 'Status Workflow Setting', 'Status Workflow Setting', 'Configuración de flujo de trabajo de estado', 'Configuração do fluxo de trabalho de status', 'Status Workflow Einstellung', 'Statut du flux de travail');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` int(250) NOT NULL,
  `uniq_id` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(250) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(250) NOT NULL,
  `estimated_hours` decimal(10,0) NOT NULL,
  `duration` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-1week, 2-2week..., 5-custom',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive, 1-Active',
  `is_started` tinyint(2) NOT NULL DEFAULT 0,
  `id_seq` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `uniq_id`, `name`, `is_active`, `created`, `modified`) VALUES
(1, 'f1d1c15c9518e302b5ff31bda7e2e975', 'Task', 1, '2017-03-09 10:04:10', '2017-03-09 10:04:10'),
(2, 'fa7e517a792e561ccf8ef26d7a62ead3', 'File', 1, '2017-03-09 10:15:34', '2017-03-09 10:15:34'),
(3, 'f5592d56c16fbdb11d5fcf5ba3c33d57', 'Timelog', 1, '2017-03-09 10:16:13', '2017-03-09 10:16:13'),
(4, 'b4d8f18ac485229de87769beac7694ae', 'Invoice', 1, '2017-03-09 10:16:34', '2017-03-09 10:16:34'),
(5, 'c819367bdc5fbff4f2a32f7c413d6949', 'Project', 1, '2017-03-09 10:16:48', '2017-03-09 10:16:48'),
(6, 'bf2c48b6acbce35bcd1ecf17e3e8ce38', 'User', 1, '2017-03-09 10:17:01', '2017-03-09 10:17:01'),
(7, 'f224a244f3029a3d7a4bb591ae9721f3', 'Gantt Chart', 1, '2017-03-09 10:17:18', '2017-03-09 10:17:18'),
(8, 'd8fb9d257d9279ae7d4f2cf45f20e2e7', 'Dashboard', 1, '2017-03-09 10:17:36', '2017-03-09 10:17:36'),
(9, '249ae62b0d287ece4ac92ad1b58af879', 'Template', 0, '2017-03-09 10:17:54', '2017-03-09 10:17:54'),
(10, 'd0a5ddc5dcfcf5d31e9c7d87587d8c6e', 'Milestone', 1, '2017-03-09 10:18:07', '2017-03-09 10:18:07'),
(11, '22c9b30d945ff3bbf88dd2bf59fbd90c', 'Daily Catch-Up', 0, '2017-03-09 10:18:29', '2017-03-09 10:18:29'),
(12, 'e225d605ab2983649bcbc38242287e43', 'Email Notification', 0, '2017-03-09 10:18:45', '2017-03-09 10:18:45'),
(13, '106c65c7512c243072929ed626f5dd80', 'Calendar', 0, '2017-03-09 10:20:06', '2017-03-09 10:20:06'),
(14, '35f405ccad2e62daeb90ea3c1e7c6645', 'Kanban', 0, '2017-03-09 10:20:27', '2017-03-09 10:20:27'),
(15, 'f1d1c15c9518e302b5ff31bda7e0opn6', 'Expense', 0, '2017-03-09 10:04:10', '2017-03-09 10:04:10'),
(16, 'f1d1c15c9518e302b5ff31bda7e8ior5', 'Wiki', 1, '2017-03-09 10:04:10', '2017-03-09 10:04:10'),
(17, 'f1d1c15c9518e302b5ff31bda7e896kj', 'Settings', 1, '2017-03-09 10:04:10', '2017-03-09 10:04:10'),
(18, 'f1d1c15c9518e302b5ff31bda7ep93f2', 'Defect', 0, '2017-03-09 10:04:10', '2017-03-09 10:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `new_pricing_users`
--

CREATE TABLE `new_pricing_users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `per_user_price` int(11) NOT NULL DEFAULT 0,
  `total_price` int(11) NOT NULL DEFAULT 0,
  `plan_id` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_seen` datetime DEFAULT NULL,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--

-- Table structure for table `osusage_details`
--

CREATE TABLE `osusage_details` (
  `id` int(11) NOT NULL,
  `loggedin` tinyint(4) NOT NULL,
  `task` int(11) NOT NULL,
  `reply` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `taskgroup` int(11) NOT NULL,
  `timelog` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `is_paid` tinyint(2) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os_session_logs`
--

CREATE TABLE `os_session_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `overloads`
--

CREATE TABLE `overloads` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `overload` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `company_id` int(11) NOT NULL,
  `task_type` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(100) NOT NULL,
  `project_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-Internal, 2-External',
  `priority` tinyint(2) NOT NULL DEFAULT 2,
  `default_assign` int(255) NOT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1- Active, 2- Inactive',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1= Started, 2= Hold on, 3= Stack',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `estimated_hours` decimal(10,0) DEFAULT NULL,
  `dt_created` datetime NOT NULL,
  `dt_updated` datetime DEFAULT NULL,
  `is_multiple_sprint` tinyint(2) NOT NULL DEFAULT 0,
  `project_methodology_id` int(11) NOT NULL DEFAULT 1,
  `status_group_id` int(11) NOT NULL DEFAULT 0,
  `defect_status_group_id` int(11) NOT NULL DEFAULT 0,
  `is_zapaction` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_actions`
--

CREATE TABLE `project_actions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `is_allowed` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=Allowed, 0=Not Allowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_booked_resources`
--

CREATE TABLE `project_booked_resources` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `booked_hours` int(11) NOT NULL,
  `overload` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `project_fields`
--

CREATE TABLE `project_fields` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `field_name` text DEFAULT NULL,
  `form_fields` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_metas`
--

CREATE TABLE `project_metas` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_manager` varchar(100) NOT NULL DEFAULT '0',
  `client` int(11) NOT NULL DEFAULT 0,
  `currency` smallint(6) NOT NULL DEFAULT 0,
  `budget` int(11) NOT NULL DEFAULT 0,
  `default_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cost_appr` int(11) NOT NULL DEFAULT 0,
  `min_tol` tinyint(4) NOT NULL DEFAULT 0,
  `max_tol` tinyint(4) NOT NULL DEFAULT 0,
  `proj_type` int(11) NOT NULL DEFAULT 0,
  `industry` smallint(6) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `project_methodologies`
--

CREATE TABLE `project_methodologies` (
  `id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `status_group_id` int(11) NOT NULL,
  `listing_description` text COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_template_view_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-enable,0-Disable',
  `seq_no` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_methodologies`
--

INSERT INTO `project_methodologies` (`id`, `title`, `status_group_id`, `listing_description`, `short_description`, `description`, `thumbnail`, `full_image`, `project_template_view_id`, `status`, `seq_no`, `created`, `updated`) VALUES
(1, 'Simple', 28, 'Do more than just \"manage\" your project.', 'Do more than just \"manage\" your project.', '<p>Easy to use and manage projects with this template. This helps to:</p>\r\n<ul>\r\n<li>Manage and track status your tasks in a list view</li>\r\n<li>Delegate tasks easily to assign tasks to teams</li>\r\n<li>Monitor team’s activity at one place</li>\r\n</ul>', 'simple.png', 'full_simple.svg', 1, 1, 1, '2018-07-10 00:00:00', '2018-07-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_notes`
--

CREATE TABLE `project_notes` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(80) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_updated` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_settings`
--

CREATE TABLE `project_settings` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `velocity_reports` tinyint(2) NOT NULL COMMENT '0=>Story Point, 1=>Est Hr',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_statuses`
--

CREATE TABLE `project_statuses` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_statuses`
--

INSERT INTO `project_statuses` (`id`, `company_id`, `user_id`, `name`, `is_active`, `created`, `modified`) VALUES
(1, 0, 0, 'Started', 1, '2019-09-17 00:00:00', '2019-09-17 00:00:00'),
(2, 0, 0, 'On Hold', 1, '2019-09-17 00:00:00', '2019-09-17 00:00:00'),
(3, 0, 0, 'Stack', 1, '2019-09-17 00:00:00', '2019-09-17 00:00:00'),
(4, 0, 0, 'Completed', 1, '2019-09-17 08:26:12', '2019-09-17 08:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `project_technologies`
--

CREATE TABLE `project_technologies` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `technology_id` smallint(6) NOT NULL COMMENT 'Foreign key of "technologies"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_templates`
--

CREATE TABLE `project_templates` (
  `id` int(11) NOT NULL,
  `user_id` int(250) NOT NULL,
  `company_id` int(250) NOT NULL,
  `module_name` varchar(250) NOT NULL,
  `is_default` tinyint(4) NOT NULL COMMENT '0-default,1-not',
  `is_active` tinyint(2) NOT NULL COMMENT '1-active,0-inactive',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(2) DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_users`
--

CREATE TABLE `project_users` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'Foreign key of "projects"',
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key of "users"',
  `istype` tinyint(2) NOT NULL DEFAULT 2 COMMENT '1-Admin, 2-Moderator, 3-Viewer',
  `default_email` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-No, 1-Yes',
  `dt_visited` datetime NOT NULL,
  `role_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quicklink_menus`
--

CREATE TABLE `quicklink_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_language_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quicklink_menus`
--

INSERT INTO `quicklink_menus` (`id`, `name`, `menu_language_id`, `created`) VALUES
(1, 'New', 40, '2019-03-27 20:21:35'),
(2, 'Analytics', 41, '2019-03-27 20:21:52'),
(3, 'Others', 42, '2019-03-27 20:22:06'),
(4, 'Company Settings', 43, '2019-03-27 20:22:30'),
(5, 'Personal Settings', 44, '2019-03-28 12:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `quicklink_submenus`
--

CREATE TABLE `quicklink_submenus` (
  `id` int(11) NOT NULL,
  `quicklink_menu_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_language_id` int(11) DEFAULT NULL,
  `action_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quicklink_submenus`
--

INSERT INTO `quicklink_submenus` (`id`, `quicklink_menu_id`, `name`, `menu_language_id`, `action_name`, `status`, `created`) VALUES
(1, 1, 'Project', 2, NULL, 1, '2019-03-27 20:23:31'),
(2, 1, 'User', 8, NULL, 1, '2019-03-27 20:23:46'),
(3, 1, 'Task', 10, NULL, 1, '2019-03-27 20:24:00'),
(5, 1, 'Time Entry', 13, NULL, 1, '2019-03-27 20:24:26'),
(9, 2, 'Hours Spent', 17, NULL, 1, '2019-03-27 20:25:37'),
(10, 2, 'Task Reports', 20, NULL, 1, '2019-03-27 20:25:52'),
(11, 2, 'Weekly Usage', 22, NULL, 1, '2019-03-27 20:26:08'),
(14, 2, 'Pending Task', 35, NULL, 1, '2019-03-27 20:27:01'),
(17, 3, 'Archive', 3, NULL, 1, '2019-03-27 20:28:00'),
(20, 3, 'Activities', 5, NULL, 1, '2019-03-27 20:28:55'),
(21, 3, 'Calendar', 6, NULL, 1, '2019-03-27 20:29:08'),
(22, 4, 'My Company', 7, NULL, 1, '2019-03-28 09:47:32'),
(23, 4, 'Daily catch-Up', 9, NULL, 1, '2019-03-28 09:47:47'),
(24, 4, 'Import & Export', 12, NULL, 1, '2019-03-28 09:48:03'),
(25, 4, 'Task Type', 14, NULL, 1, '2019-03-28 09:48:16'),
(30, 5, 'My Profile', 24, NULL, 1, '2019-03-28 12:35:56'),
(31, 5, 'Change Password', 26, NULL, 1, '2019-03-28 12:36:10'),
(32, 5, 'Notifications', 27, NULL, 1, '2019-03-28 12:36:22'),
(33, 5, 'Email Reports', 28, NULL, 1, '2019-03-28 12:36:33'),
(34, 5, 'Default View', 29, NULL, 1, '2019-03-28 12:36:49'),
(35, 5, 'Getting Started', 30, NULL, 1, '2019-03-28 12:37:07'),
(36, 5, 'Product Updates', 31, NULL, 1, '2019-03-28 12:37:19'),
(37, 5, 'Help Desk', 33, NULL, 1, '2019-03-28 12:37:36'),
(39, 5, 'Launchpad', 37, NULL, 1, '2019-03-28 16:18:03'),
(40, 3, 'Companies', 38, NULL, 1, '2019-03-29 13:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `recurring_easycases`
--

CREATE TABLE `recurring_easycases` (
  `id` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `recurring_type` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `occurrence` int(11) DEFAULT 0,
  `end_date` date DEFAULT NULL,
  `recurring_end_type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `frequency` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `rec_interval` int(11) DEFAULT 0,
  `bymonthday` int(11) DEFAULT 0,
  `byday` varchar(255) DEFAULT NULL,
  `byweekno` int(11) DEFAULT 0,
  `bymonth` int(11) DEFAULT 0,
  `occurrences` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `releases`
--

CREATE TABLE `releases` (
  `id` int(11) NOT NULL,
  `title` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  `is_hyperlink` tinyint(2) NOT NULL DEFAULT 0,
  `hyperlink_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `release_logs`
--

CREATE TABLE `release_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `release_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `release_subscriptions`
--

CREATE TABLE `release_subscriptions` (
  `id` int(11) NOT NULL,
  `release_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resource_settings`
--

CREATE TABLE `resource_settings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_group_id` int(11) DEFAULT 0,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `uniq_id`, `company_id`, `role_group_id`, `role`, `short_name`, `created`, `modified`) VALUES
(1, 'a99f2a757e016091414fe2037823f4ab', 0, NULL, 'Owner', 'owner', '2017-03-04 00:00:00', '2017-03-04 00:00:00'),
(2, 'a99f2a757e016091414fe2037823f4ac', 0, NULL, 'Admin', 'adm', '2017-03-04 00:00:00', '2017-05-24 13:23:30'),
(3, 'a99f2a757e016091414fe2037823f4ad', 0, NULL, 'User', 'usr', '2017-03-04 00:00:00', '2017-05-24 06:40:16'),
(4, 'a99f2a757e016091414fe2037823f4ae', 0, NULL, 'Client', 'clnt', '2017-03-04 00:00:00', '2017-05-24 13:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `role_actions`
--

CREATE TABLE `role_actions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `is_allowed` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=Allowed, 0= Not Allowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_actions`
--

INSERT INTO `role_actions` (`id`, `company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(1, 0, 1, 1, 1),
(2, 0, 1, 2, 1),
(3, 0, 1, 3, 1),
(4, 0, 1, 4, 1),
(5, 0, 1, 5, 1),
(6, 0, 1, 6, 1),
(7, 0, 1, 7, 1),
(8, 0, 1, 8, 1),
(9, 0, 1, 9, 1),
(10, 0, 1, 10, 1),
(11, 0, 1, 11, 1),
(12, 0, 1, 12, 1),
(13, 0, 1, 13, 1),
(14, 0, 1, 14, 1),
(15, 0, 1, 15, 1),
(16, 0, 1, 16, 1),
(17, 0, 1, 17, 1),
(18, 0, 1, 18, 1),
(19, 0, 1, 19, 1),
(20, 0, 1, 20, 1),
(21, 0, 1, 21, 1),
(22, 0, 1, 22, 1),
(23, 0, 1, 23, 1),
(24, 0, 1, 24, 1),
(25, 0, 1, 25, 1),
(26, 0, 1, 26, 1),
(27, 0, 1, 27, 1),
(28, 0, 1, 28, 1),
(29, 0, 1, 29, 1),
(30, 0, 1, 30, 1),
(31, 0, 1, 31, 1),
(32, 0, 1, 32, 1),
(33, 0, 1, 33, 1),
(34, 0, 1, 34, 1),
(35, 0, 1, 35, 1),
(36, 0, 1, 36, 1),
(37, 0, 1, 37, 1),
(38, 0, 1, 41, 1),
(39, 0, 1, 43, 1),
(40, 0, 1, 48, 1),
(41, 0, 1, 49, 1),
(42, 0, 1, 50, 1),
(43, 0, 1, 51, 1),
(44, 0, 1, 52, 1),
(45, 0, 1, 53, 1),
(46, 0, 1, 54, 1),
(47, 0, 1, 55, 1),
(48, 0, 1, 56, 1),
(49, 0, 1, 57, 1),
(50, 0, 1, 59, 1),
(51, 0, 1, 60, 1),
(52, 0, 1, 61, 1),
(53, 0, 1, 62, 1),
(54, 0, 1, 63, 1),
(55, 0, 1, 64, 1),
(56, 0, 1, 65, 1),
(57, 0, 1, 66, 1),
(58, 0, 1, 67, 1),
(59, 0, 1, 68, 1),
(60, 0, 1, 69, 1),
(61, 0, 1, 75, 1),
(62, 0, 1, 76, 1),
(63, 0, 1, 77, 1),
(64, 0, 1, 78, 1),
(65, 0, 1, 79, 1),
(66, 0, 1, 80, 1),
(67, 0, 1, 81, 1),
(68, 0, 1, 82, 1),
(69, 0, 1, 83, 1),
(70, 0, 1, 84, 1),
(71, 0, 1, 85, 1),
(72, 0, 1, 86, 1),
(73, 0, 1, 87, 1),
(74, 0, 1, 88, 1),
(75, 0, 1, 89, 1),
(76, 0, 1, 90, 1),
(77, 0, 1, 91, 1),
(78, 0, 1, 92, 1),
(79, 0, 1, 93, 1),
(80, 0, 1, 94, 1),
(81, 0, 1, 95, 1),
(82, 0, 1, 96, 1),
(83, 0, 1, 97, 1),
(84, 0, 1, 98, 1),
(85, 0, 1, 99, 1),
(86, 0, 1, 100, 1),
(87, 0, 1, 101, 1),
(88, 0, 2, 1, 1),
(89, 0, 2, 2, 1),
(90, 0, 2, 3, 1),
(91, 0, 2, 4, 1),
(92, 0, 2, 5, 1),
(93, 0, 2, 6, 1),
(94, 0, 2, 7, 1),
(95, 0, 2, 8, 1),
(96, 0, 2, 9, 1),
(97, 0, 2, 10, 1),
(98, 0, 2, 11, 1),
(99, 0, 2, 12, 1),
(100, 0, 2, 13, 1),
(101, 0, 2, 14, 1),
(102, 0, 2, 15, 1),
(103, 0, 2, 16, 1),
(104, 0, 2, 17, 1),
(105, 0, 2, 18, 1),
(106, 0, 2, 19, 1),
(107, 0, 2, 20, 1),
(108, 0, 2, 21, 1),
(109, 0, 2, 22, 1),
(110, 0, 2, 23, 1),
(111, 0, 2, 24, 1),
(112, 0, 2, 25, 1),
(113, 0, 2, 26, 1),
(114, 0, 2, 27, 1),
(115, 0, 2, 28, 1),
(116, 0, 2, 29, 1),
(117, 0, 2, 30, 1),
(118, 0, 2, 31, 1),
(119, 0, 2, 32, 1),
(120, 0, 2, 33, 1),
(121, 0, 2, 34, 1),
(122, 0, 2, 35, 1),
(123, 0, 2, 36, 1),
(124, 0, 2, 37, 1),
(125, 0, 2, 41, 1),
(126, 0, 2, 43, 1),
(127, 0, 2, 48, 1),
(128, 0, 2, 49, 1),
(129, 0, 2, 50, 1),
(130, 0, 2, 51, 1),
(131, 0, 2, 52, 1),
(132, 0, 2, 53, 1),
(133, 0, 2, 54, 1),
(134, 0, 2, 55, 1),
(135, 0, 2, 56, 1),
(136, 0, 2, 57, 1),
(137, 0, 2, 59, 1),
(138, 0, 2, 60, 1),
(139, 0, 2, 61, 1),
(140, 0, 2, 62, 1),
(141, 0, 2, 63, 1),
(142, 0, 2, 64, 1),
(143, 0, 2, 65, 1),
(144, 0, 2, 66, 1),
(145, 0, 2, 67, 1),
(146, 0, 2, 68, 1),
(147, 0, 2, 69, 1),
(148, 0, 2, 75, 1),
(149, 0, 2, 76, 1),
(150, 0, 2, 77, 1),
(151, 0, 2, 78, 1),
(152, 0, 2, 79, 1),
(153, 0, 2, 80, 1),
(154, 0, 2, 81, 1),
(155, 0, 2, 82, 1),
(156, 0, 2, 83, 1),
(157, 0, 2, 84, 1),
(158, 0, 2, 85, 1),
(159, 0, 2, 86, 1),
(160, 0, 2, 87, 1),
(161, 0, 2, 88, 1),
(162, 0, 2, 89, 1),
(163, 0, 2, 90, 1),
(164, 0, 2, 91, 1),
(165, 0, 2, 92, 1),
(166, 0, 2, 93, 1),
(167, 0, 2, 94, 1),
(168, 0, 2, 95, 1),
(169, 0, 2, 96, 1),
(170, 0, 2, 97, 1),
(171, 0, 2, 98, 1),
(172, 0, 2, 99, 1),
(173, 0, 2, 100, 1),
(174, 0, 2, 101, 1),
(175, 0, 3, 1, 1),
(176, 0, 3, 2, 1),
(177, 0, 3, 3, 1),
(178, 0, 3, 4, 1),
(179, 0, 3, 5, 1),
(180, 0, 3, 6, 1),
(181, 0, 3, 7, 1),
(182, 0, 3, 8, 1),
(183, 0, 3, 9, 1),
(184, 0, 3, 10, 1),
(185, 0, 3, 11, 1),
(186, 0, 3, 12, 1),
(187, 0, 3, 13, 1),
(188, 0, 3, 14, 1),
(189, 0, 3, 15, 1),
(190, 0, 3, 16, 1),
(191, 0, 3, 17, 1),
(192, 0, 3, 18, 1),
(193, 0, 3, 19, 1),
(194, 0, 3, 20, 1),
(195, 0, 3, 21, 1),
(196, 0, 3, 22, 0),
(197, 0, 3, 23, 0),
(198, 0, 3, 24, 0),
(199, 0, 3, 25, 1),
(200, 0, 3, 26, 1),
(201, 0, 3, 27, 1),
(202, 0, 3, 28, 1),
(203, 0, 3, 29, 1),
(204, 0, 3, 30, 1),
(205, 0, 3, 31, 1),
(206, 0, 3, 32, 1),
(207, 0, 3, 33, 1),
(208, 0, 3, 34, 0),
(209, 0, 3, 35, 0),
(210, 0, 3, 36, 0),
(211, 0, 3, 37, 0),
(212, 0, 3, 41, 1),
(213, 0, 3, 43, 1),
(214, 0, 3, 48, 1),
(215, 0, 3, 49, 1),
(216, 0, 3, 50, 1),
(217, 0, 3, 51, 1),
(218, 0, 3, 52, 0),
(219, 0, 3, 53, 0),
(220, 0, 3, 54, 0),
(221, 0, 3, 55, 0),
(222, 0, 3, 56, 0),
(223, 0, 3, 57, 0),
(224, 0, 3, 59, 0),
(225, 0, 3, 60, 1),
(226, 0, 3, 61, 1),
(227, 0, 3, 62, 1),
(228, 0, 3, 63, 1),
(229, 0, 3, 64, 1),
(230, 0, 3, 65, 0),
(231, 0, 3, 66, 1),
(232, 0, 3, 67, 1),
(233, 0, 3, 68, 1),
(234, 0, 3, 69, 0),
(235, 0, 3, 75, 1),
(236, 0, 3, 76, 1),
(237, 0, 3, 77, 0),
(238, 0, 3, 78, 0),
(239, 0, 3, 79, 0),
(240, 0, 3, 80, 0),
(241, 0, 3, 81, 0),
(242, 0, 3, 82, 0),
(243, 0, 3, 83, 0),
(244, 0, 3, 84, 0),
(245, 0, 3, 85, 0),
(246, 0, 3, 86, 0),
(247, 0, 3, 87, 1),
(248, 0, 3, 88, 1),
(249, 0, 3, 89, 1),
(250, 0, 3, 90, 1),
(251, 0, 3, 91, 1),
(252, 0, 3, 92, 1),
(253, 0, 3, 93, 1),
(254, 0, 3, 94, 1),
(255, 0, 3, 95, 1),
(256, 0, 3, 96, 1),
(257, 0, 3, 97, 1),
(258, 0, 3, 98, 0),
(259, 0, 3, 99, 0),
(260, 0, 3, 100, 1),
(261, 0, 3, 101, 1),
(262, 0, 4, 1, 1),
(263, 0, 4, 2, 1),
(264, 0, 4, 3, 1),
(265, 0, 4, 4, 1),
(266, 0, 4, 5, 1),
(267, 0, 4, 6, 1),
(268, 0, 4, 7, 1),
(269, 0, 4, 8, 1),
(270, 0, 4, 9, 1),
(271, 0, 4, 10, 1),
(272, 0, 4, 11, 1),
(273, 0, 4, 12, 1),
(274, 0, 4, 13, 1),
(275, 0, 4, 14, 1),
(276, 0, 4, 15, 1),
(277, 0, 4, 16, 1),
(278, 0, 4, 17, 1),
(279, 0, 4, 18, 1),
(280, 0, 4, 19, 1),
(281, 0, 4, 20, 1),
(282, 0, 4, 21, 1),
(283, 0, 4, 22, 0),
(284, 0, 4, 23, 0),
(285, 0, 4, 24, 0),
(286, 0, 4, 25, 1),
(287, 0, 4, 26, 1),
(288, 0, 4, 27, 1),
(289, 0, 4, 28, 1),
(290, 0, 4, 29, 1),
(291, 0, 4, 30, 1),
(292, 0, 4, 31, 1),
(293, 0, 4, 32, 1),
(294, 0, 4, 33, 1),
(295, 0, 4, 34, 0),
(296, 0, 4, 35, 0),
(297, 0, 4, 36, 0),
(298, 0, 4, 37, 0),
(299, 0, 4, 41, 1),
(300, 0, 4, 43, 1),
(301, 0, 4, 48, 1),
(302, 0, 4, 49, 1),
(303, 0, 4, 50, 1),
(304, 0, 4, 51, 1),
(305, 0, 4, 52, 0),
(306, 0, 4, 53, 0),
(307, 0, 4, 54, 0),
(308, 0, 4, 55, 0),
(309, 0, 4, 56, 0),
(310, 0, 4, 57, 0),
(311, 0, 4, 59, 0),
(312, 0, 4, 60, 1),
(313, 0, 4, 61, 1),
(314, 0, 4, 62, 0),
(315, 0, 4, 63, 0),
(316, 0, 4, 64, 0),
(317, 0, 4, 65, 0),
(318, 0, 4, 66, 1),
(319, 0, 4, 67, 1),
(320, 0, 4, 68, 1),
(321, 0, 4, 69, 0),
(322, 0, 4, 75, 1),
(323, 0, 4, 76, 1),
(324, 0, 4, 77, 0),
(325, 0, 4, 78, 0),
(326, 0, 4, 79, 0),
(327, 0, 4, 80, 0),
(328, 0, 4, 81, 0),
(329, 0, 4, 82, 0),
(330, 0, 4, 83, 0),
(331, 0, 4, 84, 0),
(332, 0, 4, 85, 0),
(333, 0, 4, 86, 0),
(334, 0, 4, 87, 1),
(335, 0, 4, 88, 1),
(336, 0, 4, 89, 1),
(337, 0, 4, 90, 1),
(338, 0, 4, 91, 1),
(339, 0, 4, 92, 1),
(340, 0, 4, 93, 1),
(341, 0, 4, 94, 1),
(342, 0, 4, 95, 1),
(343, 0, 4, 96, 1),
(344, 0, 4, 97, 1),
(345, 0, 4, 98, 0),
(346, 0, 4, 99, 0),
(347, 0, 4, 100, 1),
(348, 0, 4, 101, 1),
(349, 0, 1, 103, 1),
(350, 0, 1, 104, 1),
(351, 0, 1, 105, 1),
(352, 0, 1, 106, 1),
(353, 0, 1, 107, 1),
(354, 0, 2, 103, 1),
(355, 0, 2, 104, 1),
(356, 0, 2, 105, 1),
(357, 0, 2, 106, 1),
(358, 0, 2, 107, 1),
(359, 0, 3, 103, 0),
(360, 0, 3, 104, 0),
(361, 0, 3, 105, 0),
(362, 0, 3, 106, 0),
(363, 0, 3, 107, 0),
(364, 0, 4, 103, 0),
(365, 0, 4, 104, 0),
(366, 0, 4, 105, 0),
(367, 0, 4, 106, 0),
(368, 0, 4, 107, 0),
(369, 0, 1, 108, 1),
(370, 0, 2, 108, 1),
(371, 0, 3, 108, 1),
(372, 0, 4, 108, 1),
(373, 0, 1, 109, 1),
(374, 0, 2, 109, 1),
(375, 0, 3, 109, 1),
(376, 0, 4, 109, 1),
(377, 0, 1, 110, 1),
(378, 0, 1, 111, 1),
(379, 0, 1, 112, 1),
(380, 0, 1, 113, 1),
(381, 0, 1, 114, 1),
(382, 0, 1, 115, 1),
(383, 0, 2, 110, 1),
(384, 0, 2, 111, 1),
(385, 0, 2, 112, 1),
(386, 0, 2, 113, 1),
(387, 0, 2, 114, 1),
(388, 0, 2, 115, 1),
(389, 0, 3, 110, 0),
(390, 0, 3, 111, 0),
(391, 0, 3, 112, 0),
(392, 0, 3, 113, 0),
(393, 0, 3, 114, 0),
(394, 0, 3, 115, 0),
(395, 0, 4, 110, 0),
(396, 0, 4, 111, 0),
(397, 0, 4, 112, 0),
(398, 0, 4, 113, 0),
(399, 0, 4, 114, 0),
(400, 0, 4, 115, 0),
(401, 0, 1, 118, 1),
(402, 0, 2, 118, 1),
(403, 0, 3, 118, 0),
(404, 0, 4, 118, 0),
(405, 0, 1, 119, 1),
(406, 0, 2, 119, 1),
(407, 0, 3, 119, 0),
(408, 0, 4, 119, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_groups`
--

CREATE TABLE `role_groups` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_modules`
--

CREATE TABLE `role_modules` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=Enabled, 2=Disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_modules`
--

INSERT INTO `role_modules` (`id`, `company_id`, `module_id`, `role_id`, `is_active`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 14, 1, 0),
(3, 1, 13, 1, 0),
(4, 1, 12, 1, 1),
(5, 1, 11, 1, 1),
(6, 1, 10, 1, 1),
(7, 1, 9, 1, 1),
(8, 1, 8, 1, 1),
(9, 1, 7, 1, 1),
(10, 1, 2, 1, 1),
(11, 1, 3, 1, 1),
(12, 1, 4, 1, 1),
(13, 1, 5, 1, 1),
(14, 1, 6, 1, 1),
(15, 1, 1, 2, 1),
(16, 1, 2, 2, 1),
(17, 1, 3, 2, 1),
(18, 1, 4, 2, 1),
(19, 1, 5, 2, 1),
(20, 1, 6, 2, 1),
(21, 1, 7, 2, 1),
(22, 1, 13, 2, 0),
(23, 1, 12, 2, 1),
(24, 1, 10, 2, 1),
(25, 1, 11, 2, 1),
(26, 1, 14, 2, 0),
(27, 1, 8, 2, 1),
(28, 1, 9, 2, 1),
(29, 1, 3, 3, 1),
(30, 1, 1, 3, 1),
(31, 1, 14, 3, 0),
(32, 1, 13, 3, 0),
(33, 1, 12, 3, 1),
(34, 1, 11, 3, 1),
(35, 1, 10, 3, 1),
(36, 1, 9, 3, 1),
(37, 1, 8, 3, 1),
(38, 1, 7, 3, 1),
(39, 1, 6, 3, 1),
(40, 1, 5, 3, 1),
(41, 1, 4, 3, 1),
(42, 1, 2, 3, 1),
(43, 1, 10, 4, 1),
(44, 1, 11, 4, 1),
(45, 1, 12, 4, 1),
(46, 1, 13, 4, 0),
(47, 1, 14, 4, 0),
(48, 1, 1, 4, 1),
(49, 1, 4, 4, 1),
(50, 1, 3, 4, 1),
(51, 1, 2, 4, 1),
(52, 1, 5, 4, 1),
(53, 1, 9, 4, 1),
(54, 1, 8, 4, 1),
(55, 1, 7, 4, 1),
(56, 1, 6, 4, 1),
(57, 1, 15, 1, 1),
(58, 1, 16, 1, 1),
(59, 1, 15, 2, 1),
(60, 1, 16, 2, 1),
(61, 1, 15, 3, 1),
(62, 1, 16, 3, 1),
(63, 1, 15, 4, 0),
(64, 1, 16, 4, 0),
(65, 1, 17, 1, 1),
(66, 1, 17, 2, 1),
(67, 1, 17, 3, 1),
(68, 1, 17, 4, 1),
(69, 1, 18, 1, 1),
(70, 1, 18, 2, 1),
(71, 1, 18, 3, 1),
(72, 1, 18, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `save_reports`
--

CREATE TABLE `save_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rpt_type` tinyint(4) NOT NULL COMMENT '1:Task 2:Hour 3:Bug 4:Project',
  `frm_dt` date NOT NULL,
  `to_dt` date NOT NULL,
  `created` datetime NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `search_filters`
--

CREATE TABLE `search_filters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `json_array` text NOT NULL,
  `first_records` int(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sidebar_menus`
--

CREATE TABLE `sidebar_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_language_id` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `href_exist` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-> Link, 0-> void'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sidebar_menus`
--

INSERT INTO `sidebar_menus` (`id`, `name`, `menu_language_id`, `status`, `href_exist`) VALUES
(1, 'Dashboard', 46, 1, 1),
(2, 'Projects', 47, 1, 1),
(3, 'Tasks', 48, 1, 1),
(4, 'Reports', 49, 1, 1),
(5, 'Time Log', 50, 1, 1),
(6, 'Gantt Chart', 4, 1, 1),
(7, 'Wiki', 51, 1, 1),
(8, 'Kanban', 52, 1, 1),
(9, 'Users', 53, 1, 1),
(10, 'More', 54, 1, 0),
(11, 'Backlog', NULL, 1, 1),
(12, 'Active Sprint', NULL, 1, 1),
(13, 'Template', NULL, 1, 1),
(14, 'Resource Mgmt', NULL, 1, 1),
(15, 'Status Workflow', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sidebar_submenus`
--

CREATE TABLE `sidebar_submenus` (
  `id` int(11) NOT NULL,
  `sidebar_menu_id` int(11) NOT NULL,
  `menu_language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `href_exist` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-> Link, 0-> void',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sidebar_submenus`
--

INSERT INTO `sidebar_submenus` (`id`, `sidebar_menu_id`, `menu_language_id`, `name`, `status`, `href_exist`, `created`) VALUES
(3, 3, 57, 'All Tasks', 1, 0, '2019-04-10 11:19:01'),
(4, 3, 58, 'Tasks assigned to me', 1, 0, '2019-04-10 11:19:14'),
(5, 3, 59, 'Favourites', 1, 0, '2019-04-10 11:19:38'),
(6, 3, 60, 'Overdue', 1, 0, '2019-04-10 11:19:52'),
(7, 3, 61, 'Tasks I''ve created', 1, 0, '2019-04-10 11:20:17'),
(8, 3, 62, 'High Priority', 1, 0, '2019-04-10 11:20:41'),
(9, 3, 63, 'All Opened', 1, 0, '2019-04-10 11:20:54'),
(10, 3, 64, 'All Closed', 1, 0, '2019-04-10 11:21:09'),
(11, 4, 65, 'Sprint Report', 1, 1, '2019-04-10 11:21:51'),
(12, 4, 66, 'Velocity Chart', 1, 1, '2019-04-10 11:22:06'),
(13, 4, 67, 'Average Age Report', 1, 1, '2019-04-10 11:22:25'),
(14, 4, 68, 'Created vs. Resolved Tasks Report', 1, 1, '2019-04-10 11:22:56'),
(15, 4, 69, 'Pie Chart Report', 1, 1, '2019-04-10 11:23:31'),
(16, 4, 70, 'Recently Created Tasks Report', 1, 1, '2019-04-10 11:23:56'),
(17, 4, 71, 'Resolution Time Report', 1, 1, '2019-04-10 11:24:17'),
(18, 4, 72, 'Time Since Tasks Report', 1, 1, '2019-04-10 11:24:34'),
(19, 4, 73, 'Hours Spent Report', 1, 1, '2019-04-10 11:24:45'),
(20, 4, 74, 'Tasks Reports', 1, 1, '2019-04-10 11:25:05'),
(21, 4, 75, 'Weekly Usage', 1, 1, '2019-04-10 11:25:16'),
(22, 4, 25, 'Resource Utilization', 1, 1, '2019-04-10 11:26:25'),
(23, 4, 76, 'Pending Tasks', 1, 1, '2019-04-10 11:26:45'),
(24, 5, 77, 'Time Log List View', 1, 1, '2019-04-10 11:27:33'),
(25, 5, 36, 'Weekly Timesheet', 1, 1, '2019-04-10 11:27:49'),
(26, 5, 25, 'Resource Utilization', 1, 1, '2019-04-10 11:28:01'),
(27, 5, 32, 'Resource Availability', 1, 1, '2019-04-10 11:28:12'),
(28, 10, 78, 'Files', 1, 1, '2019-04-10 11:28:32'),
(29, 10, 79, 'Invoices', 1, 1, '2019-04-10 11:28:44'),
(30, 10, 9, 'Daily Catch-Up', 1, 1, '2019-04-10 11:28:55'),
(31, 10, 3, 'Archive', 1, 1, '2019-04-10 11:29:05'),
(32, 10, 45, 'Template', 1, 1, '2019-04-10 11:29:12'),
(33, 14, 25, 'Resource Utilization', 1, 1, '2019-08-14 04:00:00'),
(34, 14, 32, 'Resource Availability', 1, 1, '2019-08-14 00:00:00'),
(35, 10, NULL, 'Wiki', 1, 1, '2019-08-14 00:00:00'),
(36, 10, NULL, 'Kanban', 1, 1, '2019-08-14 00:00:00'),
(37, 10, NULL, 'Gantt Chart', 1, 1, '2019-08-16 00:00:00'),
(38, 4, 0, 'Sprint Burndown Report', 1, 1, '2019-12-09 00:00:00');

-- --------------------------------------------------------


-- Table structure for table `slack_creds`
--

CREATE TABLE `slack_creds` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `slack_client_id` varchar(255) DEFAULT NULL,
  `slack_client_secret` varchar(255) DEFAULT NULL,
  `access_json` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status_groups`
--

CREATE TABLE `status_groups` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_default` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1: Default Group, 0: Custom Group',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_groups`
--

INSERT INTO `status_groups` (`id`, `parent_id`, `company_id`, `name`, `description`, `created_by`, `is_default`, `created`, `modified`) VALUES
(1, 0, 0, 'Default Status Workflow', 'A default status workflow can be set for when a pick task is New, In Progress, Resolve, or Close.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(2, 0, 0, 'Bug Tracking Workflow', 'Collaborative bug fixing for faster resolution. Make your projects profitable by reducing time spent on defect management.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(3, 0, 0, 'Content Management Workflow', 'Collaborate, brainstorm to publish your ideas into engaging content. Manage content calendars, curate & release on time.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(4, 0, 0, 'Task tracking Workflow', 'Track your weekly chores, career & personal goals or plan an event with simple to-do items and check them off as you progress.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(5, 0, 0, 'Recruitment Workflow', 'Tailor made task types, task labels and statuses to keep your team and recruitment process aligned.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00'),
(6, 0, 0, 'Procurement Workflow', 'Stay on top of quotes, approvals, purchases & vendors payments & maintain a transparent procurement process.', 0, 1, '2019-11-25 00:00:00', '2019-11-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `status_masters`
--

CREATE TABLE `status_masters` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `legend` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_masters`
--

INSERT INTO `status_masters` (`id`, `name`, `legend`) VALUES
(1, 'New', 1),
(2, 'In-progress', 2),
(3, 'Closed', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(200) NOT NULL,
  `seq_odr` tinyint(3) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `seq_odr`, `created`) VALUES
(1, 'Tasks', 1, '2013-12-12 20:02:33'),
(2, 'Files', 3, '2013-12-12 20:03:47'),
(3, 'Projects', 4, '2013-12-12 20:03:51'),
(4, 'Users', 5, '2013-12-12 20:03:54'),
(5, 'Time Log', 6, '2013-10-10 00:00:00'),
(6, 'Analytics', 8, '2013-12-12 20:04:00'),
(7, 'Archive', 10, '2013-12-12 20:04:03'),
(9, 'Profile', 11, '2013-12-12 20:04:07'),
(10, 'Daily Catch-up', 12, '2013-12-12 20:04:10'),
(11, 'Emails Notifications', 13, '2013-12-12 20:04:13'),
(12, 'Pricing & Billing', 14, '2013-12-12 20:04:15'),
(13, 'Import & Export Data', 15, '2013-12-12 20:04:17'),
(14, 'Cancel Account', 16, '2013-12-23 20:02:38'),
(15, 'Invoice', 7, '2015-06-05 00:00:00'),
(16, 'Task Type', 2, '2015-09-03 15:07:18'),
(17, 'Resourse Utilization', 9, '2015-09-16 11:42:34'),
(18, 'Company Setting', 12, '2015-11-06 18:53:41'),
(19, 'Project Template', 5, '2017-12-18 00:00:00'),
(20, 'Tasks List', 1, '2017-12-18 00:00:00'),
(22, 'Kanban View', 1, '2017-12-18 00:00:00'),
(23, 'Calendar View', 1, '2017-12-18 00:00:00'),
(24, 'Gantt Chart', 11, '2017-12-18 00:00:00'),
(25, 'Timesheet', 2, '2017-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `plan` int(11) NOT NULL COMMENT '1-Demo, 2-PRO, 3-LITE, 4-PREMIUM',
  `storage` varchar(250) NOT NULL COMMENT 'Mb',
  `project_limit` varchar(100) NOT NULL,
  `user_limit` varchar(100) NOT NULL,
  `milestone_limit` varchar(50) NOT NULL,
  `free_trail_days` smallint(6) NOT NULL,
  `price` smallint(6) NOT NULL,
  `month` smallint(6) NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-Inactive,1-Active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `plan`, `storage`, `project_limit`, `user_limit`, `milestone_limit`, `free_trail_days`, `price`, `month`, `is_active`, `created`, `modified`) VALUES
(1, 1, 'Unlimited', 'Unlimited', '20', 'Unlimited', 0, 0, 12, 1, '2018-05-23 06:47:56', '2018-05-23 06:47:56');

-- --------------------------------------------------------
--
-- Table structure for table `task_fields`
--

CREATE TABLE `task_fields` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `field_name` text DEFAULT NULL,
  `form_fields` varchar(255) DEFAULT NULL,
  `project_form_fields` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_settings`
--

CREATE TABLE `task_settings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `edit_task` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1 = All, 2 = Owner & admin, 3 = Task Owner'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_views`
--

CREATE TABLE `task_views` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sub_name` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_views`
--

INSERT INTO `task_views` (`id`, `name`, `sub_name`, `created`) VALUES
(1, 'Task', 'List', '2015-10-07 00:00:00'),
(2, 'Task', 'Task Group', '2015-10-07 00:00:00'),
(4, 'Timelog', 'Calendar', '0000-00-00 00:00:00'),
(5, 'Timelog', 'List', '0000-00-00 00:00:00'),
(6, 'Kanban', 'Task Group', '0000-00-00 00:00:00'),
(7, 'Kanban', 'Task Status', '0000-00-00 00:00:00'),
(8, 'Project', 'Card', '0000-00-00 00:00:00'),
(9, 'Project', 'Grid', '0000-00-00 00:00:00'),
(10, 'Default task view', 'List View', '2018-01-17 00:00:00'),
(11, 'Default task view', 'Kanban View', '2018-01-17 07:00:00'),
(12, 'Default task view', 'Task Group View', '2018-01-17 02:00:00'),
(13, 'Default task view', 'Kanban Task Group View', '2018-01-17 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` smallint(6) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `name`) VALUES
(1, 'PHP'),
(2, 'JAVA/J2EE'),
(3, 'ASP .NET'),
(4, 'Ruby on Rails'),
(5, 'Data Warehousing'),
(6, 'Cake PHP'),
(7, 'Python/Django'),
(8, 'Flex/Flash Action Sc'),
(9, 'SEO Services');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL DEFAULT 0,
  `gmt_offset` double DEFAULT 0,
  `dst_offset` double DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `gmt_offset`, `dst_offset`, `code`) VALUES
(1, -12, 0, NULL),
(2, -11, 0, NULL),
(3, -10, 0, 'H'),
(4, -9, 1, 'AK'),
(5, -8, 1, 'P'),
(6, -7, 0, 'M'),
(7, -7, 1, NULL),
(8, -7, 1, 'M'),
(9, -6, 0, NULL),
(10, -6, 1, 'C'),
(11, -6, 1, NULL),
(12, -6, 0, 'C'),
(13, -5, 0, NULL),
(14, -5, 1, 'E'),
(15, -5, 0, 'E'),
(16, -4, 1, 'A'),
(17, -4, 0, NULL),
(18, -4, 1, NULL),
(19, -3.5, 1, 'N'),
(20, -3, 1, NULL),
(21, -3, 0, NULL),
(22, -3, 1, NULL),
(23, -2, 1, NULL),
(24, -1, 1, NULL),
(25, -1, 0, NULL),
(26, 0, 0, NULL),
(27, 0, 1, NULL),
(28, 1, 1, NULL),
(29, 1, 1, NULL),
(30, 1, 1, NULL),
(31, 1, 1, NULL),
(32, 1, 0, NULL),
(33, 2, 1, NULL),
(34, 2, 1, NULL),
(35, 2, 1, NULL),
(36, 2, 0, NULL),
(37, 2, 1, NULL),
(38, 2, 0, NULL),
(39, 3, 1, NULL),
(40, 3, 0, NULL),
(41, 3, 1, NULL),
(42, 3, 0, NULL),
(43, 3.5, 1, NULL),
(44, 4, 0, NULL),
(45, 4, 1, NULL),
(46, 4.5, 0, NULL),
(47, 5, 1, NULL),
(48, 5, 0, NULL),
(49, 5.5, 0, NULL),
(50, 5.75, 0, NULL),
(51, 6, 1, NULL),
(52, 6, 0, NULL),
(53, 6, 0, NULL),
(54, 6.5, 0, NULL),
(55, 7, 0, NULL),
(56, 7, 1, NULL),
(57, 8, 0, NULL),
(58, 8, 1, NULL),
(59, 8, 0, NULL),
(60, 8, 0, NULL),
(61, 8, 0, NULL),
(62, 9, 0, NULL),
(63, 9, 0, NULL),
(64, 9, 1, NULL),
(65, 9.5, 1, NULL),
(66, 9.5, 0, NULL),
(67, 10, 0, NULL),
(68, 10, 1, NULL),
(69, 10, 0, NULL),
(70, 10, 1, NULL),
(71, 10, 1, NULL),
(72, 11, 0, NULL),
(73, 12, 1, NULL),
(74, 12, 0, NULL),
(75, 13, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timezone_names`
--

CREATE TABLE `timezone_names` (
  `id` int(11) NOT NULL,
  `gmt` varchar(15) NOT NULL,
  `zone` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timezone_names`
--

INSERT INTO `timezone_names` (`id`, `gmt`, `zone`) VALUES
(1, '(GMT-12:00)', 'International Date Line West'),
(2, '(GMT-11:00)', 'Midway Island Samoa'),
(3, '(GMT-10:00)', 'Hawaii'),
(4, '(GMT-9:00)', 'Alaska'),
(5, '(GMT-08:00)', 'Pacific Time (US & Canada); Tijuana'),
(6, '(GMT-07:00)', 'Arizona'),
(7, '(GMT-07:00)', 'Chihuahua, La Paz, Mazatlan'),
(8, '(GMT-07:00)', 'Mountain Time (US & Canada)'),
(9, '(GMT-06:00)', 'Central America'),
(10, '(GMT-06:00)', 'Central Time (US & Canada)'),
(11, '(GMT-06:00)', 'Guadalajara, Mexico City, Monterrey'),
(12, '(GMT-06:00)', 'Saskatchewan'),
(13, '(GMT-05:00)', 'Bogota, Lime, Quito'),
(14, '(GMT-05:00)', 'Eastern Time (US & Canada)'),
(15, '(GMT-05:00)', 'Indiana (East)'),
(16, '(GMT-05:04)', 'Atlantic Time (Canada)'),
(17, '(GMT-04:00)', 'Caracas, La Paz'),
(18, '(GMT-04:00)', 'Santiago'),
(19, '(GMT-03:30)', 'Newfoundland'),
(20, '(GMT-03:00)', 'Brasilia'),
(21, '(GMT-03:00)', 'Buenos Aires, Georgetown'),
(22, '(GMT-03:00)', 'Greenland'),
(23, '(GMT-02:00)', 'Mid-Atlantic'),
(24, '(GMT-01:00)', 'Azores'),
(25, '(GMT-01:00)', 'Cape Verde Is.'),
(26, '(GMT)', 'Casablanca, Monrovia'),
(27, '(GMT)', 'Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London'),
(28, '(GMT+01:00)', 'Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'),
(29, '(GMT+01:00)', 'Belgrade, Bratislava, Budapest, Ljubljana, Prague'),
(30, '(GMT+01:00)', 'Brussels, Copenhagen, Madrid, Paris'),
(31, '(GMT+01:00)', 'Sarajevo, Skopje, Warsaw, Zagreb'),
(32, '(GMT+01:00)', 'West Central Africa'),
(33, '(GMT+02:00)', 'Athens, Istanbul, Minsk'),
(34, '(GMT+02:00)', 'Bucharest'),
(35, '(GMT+02:00)', 'Cairo'),
(36, '(GMT+02:00)', 'Harare, Pretoria'),
(37, '(GMT+02:00)', 'Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius'),
(38, '(GMT+02:00)', 'Jerusalem'),
(39, '(GMT+03:00)', 'Baghdad'),
(40, '(GMT+03:00)', 'Kuwait, Riyadh'),
(41, '(GMT+03:00)', 'Moscow, St. Petersburg, Volgograd'),
(42, '(GMT+03:00)', 'Nairobi'),
(43, '(GMT+03:30)', 'Tehran'),
(44, '(GMT+04:00)', 'Abu Dhabi, Muscat'),
(45, '(GMT+04:00)', 'Baku, Tbilisi, Yerevan'),
(46, '(GMT+04:30)', 'Kabul'),
(47, '(GMT+05:00)', 'Ekaterinburg'),
(48, '(GMT+05:00)', 'Islamabad, Karachi, Tashkent'),
(49, '(GMT+05:30)', 'Chennai, Kolkata, Mumbai, New Delhi'),
(50, '(GMT+05.75)', 'Kathmandu'),
(51, '(GMT+06:00)', 'Almaty, Novosibirsk'),
(52, '(GMT+06:00)', 'Astana, Dhaka'),
(53, '(GMT+06:00)', 'Sri Jayawardenepura'),
(54, '(GMT+06:30)', 'Rangoon'),
(55, '(GMT+07:00)', 'Bangkok, Hanoi, Jakarta'),
(56, '(GMT+07:00)', 'Krasnoyarsk'),
(57, '(GMT+08:00)', 'Beijing, Chongging, Hong Kong, Urumgi'),
(58, '(GMT+08:00)', 'Irkutsk, Ulaan Bataar'),
(59, '(GMT+08:00)', 'Kuala Lumpur, Singapore'),
(60, '(GMT+08:00)', 'Perth'),
(61, '(GMT+08:00)', 'Taipei'),
(62, '(GMT+09:00)', 'Osaka, Sapporo, Tokyo'),
(63, '(GMT+09:00)', 'Seoul'),
(64, '(GMT+09:00)', 'Yakutsk'),
(65, '(GMT+09:30)', 'Adelaide'),
(66, '(GMT+09:30)', 'Darwin'),
(67, '(GMT+10:00)', 'Brisbane'),
(68, '(GMT+10:00)', 'Canberra, Melbourne, Sydney'),
(69, '(GMT+10:00)', 'Guam, Port Moresby'),
(70, '(GMT+10:00)', 'Hobart'),
(71, '(GMT+10:00)', 'Vladivostok'),
(72, '(GMT+11:00)', 'Magadan, Solomon Is., New Caledonia'),
(73, '(GMT+12:00)', 'Auckland, Wellington'),
(74, '(GMT+12:00)', 'Figi, Kamchatka, Marshall Is.'),
(75, '(GMT+13:00)', 'Nuku''alofa');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(12) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `short_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `seq_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `company_id`, `project_id`, `short_name`, `name`, `seq_order`) VALUES
(1, 0, 0, 'bug', 'Bug', 2),
(2, 0, 0, 'dev', 'Development', 1),
(3, 0, 0, 'enh', 'Enhancement', 6),
(4, 0, 0, 'rnd', 'Research n Do', 7),
(5, 0, 0, 'qa', 'Quality Assurance', 9),
(6, 0, 0, 'unt', 'Unit Testing', 10),
(7, 0, 0, 'mnt', 'Maintenance', 8),
(8, 0, 0, 'oth', 'Others', 12),
(9, 0, 0, 'rel', 'Release', 11),
(10, 0, 0, 'upd', 'Update', 3),
(11, 0, 0, 'idea', 'Idea', 5),
(12, 0, 0, 'cr', 'Change Request', 4),
(13, 0, 0, 'ep', 'Epic', 13),
(14, 0, 0, 'sto', 'Story', 14);

-- --------------------------------------------------------

--
-- Table structure for table `type_companies`
--

CREATE TABLE `type_companies` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_companies`
--

INSERT INTO `type_companies` (`id`, `company_id`, `type_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(64) NOT NULL,
  `btprofile_id` varchar(100) DEFAULT NULL,
  `usersubscription_id` int(10) DEFAULT NULL,
  `credit_cardtoken` varchar(100) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL COMMENT 'Only last 4degit of card',
  `expiry_date` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `update_email` varchar(150) NOT NULL,
  `update_random` varchar(150) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `is_beta` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1 For beta user ,0 - Default',
  `last_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `istype` tinyint(2) NOT NULL DEFAULT 3 COMMENT '1-Super Admin, 2-Internal User, 3-External User',
  `photo` varchar(50) DEFAULT NULL,
  `photo_reset` varchar(50) DEFAULT NULL,
  `isactive` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1 - ACTIVE, 2 - INACTIVE . 2-Disabled ,3- Deleted user',
  `timezone_id` smallint(6) DEFAULT 26,
  `isemail` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-Send Email, 0-Don''t Send',
  `is_agree` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0: No, 1: Yes',
  `usersub_type` tinyint(4) DEFAULT 0 COMMENT '0->Free User, 1->Paid User',
  `est_billing_amount` float(10,2) DEFAULT 0.00,
  `dt_created` datetime NOT NULL,
  `dt_updated` datetime DEFAULT NULL,
  `dt_last_login` datetime DEFAULT NULL,
  `dt_last_logout` datetime DEFAULT NULL,
  `query_string` varchar(100) DEFAULT NULL,
  `gaccess_token` mediumtext DEFAULT NULL,
  `google_id` varchar(200) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `sig` varchar(100) NOT NULL,
  `desk_notify` tinyint(4) NOT NULL DEFAULT 1,
  `active_dashboard_tab` int(11) NOT NULL DEFAULT 7 COMMENT 'Sum of Binary values which will show tabs accordingly',
  `is_moderator` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0: No grant privilege, 1: Yes',
  `verify_string` varchar(100) DEFAULT NULL,
  `show_default_inner` tinyint(4) NOT NULL DEFAULT 1,
  `updated_by` int(1) NOT NULL DEFAULT 0 COMMENT '0: self edit,1: Edit by owner/admin',
  `is_online` tinyint(2) DEFAULT 0,
  `is_dst` tinyint(2) NOT NULL DEFAULT 0,
  `language_id` int(11) NOT NULL DEFAULT 2,
  `is_agree_tosp` tinyint(2) NOT NULL DEFAULT 1,
  `is_receive_update` tinyint(2) NOT NULL DEFAULT 0,
  `outer_signup` tinyint(2) NOT NULL DEFAULT 0,
  `language` varchar(10) NOT NULL DEFAULT 'eng',
  `time_format` tinyint(2) NOT NULL DEFAULT 12,
  `phone` varchar(20) NOT NULL DEFAULT '0',
  `is_dummy` tinyint(2) NOT NULL DEFAULT 0,
  `one_tap_token` text DEFAULT NULL,
  `keep_hover_effect` tinyint(3) NOT NULL DEFAULT 0,
  `linkedin_id` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `user_device_tokens`
--

CREATE TABLE `user_device_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ios_device_token` text NOT NULL,
  `android_device_token` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_infos`
--

CREATE TABLE `user_infos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `access_token` text DEFAULT NULL,
  `is_google_signup` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_invitations`
--

CREATE TABLE `user_invitations` (
  `id` int(11) NOT NULL,
  `invitor_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_type` tinyint(2) NOT NULL DEFAULT 3,
  `project_id` mediumtext DEFAULT NULL COMMENT 'Comma separated value of project ids',
  `user_id` int(11) NOT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT 1,
  `qstr` varchar(100) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_leaves`
--

CREATE TABLE `user_leaves` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `dt_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_menus`
--

CREATE TABLE `user_menus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `menu` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `easycase_mentions`
--

CREATE TABLE `easycase_mentions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `mention_type_id` int(11) NOT NULL,
  `mention_type` int(11) NOT NULL COMMENT '1- user 2 task',
  `mention_by` int(11) NOT NULL,
  `easycase_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT 0,
  `mention_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-Email',
  `value` tinyint(4) NOT NULL COMMENT '0-None, 1-Daily, 2-Weekly, 3-Monthly',
  `due_val` tinyint(4) NOT NULL COMMENT '0-Not,1-send',
  `new_case` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-No, 1-Yes',
  `reply_case` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-No, 1-Yes',
  `case_status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0-No, 1-Yes',
  `weekly_usage_alert` tinyint(2) NOT NULL DEFAULT 1 COMMENT 'Only for owner/admins 1-> Default on 0-> Off ',
  `mention_case` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_quicklinks`
--

CREATE TABLE `user_quicklinks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `quicklink_menu_id` int(11) NOT NULL,
  `quicklink_submenu_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sidebar_menus`
--

CREATE TABLE `user_sidebar_menus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `sidebar_menu_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sidebar_submenus`
--

CREATE TABLE `user_sidebar_submenus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_sidebar_menu_id` int(11) NOT NULL,
  `sidebar_submenu_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `subscription_id` tinyint(4) NOT NULL,
  `storage` varchar(50) NOT NULL,
  `project_limit` varchar(50) NOT NULL,
  `user_limit` varchar(50) NOT NULL,
  `milestone_limit` varchar(50) NOT NULL,
  `free_trail_days` varchar(15) NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT 0.00,
  `month` smallint(6) NOT NULL DEFAULT 1,
  `amt_due` float(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(100) DEFAULT NULL,
  `btsubscription_id` varchar(100) DEFAULT NULL,
  `btprofile_id` varchar(255) DEFAULT NULL,
  `creditcard_token` varchar(255) DEFAULT '',
  `payment_status` tinyint(2) DEFAULT 0,
  `discount` float(10,2) DEFAULT NULL,
  `subscription_mail` tinyint(2) NOT NULL DEFAULT 0 COMMENT 'This will check if the user will receive mail about any subscription/Upgrade/Downgrade of plan etc',
  `is_cancel` tinyint(2) DEFAULT 0 COMMENT '1->Cancelled',
  `is_sub_upgraded_bt` tinyint(2) DEFAULT 0,
  `cancel_mail_flag` tinyint(2) DEFAULT 0,
  `no_of_atmpt_upgrd` tinyint(2) DEFAULT NULL,
  `is_free` tinyint(2) NOT NULL DEFAULT 0,
  `is_updown` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0->Cancelled , 1-> Upgraded ,2-> Downgrad',
  `sub_start_date` datetime DEFAULT NULL,
  `next_billing_date` date DEFAULT NULL,
  `cancel_date` date DEFAULT NULL,
  `extend_date` datetime NOT NULL,
  `extend_trial` int(11) NOT NULL DEFAULT 0,
  `trial_expired` tinyint(2) NOT NULL DEFAULT 0,
  `new_expiry_day` date NOT NULL,
  `temp_sub_cancel` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_themes`
--

CREATE TABLE `user_themes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sidebar_color` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `navbar_color` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mini_leftmenu` tinyint(4) NOT NULL DEFAULT 0,
  `dark_leftmenu` tinyint(4) NOT NULL DEFAULT 0,
  `dark_navbar` tinyint(4) NOT NULL DEFAULT 0,
  `fixed_navbar` tinyint(4) NOT NULL DEFAULT 0,
  `footer_dark` tinyint(4) NOT NULL DEFAULT 0,
  `footer_fixed` tinyint(4) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `work_hours`
--

CREATE TABLE `work_hours` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `work_hours` float(5,2) NOT NULL,
  `week_ends` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`);

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `case_file_id` (`case_file_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type` (`type`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `beta_users`
--
ALTER TABLE `beta_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_actions`
--
ALTER TABLE `case_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `action` (`action`);

--
-- Indexes for table `case_activities`
--
ALTER TABLE `case_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `case_no` (`case_no`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type` (`type`),
  ADD KEY `isactive` (`isactive`);

--
-- Indexes for table `case_comments`
--
ALTER TABLE `case_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `isactive` (`isactive`);

--
-- Indexes for table `case_editor_files`
--
ALTER TABLE `case_editor_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniq_id` (`uniq_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `case_files`
--
ALTER TABLE `case_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `isactive` (`isactive`);

--
-- Indexes for table `case_file_drives`
--
ALTER TABLE `case_file_drives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`id`),
  ADD KEY `project_id` (`id`);

--
-- Indexes for table `case_filters`
--
ALTER TABLE `case_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_recents`
--
ALTER TABLE `case_recents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`id`),
  ADD KEY `easycase_id` (`id`),
  ADD KEY `company_id` (`id`),
  ADD KEY `user_id` (`id`);

--
-- Indexes for table `case_reminders`
--
ALTER TABLE `case_reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `is_emailed` (`is_emailed`);

--
-- Indexes for table `case_removed_files`
--
ALTER TABLE `case_removed_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_settings`
--
ALTER TABLE `case_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_templates`
--
ALTER TABLE `case_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `case_user_emails`
--
ALTER TABLE `case_user_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`,`user_id`);

--
-- Indexes for table `case_user_views`
--
ALTER TABLE `case_user_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_lists`
--
ALTER TABLE `check_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `company_apis`
--
ALTER TABLE `company_apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_holidays`
--
ALTER TABLE `company_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company_users`
--
ALTER TABLE `company_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_type` (`user_type`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_currency_name` (`name`);

--
-- Indexes for table `custom_filters`
--
ALTER TABLE `custom_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_statuses`
--
ALTER TABLE `custom_statuses`
  ADD PRIMARY KEY (`id`);
--
-- Indexes for table `easycase_mentions`
--
ALTER TABLE `easycase_mentions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailyupdate_notifications`
--
ALTER TABLE `dailyupdate_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_updates`
--
ALTER TABLE `daily_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_project_templates`
--
ALTER TABLE `default_project_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_project_template_cases`
--
ALTER TABLE `default_project_template_cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_tasks`
--
ALTER TABLE `default_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_task_views`
--
ALTER TABLE `default_task_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_templates`
--
ALTER TABLE `default_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_companies`
--
ALTER TABLE `deleted_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_requests`
--
ALTER TABLE `demo_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `easycases`
--
ALTER TABLE `easycases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniq_id` (`uniq_id`),
  ADD KEY `case_no` (`case_no`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `isactive` (`isactive`),
  ADD KEY `legend` (`legend`),
  ADD KEY `status` (`status`),
  ADD KEY `format` (`format`),
  ADD KEY `istype` (`istype`),
  ADD KEY `assign_to` (`assign_to`),
  ADD KEY `priority` (`priority`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `depends` (`depends`),
  ADD KEY `children` (`children`),
  ADD KEY `project_id_2` (`project_id`,`istype`,`legend`,`depends`,`children`);

--
-- Indexes for table `easycase_favourites`
--
ALTER TABLE `easycase_favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `easycase_labels`
--
ALTER TABLE `easycase_labels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`id`),
  ADD KEY `company_id` (`id`),
  ADD KEY `project_id` (`id`),
  ADD KEY `label_id` (`id`);

--
-- Indexes for table `easycase_linkings`
--
ALTER TABLE `easycase_linkings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`id`),
  ADD KEY `link_id` (`id`),
  ADD KEY `project_id` (`id`),
  ADD KEY `easycase_id` (`id`);

--
-- Indexes for table `easycase_links`
--
ALTER TABLE `easycase_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `easycase_milestones`
--
ALTER TABLE `easycase_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `easycase_id` (`easycase_id`),
  ADD KEY `milestone_id` (`milestone_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `easycase_recurring_tracks`
--
ALTER TABLE `easycase_recurring_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `easycase_relates`
--
ALTER TABLE `easycase_relates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_reminders`
--
ALTER TABLE `email_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_settings`
--
ALTER TABLE `feature_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`id`);

--
-- Indexes for table `google_calendar_settings`
--
ALTER TABLE `google_calendar_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_event_settings`
--
ALTER TABLE `google_event_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helps`
--
ALTER TABLE `helps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_times`
--
ALTER TABLE `log_times`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_lt_user_task_project` (`task_id`,`user_id`,`project_id`);

--
-- Indexes for table `log_types`
--
ALTER TABLE `log_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_tbls`
--
ALTER TABLE `mail_tbls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_languages`
--
ALTER TABLE `menu_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`);

--
-- Indexes for table `new_pricing_users`
--
ALTER TABLE `new_pricing_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `osusage_details`
--
ALTER TABLE `osusage_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os_session_logs`
--
ALTER TABLE `os_session_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `overloads`
--
ALTER TABLE `overloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniq_id` (`uniq_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `isactive` (`isactive`),
  ADD KEY `project_type` (`project_type`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `project_actions`
--
ALTER TABLE `project_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_booked_resources`
--
ALTER TABLE `project_booked_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_fields`
--
ALTER TABLE `project_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_metas`
--
ALTER TABLE `project_metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_methodologies`
--
ALTER TABLE `project_methodologies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_notes`
--
ALTER TABLE `project_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `is_updated` (`is_updated`);

--
-- Indexes for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_statuses`
--
ALTER TABLE `project_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `project_technologies`
--
ALTER TABLE `project_technologies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `tech_proj_id` (`technology_id`);

--
-- Indexes for table `project_templates`
--
ALTER TABLE `project_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `project_users`
--
ALTER TABLE `project_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `istype` (`istype`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `quicklink_menus`
--
ALTER TABLE `quicklink_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quicklink_submenus`
--
ALTER TABLE `quicklink_submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quicklink_menu_id` (`quicklink_menu_id`),
  ADD KEY `menu_language_id` (`menu_language_id`);

--
-- Indexes for table `recurring_easycases`
--
ALTER TABLE `recurring_easycases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `releases`
--
ALTER TABLE `releases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `release_logs`
--
ALTER TABLE `release_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `release_subscriptions`
--
ALTER TABLE `release_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `release_id` (`release_id`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- Indexes for table `resource_settings`
--
ALTER TABLE `resource_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`);

--
-- Indexes for table `role_actions`
--
ALTER TABLE `role_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_groups`
--
ALTER TABLE `role_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`uniq_id`);

--
-- Indexes for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save_reports`
--
ALTER TABLE `save_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_filters`
--
ALTER TABLE `search_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sidebar_menus`
--
ALTER TABLE `sidebar_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sidebar_submenus`
--
ALTER TABLE `sidebar_submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sidebar_menu_id` (`sidebar_menu_id`);

--
-- Indexes for table `slack_creds`
--
ALTER TABLE `slack_creds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_groups`
--
ALTER TABLE `status_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_masters`
--
ALTER TABLE `status_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
--
-- Indexes for table `task_fields`
--
ALTER TABLE `task_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `task_settings`
--
ALTER TABLE `task_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_views`
--
ALTER TABLE `task_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezone_names`
--
ALTER TABLE `timezone_names`
  ADD KEY `id` (`id`);
--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_companies`
--
ALTER TABLE `type_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id_2` (`uniq_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `uniq_id` (`uniq_id`),
  ADD KEY `istype` (`istype`),
  ADD KEY `isactive` (`isactive`),
  ADD KEY `isemail` (`isemail`),
  ADD KEY `timezone_id` (`timezone_id`);

--
-- Indexes for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_invitations`
--
ALTER TABLE `user_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_leaves`
--
ALTER TABLE `user_leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menus`
--
ALTER TABLE `user_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_quicklinks`
--
ALTER TABLE `user_quicklinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sidebar_menus`
--
ALTER TABLE `user_sidebar_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sidebar_menu_id` (`sidebar_menu_id`);

--
-- Indexes for table `user_sidebar_submenus`
--
ALTER TABLE `user_sidebar_submenus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- Indexes for table `user_themes`
--
ALTER TABLE `user_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_hours`
--
ALTER TABLE `work_hours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beta_users`
--
ALTER TABLE `beta_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_actions`
--
ALTER TABLE `case_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_activities`
--
ALTER TABLE `case_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_comments`
--
ALTER TABLE `case_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_editor_files`
--
ALTER TABLE `case_editor_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_files`
--
ALTER TABLE `case_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_file_drives`
--
ALTER TABLE `case_file_drives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_filters`
--
ALTER TABLE `case_filters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_recents`
--
ALTER TABLE `case_recents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_reminders`
--
ALTER TABLE `case_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_removed_files`
--
ALTER TABLE `case_removed_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_settings`
--
ALTER TABLE `case_settings`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_templates`
--
ALTER TABLE `case_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `case_user_emails`
--
ALTER TABLE `case_user_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_lists`
--
ALTER TABLE `check_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `company_apis`
--
ALTER TABLE `company_apis`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_holidays`
--
ALTER TABLE `company_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_users`
--
ALTER TABLE `company_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `custom_filters`
--
ALTER TABLE `custom_filters`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_statuses`
--
ALTER TABLE `custom_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `dailyupdate_notifications`
--
ALTER TABLE `dailyupdate_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_updates`
--
ALTER TABLE `daily_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_project_templates`
--
ALTER TABLE `default_project_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `default_project_template_cases`
--
ALTER TABLE `default_project_template_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `default_tasks`
--
ALTER TABLE `default_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `default_task_views`
--
ALTER TABLE `default_task_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_templates`
--
ALTER TABLE `default_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deleted_companies`
--
ALTER TABLE `deleted_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_requests`
--
ALTER TABLE `demo_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycases`
--
ALTER TABLE `easycases`
  MODIFY `id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `easycase_favourites`
--
ALTER TABLE `easycase_favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycase_labels`
--
ALTER TABLE `easycase_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycase_linkings`
--
ALTER TABLE `easycase_linkings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycase_links`
--
ALTER TABLE `easycase_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycase_milestones`
--
ALTER TABLE `easycase_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `easycase_recurring_tracks`
--
ALTER TABLE `easycase_recurring_tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easycase_relates`
--
ALTER TABLE `easycase_relates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_reminders`
--
ALTER TABLE `email_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feature_settings`
--
ALTER TABLE `feature_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `google_calendar_settings`
--
ALTER TABLE `google_calendar_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `google_event_settings`
--
ALTER TABLE `google_event_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helps`
--
ALTER TABLE `helps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `log_times`
--
ALTER TABLE `log_times`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_types`
--
ALTER TABLE `log_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `mail_tbls`
--
ALTER TABLE `mail_tbls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT for table `menu_languages`
--
ALTER TABLE `menu_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `new_pricing_users`
--
ALTER TABLE `new_pricing_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `easycase_mentions`
--
ALTER TABLE `easycase_mentions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `osusage_details`
--
ALTER TABLE `osusage_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `os_session_logs`
--
ALTER TABLE `os_session_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `overloads`
--
ALTER TABLE `overloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `project_actions`
--
ALTER TABLE `project_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_booked_resources`
--
ALTER TABLE `project_booked_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_fields`
--
ALTER TABLE `project_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_metas`
--
ALTER TABLE `project_metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_methodologies`
--
ALTER TABLE `project_methodologies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_notes`
--
ALTER TABLE `project_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_settings`
--
ALTER TABLE `project_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_statuses`
--
ALTER TABLE `project_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_technologies`
--
ALTER TABLE `project_technologies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_templates`
--
ALTER TABLE `project_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_users`
--
ALTER TABLE `project_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quicklink_menus`
--
ALTER TABLE `quicklink_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quicklink_submenus`
--
ALTER TABLE `quicklink_submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `recurring_easycases`
--
ALTER TABLE `recurring_easycases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `releases`
--
ALTER TABLE `releases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `release_logs`
--
ALTER TABLE `release_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `release_subscriptions`
--
ALTER TABLE `release_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resource_settings`
--
ALTER TABLE `resource_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_actions`
--
ALTER TABLE `role_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT for table `role_groups`
--
ALTER TABLE `role_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_modules`
--
ALTER TABLE `role_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `save_reports`
--
ALTER TABLE `save_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_filters`
--
ALTER TABLE `search_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `sidebar_menus`
--
ALTER TABLE `sidebar_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `sidebar_submenus`
--
ALTER TABLE `sidebar_submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--


--
-- AUTO_INCREMENT for table `slack_creds`
--
ALTER TABLE `slack_creds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_groups`
--
ALTER TABLE `status_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_masters`
--
ALTER TABLE `status_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `task_fields`
--
ALTER TABLE `task_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_settings`
--
ALTER TABLE `task_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_views`
--
ALTER TABLE `task_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `type_companies`
--
ALTER TABLE `type_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_invitations`
--
ALTER TABLE `user_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_leaves`
--
ALTER TABLE `user_leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `user_menus` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_quicklinks`
--
ALTER TABLE `user_quicklinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sidebar_menus`
--
ALTER TABLE `user_sidebar_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_sidebar_submenus`
--
ALTER TABLE `user_sidebar_submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_themes`
--
ALTER TABLE `user_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_hours`
--
ALTER TABLE `work_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quicklink_submenus`
--
ALTER TABLE `quicklink_submenus`
  ADD CONSTRAINT `quicklink_submenus_ibfk_1` FOREIGN KEY (`quicklink_menu_id`) REFERENCES `quicklink_menus` (`id`),
  ADD CONSTRAINT `quicklink_submenus_ibfk_3` FOREIGN KEY (`menu_language_id`) REFERENCES `menu_languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


INSERT INTO `modules` (`id`, `uniq_id`, `name`, `is_active`, `created`, `modified`) VALUES
(19, 'f1d1c15c9518e302b5ff31bda7eghtd5', 'Reports', 1, '2021-07-21 10:04:10', '2021-07-21 10:04:10');

INSERT INTO `actions` (`uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
('88a0ef43b19c03aa6d17a91080ghuy75', 19, 'View Average Age Report', 'View Average Age', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('7ujnhgf1468b813a1c1856c200bf50e7', 19, 'View Resolution Time Report', 'View Resolution Time', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('71de5ef0880310a7e2b2593ee6jknh90', 19, 'View Recently Created Tasks Report', 'View Recently Created Tasks', 0,'2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('gy64rf876ba366a1045c08b5e3438d23', 19, 'View Created vs Resolved Tasks Report', 'View Created vs Resolved Tasks', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('7a184221ad371e56dfc955d64djhgt54', 19, 'View Task Report', 'View Task', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('83f311f3cda05a2170c4be30b54sxbh9', 19, 'View Time Since Task Report', 'View Time Since Task', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('028d11d076ceeada460765cce0okvde3', 19, 'View Hour Spent Report', 'View Hour Spent', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('a4d02d07ef2da4666ecb231f86yhbs32', 19, 'View Timesheet Report', 'View Timesheet', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('71ad7936b4d64aa912e47f26d6wa21kl', 19, 'View Sprint Report', 'View Sprint', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('9da30cd8ece12fc783be9153ccf43sd9', 19, 'View Sprint Burndown Report', 'View Sprint Burndown', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('c75ba6399e01301198440001hgt520ok', 19, 'View Velocity Chart', 'View Velocity Chart', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('3bbe643120d9ef8b0dce477905edvbh8', 19, 'View Weekly Usage', 'View Weekly Usage', 0,'2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('a3a43c0509667c28d3283910olnh7rd4', 19, 'View Pending Task', 'View Pending Task', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('0c16733ba363ce3a60261f2ad5gbi97z', 19, 'View Pie Chart Report', 'View Pie Chart', 0,'2021-08-06 04:41:20', '2021-08-06 04:41:20');

INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 1, 120, 1),
(0, 2, 120, 1),
(0, 3, 120, 1),
(0, 4, 120, 1),
(0, 1, 121, 1),
(0, 2, 121, 1),
(0, 3, 121, 1),
(0, 4, 121, 1),
(0, 1, 122, 1),
(0, 2, 122, 1),
(0, 3, 122, 1),
(0, 4, 122, 1),
(0, 1, 123, 1),
(0, 2, 123, 1),
(0, 3, 123, 1),
(0, 4, 123, 1),
(0, 1, 124, 1),
(0, 2, 124, 1),
(0, 3, 124, 1),
(0, 4, 124, 1),
(0, 1, 125, 1),
(0, 2, 125, 1),
(0, 3, 125, 1),
(0, 4, 125, 1),
(0, 1, 126, 1),
(0, 2, 126, 1),
(0, 3, 126, 1),
(0, 4, 126, 1),
(0, 1, 127, 1),
(0, 2, 127, 1),
(0, 3, 127, 0),
(0, 4, 127, 0),
(0, 1, 128, 1),
(0, 2, 128, 1),
(0, 3, 128, 1),
(0, 4, 128, 1),
(0, 1, 129, 1),
(0, 2, 129, 1),
(0, 3, 129, 1),
(0, 4, 129, 1),
(0, 1, 130, 1),
(0, 2, 130, 1),
(0, 3, 130, 1),
(0, 4, 130, 1),
(0, 1, 131, 1),
(0, 2, 131, 1),
(0, 3, 131, 0),
(0, 4, 131, 0),
(0, 1, 132, 1),
(0, 2, 132, 1),
(0, 3, 132, 1),
(0, 4, 132, 1),
(0, 1, 133, 1),
(0, 2, 133, 1),
(0, 3, 133, 1),
(0, 4, 133, 1);

INSERT INTO `modules` (`id`, `uniq_id`, `name`, `is_active`, `created`, `modified`) VALUES
(20, '7upo4cd8ece12fc783be9153cujhy6789', 'Bug Tracking', 1, '2021-07-21 10:04:10', '2021-07-21 10:04:10');

INSERT INTO `actions` (`uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
('7upo4cd8ece12fc783be9153c24kj34r', 20, 'View Bug', 'View Bug', 0, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('9da30cd8ece12fc783be9153c24ju67o', 20, 'View Bug Setting', 'View Bug Setting', 0,'2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('2jkou8cd8ece12fc783be9153c2p9ij6', 20, 'Create Bug', 'Create Bug', 1, '2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('0c16733ba363ce3a60261f2ad5ujy678', 20, 'Edit Bug', 'Edit Bug', 1,'2021-08-06 04:41:20', '2021-08-06 04:41:20'),
('0c16733ba363ce3a60261f2ad5hu854d', 20, 'Delete Bug', 'Delete Bug', 1,'2021-08-06 04:41:20', '2021-08-06 04:41:20');

INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 1, 134, 1),
(0, 2, 134, 1),
(0, 3, 134, 1),
(0, 4, 134, 0),
(0, 1, 135, 1),
(0, 2, 135, 1),
(0, 3, 135, 0),
(0, 4, 135, 0),
(0, 1, 136, 1),
(0, 2, 136, 1),
(0, 3, 136, 1),
(0, 4, 136, 1),
(0, 1, 137, 1),
(0, 2, 137, 1),
(0, 3, 137, 1),
(0, 4, 137, 0),
(0, 1, 138, 1),
(0, 2, 138, 1),
(0, 3, 138, 1),
(0, 4, 138, 0);
INSERT INTO `actions` (`uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
('88a0ef43b19c03aa6d17a91kju8gfr5', 19, 'View Bug Report', 'View Bug Report', 0, '2021-10-04 04:41:20', '2021-10-04 04:41:20');
INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 1, 139, 1),
(0, 2, 139, 1),
(0, 3, 139, 0),
(0, 4, 139, 0);
ALTER TABLE `case_files` ADD `type` TINYINT(2) NULL  DEFAULT '1' AFTER `isactive`, ADD `created` DATETIME NULL AFTER `type`, ADD `modified` DATETIME NULL AFTER `created`;

UPDATE `case_files` SET `type` =1;

DROP TABLE IF EXISTS bookmarks;
CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `open_in_same_page` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `seq` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4;

INSERT INTO `role_modules` (`company_id`, `module_id`, `role_id`, `is_active`) VALUES
(1, 19, 1, 1),
(1, 19, 2, 1),
(1, 19, 3, 1),
(1, 19, 4, 1),
(1, 20, 1, 1),
(1, 20, 2, 1),
(1, 20, 3, 1),
(1, 20, 4, 1);
ALTER TABLE `easycases` ADD `initial_due_date` DATETIME NULL AFTER `is_zapaction`;
INSERT INTO `actions` (id, `uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
(141,'88a0ef43b19c03aa6d17a91hy6785fr4', 1, 'Change Due Date Reason', 'Change Due Date Reason', 1, '2021-10-19 04:41:20', '2021-10-19 04:41:20');
INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 1, 141, 0),
(0, 2, 141, 0),
(0, 3, 141, 0),
(0, 4, 141, 0);
INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 3, 102, 1),
(0, 4, 102, 1);

INSERT INTO `actions` (`id`,`uniq_id`, `module_id`, `action`, `display_name`, `display_group`, `created`, `modified`) VALUES
(142,'89a0ef43b19c03aa6d19a91hy6785fr9', 1, 'View Zoom Meeting', 'View Zoom Meeting', 1, '2021-11-09 04:41:20', '2021-11-09 04:41:20'),(143,'89a0eu43b19c03aa6d19a91uy6785fr7', 1, 'Create Zoom Meeting', 'Create Zoom Meeting', 1, '2021-11-09 04:41:20', '2021-11-09 04:41:20');

INSERT INTO `role_actions` (`company_id`, `role_id`, `action_id`, `is_allowed`) VALUES
(0, 1, 142, 1),
(0, 2, 142, 1),
(0, 3, 142, 0),
(0, 4, 142, 0),
(0, 1, 143, 1),
(0, 2, 143, 1),
(0, 3, 143, 0),
(0, 4, 143, 0);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
