-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/06/2025 às 15:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `seiosf67_curadoria_memes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `memes`
--

CREATE TABLE `memes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `imagem_url` text DEFAULT NULL,
  `legenda` text DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `memes`
--

INSERT INTO `memes` (`id`, `titulo`, `imagem_url`, `legenda`, `autor`, `criado_em`, `usuario_id`) VALUES
(1, 'Gato programador', 'https://pbs.twimg.com/media/FSmDyTDX0BANJ5A.png', 'Quando o código não compila de primeira.', 'GatinhoCustoso123', '2025-06-03 18:44:38', 0),
(2, 'Político honesto', 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Foto_oficial_de_Luiz_In%C3%A1cio_Lula_da_Silva_%28ombros%29_denoise.jpg', 'Essa espécie está em extinção.', 'Luiz Honesto da Silva', '2025-06-03 18:46:20', 0),
(3, 'Trollface', 'https://s2.glbimg.com/CIsIPxJnEsS38B7mQ9bPq_6q-5o=/0x0:695x463/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2020/O/R/k9NvlVQ9mixSDzodczAw/trollface.jpg', 'Literalmente o trollface', 'Trollface', '2025-06-03 18:49:15', 0),
(4, 'Velocidade é tudo', 'https://i.pinimg.com/736x/46/8a/fa/468afaeccb2028649f14947b6bfb8a1c.jpg', 'O Hello Word mais rápido já existente', 'Lucas Coder', '2025-06-03 18:52:23', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `meme_tag`
--

CREATE TABLE `meme_tag` (
  `meme_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `meme_tag`
--

INSERT INTO `meme_tag` (`meme_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 3),
(3, 5),
(4, 1),
(4, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(1, 'humor'),
(2, 'gatos'),
(3, 'política'),
(4, 'tecnologia'),
(5, 'memes clássicos'),
(6, 'humor negro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(3, 'thiago', 'thiago@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `meme_id` int(11) DEFAULT NULL,
  `tipo` enum('like','dislike') DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `meme_tag`
--
ALTER TABLE `meme_tag`
  ADD PRIMARY KEY (`meme_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Índices de tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meme_id` (`meme_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `memes`
--
ALTER TABLE `memes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `meme_tag`
--
ALTER TABLE `meme_tag`
  ADD CONSTRAINT `meme_tag_ibfk_1` FOREIGN KEY (`meme_id`) REFERENCES `memes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meme_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`meme_id`) REFERENCES `memes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
