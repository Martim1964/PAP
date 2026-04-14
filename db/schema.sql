--
-- Database: `pap_db`
--
-- --------------------------------------------------------

--
-- Table structure for table `catalogo_bolos`
--

CREATE TABLE `catalogo_bolos` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Dumping data for table `catalogo_bolos`
--
INSERT INTO `catalogo_bolos` (`id`, `slug`, `nome`, `descricao`, `imagem`, `categoria_id`, `ativo`) VALUES
(1, 'bolo-avos', 'Bolo de Avós', 'Um bolo especial dedicado aos avós.', 'img-pap/nossos-bolos/aniversario/bolo-avós-aniv.jpg', 1, 1),
(2, 'bolo-camisa', 'Bolo Camisa', 'Perfeito para os apaixonados por futebol.', 'img-pap/nossos-bolos/aniversario/bolo-camisa-aniv.jpg', 1, 1),
(3, 'bolo-cars', 'Bolo Cars', 'Bolo inspirado no filme Cars.', 'img-pap/nossos-bolos/aniversario/bolo-cars-aniv.jpg', 1, 1),
(4, 'bolo-conchas', 'Bolo Conchas', 'Bolo decorado com conchas.', 'img-pap/nossos-bolos/aniversario/bolo-conchas-aniv.jpg', 1, 1),
(5, 'bolo-panda', 'Bolo Panda', 'Fofíssimo bolo panda.', 'img-pap/nossos-bolos/aniversario/bolo-panda-aniv.jpg', 1, 1),
(6, 'bolo-pasteleiro', 'Bolo Pasteleiro', 'Clássico bolo pasteleiro.', 'img-pap/nossos-bolos/aniversario/bolo-pasteleiro-aniv.jpg', 1, 1),
(7, 'bolo-praia', 'Bolo Praia', 'Bolo com tema de praia.', 'img-pap/nossos-bolos/aniversario/bolo-praia-aniv.jpg', 1, 1),
(8, 'bolo-rosa', 'Bolo Rosa', 'Bolo rosa delicado.', 'img-pap/nossos-bolos/aniversario/bolo-rosa-aniv.jpg', 1, 1),
(9, 'bolo-sofa', 'Bolo Sofá', 'Confortável bolo sofá.', 'img-pap/nossos-bolos/aniversario/bolo-sofa-aniv.jpg', 1, 1),
(10, 'bolo-sonic', 'Bolo Sonic', 'Bolo do velocíssimo Sonic.', 'img-pap/nossos-bolos/aniversario/bolo-sonic-aniv.jpg', 1, 1),
(11, 'bolo-batismo', 'Bolo Batismo', 'Um bolo especial dedicado aos batismos.', 'img-pap/nossos-bolos/batizado/bolo-batismo-bat.jfif', 3, 1),
(12, 'bolo-1comunhao', 'Bolo 1ª Comunhão', 'Um bolo especial para a primeira comunhão.', 'img-pap/nossos-bolos/batizado/bolo-1ºcomunhão-bat.jfif', 3, 1),
(13, 'bolo-baloico', 'Bolo Baloiço', 'Um bolo temático de baloiço.', 'img-pap/nossos-bolos/batizado/bolo-baloiço-bat.jfif', 3, 1),
(14, 'bolo-aliancas', 'Bolo Alianças', 'Um bolo elegante com tema de alianças.', 'img-pap/nossos-bolos/casamento/bolo-aliancas-cas.jpg', 2, 1),
(15, 'bolo-bodas-diamante', 'Bolo Bodas de Diamante', 'Bolo especial para bodas de diamante.', 'img-pap/nossos-bolos/casamento/bolo-bodas-diamante-cas.jpg', 2, 1),
(16, 'bolo-flores', 'Bolo Flores', 'Bolo decorado com flores delicadas.', 'img-pap/nossos-bolos/casamento/bolo-flores-cas.jpg', 2, 1),
(17, 'bolo-flores-comestiveis', 'Bolo Flores Comestíveis', 'Bolo com flores comestíveis.', 'img-pap/nossos-bolos/casamento/bolo-flores-comestiveis-cas.jpg', 2, 1),
(18, 'bolachas-natal', 'Bolachas Natal', 'Deliciosas bolachas natalícias.', 'img-pap/nossos-bolos/cupcakes/bolachas-natal.jpg', 4, 1),
(19, 'bolachas-panda', 'Bolachas Panda', 'Bolachas temáticas de panda.', 'img-pap/nossos-bolos/cupcakes/bolachas-panda.jpg', 4, 1),
(20, 'mini-brigadeiros', 'Mini Brigadeiros', 'Mini brigadeiros deliciosos.', 'img-pap/nossos-bolos/cupcakes/mini-brigadeiros.jpg', 4, 1),
(21, 'brigadeiro-chocolate', 'Brigadeiro Chocolate', 'Clássico brigadeiro de chocolate.', 'img-pap/nossos-bolos/cupcakes/brigadeiro-chocolate.jpg', 4, 1),
(22, 'torta-chocolate', 'Torta de Chocolate', 'Torta rica em chocolate.', 'img-pap/nossos-bolos/cupcakes/torta-chocolate.jpg', 4, 1),
(23, 'torta-laranja', 'Torta de Laranja', 'Torta refrescante de laranja.', 'img-pap/nossos-bolos/cupcakes/torta-laranja.jpg', 4, 1),
(24, 'bolo-bolacha', 'Bolo Bolacha', 'Delicioso bolo de bolacha.', 'img-pap/nossos-bolos/cupcakes/bolo-bolacha.jpg', 4, 1),
(25, 'torre-choux', 'Torre de Choux', 'Elegante torre de choux.', 'img-pap/nossos-bolos/cupcakes/bolo-ar-gri-est-4.jpg', 4, 1);
-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(50) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `slug`, `nome`) VALUES
(1, 'aniversario', 'Aniversário'),
(2, 'casamento', 'Casamento'),
(3, 'batizado', 'Batizado'),
(4, 'cupcakes', 'Cupcakes e Doces');

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `assunto` varchar(200) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encomendas`
--

CREATE TABLE `encomendas` (
  `id` int(10) UNSIGNED NOT NULL,
  `utilizador_id` int(10) UNSIGNED NOT NULL,
  `bolo_slug` varchar(100) NOT NULL,
  `bolo_nome` varchar(150) NOT NULL,
  `tamanho_slug` varchar(30) NOT NULL,
  `tamanho_label` varchar(100) NOT NULL,
  `massa_slug` varchar(30) DEFAULT NULL,
  `massa_label` varchar(100) DEFAULT NULL,
  `recheio_slug` varchar(30) DEFAULT NULL,
  `recheio_label` varchar(100) DEFAULT NULL,
  `data_evento` date NOT NULL,
  `observacoes` text DEFAULT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` enum('pendente','confirmada','pronta','entregue','cancelada') NOT NULL DEFAULT 'pendente',
  `data_encomenda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `massas`
--

CREATE TABLE `massas` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `massas`
--

INSERT INTO `massas` (`id`, `slug`, `label`, `preco`, `premium`) VALUES
(1, 'baunilha', 'Baunilha', 0.00, 0),
(2, 'laranja_canela', 'Laranja e Canela', 0.00, 0),
(3, 'papoila_limao', 'Papoila e Limão', 0.00, 0),
(4, 'chocolate', 'Chocolate Negro', 10.00, 1),
(5, 'red_velvet', 'Red Velvet', 12.00, 1),
(6, 'cenoura', 'Laranja e Amêndoa', 8.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recheios`
--

