-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2024 年 10 月 01 日 12:23
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `birdies`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `food` int(11) NOT NULL,
  `drink` int(11) NOT NULL,
  `who` int(11) NOT NULL,
  `frequency` int(11) NOT NULL,
  `importance` int(11) NOT NULL,
  `mind` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `memory`
--

CREATE TABLE `memory` (
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `regiDate` date NOT NULL,
  `place` varchar(11) NOT NULL,
  `withWho` varchar(11) NOT NULL,
  `publish` tinyint(4) NOT NULL,
  `memo` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `memory`
--

INSERT INTO `memory` (`user_id`, `image`, `regiDate`, `place`, `withWho`, `publish`, `memo`, `created_at`, `updated_at`, `id`) VALUES
(5, '', '2024-09-10', '東京', '母', 1, 'あいうえお', '2024-09-27 21:56:00', NULL, 1),
(5, '', '2024-09-13', '大阪', '父', 0, 'かきくけこ', '2024-09-27 22:00:59', NULL, 2),
(5, '', '2024-09-13', '大阪', '父', 0, 'かきくけこ', '2024-09-27 22:07:46', NULL, 4),
(5, '', '2024-09-08', '東京', '母', 1, 'あいうえお', '2024-09-27 22:08:03', NULL, 5),
(5, '', '2024-09-02', '東京', '母', 1, 'あいうえお', '2024-09-27 22:12:19', NULL, 6),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:14:22', NULL, 7),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:16:00', NULL, 8),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:27:54', NULL, 9),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:27:55', NULL, 10),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:28:02', NULL, 11),
(5, '', '2024-09-02', '東京', '母', 0, 'あいうえお', '2024-09-27 22:33:41', NULL, 12),
(5, '', '2024-09-02', '東京', '母', 0, '', '2024-09-27 22:34:04', NULL, 13),
(5, '', '2024-09-03', '東京', '母', 0, 'かきくけこ', '2024-09-27 22:38:48', NULL, 14),
(5, 'upload/66f6ba6812769.png', '2024-09-10', '東京', '母', 0, 'あいうえお', '2024-09-27 23:00:08', NULL, 15),
(5, 'upload/66f6bae3896bc.png', '2024-09-10', '東京', '母', 0, 'あいうえお', '2024-09-27 23:02:11', NULL, 16),
(5, 'upload/66f6baf7732c2.png', '2024-09-08', '東京', '母', 0, '恵比寿', '2024-09-27 23:02:31', NULL, 17),
(5, 'upload/66f6bbc72ca37.png', '2024-09-11', '東京', '母', 0, 'あいうえお', '2024-09-27 23:05:59', NULL, 18),
(5, 'upload/66f6bc2993c39.png', '2024-09-09', '東京', '母', 1, 'あいうえお', '2024-09-27 23:07:37', NULL, 19),
(7, 'upload/66fba3e7aa39d.png', '2024-10-16', '東京', '母', 1, 'あいうえお', '2024-10-01 16:25:27', NULL, 20),
(7, 'upload/66fba74e2d5a8.png', '2024-09-29', '大阪', '父', 1, '楽しかった', '2024-10-01 16:39:58', NULL, 21),
(7, 'upload/66fba87b496c2.png', '2024-09-03', '東京', '妹', 1, '旅行', '2024-10-01 16:44:59', NULL, 23),
(7, 'upload/66fba9071d741.png', '2024-09-29', '大阪', '父', 1, '楽しかった', '2024-10-01 16:47:19', NULL, 24);

-- --------------------------------------------------------

--
-- テーブルの構造 `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `gender` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `registered_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `register`
--

INSERT INTO `register` (`id`, `username`, `gender`, `birthday`, `email`, `password`, `registered_date`, `updated_date`) VALUES
(1, 'aya', 2, '1982-04-03', 'aaaa@gmail.com', '$2y$10$N.mqqRfUFoAH4sIgqCpw7OivD.PPlGOKX5wpqJuZJ6uiuqLFt0KzS', '2024-09-10 12:02:28', '2024-09-10 12:02:28'),
(4, 'Hiro', 1, '1988-12-11', 'bbbb@gmail.com', '$2y$10$VVO.iB.ucizYuu14.iVhBOY3GMWK5I3QlGV9CO7Qsn8T2nnP1R4ky', '2024-09-10 12:48:14', '2024-09-10 12:48:14'),
(5, 'michaek', 1, '2024-09-11', 'mike@gmail.com', '$2y$10$AxyAZgREUeuWG1hRMSb3oOCZRUFXgeXO4.Qv9xYKwHnRtHHjM7z4C', '2024-09-27 12:55:43', '2024-09-27 12:55:43'),
(6, 'Michael Spence', 1, '1986-12-05', 'mike@gmail.com', '$2y$10$kIvxhfzZrMjlGn99biu/JOT1GVJlRA/SKrKhvsYnVOYt3b6q669De', '2024-09-30 04:28:42', '2024-09-30 04:28:42'),
(7, 'aya', 2, '2020-06-01', 'sasakiaya@gmail.com', '$2y$10$afoIZaSI18mv4Zv2wt6TI.7bwY.5Uh3QsB6LzRzoyr5eE8CyXkomS', '2024-10-01 05:51:06', '2024-10-01 05:51:06');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `memory`
--
ALTER TABLE `memory`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `memory`
--
ALTER TABLE `memory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- テーブルの AUTO_INCREMENT `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
