-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Fev-2022 às 21:13
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `store`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `user`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@admin.com', '$2y$10$uK8xH/s5jnt5Jgv7OwuoWO7q572eyLVOXXlYyhMjedoy9XmPtSxMa', '2021-12-05 22:26:58', '2021-12-05 22:26:58', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `hash` varchar(50) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id_client`, `email`, `password`, `name`, `address`, `city`, `phone`, `hash`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'thisdev22@gmail.com', '$2y$10$o/PwCFxavd2p7HtQJpPl/OpzhtB4NAcWa5ng9kynKI0hMk2nuKeEO', 'Amilton', 'Rua Ana Araújo Siqueira', 'Itapeva-MG', '(35) 99821-6583', NULL, 1, '2022-02-03 14:46:19', '2022-02-09 15:09:39', NULL),
(3, 'contato.daniel.dev@gmail.com', '$2y$10$dqwrKWuqWcHPfc6u.Ji9EO2BQclrysce2ndubwIDwC78MVfbyyy3C', 'Clóvis', 'Rua Ana Araújo Siqueira', 'Itapeva-MG', '(35) 99821-6583', NULL, 1, '2022-02-05 23:53:53', '2022-02-09 15:08:55', NULL),
(4, 'df46636@gmail.com', '$2y$10$aTa3V0pM.ZuYsPgrDhDBheMvCt92QWDx.GuNlIlCNN/mSWMB1oqOK', 'Vanderson', '123456', 'Minduri', '(35) 99821-6583', NULL, 1, '2022-02-09 14:54:07', '2022-02-09 15:09:23', NULL),
(5, 'dfdev2022@gmail.com', '$2y$10$O5lcomC2RJF35peC2TOLaOKZEEmwUN0uyn4pfC8wTjOwRxShEZZuO', 'Jobson', 'Rua Tapecaria machado', 'Londrina', '(35) 99821-6583', NULL, 1, '2022-02-09 15:00:36', '2022-02-09 15:09:11', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id_order`, `id_client`, `date`, `address`, `city`, `email`, `phone`, `code_order`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 2, '2022-02-05 23:40:19', 'Rua americo brasileiro N 200', 'Carrancas', 'thisdev22@gmail.com', '', 'YP625670', 'SEND', '', '2022-02-05 23:40:19', '2022-02-09 14:45:15'),
(2, 3, '2022-02-05 23:56:52', 'Rua Ana Araújo Siqueira', 'Itapeva-MG', 'contato.daniel.dev@gmail.com', '', 'RD256847', 'PENDING', '', '2022-02-05 23:56:52', '2022-02-09 13:16:57'),
(3, 3, '2022-02-06 00:09:15', 'Rua Ana Araújo Siqueira', 'Itapeva-MG', 'contato.daniel.dev@gmail.com', '', 'YK977609', 'SEND', '', '2022-02-06 00:09:15', '2022-02-09 14:43:40'),
(4, 3, '2022-02-06 00:24:53', 'Rua Ana Araújo Siqueira', 'Itapeva-MG', 'contato.daniel.dev@gmail.com', '', 'GG955545', 'PROCESSING', '', '2022-02-06 00:24:53', '2022-02-07 14:39:46'),
(5, 4, '2022-02-09 14:55:44', '123456', 'Minduri', 'df46636@gmail.com', '(35) 99821-6583', 'CM981659', 'PENDING', '', '2022-02-09 14:55:44', '2022-02-09 14:55:44'),
(6, 5, '2022-02-09 15:01:32', 'Rua Tapecaria machado', 'Londrina', 'dfdev2022@gmail.com', '(35) 99821-6583', 'BQ678797', 'PENDING', '', '2022-02-09 15:01:32', '2022-02-09 15:01:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `visible` tinyint(4) NOT NULL,
  `bestseller` tinyint(4) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id_product`, `category`, `name`, `description`, `image`, `price`, `stock`, `visible`, `bestseller`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cameras', 'Câmera Nikon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_06.jpg', '659.00', 100, 1, 1, '2021-11-29 15:00:58', '2021-11-29 15:00:58', NULL),
(2, 'tvs', 'Tv 43 Polegadas', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_20.jpg', '2499.00', 100, 1, 0, '2021-11-29 11:07:30', '2021-11-29 11:07:30', NULL),
(3, 'relogios', 'Relógio', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_11.jpg', '499.00', 0, 1, 0, '2021-11-29 11:07:30', '2021-11-29 11:07:30', NULL),
(4, 'celulares', 'Smartphone', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_02.jpg', '1299.00', 100, 1, 1, '2021-11-29 12:37:57', '2021-11-29 12:37:57', NULL),
(5, 'celulares', 'Smartphone Samsung', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_01.jpg', '999.00', 100, 1, 1, '2021-11-29 13:03:31', '2021-11-29 13:03:31', NULL),
(6, 'cameras', 'Câmera Samsung', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_07.jpg', '789.00', 50, 1, 0, '2021-11-29 13:03:31', '2021-11-29 13:03:31', NULL),
(7, 'controles', 'Controle Xbox One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_18.jpg', '299.00', 20, 1, 1, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL),
(9, 'fones', 'Fone JBL Bluetooth', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'el_hover_img1.jpg', '229.00', 20, 1, 0, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL),
(10, 'fones', 'Fone Zebronics Bluetooth', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'phone.png', '159.00', 20, 1, 0, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL),
(11, 'notebooks', 'Notebook Aspire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'digital_14.jpg', '1979.00', 20, 1, 1, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL),
(12, 'som', 'Caixa de som JBL', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'jbl.png', '799.00', 20, 1, 0, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL),
(13, 'computadores', 'Computador Lenovo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis efficitur pharetra. Aenean ut orci mi. Mauris sit amet rhoncus odio. Vestibulum eget ante vestibulum justo aliquet sodales. Nulla semper diam id egestas tristique. Phasellus suscipit lectus libero, sit amet venenatis dolor venenatis auctor.', 'pc.png', '2799.00', 0, 1, 0, '2021-11-29 13:19:07', '2021-11-29 13:19:07', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sale_products`
--

CREATE TABLE `sale_products` (
  `id_sale` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `price_unit` decimal(6,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sale_products`
--

INSERT INTO `sale_products` (`id_sale`, `id_order`, `name`, `price_unit`, `quantity`, `created_at`) VALUES
(1, 1, 'Câmera Nikon', '659.00', 1, '2022-02-05 23:40:19'),
(2, 1, 'Tv 43 Polegadas', '2499.00', 1, '2022-02-05 23:40:19'),
(3, 1, 'Controle Xbox One', '299.00', 2, '2022-02-05 23:40:19'),
(4, 2, 'Tv 43 Polegadas', '2499.00', 1, '2022-02-05 23:56:52'),
(5, 2, 'Câmera Samsung', '789.00', 1, '2022-02-05 23:56:52'),
(6, 3, 'Controle Xbox One', '299.00', 2, '2022-02-06 00:09:15'),
(7, 4, 'Câmera Samsung', '789.00', 1, '2022-02-06 00:24:53'),
(8, 5, 'Fone Zebronics Bluetooth', '159.00', 2, '2022-02-09 14:55:44'),
(9, 5, 'Caixa de som JBL', '799.00', 1, '2022-02-09 14:55:44'),
(10, 6, 'Tv 43 Polegadas', '2499.00', 2, '2022-02-09 15:01:32'),
(11, 6, 'Fone JBL Bluetooth', '229.00', 3, '2022-02-09 15:01:32'),
(12, 6, 'Fone Zebronics Bluetooth', '159.00', 3, '2022-02-09 15:01:32'),
(13, 6, 'Notebook Aspire', '1979.00', 4, '2022-02-09 15:01:32');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- Índices para tabela `sale_products`
--
ALTER TABLE `sale_products`
  ADD PRIMARY KEY (`id_sale`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