CREATE TABLE `recheios` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recheios`
--

INSERT INTO `recheios` (`id`, `slug`, `label`, `preco`, `premium`) VALUES
(1, 'caramelo', 'Caramelo Salgado', 0.00, 0),
(2, 'morango', 'Curd de Morango', 0.00, 0),
(3, 'limao', 'Curd de Limão', 0.00, 0),
(4, 'creamcheese', 'Cream Cheese Laranja', 0.00, 0),
(5, 'brigadeiro', 'Brigadeiro Negro', 8.00, 1),
(6, 'mascarpone', 'Mascarpone', 10.00, 1),
(7, 'framboesa', 'Ganache Framboesa', 12.00, 1),
(8, 'maracuja', 'Ganache Maracujá', 12.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tamanhos`
--

CREATE TABLE `tamanhos` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `ordem` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanhos`
--

INSERT INTO `tamanhos` (`id`, `slug`, `label`, `preco`, `ordem`) VALUES
(1, 'pequeno', 'Pequeno (10-12 pessoas)', 25.00, 1),
(2, 'medio', 'Médio (13-16 pessoas)', 35.00, 2),
(3, 'grande', 'Grande (17-20 pessoas)', 50.00, 3),
(4, 'muito_grande', 'Muito Grande (20+ pessoas)', 70.00, 4);

-- --------------------------------------------------------

--
-- Table structure for table `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_registo` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catalogo_bolos`
--
ALTER TABLE `catalogo_bolos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_bolo_categoria` (`categoria_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enc_utilizador` (`utilizador_id`);

--
-- Indexes for table `massas`
--
ALTER TABLE `massas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `recheios`
--
ALTER TABLE `recheios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `tamanhos`
--
ALTER TABLE `tamanhos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catalogo_bolos`
--
ALTER TABLE `catalogo_bolos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `massas`
--
ALTER TABLE `massas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recheios`
--
ALTER TABLE `recheios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tamanhos`
--
ALTER TABLE `tamanhos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catalogo_bolos`
--
ALTER TABLE `catalogo_bolos`
  ADD CONSTRAINT `fk_bolo_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Constraints for table `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `fk_enc_utilizador` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);
COMMIT;

