
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
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
(2, 'bolo-camisa', 'Bolo Camisa', 'Perfeito para quem anda sempre de camisa.', 'img-pap/nossos-bolos/aniversario/bolo-camisa-aniv.jpg', 1, 1),
(3, 'bolo-cars', 'Bolo Cars', 'Bolo inspirado no filme Cars.', 'img-pap/nossos-bolos/aniversario/bolo-cars-aniv.jpg', 1, 1),
(4, 'bolo-conchas', 'Bolo Conchas', 'Bolo decorado com conchas.', 'img-pap/nossos-bolos/aniversario/bolo-conchas-aniv.jpg', 1, 1),
(5, 'bolo-panda', 'Bolo Panda', 'Fofíssimo bolo panda.', 'img-pap/nossos-bolos/aniversario/bolo-panda-aniv.jpg', 1, 1),
(6, 'bolo-pasteleiro', 'Bolo Pasteleiro', 'Clássico bolo pasteleiro.', 'img-pap/nossos-bolos/aniversario/bolo-pasteleiro-aniv.jpg', 1, 1),
(7, 'bolo-praia', 'Bolo Praia', 'Bolo com tema de praia.', 'img-pap/nossos-bolos/aniversario/bolo-praia-aniv.jpg', 1, 0),
(8, 'bolo-rosa', 'Bolo Rosa', 'Bolo rosa delicado.', 'img-pap/nossos-bolos/aniversario/bolo-rosa-aniv.jpg', 1, 0),
(9, 'bolo-sofa', 'Bolo Sofá', 'Confortável bolo sofá.', 'img-pap/nossos-bolos/aniversario/bolo-sofa-aniv.jpg', 1, 1),
(10, 'bolo-sonic', 'Bolo Sonic', 'Bolo do velocíssimo Sonic.', 'img-pap/nossos-bolos/aniversario/bolo-sonic-aniv.jpg', 1, 0),
(11, 'bolo-batismo', 'Bolo Batismo', 'Um bolo especial dedicado aos batismos.', 'img-pap/nossos-bolos/batizado/bolo-batismo-bat.jfif', 3, 1),
(12, 'bolo-1comunhao', 'Bolo 1ª Comunhão', 'Um bolo especial para a primeira comunhão.', 'img-pap/nossos-bolos/batizado/bolo-1ºcomunhão-bat.jfif', 3, 1),
(13, 'bolo-baloico', 'Bolo Baloiço', 'Um bolo temático de baloiço.', 'img-pap/nossos-bolos/batizado/bolo-baloiço-bat.jfif', 3, 1),
(14, 'bolo-aliancas', 'Bolo Alianças', 'Um bolo elegante com tema de alianças.', 'img-pap/nossos-bolos/casamento/bolo-aliancas-cas.jpg', 2, 0),
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
(25, 'torre-choux', 'Torre de Choux', 'Elegante torre de choux.', 'img-pap/nossos-bolos/cupcakes/bolo-ar-gri-est-4.jpg', 4, 0),
(26, 'cupcake-doces-dias', 'Cupcake Doces Dias', 'Cupcakes com os nossos melhores ingredientes.', 'img-pap/nossos-bolos/cupcakes_93722_16x9.png', 4, 0),
(27, 'bolo_angry', 'Bolo Angry Bird', 'Bolo especial com boneco angry bird', 'img-pap/nossos-bolos/489959573_1142637984543047_8460307170847270582_n.jpg', 1, 0);

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
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendente','respondido') NOT NULL DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `nome`, `email`, `telefone`, `assunto`, `mensagem`, `data_envio`, `estado`) VALUES
(1, 'Tininho dos Olivais', 'martimdias123@gmail.com', '915838770', 'Quero comprar', 'brtefesnkev', '2026-03-23 15:57:03', 'pendente'),
(2, 'Martim Dias', 'martimdias889@gmail.com', '915838770', 'Quero comprar', 'vewfvetfvse', '2026-03-23 16:02:58', 'respondido'),
(3, 'Tininho dos Olivais', 'martimdias123@gmail.com', '915838770', 'Quero comprar', 'sfefgbrrtdgb', '2026-03-23 16:03:52', 'pendente'),
(4, 'Tininho dos Olivais', 'martimdias123@gmail.com', '915838770', 'Quero comprar', 'vt4ebfhtbgv', '2026-03-23 16:10:28', 'pendente'),
(5, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'Quero comprar', 'vhhhhgbn', '2026-04-06 15:44:07', 'pendente'),
(6, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'Quero fazer uma encomenda', 'Ola eu gostava de fazer uma encomenda so que preciso de saber uma informacao. Como faco para trabalhar essa encomenda', '2026-04-08 10:39:09', 'pendente'),
(7, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'a', 'hjkn', '2026-04-08 10:44:03', 'respondido'),
(8, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'a', 'hjkn', '2026-04-08 10:44:27', 'pendente'),
(9, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'Quero comprar', 'vjhvb', '2026-04-08 20:13:55', 'respondido'),
(10, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'Quero comprar', 'bnn', '2026-04-08 20:15:59', 'pendente'),
(11, 'Martim Dias', 'martimdias2358@gmail.com', '915838770', 'Quero comprar ', 'hetfdhtrhdtr', '2026-04-17 12:46:51', 'pendente');

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

