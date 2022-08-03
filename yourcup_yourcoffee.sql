-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-08-03 17:55:16
-- サーバのバージョン： 10.4.22-MariaDB
-- PHP のバージョン: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `yourcap_yourcoffee`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `coffees`
--

CREATE TABLE `coffees` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'USER_ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `evaluation` int(255) NOT NULL DEFAULT 0 COMMENT '総合評価',
  `place` varchar(255) NOT NULL COMMENT '購入店',
  `price` int(32) DEFAULT NULL COMMENT '価格',
  `origin` varchar(255) DEFAULT NULL COMMENT '生産地',
  `variety` varchar(255) DEFAULT NULL COMMENT '品種',
  `brew` varchar(255) DEFAULT NULL COMMENT '抽出方法',
  `roast` varchar(255) DEFAULT NULL COMMENT '焙煎',
  `image` varchar(255) DEFAULT NULL COMMENT '珈琲画像',
  `comment` varchar(512) DEFAULT NULL COMMENT 'コメント',
  `publish_status` int(32) NOT NULL COMMENT '公開設定',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `coffees`
--

INSERT INTO `coffees` (`id`, `user_id`, `name`, `evaluation`, `place`, `price`, `origin`, `variety`, `brew`, `roast`, `image`, `comment`, `publish_status`, `created_at`, `updated_at`) VALUES
(80, 2, 'アイスコーヒー', 4, '落花生喫茶', 450, 'ブラジル', NULL, NULL, NULL, NULL, NULL, 1, '2022-07-28 21:48:09', '2022-07-28 21:48:09'),
(82, 1, 'カプチーノ', 5, 'ふくろう喫茶店', 1200, '', '', '', '', '', '', 1, '2022-07-28 22:17:02', '2022-07-28 22:17:02'),
(86, 1, 'カフェラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 2, '2022-07-29 00:05:55', '2022-07-29 00:05:55'),
(87, 1, 'カフェラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 2, '2022-07-29 02:53:08', '2022-07-29 02:53:08'),
(88, 2, 'カフェラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 1, '2022-07-29 04:04:44', '2022-07-29 04:04:44'),
(89, 1, 'アイスラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 2, '2022-07-29 05:04:22', '2022-07-29 05:04:22'),
(90, 1, 'カフェラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 2, '2022-07-29 05:04:30', '2022-07-29 05:04:30'),
(91, 1, 'カフェラテ', 3, 'スターバックス', 0, '', '', '', '', '', '', 2, '2022-07-29 05:04:39', '2022-07-29 05:04:39'),
(92, 1, 'キャラメルマキアート', 2, 'スターバックス', 0, '', '', '', '', '', '', 1, '2022-07-30 14:33:52', '2022-07-30 14:33:52'),
(93, 1, 'ブラックコーヒー', 3, '星乃珈琲', 0, '', '', '', '', '', '', 1, '2022-07-30 14:34:04', '2022-07-30 14:34:04'),
(94, 1, 'キャラメルマキアート', 2, '青空コーヒー', 550, 'ブラジル', 'ゲイシャ', '', '', '', 'とても美味しかった。\r\nまた飲みたいと思える味わい。', 2, '2022-07-30 14:48:46', '2022-07-30 14:48:46'),
(96, 1, 'キャラメルマキアート', 3, '中目黒喫茶', 1200, 'ブラジル', '不明', 'ペーパードリップ', '浅煎り', '', 'あああああああああああああああああああああ\r\nあああああ\r\nあああああああああああ\r\nあああああああああ！', 1, '2022-08-02 02:13:57', '2022-08-02 02:13:57'),
(98, 1, 'カフェラテ', 3, 'スターバックス', 900, 'ブラジル', '', 'サイフォン', '', '220802140255coffee_cup2.jpg', '編集', 2, '2022-08-02 02:28:12', '2022-08-02 02:28:12');

-- --------------------------------------------------------

--
-- テーブルの構造 `goods`
--

CREATE TABLE `goods` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザID',
  `coffee_id` int(32) NOT NULL COMMENT '珈琲ID',
  `created_at` datetime NOT NULL COMMENT '登録日時',
  `updated_at` datetime NOT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `goods`
--

INSERT INTO `goods` (`id`, `user_id`, `coffee_id`, `created_at`, `updated_at`) VALUES
(54, 2, 88, '2022-08-01 23:20:48', '2022-08-01 23:20:48'),
(55, 14, 88, '2022-08-01 23:20:48', '2022-08-01 23:20:48'),
(59, 2, 94, '2022-08-02 00:25:44', '2022-08-02 00:25:44'),
(60, 14, 94, '2022-08-02 00:25:44', '2022-08-02 00:25:44'),
(66, 1, 88, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(50) NOT NULL COMMENT 'メールアドレス',
  `token` varchar(80) NOT NULL COMMENT 'トークン',
  `token_sent_at` datetime NOT NULL COMMENT 'トークン作成日時',
  `cood` int(32) NOT NULL COMMENT '認証コード'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'ユーザネーム',
  `mail` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `comment` varchar(512) NOT NULL COMMENT 'コメント',
  `created_at` datetime NOT NULL COMMENT '登録日時',
  `updated_at` datetime NOT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users_coffees`
--

CREATE TABLE `users_coffees` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザID',
  `coffee_id` int(32) NOT NULL COMMENT '珈琲ID',
  `created_at` datetime NOT NULL COMMENT '登録日時',
  `updated_at` datetime NOT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `coffees`
--
ALTER TABLE `coffees`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`mail`);

--
-- テーブルのインデックス `users_coffees`
--
ALTER TABLE `users_coffees`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `coffees`
--
ALTER TABLE `coffees`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=100;

--
-- テーブルの AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=67;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- テーブルの AUTO_INCREMENT `users_coffees`
--
ALTER TABLE `users_coffees`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
