-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 27, 2019 lúc 11:29 AM
-- Phiên bản máy phục vụ: 10.4.10-MariaDB
-- Phiên bản PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sampledb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `commentid` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_vietnamese_ci DEFAULT ' ',
  `profileIDcmt` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `Timecmt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`commentid`, `comment`, `profileIDcmt`, `postID`, `Timecmt`) VALUES
(6, '            s', 2, 9, '2019-12-16 16:45:25'),
(7, 'dasd', 2, 9, '2019-12-16 16:45:29'),
(8, '            ds', 2, 9, '2019-12-16 16:45:39'),
(9, '   s   ', 2, 11, '2019-12-16 22:50:42'),
(10, '      asdsd      ', 2, 11, '2019-12-16 22:50:46'),
(11, '      asdsd      ', 2, 11, '2019-12-16 22:57:38'),
(12, '      asdsd      ', 2, 11, '2019-12-16 22:59:10'),
(13, '      asdsd      ', 2, 11, '2019-12-16 22:59:43'),
(14, '      asdsd      ', 2, 11, '2019-12-16 23:02:51'),
(15, '      asdsd      ', 2, 11, '2019-12-16 23:10:19'),
(16, '      asdsd      ', 2, 11, '2019-12-16 23:10:38'),
(17, '      asdsd      ', 2, 11, '2019-12-16 23:13:43'),
(18, '      asdsd      ', 2, 11, '2019-12-16 23:18:47'),
(19, 'asdas', 2, 11, '2019-12-16 23:18:59'),
(20, '          asdas  ', 2, 11, '2019-12-16 23:19:03'),
(21, '            ', 2, 11, '2019-12-16 23:19:04'),
(22, '    dd        ', 2, 11, '2019-12-16 23:19:05'),
(23, '    dd        ', 2, 11, '2019-12-16 23:19:17'),
(24, 'asdasd         ', 2, 11, '2019-12-16 23:19:21'),
(25, '            asdasd', 2, 11, '2019-12-16 23:35:13'),
(26, '            d', 2, 11, '2019-12-16 23:35:14'),
(27, '            d', 2, 11, '2019-12-16 23:56:01'),
(28, '            d', 2, 11, '2019-12-17 00:00:58'),
(29, '            s', 2, 11, '2019-12-17 00:01:04'),
(30, '            ', 2, 11, '2019-12-17 11:21:28'),
(31, '            ', 2, 11, '2019-12-17 11:21:48'),
(32, '            ', 2, 11, '2019-12-17 11:22:05'),
(33, '  asdas', 2, 11, '2019-12-17 11:24:16'),
(34, '  asdas', 2, 11, '2019-12-17 11:30:42'),
(35, '            asd', 2, 11, '2019-12-17 15:09:56'),
(36, 'asd         ', 2, 11, '2019-12-17 15:10:01'),
(37, 'asdas', 2, 11, '2019-12-17 15:21:25'),
(38, 'asdas', 2, 11, '2019-12-17 15:21:36'),
(39, '                     dasd    ', 2, 11, '2019-12-17 15:21:39'),
(40, NULL, 2, 13, '2019-12-18 10:39:40'),
(41, NULL, 2, 12, '2019-12-18 10:39:40'),
(42, NULL, 2, 13, '2019-12-18 10:39:45'),
(43, NULL, 2, 12, '2019-12-18 10:39:45'),
(44, NULL, 2, 13, '2019-12-18 10:39:52'),
(45, NULL, 2, 12, '2019-12-18 10:39:52'),
(46, NULL, 2, 13, '2019-12-18 10:49:09'),
(47, NULL, 2, 12, '2019-12-18 10:49:09'),
(48, NULL, 2, 13, '2019-12-18 10:49:11'),
(49, NULL, 2, 12, '2019-12-18 10:49:11'),
(50, NULL, 2, 13, '2019-12-18 10:49:14'),
(51, NULL, 2, 12, '2019-12-18 10:49:14'),
(52, NULL, 2, 13, '2019-12-18 10:49:18'),
(53, NULL, 2, 12, '2019-12-18 10:49:18'),
(54, NULL, 2, 13, '2019-12-18 10:49:31'),
(55, NULL, 2, 12, '2019-12-18 10:49:31'),
(60, 'cmt1', 2, 13, '2019-12-18 10:57:30'),
(61, 'cmt2', 2, 12, '2019-12-18 10:57:30'),
(62, 'cmt3', 2, 13, '2019-12-19 01:12:25'),
(63, 'cmt4', 2, 12, '2019-12-19 01:12:25'),
(64, 'cmt5', 2, 13, '2019-12-19 01:33:20'),
(65, 'cmt6', 2, 12, '2019-12-19 01:33:20'),
(85, 'đ m nó', 2, 17, '2019-12-23 17:52:24'),
(86, '                         asdasd', 2, 9, '2019-12-23 17:59:42'),
(87, '                         asdasd', 2, 9, '2019-12-23 18:01:40'),
(88, '                         asdasd', 2, 9, '2019-12-23 18:01:47'),
(163, 'đ m m NGỌC', 2, 17, '2019-12-27 15:13:25'),
(164, 'đ m m NGỌC', 2, 17, '2019-12-27 15:21:31'),
(165, 'đ m m NGỌC', 2, 17, '2019-12-27 15:22:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations`
--