--
-- Dumping data for table `encomendas`
--

INSERT INTO `encomendas` (`id`, `utilizador_id`, `bolo_slug`, `bolo_nome`, `tamanho_slug`, `tamanho_label`, `massa_slug`, `massa_label`, `recheio_slug`, `recheio_label`, `data_evento`, `observacoes`, `quantidade`, `preco_unitario`, `preco_total`, `iva`, `estado`, `data_encomenda`) VALUES
(15, 6, 'bolo-bolacha', 'Bolo Bolacha', 'grande', 'Tamanho Familiar', '', '', '', '', '2026-04-30', '', 1, 40.00, 40.00, 9.20, 'cancelada', '2026-04-02 18:09:01'),
(16, 6, 'bolachas-panda', 'Bolachas Panda', 'muito_grande', 'Pack 50 unidades', '', '', '', '', '2026-04-30', '', 1, 70.00, 70.00, 16.10, 'confirmada', '2026-04-02 18:09:01'),
(20, 2, 'bolo-avos', 'Bolo de Avós', 'grande', 'Grande (17-20 pessoas)', 'red_velvet', 'Red Velvet', 'brigadeiro', 'Brigadeiro Negro', '2026-04-30', '', 1, 70.00, 70.00, 16.10, 'confirmada', '2026-04-03 10:46:59'),
(21, 2, 'bolo-aliancas', 'Bolo Alianças', 'muito_grande', 'Muito Grande (20+ pessoas)', 'red_velvet', 'Red Velvet', 'framboesa', 'Ganache Framboesa', '2026-04-30', '', 1, 94.00, 94.00, 21.62, 'confirmada', '2026-04-06 15:53:33'),
(22, 2, 'bolo-bodas-diamante', 'Bolo Bodas de Diamante', 'muito_grande', 'Muito Grande (20+ pessoas)', 'laranja_canela', 'Laranja e Canela', 'morango', 'Curd de Morango', '2026-04-30', '', 1, 70.00, 70.00, 16.10, 'confirmada', '2026-04-06 15:54:25'),
(23, 2, 'bolo-cars', 'Bolo Cars', 'muito_grande', 'Muito Grande (20+ pessoas)', 'baunilha', 'Baunilha', 'caramelo', 'Caramelo Salgado', '2026-04-30', '', 1, 70.00, 70.00, 16.10, 'confirmada', '2026-04-06 15:55:25'),
(24, 2, 'bolo-praia', 'Bolo Praia', 'medio', 'Médio (13-16 pessoas)', 'chocolate', 'Chocolate Negro', 'brigadeiro', 'Brigadeiro Negro', '2026-04-30', '', 1, 53.00, 53.00, 12.19, 'confirmada', '2026-04-06 15:56:03'),
(25, 2, 'bolo-sofa', 'Bolo Sofá', 'medio', 'Médio (13-16 pessoas)', 'chocolate', 'Chocolate Negro', 'framboesa', 'Ganache Framboesa', '2026-04-30', '', 1, 57.00, 57.00, 13.11, 'confirmada', '2026-04-06 15:56:43'),
(26, 2, 'bolo-bolacha', 'Bolo Bolacha', 'grande', 'Tamanho Familiar', '', '', '', '', '2026-04-30', '', 1, 40.00, 40.00, 9.20, 'confirmada', '2026-04-06 15:57:55'),
(27, 2, 'bolo-bodas-diamante', 'Bolo Bodas de Diamante', 'muito_grande', 'Muito Grande (50+ pess.)', 'red_velvet', 'Red Velvet', 'mascarpone', 'Mascarpone', '2026-04-30', '', 1, 167.00, 167.00, 38.41, 'confirmada', '2026-04-08 10:07:24'),
(28, 5, 'bolo-cars', 'Bolo Cars', 'grande', 'Grande (15-25 pess.)', 'laranja_canela', 'Laranja e Canela', 'limao', 'Curd de Limão', '2026-04-30', '', 1, 70.00, 70.00, 16.10, 'confirmada', '2026-04-14 18:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `encomendas_personalizadas`
--

CREATE TABLE `encomendas_personalizadas` (
  `id` int(11) NOT NULL,
  `utilizador_id` int(11) NOT NULL,
  `tamanho` varchar(50) NOT NULL,
  `massa` varchar(50) DEFAULT NULL,
  `recheio` varchar(50) DEFAULT NULL,
  `data_evento` date NOT NULL,
  `tema` varchar(50) DEFAULT NULL,
  `observacoes` varchar(10000) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Pendente',
  `imagem` varchar(255) DEFAULT NULL,
  `data_encomenda_personalizada` timestamp NOT NULL DEFAULT current_timestamp(),
  `tamanho_final` varchar(255) DEFAULT NULL,
  `massa_final` varchar(255) DEFAULT NULL,
  `recheio_final` varchar(255) DEFAULT NULL,
  `quantidade_final` int(11) DEFAULT 1,
  `data_evento_final` date DEFAULT NULL,
  `preco_unit` decimal(10,2) DEFAULT 0.00,
  `preco_total` decimal(10,2) DEFAULT 0.00,
  `iva` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `encomendas_personalizadas`
--

INSERT INTO `encomendas_personalizadas` (`id`, `utilizador_id`, `tamanho`, `massa`, `recheio`, `data_evento`, `tema`, `observacoes`, `estado`, `imagem`, `data_encomenda_personalizada`, `tamanho_final`, `massa_final`, `recheio_final`, `quantidade_final`, `data_evento_final`, `preco_unit`, `preco_total`, `iva`) VALUES
(7, 2, 'muito_grande', 'chocolate', 'brigadeiro', '2026-04-30', 'aniversario', 'Quero como nome do bolo, o meu nome de cliente: Martim', 'confirmada', 'bolo-personalizador.png', '2026-04-06 12:08:21', 'Muito Grande (+20 pessoas)', 'Red Velvet', 'Ganache Framboesa', 2, '2026-04-30', 88.00, 176.00, 40.48),
(8, 2, 'muito_grande', 'red_velvet', 'framboesa', '2026-04-30', 'aniversario', '', 'confirmada', 'nome-personalizado-da-estrela-do-topo-do-bolo.png', '2026-04-06 12:24:04', 'Muito Grande (+20 pessoas)', '', '', 5, '2026-04-30', 77.00, 385.00, 88.55),
(9, 2, 'pequeno', '', '', '2026-04-24', 'outro', '', 'confirmada', 'cupcakes_93722_16x9.png', '2026-04-06 13:06:03', 'Muito Grande (+20 pessoas)', '', '', 2, '2026-04-21', 45.00, 90.00, 20.70),
(12, 5, 'pequeno', '', '', '2026-04-25', 'outro', '', 'confirmada', 'cupcakes_93722_16x9.png', '2026-04-16 09:55:41', '', '', '', 1, '0000-00-00', 60.00, 60.00, 13.80),
(13, 7, 'medio', '', '', '2026-04-30', 'aniversario', 'quero um bolo retroespecial', 'Pendente', NULL, '2026-04-17 15:53:37', NULL, NULL, NULL, 1, NULL, 0.00, 0.00, 0.00),
(14, 1, 'grande', 'chocolate', 'limao', '2026-05-28', 'outro', '', 'confirmada', NULL, '2026-04-24 11:23:47', 'Muito Grande (+40 pessoas)', 'Red Velvet', 'Ganache Framboesa', 1, '0000-00-00', 120.00, 120.00, 27.60);

-- --------------------------------------------------------

--
-- Table structure for table `informacoes`
--

CREATE TABLE `informacoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `conteudo` text NOT NULL,
  `ordem` int(11) DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informacoes`
--

INSERT INTO `informacoes` (`id`, `nome`, `conteudo`, `ordem`, `ativo`) VALUES
(1, 'Transporte de forma segura', 'Para que o seu bolo chegue ao destino em condições impecáveis, recomendamos que o transporte seja feito sobre uma superfície plana e estável. O local mais seguro é o chão do banco da frente do lado direito (banco do pendura). Mantenha uma condução defensiva, evitando travagens bruscas e curvas a alta velocidade, utilize o ar condicionado em dias quentes.', 7, 1),
(2, 'Método de pagamento', 'Para facilitar o seu pagamento de forma segura, o mesmo é feito exclusivamente via cartão bancário', 8, 1),
(3, 'Prazos de Encomenda', 'Para garantirmos o detalhe que cada projeto exige, recomendamos que realize a sua reserva com uma antecedência mínima de 15 dias. Aceitamos encomendas até ao limite máximo de 7 dias antes da data pretendida, mediante disponibilidade de agenda.', 5, 1),
(4, 'Alergias Alimentares', 'A nossa prioridade é a sua segurança. Dispomos de receitas adaptadas, incluindo opções sem glúten. Contudo, informamos que os produtos são confecionados num ambiente onde se manipulam alergénios. Indique qualquer intolerância no campo de \"Observações\" ao encomendar.', 1, 1),
(5, 'Alterações e cancelamentos', 'O prazo para alterações e cancelamentos varia consoante o tipo de bolo encomendado, no entanto o prazo mínimo é sempre de 7 dias antes da data do evento. Após este prazo poderá não ser possível garantir qualquer alteração ou reembolso.', 9, 1),
(6, 'Personalização', 'Na Doces Dias, transformamos as suas ideias em sabor. Pode definir a massa, o recheio e enviar uma foto de referência. Após a submissão, a nossa equipa entrará em contacto para validar detalhes e apresentar o orçamento final.', 6, 1),
(7, 'Nova Info', 'Info de teste', 10, 0),
(12, 'teste', '', 2, 0),
(13, 'bdfbef', '', 3, 0),
(14, 'bdfbef', '', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `massas`
--

CREATE TABLE `massas` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `premium` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `massas`
--

INSERT INTO `massas` (`id`, `slug`, `label`, `preco`, `premium`, `ativo`) VALUES
(1, 'baunilha', 'Baunilha', 0.00, 0, 1),
(2, 'laranja_canela', 'Laranja e Canela', 0.00, 0, 1),
(3, 'papoila_limao', 'Papoila e Limão', 0.00, 0, 1),
(4, 'chocolate', 'Chocolate Negro', 10.00, 1, 1),
(5, 'red_velvet', 'Red Velvet', 12.00, 1, 1),
(6, 'cenoura', 'Laranja e Amêndoa', 8.00, 1, 1),
(7, 'cacau', 'Cacau', 12.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters_enviadas`
--

CREATE TABLE `newsletters_enviadas` (
  `id` int(11) NOT NULL,
  `assunto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensagem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletters_enviadas`
--

INSERT INTO `newsletters_enviadas` (`id`, `assunto`, `mensagem`, `data_envio`) VALUES
(20, 'teste', 'R5Y4HTEFD', '2026-04-17 16:29:26'),
(21, 'MHMFBVNBD', 'VB FDCXVGVFC', '2026-04-17 16:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscritores`
--

CREATE TABLE `newsletter_subscritores` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_subscricao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter_subscritores`
--

INSERT INTO `newsletter_subscritores` (`id`, `email`, `data_subscricao`, `ativo`) VALUES
(1, 'martimdias2358@gmail.com', '2026-04-08 11:10:46', 0),
(11, 'tininho.dias@outlook.com', '2026-04-09 15:02:37', 1),
(12, 'Tininho@gmail.com', '2026-04-17 14:41:25', 1),
(13, 'martimdias123@gmail.com', '2026-04-24 11:12:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recheios`
--

CREATE TABLE `recheios` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `premium` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recheios`
--

INSERT INTO `recheios` (`id`, `slug`, `label`, `preco`, `premium`, `ativo`) VALUES
(1, 'caramelo', 'Caramelo Salgado', 0.00, 0, 1),
(2, 'morango', 'Curd de Morango', 0.00, 0, 1),
(3, 'limao', 'Curd de Limão', 0.00, 0, 1),
(4, 'creamcheese', 'Cream Cheese Laranja', 0.00, 0, 1),
(5, 'brigadeiro', 'Brigadeiro Negro', 8.00, 1, 1),
(6, 'mascarpone', 'Mascarpone', 10.00, 1, 1),
(7, 'framboesa', 'Ganache Framboesa', 12.00, 1, 1),
(8, 'maracuja', 'Ganache Maracujá', 12.00, 1, 1),
(9, 'banana', 'Curd de Banana', 6.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tamanhos_produtos`
--

CREATE TABLE `tamanhos_produtos` (
  `id` int(10) UNSIGNED NOT NULL,
  `bolo_slug` varchar(100) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `label` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `ordem` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanhos_produtos`
--

INSERT INTO `tamanhos_produtos` (`id`, `bolo_slug`, `slug`, `label`, `preco`, `ordem`, `ativo`) VALUES
(1, 'bolachas-natal', 'pack_6', 'Pack 6 unidades', 20.00, 1, 1),
(2, 'bolachas-natal', 'pack_14', 'Pack 14 unidades', 40.00, 2, 1),
(3, 'bolachas-natal', 'pack_28', 'Pack 28 unidades', 55.00, 3, 1),
(4, 'bolachas-natal', 'pack_50', 'Pack 50 unidades', 70.00, 4, 1),
(5, 'bolachas-panda', 'pack_6', 'Pack 6 unidades', 25.00, 1, 1),
(6, 'bolachas-panda', 'pack_14', 'Pack 14 unidades', 45.00, 2, 1),
(7, 'bolachas-panda', 'pack_28', 'Pack 28 unidades', 60.00, 3, 1),
(8, 'bolachas-panda', 'pack_50', 'Pack 50 unidades', 75.00, 4, 1),
(9, 'mini-brigadeiros', 'pack_6', 'Pack 6 unidades', 10.00, 1, 1),
(10, 'mini-brigadeiros', 'pack_14', 'Pack 14 unidades', 20.00, 2, 1),
(11, 'mini-brigadeiros', 'pack_28', 'Pack 28 unidades', 35.00, 3, 1),
(12, 'mini-brigadeiros', 'pack_50', 'Pack 50 unidades', 50.00, 4, 1),
(13, 'brigadeiro-chocolate', 'normal', 'Tamanho Normal', 15.00, 1, 1),
(14, 'brigadeiro-chocolate', 'familiar', 'Tamanho Familiar', 30.00, 2, 1),
(15, 'bolo-bolacha', 'normal', 'Tamanho Normal', 20.00, 1, 1),
(16, 'bolo-bolacha', 'familiar', 'Tamanho Familiar', 35.00, 2, 1),
(17, 'torta-chocolate', 'normal', 'Tamanho Normal', 25.00, 1, 1),
(18, 'torta-chocolate', 'familiar', 'Tamanho Familiar', 40.00, 2, 1),
(19, 'torta-laranja', 'normal', 'Tamanho Normal', 25.00, 1, 1),
(20, 'torta-laranja', 'familiar', 'Tamanho Familiar', 40.00, 2, 1),
(54, 'bolo-avos', 'pequeno', 'Pequeno (10-12 pess.)', 35.00, 1, 1),
(55, 'bolo-avos', 'medio', 'Médio (13-16 pess.)', 50.00, 2, 1),
(56, 'bolo-avos', 'grande', 'Grande (17-20 pess.)', 70.00, 3, 1),
(57, 'bolo-camisa', 'pequeno', 'Pequeno (10-12 pess.)', 27.00, 1, 1),
(58, 'bolo-camisa', 'medio', 'Médio (13-16 pess.)', 38.00, 2, 1),
(59, 'bolo-camisa', 'grande', 'Grande (17-20 pess.)', 50.00, 3, 1),
(60, 'bolo-cars', 'grande', 'Grande (15-25 pess.)', 70.00, 3, 1),
(61, 'bolo-cars', 'muito_grande', 'Muito Grande (25+ pess.)', 95.00, 4, 1),
(62, 'bolo-conchas', 'pequeno', 'Pequeno (10-12 pess.)', 30.00, 1, 1),
(63, 'bolo-conchas', 'medio', 'Médio (13-16 pess.)', 40.00, 2, 1),
(64, 'bolo-conchas', 'grande', 'Grande (17-20 pess.)', 55.00, 3, 1),
(65, 'bolo-panda', 'pequeno', 'Pequeno (10-12 pess.)', 45.00, 1, 1),
(66, 'bolo-panda', 'medio', 'Médio (13-16 pess.)', 60.00, 2, 1),
(67, 'bolo-panda', 'grande', 'Grande (17-20 pess.)', 72.50, 3, 1),
(68, 'bolo-panda', 'muito_grande', 'Muito Grande (25+ pess.)', 85.00, 4, 1),
(69, 'bolo-pasteleiro', 'pequeno', 'Pequeno (10-12 pess.)', 37.50, 1, 1),
(70, 'bolo-pasteleiro', 'medio', 'Médio (13-16 pess.)', 53.00, 2, 1),
(71, 'bolo-pasteleiro', 'grande', 'Grande (17-20 pess.)', 65.00, 3, 1),
(72, 'bolo-pasteleiro', 'muito_grande', 'Muito Grande (25+ pess.)', 77.00, 4, 1),
(73, 'bolo-sofa', 'pequeno', 'Pequeno (10-12 pess.)', 40.00, 1, 1),
(74, 'bolo-sofa', 'medio', 'Médio (13-16 pess.)', 70.00, 2, 1),
(75, 'bolo-1comunhao', 'grande', 'Grande (15-30 pess.)', 80.00, 3, 1),
(76, 'bolo-1comunhao', 'muito_grande', 'Muito Grande (30+ pess.)', 115.00, 4, 1),
(77, 'bolo-baloico', 'grande', 'Grande (20-35 pess.)', 110.00, 3, 1),
(78, 'bolo-baloico', 'muito_grande', 'Muito Grande (35+ pess.)', 140.00, 4, 1),
(79, 'bolo-batismo', 'grande', 'Grande (15-25 pess.)', 65.00, 3, 1),
(80, 'bolo-batismo', 'muito_grande', 'Muito Grande (25+ pess.)', 92.50, 4, 1),
(81, 'bolo-bodas-diamante', 'grande', 'Grande (30-50 pess.)', 120.00, 3, 1),
(82, 'bolo-bodas-diamante', 'muito_grande', 'Muito Grande (50+ pess.)', 145.00, 4, 1),
(83, 'bolo-flores', 'grande', 'Grande (20-40 pess.)', 105.00, 3, 1),
(84, 'bolo-flores', 'muito_grande', 'Muito Grande (40+ pess.)', 125.00, 4, 1),
(85, 'bolo-flores-comestiveis', 'grande', 'Grande (40-60 pess.)', 135.00, 3, 1),
(86, 'bolo-flores-comestiveis', 'muito_grande', 'Muito Grande (60+ pess.)', 165.00, 4, 1),
(87, 'cupcake-doces-dias', 'pack_6', 'Pack 6 unidades', 15.00, 1, 1),
(88, 'cupcake-doces-dias', 'pack_12', 'Pack 12 unidades', 28.00, 2, 1),
(89, 'ebtfdxbtrs', 'pack_6', 'Pack 6 unidades', 12.00, 1, 1),
(90, 'bolo_angry', 'tamanho_unico', '15+ pessoas', 67.00, 1, 1);

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
  `reset_token_expires_at` datetime DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome`, `email`, `pass`, `telefone`, `data_nascimento`, `data_registo`, `reset_token_hash`, `reset_token_expires_at`, `admin`, `ativo`) VALUES
(1, 'Tininho dos Olivais', 'martimdias123@gmail.com', '$2y$10$O7VmmUviYZxNXTWbcG4skeJLj/eOd61aOcn8sXBTgV5XqZwklBYRm', '915838770', '2007-07-24', '2026-03-23 15:58:40', '27a978e8d60538f538c83f1cd898c789252b722970b188c8e32f637e9bb5de44', '2026-03-25 21:48:27', 0, 1),
(2, 'Martim Dias', 'martimdias2358@gmail.com', '$2y$10$Qfftv/JnbGTQfcjSA7IwwuhyACb4snUHlqNHBzqlrTdYJqfh4BFsG', '915838770', NULL, '2026-03-25 20:19:31', 'a06774f70ab7ea28f12f27b391d55ad6aa7dff9fb9d6c21a2e0669a35c1aa0d2', '2026-04-27 19:59:29', 1, 1),
(5, 'Martim Dias', 'martimdias347@gmail.com', '$2y$10$k7WcDL9nIr/88KZ3mNiqYu9XlK5s8JR0wloYSGryZj8grnKnYRWl6', '915838770', '2007-04-16', '2026-04-01 17:22:24', NULL, NULL, 0, 1),
(6, 'Tininho dos Olivais', 'martimdias1800@gmail.com', '$2y$10$QvzFwBu2pmVQHtNzd3pvpenaJmILiFaEIoSSN5kblPuAdyxlBXvPO', '915838770', '2007-07-24', '2026-04-02 16:19:48', NULL, NULL, 0, 0),
(7, 'Martim', 'tininho.dias@outlook.com', '$2y$10$ojnOF2R9alPHqRhLA.F8/eaO112X8olja0O6sq.a4OBXS65xeXsU6', '911234567', '2026-04-25', '2026-04-08 21:17:12', NULL, NULL, 1, 1),
(8, 'Doces Dias Test1', 'docesdias@teste1.com', '$2y$10$j4Qf6HH2FjslJ74cLKTfaOBZjEheZ3DpCOVRVNtbIKvx17g6DZMM6', '915838770', '2026-04-30', '2026-04-14 18:06:58', NULL, NULL, 1, 1),
(16, 'Tininho Test', 'Tininho@gmail.com', '$2y$10$jClX3BKaA1x45X81yifnL.rp3t/vrrlN0vsrea1mPDTxOWPy2dSTK', '995838770', '2007-07-24', '2026-04-15 17:21:49', NULL, NULL, 0, 1),
(17, 'Martim Dias', 'martim13@gmail.com', '$2y$10$47IFljnQ.hMLQa2obdgx8Ofzpv9prdivF2v5IUIvG2UVrolzgJbNe', '9 158 387 70', '2013-04-15', '2026-04-17 16:12:59', NULL, NULL, 0, 1),
(18, 'Tininho dos Olivais', 'rgdszvsfd@bdsfj.com', '$2y$10$kVCKEPLeGe8E6is.6dO4..b97jN0/dFbhVRiBdZg6lG9QOgZG6/Jq', '915838770', '2013-04-17', '2026-04-17 16:15:04', NULL, NULL, 0, 1);

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
-- Indexes for table `encomendas_personalizadas`
--
ALTER TABLE `encomendas_personalizadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informacoes`
--
ALTER TABLE `informacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `massas`
--
ALTER TABLE `massas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `newsletters_enviadas`
--
ALTER TABLE `newsletters_enviadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscritores`
--
ALTER TABLE `newsletter_subscritores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `recheios`
--
ALTER TABLE `recheios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `tamanhos_produtos`
--
ALTER TABLE `tamanhos_produtos`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `encomendas_personalizadas`
--
ALTER TABLE `encomendas_personalizadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `informacoes`
--
ALTER TABLE `informacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `massas`
--
ALTER TABLE `massas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `newsletters_enviadas`
--
ALTER TABLE `newsletters_enviadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `newsletter_subscritores`
--
ALTER TABLE `newsletter_subscritores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `recheios`
--
ALTER TABLE `recheios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tamanhos_produtos`
--
ALTER TABLE `tamanhos_produtos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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


