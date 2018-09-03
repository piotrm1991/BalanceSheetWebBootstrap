-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 03 Wrz 2018, 11:03
-- Wersja serwera: 10.1.32-MariaDB
-- Wersja PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `balance_personal`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expense_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `payment_method_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `expense_category_assigned_to_user_id`, `payment_method_assigned_to_user_id`, `amount`, `date`, `comment`) VALUES
(1, 1, 5, 1, '5.00', '2018-08-31', 'test'),
(2, 1, 8, 1, '45.00', '2018-08-31', 'tret'),
(3, 1, 11, 3, '5345.00', '2018-08-31', 'tt'),
(4, 1, 1, 1, '14.00', '2018-08-31', 'dsfsdf'),
(5, 1, 4, 2, '5.00', '2018-08-09', ''),
(6, 1, 1, 3, '1.00', '2018-08-02', ''),
(7, 1, 10, 1, '13.00', '2018-09-01', ''),
(11, 1, 11, 2, '3434.00', '2018-09-02', 'efd'),
(12, 1, 11, 2, '5.00', '2018-08-07', ''),
(13, 1, 10, 1, '1213.00', '2018-09-02', ''),
(14, 1, 5, 2, '3434.00', '2018-09-02', ''),
(15, 1, 4, 1, '155.00', '2018-09-02', ''),
(16, 1, 1, 1, '333.00', '2018-09-03', 'e');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_assigned_to_users`
--

CREATE TABLE `expenses_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_assigned_to_users`
--

INSERT INTO `expenses_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Transport'),
(2, 1, 'Books'),
(3, 1, 'Food'),
(4, 1, 'Apartments'),
(5, 1, 'Training'),
(6, 1, 'Health'),
(7, 1, 'Clothes'),
(8, 1, 'Hygiene'),
(9, 1, 'Kids'),
(10, 1, 'Recreation'),
(11, 1, 'Trip'),
(12, 1, 'Savings'),
(13, 1, 'For Retirement'),
(14, 1, 'Debt Repayment'),
(15, 1, 'Gift'),
(16, 1, 'Another'),
(32, 2, 'Transport'),
(33, 2, 'Books'),
(34, 2, 'Food'),
(35, 2, 'Apartments'),
(36, 2, 'Training'),
(37, 2, 'Health'),
(38, 2, 'Clothes'),
(39, 2, 'Hygiene'),
(40, 2, 'Kids'),
(41, 2, 'Recreation'),
(42, 2, 'Trip'),
(43, 2, 'Savings'),
(44, 2, 'For Retirement'),
(45, 2, 'Debt Repayment'),
(46, 2, 'Gift'),
(47, 2, 'Another'),
(48, 3, 'Transport'),
(49, 3, 'Books'),
(50, 3, 'Food'),
(51, 3, 'Apartments'),
(52, 3, 'Training'),
(53, 3, 'Health'),
(54, 3, 'Clothes'),
(55, 3, 'Hygiene'),
(56, 3, 'Kids'),
(57, 3, 'Recreation'),
(58, 3, 'Trip'),
(59, 3, 'Savings'),
(60, 3, 'For Retirement'),
(61, 3, 'Debt Repayment'),
(62, 3, 'Gift'),
(63, 3, 'Another'),
(64, 4, 'Transport'),
(65, 4, 'Books'),
(66, 4, 'Food'),
(67, 4, 'Apartments'),
(68, 4, 'Training'),
(69, 4, 'Health'),
(70, 4, 'Clothes'),
(71, 4, 'Hygiene'),
(72, 4, 'Kids'),
(73, 4, 'Recreation'),
(74, 4, 'Trip'),
(75, 4, 'Savings'),
(76, 4, 'For Retirement'),
(77, 4, 'Debt Repayment'),
(78, 4, 'Gift'),
(79, 4, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_default`
--

CREATE TABLE `expenses_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_default`
--

