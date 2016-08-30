-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 24 Lip 2016, 14:57
-- Wersja serwera: 5.6.31-0ubuntu0.14.04.2
-- Wersja PHP: 7.0.9-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `Shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Admins`
--

CREATE TABLE `Admins` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `hassed_pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Items`
--

CREATE TABLE `Items` (
  `id` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Items_group`
--

CREATE TABLE `Items_group` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Items_photos`
--

CREATE TABLE `Items_photos` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `src` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_reciver` int(11) NOT NULL,
  `text_message` text NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Product_Orders`
--

CREATE TABLE `Product_Orders` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `surname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `hassed_pass` varchar(60) NOT NULL,
  `addres` text NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_group` (`id_group`);

--
-- Indexes for table `Items_group`
--
ALTER TABLE `Items_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Items_photos`
--
ALTER TABLE `Items_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item` (`id_item`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sender` (`id_sender`),
  ADD KEY `id_reciver` (`id_reciver`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `Product_Orders`
--
ALTER TABLE `Product_Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_item` (`id_item`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Items_group`
--
ALTER TABLE `Items_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Items_photos`
--
ALTER TABLE `Items_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Product_Orders`
--
ALTER TABLE `Product_Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `Items_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `Items_group` (`id`);

--
-- Ograniczenia dla tabeli `Items_photos`
--
ALTER TABLE `Items_photos`
  ADD CONSTRAINT `Items_photos_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `Items` (`id`);

--
-- Ograniczenia dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`id_reciver`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Product_Orders`
--
ALTER TABLE `Product_Orders`
  ADD CONSTRAINT `Product_Orders_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `Items` (`id`),
  ADD CONSTRAINT `Product_Orders_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `Orders` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
