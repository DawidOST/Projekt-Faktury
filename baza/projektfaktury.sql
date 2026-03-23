-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 08:11 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projektfaktury`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `faktury`
--

CREATE TABLE `faktury` (
  `id` int(11) NOT NULL,
  `numer_faktury` varchar(50) NOT NULL,
  `data_wystawienia` date NOT NULL,
  `id_sprzedawcy` int(11) NOT NULL,
  `id_nabywcy` int(11) NOT NULL,
  `status` enum('robocza','wysłana','zaakceptowana','odrzucona') DEFAULT 'robocza'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `firmy`
--

CREATE TABLE `firmy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `adres` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firmy`
--

INSERT INTO `firmy` (`id`, `nazwa`, `nip`, `adres`) VALUES
(1, 'Firma1', '1234563218', '28 Czerwca 1956 r. 352/360, 61-441 Poznań'),
(2, 'Firma2', '1234563217', 'Pleszewska 1, 61-136 Poznań');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pozycje_faktury`
--

CREATE TABLE `pozycje_faktury` (
  `id` int(11) NOT NULL,
  `id_faktury` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `cena_netto` decimal(10,2) NOT NULL,
  `id_vat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stawki_vat`
--

CREATE TABLE `stawki_vat` (
  `id` int(11) NOT NULL,
  `wartosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stawki_vat`
--

INSERT INTO `stawki_vat` (`id`, `wartosc`) VALUES
(1, 23),
(2, 8),
(3, 5),
(4, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`) VALUES
(1, 'admin', '$2y$10$4KzgyI7ThTEHx3LDPCtXW.Db42V07kIK84u5eUHlIMH3c9.xRHaEO');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `faktury`
--
ALTER TABLE `faktury`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sprzedawcy` (`id_sprzedawcy`),
  ADD KEY `id_nabywcy` (`id_nabywcy`);

--
-- Indeksy dla tabeli `firmy`
--
ALTER TABLE `firmy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pozycje_faktury`
--
ALTER TABLE `pozycje_faktury`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_faktury` (`id_faktury`),
  ADD KEY `id_vat` (`id_vat`);

--
-- Indeksy dla tabeli `stawki_vat`
--
ALTER TABLE `stawki_vat`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faktury`
--
ALTER TABLE `faktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `firmy`
--
ALTER TABLE `firmy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pozycje_faktury`
--
ALTER TABLE `pozycje_faktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stawki_vat`
--
ALTER TABLE `stawki_vat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faktury`
--
ALTER TABLE `faktury`
  ADD CONSTRAINT `faktury_ibfk_1` FOREIGN KEY (`id_sprzedawcy`) REFERENCES `firmy` (`id`),
  ADD CONSTRAINT `faktury_ibfk_2` FOREIGN KEY (`id_nabywcy`) REFERENCES `firmy` (`id`);

--
-- Constraints for table `pozycje_faktury`
--
ALTER TABLE `pozycje_faktury`
  ADD CONSTRAINT `pozycje_faktury_ibfk_1` FOREIGN KEY (`id_faktury`) REFERENCES `faktury` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pozycje_faktury_ibfk_2` FOREIGN KEY (`id_vat`) REFERENCES `stawki_vat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