INSERT INTO `expenses_category_default` (`id`, `name`) VALUES
(1, 'Transport'),
(2, 'Books'),
(3, 'Food'),
(4, 'Apartments'),
(5, 'Training'),
(6, 'Health'),
(7, 'Clothes'),
(8, 'Hygiene'),
(9, 'Kids'),
(10, 'Recreation'),
(11, 'Trip'),
(12, 'Savings'),
(13, 'For Retirement'),
(14, 'Debt Repayment'),
(15, 'Gift'),
(16, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `income_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes`
--

INSERT INTO `incomes` (`id`, `user_id`, `income_category_assigned_to_user_id`, `amount`, `date`, `comment`) VALUES
(1, 1, 4, '5.00', '2018-08-31', 'ddsfsdfsdf'),
(2, 1, 1, '15.00', '2018-09-13', 'test'),
(3, 1, 3, '132.00', '2018-09-01', ''),
(4, 1, 2, '144.00', '2018-09-02', ''),
(5, 1, 4, '44.00', '2018-09-02', 'gdgdfg'),
(6, 1, 2, '33.00', '2018-08-06', ''),
(7, 1, 1, '4.00', '2018-08-09', ''),
(8, 1, 1, '8000.00', '2018-09-03', ''),
(9, 1, 1, '33.00', '2018-09-03', 'sdfsdf');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_assigned_to_users`
--

CREATE TABLE `incomes_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_assigned_to_users`
--

INSERT INTO `incomes_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Salary'),
(2, 1, 'Interest'),
(3, 1, 'Allegro'),
(4, 1, 'Another'),
(8, 2, 'Salary'),
(9, 2, 'Interest'),
(10, 2, 'Allegro'),
(11, 2, 'Another'),
(12, 3, 'Salary'),
(13, 3, 'Interest'),
(14, 3, 'Allegro'),
(15, 3, 'Another'),
(16, 4, 'Salary'),
(17, 4, 'Interest'),
(18, 4, 'Allegro'),
(19, 4, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_default`
--

CREATE TABLE `incomes_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_default`
--

INSERT INTO `incomes_category_default` (`id`, `name`) VALUES
(1, 'Salary'),
(2, 'Interest'),
(3, 'Allegro'),
(4, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_assigned_to_users`
--

CREATE TABLE `payment_methods_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_assigned_to_users`
--

INSERT INTO `payment_methods_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Cash'),
(2, 1, 'Debit Card'),
(3, 1, 'Credit Card'),
(4, 2, 'Cash'),
(5, 2, 'Debit Card'),
(6, 2, 'Credit Card'),
(7, 3, 'Cash'),
(8, 3, 'Debit Card'),
(9, 3, 'Credit Card'),
(10, 4, 'Cash'),
(11, 4, 'Debit Card'),
(12, 4, 'Credit Card');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_default`
--

CREATE TABLE `payment_methods_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_default`
--

INSERT INTO `payment_methods_default` (`id`, `name`) VALUES
(1, 'Cash'),
(2, 'Debit Card'),
(3, 'Credit Card');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'qwerty123', '$2y$10$mjf7N9fXa9EovmqmBgQr3u/ADOGAI/7J.7CM0/ewI3lzk0wFW.spq', 'qwerty@gmail.com'),
(2, 'asdfgh123', '$2y$10$2q6wCYrP48mtWdrhn9xwmOfJ9kbEnMwQuDisnRdc9bYrAQjM2AX0e', 'asdfgh@gmail.com'),
(3, 'piotr123', '$2y$10$j5rliVJFKFjYwhPOXF6n.eDV0c9deGM0nbM2wZs6H5wkI9ihXM4qa', 'piotr@gmail.com'),
(4, 'test1234', '$2y$10$CE/4OwPnxwA2KGfpOlLMPu33N5gFKQp3xW.ikx0nWIBK18UoY3aOW', 'test@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