CREATE TABLE `conversations` (
  `conversationID` int(11) NOT NULL,
  `lastMessageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `conversations`
--

INSERT INTO `conversations` (`conversationID`, `lastMessageID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations_messages`
--

CREATE TABLE `conversations_messages` (
  `conversationID` int(11) NOT NULL COMMENT 'id bên conversation',
  `messageID` int(11) NOT NULL COMMENT 'id bên conversation_send',
  `profileID` int(11) NOT NULL COMMENT 'id người gửi/người nhận',
  `seen` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `conversations_messages`
--

INSERT INTO `conversations_messages` (`conversationID`, `messageID`, `profileID`, `seen`, `deleted`) VALUES
(1, 1, 1, 0, 0),
(1, 1, 2, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations_sent`
--

CREATE TABLE `conversations_sent` (
  `messageID` int(11) NOT NULL,
  `message` mediumtext COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `profileID` int(11) NOT NULL COMMENT 'id của người đã gửi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `conversations_sent`
--

INSERT INTO `conversations_sent` (`messageID`, `message`, `time`, `profileID`) VALUES
(1, '🙁<br>', '2019-12-19 11:46:46', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations_users`
--

CREATE TABLE `conversations_users` (
  `conversationID` int(11) NOT NULL COMMENT 'id bên conversation',
  `profileID` int(11) NOT NULL COMMENT 'id người tham gia',
  `seen` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `conversations_users`
--

INSERT INTO `conversations_users` (`conversationID`, `profileID`, `seen`) VALUES
(1, 1, 0),
(1, 2, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `userone` int(11) NOT NULL,
  `usertwo` int(11) NOT NULL,
  `addedTime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

CREATE TABLE `likes` (
  `id_likes` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_posts` int(11) NOT NULL,
  `time_likes` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`id_likes`, `id_users`, `id_posts`, `time_likes`) VALUES
(64, 2, 9, '2019-12-14 14:43:43'),
(65, 2, 11, '2019-12-17 11:08:23'),
(66, 2, 13, '2019-12-17 16:08:48'),
(67, 2, 12, '2019-12-19 02:22:42'),
(70, 2, 14, '2019-12-19 07:10:05'),
(72, 2, 16, '2019-12-19 11:52:59'),
(73, 2, 15, '2019-12-19 11:53:05'),
(81, 2, 17, '2019-12-27 15:59:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `node_type` varchar(32) COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'dạng thông báo (post, comment, friend request, react, message...)',
  `node_url` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `message` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `seen` enum('0','1') COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `profileID` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `image` longblob DEFAULT NULL,
  `imagetype` varchar(10) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`postID`, `content`, `profileID`, `createdAt`, `image`, `imagetype`, `visibility`) VALUES
(17, 'aaaa', 2, '2019-12-19 11:07:59', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_privacy`
--

CREATE TABLE `post_privacy` (
  `id` int(11) NOT NULL,
  `visibility` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `post_privacy`
--

INSERT INTO `post_privacy` (`id`, `visibility`) VALUES
(0, 'Công khai'),
(1, 'Bạn bè'),
(2, 'Riêng tư');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `profileID` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `fullname` varchar(50) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `mobilenumber` varchar(20) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `pfp` longblob DEFAULT NULL,
  `pfptype` varchar(10) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`profileID`, `username`, `email`, `password`, `fullname`, `mobilenumber`, `pfp`, `pfptype`, `code`, `status`) VALUES
(1, '1760005', 'dangtrunghieu2304@gmail.com', '$2y$10$xPoZmsKeokTa7mgXafNXNOyGPfovlR296uLOMSlUjPQm7iY6vwUHy', NULL, NULL, NULL, '', 'agpgJvYybgoFu7aO', 0),
(2, 'tester', 'timchideyeu1998@gmail.com', '$2y$10$JiD/po9JSIniGAzL97Puvug5PnuIG5Nr5faLFxAC6LCnkc/WARqJG', 'noname', '114', NULL, 'png', '', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentid`);

--
-- Chỉ mục cho bảng `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversationID`);

--
-- Chỉ mục cho bảng `conversations_messages`
--
ALTER TABLE `conversations_messages`
  ADD PRIMARY KEY (`conversationID`,`messageID`,`profileID`);

--
-- Chỉ mục cho bảng `conversations_sent`
--
ALTER TABLE `conversations_sent`
  ADD PRIMARY KEY (`messageID`);

--
-- Chỉ mục cho bảng `conversations_users`
--
ALTER TABLE `conversations_users`
  ADD PRIMARY KEY (`conversationID`,`profileID`);

--
-- Chỉ mục cho bảng `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_likes`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Chỉ mục cho bảng `post_privacy`
--
ALTER TABLE `post_privacy`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`profileID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT cho bảng `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `conversations_sent`
--
ALTER TABLE `conversations_sent`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `id_likes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `profileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
