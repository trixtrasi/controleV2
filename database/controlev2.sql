-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Maio-2024 às 22:22
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `controlev2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `eventos__id` int(12) NOT NULL,
  `eventos__status` tinyint(4) NOT NULL DEFAULT 1,
  `eventos__data_ini` date NOT NULL,
  `eventos__data_fim` date DEFAULT NULL,
  `eventos__texto` text NOT NULL,
  `eventos__create_by` int(11) NOT NULL,
  `eventos__create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `eventos__exclude_by` int(11) DEFAULT NULL,
  `eventos__exclude_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `users__id` int(11) NOT NULL,
  `users__status` tinyint(2) NOT NULL DEFAULT 1,
  `users__username` bigint(19) NOT NULL,
  `users__nome` varchar(55) NOT NULL,
  `users__password` varchar(255) NOT NULL,
  `users__nivel` tinyint(4) NOT NULL DEFAULT 1,
  `users__create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `users__remove_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`users__id`, `users__status`, `users__username`, `users__nome`, `users__password`, `users__nivel`, `users__create_at`, `users__remove_at`) VALUES
(1, 1, 4815162342, 'Admin', '$2y$10$YnqqEoI2SuPQSR8Uazt.x.5pqqjj5lUDSNeLgVqrEHjTQm2MAvoqy', 5, '2024-04-22 23:33:03', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `visitantes`
--

CREATE TABLE `visitantes` (
  `visitantes__id` int(11) NOT NULL,
  `visitantes__status` tinyint(4) NOT NULL DEFAULT 0,
  `visitantes__nome` varchar(255) DEFAULT NULL,
  `visitantes__aniversario` date DEFAULT NULL,
  `visitantes__tipo_doc` varchar(9) DEFAULT NULL,
  `visitantes__num_doc` varchar(55) DEFAULT NULL,
  `visitantes__genero` varchar(33) DEFAULT NULL,
  `visitantes__endereco` text DEFAULT NULL,
  `visitantes__telefone` varchar(33) DEFAULT NULL,
  `visitantes__create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `visitantes__create_by` int(11) NOT NULL,
  `visitantes__remove_at` datetime DEFAULT NULL,
  `visitantes__remove_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `visitantes__visitas`
--

CREATE TABLE `visitantes__visitas` (
  `visitas__id` int(6) NOT NULL,
  `visitas__visitante` int(6) NOT NULL,
  `visitas__status` tinyint(4) DEFAULT 1,
  `visitas__create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `visitas__create_by` int(6) NOT NULL,
  `visitas__chegou_d_h` datetime DEFAULT current_timestamp(),
  `visitas__previsao_chegada` date DEFAULT NULL,
  `visitas__previsao_saida` date DEFAULT NULL,
  `visitas__saiu_d_h` datetime DEFAULT NULL,
  `visitas__pm_acompanhante` varchar(55) DEFAULT NULL,
  `visitas__motivo` text DEFAULT NULL,
  `visitas__obs` text DEFAULT NULL,
  `visitas__veic_marca` varchar(55) DEFAULT NULL,
  `visitas__veic_modelo` varchar(55) DEFAULT NULL,
  `visitas__veic_placa` varchar(55) DEFAULT NULL,
  `visitas__img_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`eventos__id`),
  ADD KEY `eventos_create_by` (`eventos__create_by`),
  ADD KEY `eventos_exclude_by` (`eventos__exclude_by`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users__id`),
  ADD UNIQUE KEY `usuario` (`users__username`);

--
-- Índices para tabela `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`visitantes__id`),
  ADD KEY `create_by` (`visitantes__create_by`),
  ADD KEY `remove_by` (`visitantes__remove_by`);

--
-- Índices para tabela `visitantes__visitas`
--
ALTER TABLE `visitantes__visitas`
  ADD PRIMARY KEY (`visitas__id`) USING BTREE,
  ADD KEY `visitantes` (`visitas__visitante`),
  ADD KEY `create_by` (`visitas__create_by`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `eventos__id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `users__id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `visitantes__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `visitantes__visitas`
--
ALTER TABLE `visitantes__visitas`
  MODIFY `visitas__id` int(6) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`eventos__create_by`) REFERENCES `users` (`users__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`eventos__exclude_by`) REFERENCES `users` (`users__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `visitantes`
--
ALTER TABLE `visitantes`
  ADD CONSTRAINT `visitantes_ibfk_1` FOREIGN KEY (`visitantes__create_by`) REFERENCES `users` (`users__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visitantes_ibfk_2` FOREIGN KEY (`visitantes__remove_by`) REFERENCES `users` (`users__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `visitantes__visitas`
--
ALTER TABLE `visitantes__visitas`
  ADD CONSTRAINT `visitantes__visitas_ibfk_1` FOREIGN KEY (`visitas__visitante`) REFERENCES `visitantes` (`visitantes__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visitantes__visitas_ibfk_2` FOREIGN KEY (`visitas__create_by`) REFERENCES `users` (`users__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
