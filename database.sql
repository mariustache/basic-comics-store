-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06 Ian 2017 la 14:44
-- Versiune server: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `banda_desenata`
--

CREATE TABLE `banda_desenata` (
  `id_bd` int(11) NOT NULL,
  `nume_bd` varchar(55) NOT NULL,
  `gen` varchar(55) NOT NULL,
  `nr_issues` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `banda_desenata`
--

INSERT INTO `banda_desenata` (`id_bd`, `nume_bd`, `gen`, `nr_issues`) VALUES
(1, 'Spiderman', 'Superhero', 4),
(2, 'Batman', 'Superhero', 5),
(3, 'The Flash', 'Superhero', 3),
(4, 'Superman', 'Superhero', 3),
(5, 'Watchmen', 'Superhero', 0),
(6, 'Aquaman', 'Superhero', 3),
(7, 'Ironman', 'Superhero', 4),
(8, 'Nightwing', 'Superhero', 2),
(9, 'Harap Alb', 'Superhero', 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_nr` int(11) NOT NULL,
  `nume_nr` varchar(55) NOT NULL,
  `price` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `id_nr`, `nume_nr`, `price`, `cantitate`) VALUES
(2, 5, 31, 'Harap Alb Continua #1', 2, 1),
(3, 5, 19, 'Aquaman #1', 2, 2);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `comenzi`
--

CREATE TABLE `comenzi` (
  `id_comanda` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_mp` int(11) NOT NULL,
  `id_ml` int(11) NOT NULL,
  `data_comanda` date NOT NULL,
  `pret` int(11) NOT NULL,
  `stare_comanda` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `comenzi`
--

INSERT INTO `comenzi` (`id_comanda`, `id_user`, `id_mp`, `id_ml`, `data_comanda`, `pret`, `stare_comanda`) VALUES
(2, 5, 1, 1, '2017-01-05', 4, 'Finalizata');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `furnizor`
--

CREATE TABLE `furnizor` (
  `id_furnizor` int(11) NOT NULL,
  `nume_furnizor` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `furnizor`
--

INSERT INTO `furnizor` (`id_furnizor`, `nume_furnizor`) VALUES
(1, 'Marvel Comics'),
(2, 'DC Comics'),
(3, 'Vertigo Comics'),
(4, 'HAC!');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `imagini`
--

CREATE TABLE `imagini` (
  `id_imag` int(11) NOT NULL,
  `id_nr` int(11) NOT NULL,
  `imag_location` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `imagini`
--

INSERT INTO `imagini` (`id_imag`, `id_nr`, `imag_location`) VALUES
(1, 1, 'imag\\the_amazing_spiderman_1.jpg'),
(2, 2, 'imag\\the_amazing_spiderman_2.jpg'),
(3, 3, 'imag\\the_amazing_spiderman_3.jpg'),
(4, 4, 'imag\\the_dark_knight_1.jpg'),
(5, 5, 'imag\\the_dark_knight_2.jpg'),
(6, 6, 'imag\\the_dark_knight_3.jpg'),
(7, 7, 'imag\\the_dark_knight_4.jpg'),
(8, 8, 'imag\\the_dark_knight_5.jpg'),
(9, 9, 'imag\\the_flash_1.jpg'),
(10, 10, 'imag\\the_flash_2.jpg'),
(11, 11, 'imag\\the_flash_3.jpg'),
(12, 12, 'imag\\superman_1.jpg'),
(13, 13, 'imag\\superman_2.jpg'),
(14, 14, 'imag\\superman_3.jpg'),
(19, 19, 'imag\\aquaman_1.jpg'),
(20, 20, 'imag\\aquaman_2.jpg'),
(21, 21, 'imag\\aquaman_3.jpg'),
(24, 24, 'imag\\ironman_1.jpg'),
(25, 25, 'imag\\ironman_2.jpg'),
(26, 26, 'imag\\ironman_3.jpg'),
(27, 27, 'imag\\ironman_4.jpg'),
(28, 28, 'imag\\the_amazing_spiderman_4.jpg'),
(29, 29, 'imag\\nightwing_1.jpg'),
(30, 30, 'imag\\nightwing_2.jpg'),
(31, 31, 'imag\\harap_alb_continua_1.jpg');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `metoda_livrare`
--

CREATE TABLE `metoda_livrare` (
  `id_ml` int(11) NOT NULL,
  `tip_ml` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `metoda_livrare`
--

INSERT INTO `metoda_livrare` (`id_ml`, `tip_ml`) VALUES
(1, 'Ridicare de la sediu'),
(2, 'Curier');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `metoda_plata`
--

CREATE TABLE `metoda_plata` (
  `id_mp` int(11) NOT NULL,
  `tip_mp` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `metoda_plata`
--

INSERT INTO `metoda_plata` (`id_mp`, `tip_mp`) VALUES
(1, 'Cash'),
(2, 'Card');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `numere`
--

CREATE TABLE `numere` (
  `id_nr` int(11) NOT NULL,
  `id_bd` int(11) NOT NULL,
  `id_furnizor` int(11) NOT NULL,
  `nume_numar` varchar(55) NOT NULL,
  `issue_nr` int(11) NOT NULL,
  `data_aparitie` date NOT NULL,
  `pret` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `numere`
--

INSERT INTO `numere` (`id_nr`, `id_bd`, `id_furnizor`, `nume_numar`, `issue_nr`, `data_aparitie`, `pret`, `cantitate`) VALUES
(1, 1, 1, 'The Amazing Spiderman #1', 1, '2016-12-23', 2, 22),
(2, 1, 1, 'The Amazing Spiderman #2', 2, '2016-12-29', 2, 20),
(3, 1, 1, 'The Amazing Spiderman #3', 3, '2017-01-04', 3, 20),
(4, 2, 2, 'The Dark Knight #1', 1, '2016-12-22', 2, 20),
(5, 2, 2, 'The Dark Knight #2', 2, '2016-12-29', 2, 20),
(6, 2, 2, 'The Dark Knight #3', 3, '2017-01-22', 2, 20),
(7, 2, 2, 'The Dark Knight #4', 4, '2017-01-14', 2, 20),
(8, 2, 2, 'The Dark Knight #5', 5, '2017-01-04', 2, 20),
(9, 3, 2, 'The Flash #1', 1, '2016-12-22', 2, 20),
(10, 3, 2, 'The Flash #2', 2, '2017-01-05', 2, 20),
(11, 3, 2, 'The Flash #3', 3, '2017-01-22', 2, 20),
(12, 4, 2, 'Superman #1', 1, '2016-12-22', 2, 20),
(13, 4, 2, 'Superman #2', 2, '2017-01-12', 2, 19),
(14, 4, 2, 'Superman #3', 3, '2017-01-22', 2, 20),
(19, 6, 2, 'Aquaman #1', 1, '2016-12-22', 2, 16),
(20, 6, 2, 'Aquaman #2', 2, '2016-12-29', 2, 16),
(21, 6, 2, 'Aquaman #3', 3, '2017-01-05', 2, 19),
(24, 7, 1, 'Ironman #1', 1, '2016-12-22', 2, 18),
(25, 7, 2, 'Ironman #2', 2, '2017-01-04', 2, 19),
(26, 7, 2, 'Ironman #3', 3, '2017-01-10', 2, 19),
(27, 7, 2, 'Ironman #4', 4, '2017-01-22', 2, 19),
(28, 1, 1, 'The Amazing Spiderman #4', 4, '2017-02-23', 2, 20),
(29, 8, 2, 'Nightwing #1', 1, '2016-12-22', 2, 20),
(30, 8, 2, 'Nightwing #2', 2, '2017-02-02', 2, 19),
(31, 9, 4, 'Harap Alb Continua #1', 1, '2016-06-21', 2, 21);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `numere_comenzi`
--

CREATE TABLE `numere_comenzi` (
  `id_nr_comenzi` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `id_nr` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `numere_comenzi`
--

INSERT INTO `numere_comenzi` (`id_nr_comenzi`, `id_comanda`, `id_nr`, `cantitate`) VALUES
(4, 2, 26, 1),
(5, 2, 30, 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `nume` varchar(55) NOT NULL,
  `prenume` varchar(55) NOT NULL,
  `nr_telefon` int(10) NOT NULL,
  `address` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `nume`, `prenume`, `nr_telefon`, `address`) VALUES
(4, 'admin@admin', 'admin', 'Admin', 'Admin', 777777777, 'MagazinBenziDesenate'),
(5, 'user1@gmail.com', 'user1', 'User', '1', 722223334, 'Adresa 1'),
(6, 'user2@gmail.com', 'user2', 'User', '2', 728205180, 'User 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banda_desenata`
--
ALTER TABLE `banda_desenata`
  ADD PRIMARY KEY (`id_bd`),
  ADD UNIQUE KEY `id_bd` (`id_bd`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD UNIQUE KEY `id_cart` (`id_cart`),
  ADD KEY `id_nr` (`id_nr`),
  ADD KEY `cart_ibfk_2` (`id_user`);

--
-- Indexes for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD PRIMARY KEY (`id_comanda`),
  ADD UNIQUE KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_mp` (`id_mp`),
  ADD KEY `id_ml` (`id_ml`),
  ADD KEY `comenzi_ibfk_1` (`id_user`);

--
-- Indexes for table `furnizor`
--
ALTER TABLE `furnizor`
  ADD PRIMARY KEY (`id_furnizor`),
  ADD UNIQUE KEY `id_furnizor` (`id_furnizor`);

--
-- Indexes for table `imagini`
--
ALTER TABLE `imagini`
  ADD PRIMARY KEY (`id_imag`),
  ADD UNIQUE KEY `id_imag` (`id_imag`),
  ADD UNIQUE KEY `id_nr` (`id_nr`);

--
-- Indexes for table `metoda_livrare`
--
ALTER TABLE `metoda_livrare`
  ADD PRIMARY KEY (`id_ml`),
  ADD UNIQUE KEY `id_ml` (`id_ml`);

--
-- Indexes for table `metoda_plata`
--
ALTER TABLE `metoda_plata`
  ADD PRIMARY KEY (`id_mp`),
  ADD UNIQUE KEY `id_mp` (`id_mp`);

--
-- Indexes for table `numere`
--
ALTER TABLE `numere`
  ADD PRIMARY KEY (`id_nr`),
  ADD UNIQUE KEY `id_nr` (`id_nr`),
  ADD KEY `numere_ibfk_1` (`id_bd`),
  ADD KEY `id_furnizor` (`id_furnizor`);

--
-- Indexes for table `numere_comenzi`
--
ALTER TABLE `numere_comenzi`
  ADD PRIMARY KEY (`id_nr_comenzi`),
  ADD UNIQUE KEY `id_nr_comenzi` (`id_nr_comenzi`),
  ADD KEY `id_nr` (`id_nr`),
  ADD KEY `numere_comenzi_ibfk_1` (`id_comanda`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD KEY `id_user_2` (`id_user`);

--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_nr`) REFERENCES `numere` (`id_nr`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Restrictii pentru tabele `comenzi`
--
ALTER TABLE `comenzi`
  ADD CONSTRAINT `comenzi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `comenzi_ibfk_2` FOREIGN KEY (`id_mp`) REFERENCES `metoda_plata` (`id_mp`),
  ADD CONSTRAINT `comenzi_ibfk_3` FOREIGN KEY (`id_ml`) REFERENCES `metoda_livrare` (`id_ml`);

--
-- Restrictii pentru tabele `imagini`
--
ALTER TABLE `imagini`
  ADD CONSTRAINT `imagini_ibfk_1` FOREIGN KEY (`id_nr`) REFERENCES `numere` (`id_nr`) ON DELETE CASCADE;

--
-- Restrictii pentru tabele `numere`
--
ALTER TABLE `numere`
  ADD CONSTRAINT `numere_ibfk_1` FOREIGN KEY (`id_bd`) REFERENCES `banda_desenata` (`id_bd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `numere_ibfk_2` FOREIGN KEY (`id_furnizor`) REFERENCES `furnizor` (`id_furnizor`);

--
-- Restrictii pentru tabele `numere_comenzi`
--
ALTER TABLE `numere_comenzi`
  ADD CONSTRAINT `numere_comenzi_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comenzi` (`id_comanda`) ON DELETE CASCADE,
  ADD CONSTRAINT `numere_comenzi_ibfk_2` FOREIGN KEY (`id_nr`) REFERENCES `numere` (`id_nr`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
