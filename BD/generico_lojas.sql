-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 18/10/2023 às 16:06
-- Versão do servidor: 5.7.30
-- Versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `generico_lojas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Produtos`
--

CREATE TABLE `Produtos` (
  `idProduto` int(11) NOT NULL,
  `Usuarios_idUsuario` int(11) NOT NULL,
  `fotoProduto` varchar(100) NOT NULL,
  `nomeProduto` varchar(50) NOT NULL,
  `descricaoProduto` varchar(200) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `dataProduto` date NOT NULL,
  `horaProduto` time NOT NULL,
  `statusProduto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Usuarios`
--

CREATE TABLE `Usuarios` (
  `idUsuario` int(11) NOT NULL,
  `tipoUsuario` varchar(20) NOT NULL,
  `fotoUsuario` varchar(100) NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `cidadeUsuario` varchar(30) NOT NULL,
  `telefoneUsuario` varchar(20) NOT NULL,
  `emailUsuario` varchar(50) NOT NULL,
  `senhaUsuario` varchar(100) NOT NULL,
  `dataCadastroUsuario` date NOT NULL,
  `statusUsuario` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `Usuarios`
--

INSERT INTO `Usuarios` (`idUsuario`, `tipoUsuario`, `fotoUsuario`, `nomeUsuario`, `cidadeUsuario`, `telefoneUsuario`, `emailUsuario`, `senhaUsuario`, `dataCadastroUsuario`, `statusUsuario`) VALUES
(1, 'administrador', 'img/senhorCapivara.jpeg', 'Capivara Roedora de Matos', 'telemacoBorba', '(42) 99999-9999', 'capivara@gmail.com', '202cb962ac59075b964b07152d234b70', '2023-10-18', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Vendas`
--

CREATE TABLE `Vendas` (
  `idVenda` int(11) NOT NULL,
  `Usuarios_idUsuario` int(11) NOT NULL,
  `Produtos_idProduto` int(11) NOT NULL,
  `dataVenda` date NOT NULL,
  `horaVenda` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `Produtos`
--
ALTER TABLE `Produtos`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `id_fk_idUsuario` (`Usuarios_idUsuario`);

--
-- Índices de tabela `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices de tabela `Vendas`
--
ALTER TABLE `Vendas`
  ADD PRIMARY KEY (`idVenda`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `Produtos`
--
ALTER TABLE `Produtos`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `Vendas`
--
ALTER TABLE `Vendas`
  MODIFY `idVenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `Produtos`
--
ALTER TABLE `Produtos`
  ADD CONSTRAINT `id_fk_idUsuario` FOREIGN KEY (`Usuarios_idUsuario`) REFERENCES `Usuarios` (`idUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
