-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 14 2022 г., 14:07
-- Версия сервера: 10.5.11-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dpcp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_banhummer`
--

CREATE TABLE `tbl_banhummer` (
  `id` int(11) NOT NULL,
  `param` int(11) NOT NULL DEFAULT 1,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `company` varchar(500) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `object` varchar(500) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `confirm` varchar(255) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT 3,
  `admin` int(11) NOT NULL DEFAULT 0,
  `banned` int(11) NOT NULL DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `username`, `password`, `phone`, `company`, `object`, `confirm`, `count`, `admin`, `banned`, `create_at`) VALUES
(1, 'admin', '$2y$10$3ZnwXA1hl0oSTOmnRC7KRu4jh0d8eVsZfIWpT.6nPuuvpb.MU96tW', '', '', '', '0', 1000000, 1, 0, '2022-01-12 14:53:57'),
(2, 'maxim2d@gmail.com', '$2y$10$9ZXPDMYCxpahN3FyvguBuO3BDYTThXXK1oiKJjCZUmNOCMhazUQo6', '00000000000000', 'true-ip', 'true-ip', '0', 100, 0, 1, '2022-01-13 14:08:53');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tbl_banhummer`
--
ALTER TABLE `tbl_banhummer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tbl_banhummer`
--
ALTER TABLE `tbl_banhummer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
