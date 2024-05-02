-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2021 at 07:41 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdd`
--

-- --------------------------------------------------------

--
-- Table structure for table `contribuicoes`
--

DROP TABLE IF EXISTS `contribuicoes`;
CREATE TABLE IF NOT EXISTS `contribuicoes` (
  `id_contribuicao` int(11) NOT NULL AUTO_INCREMENT,
  `id_contribuidor` int(20) NOT NULL,
  `nome_contribuidor` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `apelido_contribuidor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `valor_contribuicao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data_contribuicao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_contribuicao`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contribuicoes`
--

INSERT INTO `contribuicoes` (`id_contribuicao`, `id_contribuidor`, `nome_contribuidor`, `apelido_contribuidor`, `valor_contribuicao`, `data_contribuicao`) VALUES
(1, 1, 'Teste', 'testinho001', '100.00', '2021-10-30'),
(2, 2, 'Teste02', 'testinho02', '200.00', '2021-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `contribuidores`
--

DROP TABLE IF EXISTS `contribuidores`;
CREATE TABLE IF NOT EXISTS `contribuidores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `apelido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contribuidores`
--

INSERT INTO `contribuidores` (`id`, `nome`, `telefone`, `apelido`, `email`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'Teste', '(35) 99999-9999', 'testinho001', 'teste@gmail.com', 'Teste', 'Teste', 'Teste', '0'),
(2, 'Teste02', '(00) 00000-0000', 'testinho02', 'testinho02@gmail.com', 'Teste', 'Teste', 'Teste', '0');

-- --------------------------------------------------------

--
-- Table structure for table `sorteios`
--

DROP TABLE IF EXISTS `sorteios`;
CREATE TABLE IF NOT EXISTS `sorteios` (
  `id_sorteio` int(11) NOT NULL AUTO_INCREMENT,
  `id_contribuidor` int(11) NOT NULL,
  `nome_contribuidor` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `apelido_contribuidor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data_sorteio` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_sorteio`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sorteios`
--

INSERT INTO `sorteios` (`id_sorteio`, `id_contribuidor`, `nome_contribuidor`, `apelido_contribuidor`, `data_sorteio`) VALUES
(1, 1, 'Teste', 'testinho001', '2021-10-30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
