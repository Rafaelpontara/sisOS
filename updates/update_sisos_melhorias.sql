-- =====================================================
-- Sisos - Script de atualização de banco de dados
-- Melhorias: categorias hierárquicas, data entrega OS
-- =====================================================

-- Adicionar parent_id na tabela categorias (suporte a subcategorias)
ALTER TABLE `categorias` 
  ADD COLUMN IF NOT EXISTS `parent_id` INT NULL DEFAULT NULL AFTER `tipo`,
  ADD INDEX IF NOT EXISTS `fk_categorias_parent` (`parent_id` ASC);

-- Se o banco não suportar ADD COLUMN IF NOT EXISTS, usar:
-- ALTER TABLE `categorias` ADD COLUMN `parent_id` INT NULL DEFAULT NULL AFTER `tipo`;

-- Adicionar campo dataEntrega na tabela os (data prevista de entrega do aparelho)
ALTER TABLE `os`
  ADD COLUMN IF NOT EXISTS `dataEntrega` DATE NULL DEFAULT NULL AFTER `garantias_id`;

-- Verificar se as colunas foram criadas
SELECT 
  COLUMN_NAME, TABLE_NAME
FROM information_schema.COLUMNS
WHERE TABLE_NAME IN ('categorias','os')
  AND COLUMN_NAME IN ('parent_id','dataEntrega')
  AND TABLE_SCHEMA = DATABASE();

-- =====================================================
-- BLOCO 2: Campos extras para produtos
-- =====================================================
ALTER TABLE `produtos`
  ADD COLUMN IF NOT EXISTS `foto`          VARCHAR(300) NULL DEFAULT NULL AFTER `entrada`,
  ADD COLUMN IF NOT EXISTS `marca`         VARCHAR(100) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `modelo`        VARCHAR(100) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `localizacao`   VARCHAR(100) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `ncm`           VARCHAR(10)  NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `garantia_dias` INT(11)      NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `observacoes`   TEXT         NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `categorias_id` INT          NULL DEFAULT NULL;

-- =====================================================
-- BLOCO 3: Bloqueio de clientes + TAGs
-- =====================================================
ALTER TABLE `clientes`
  ADD COLUMN IF NOT EXISTS `bloqueado`      TINYINT(1)   NOT NULL DEFAULT 0 AFTER `fornecedor`,
  ADD COLUMN IF NOT EXISTS `motivo_bloqueio` VARCHAR(300) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `tag`            VARCHAR(80)  NULL DEFAULT NULL COMMENT 'Ex: Bronze, Prata, Ouro, Contrato';

-- =====================================================
-- BLOCO 4: OS – retorno garantia + situação financeira separada
-- =====================================================
ALTER TABLE `os`
  ADD COLUMN IF NOT EXISTS `os_origem_id`      INT(11) NULL DEFAULT NULL COMMENT 'ID da OS original (retorno garantia)',
  ADD COLUMN IF NOT EXISTS `situacao_financeira` VARCHAR(20) NULL DEFAULT 'pendente',
  ADD COLUMN IF NOT EXISTS `data_retirada`      DATE NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `checklist`          TEXT NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `checklist_fotos`    TEXT NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `is_recorrente`      TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `recorrencia_tipo`   VARCHAR(20) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `recorrencia_proxima` DATE NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `equipamento`        VARCHAR(150) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `numeroSerie`        VARCHAR(80)  NULL DEFAULT NULL;

-- =====================================================
-- BLOCO 5: Tabela de movimentações de estoque
-- =====================================================
CREATE TABLE IF NOT EXISTS `estoque_movimentacoes` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT,
  `produtos_id`    INT(11) NOT NULL,
  `tipo`           ENUM('entrada','saida') NOT NULL,
  `origem`         VARCHAR(40) NULL DEFAULT NULL COMMENT 'compra,venda,os,avaria,ajuste,manual',
  `origem_id`      INT(11) NULL DEFAULT NULL,
  `quantidade`     DECIMAL(10,2) NOT NULL DEFAULT 1,
  `estoque_antes`  DECIMAL(10,2) NULL,
  `estoque_depois` DECIMAL(10,2) NULL,
  `observacao`     TEXT NULL,
  `usuarios_id`    INT(11) NULL,
  `created_at`     DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_estmov_produto` (`produtos_id`),
  INDEX `idx_estmov_tipo`    (`tipo`),
  INDEX `idx_estmov_data`    (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- BLOCO 6: Tabela de avarias (baixas por avaria/perda)
-- =====================================================
CREATE TABLE IF NOT EXISTS `avarias` (
  `idAvaria`    INT(11) NOT NULL AUTO_INCREMENT,
  `produtos_id` INT(11) NOT NULL,
  `quantidade`  DECIMAL(10,2) NOT NULL DEFAULT 1,
  `motivo`      VARCHAR(255) NULL,
  `observacao`  TEXT NULL,
  `usuarios_id` INT(11) NULL,
  `data`        DATE NOT NULL,
  `created_at`  DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAvaria`),
  INDEX `idx_avaria_produto` (`produtos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- BLOCO 7: Templates de checklist de entrada
-- =====================================================
CREATE TABLE IF NOT EXISTS `checklist_templates` (
  `idChecklist` INT(11) NOT NULL AUTO_INCREMENT,
  `item`        VARCHAR(200) NOT NULL,
  `ordem`       INT(11) NULL DEFAULT 0,
  `ativo`       TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idChecklist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO `checklist_templates` (`item`, `ordem`) VALUES
('Aparelho ligando', 1),
('Tela sem trincas ou manchas', 2),
('Bateria em boas condições', 3),
('Carregador entregue', 4),
('Capa protetora entregue', 5),
('Botões funcionando', 6),
('Câmera sem danos', 7),
('Sem oxidação visível', 8),
('Acessórios conferidos', 9);

-- =====================================================
-- BLOCO 8: Tags de cliente (tabela separada)
-- =====================================================
CREATE TABLE IF NOT EXISTS `cliente_tags` (
  `idTag`    INT(11) NOT NULL AUTO_INCREMENT,
  `tag`      VARCHAR(60) NOT NULL,
  `cor`      VARCHAR(10) NULL DEFAULT '#666666',
  `descricao` VARCHAR(200) NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO `cliente_tags` (`tag`, `cor`, `descricao`) VALUES
('Bronze',   '#cd7f32', 'Plano Bronze'),
('Prata',    '#a8a9ad', 'Plano Prata'),
('Ouro',     '#ffd700', 'Plano Ouro'),
('VIP',      '#9b59b6', 'Cliente VIP'),
('Contrato', '#2980b9', 'Possui contrato ativo'),
('Bloqueado','#e74c3c', 'Cliente bloqueado');

-- =====================================================
-- BLOCO 9: Relação cliente ↔ tags
-- =====================================================
CREATE TABLE IF NOT EXISTS `clientes_tags` (
  `idClienteTag` INT(11) NOT NULL AUTO_INCREMENT,
  `clientes_id`  INT(11) NOT NULL,
  `cliente_tags_id` INT(11) NOT NULL,
  PRIMARY KEY (`idClienteTag`),
  UNIQUE KEY `unq_cli_tag` (`clientes_id`, `cliente_tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

