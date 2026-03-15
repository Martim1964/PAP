-- Schema for PAP cake shop
-- Run: mysql -u root -p < schema.sql  (or use phpMyAdmin)

CREATE DATABASE IF NOT EXISTS `pap_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `pap_db`;

-- Categorias (categories)
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bolos (cakes)
CREATE TABLE IF NOT EXISTS `bolos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `descricao` TEXT,
  `preco` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `imagem` VARCHAR(255),
  `categoria_id` INT UNSIGNED,
  `tamanho` VARCHAR(50),
  `massa` VARCHAR(100),
  `recheio` VARCHAR(100),
  `data_evento` DATE DEFAULT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX (`categoria_id`),
  CONSTRAINT `fk_bolos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contactos (messages)
CREATE TABLE IF NOT EXISTS `contactos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `assunto` VARCHAR(200),
  `mensagem` TEXT NOT NULL,
  `telefone` VARCHAR(30),
  `data_envio` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Utilizadores (users / registrations) - store password hashes only
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(80) NOT NULL,
  `email` VARCHAR(200) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(30),
  `data_registo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- (Optional) tabela de login is unnecessary if you use `utilizadores`. If you prefer separate login table, create it and reference `utilizadores.id`.

-- Carrinho (shopping cart) and items
CREATE TABLE IF NOT EXISTS `carrinho` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_carrinho_user` FOREIGN KEY (`user_id`) REFERENCES `utilizadores`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `carrinho_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `carrinho_id` INT UNSIGNED NOT NULL,
  `bolo_id` INT UNSIGNED NOT NULL,
  `quantidade` INT UNSIGNED NOT NULL DEFAULT 1,
  `preco_unitario` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_item_carrinho` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_item_bolo` FOREIGN KEY (`bolo_id`) REFERENCES `bolos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bolos personalizados (custom cakes)
CREATE TABLE IF NOT EXISTS `bolos_personalizados` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `telefone` VARCHAR(30),
  `email` VARCHAR(200),
  `tamanho` VARCHAR(50),
  `massa` VARCHAR(100),
  `recheio` VARCHAR(100),
  `data_evento` DATE DEFAULT NULL,
  `tipo_evento` VARCHAR(100),
  `observacoes` TEXT,
  `foto` VARCHAR(255),
  `data_envio` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bp_user` FOREIGN KEY (`user_id`) REFERENCES `utilizadores`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
