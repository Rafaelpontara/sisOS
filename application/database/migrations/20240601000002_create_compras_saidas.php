<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Migration_Create_compras_saidas extends CI_Migration
{
    public function up()
    {
        // Tabela de compras (entradas de estoque)
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `compras` (
              `idCompra`        INT(11) NOT NULL AUTO_INCREMENT,
              `descricao`       VARCHAR(255) NOT NULL,
              `fornecedor`      VARCHAR(255) NULL DEFAULT NULL,
              `clientes_id`     INT(11) NULL DEFAULT NULL,
              `usuarios_id`     INT(11) NOT NULL,
              `data_compra`     DATE NOT NULL,
              `data_vencimento` DATE NULL DEFAULT NULL,
              `valor_total`     DECIMAL(10,2) NOT NULL DEFAULT 0,
              `valor_pago`      DECIMAL(10,2) NOT NULL DEFAULT 0,
              `forma_pgto`      VARCHAR(100) NULL DEFAULT NULL,
              `status`          VARCHAR(30) NOT NULL DEFAULT 'pendente',
              `observacoes`     TEXT NULL,
              `nota_fiscal`     VARCHAR(255) NULL DEFAULT NULL,
              `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`idCompra`),
              KEY `fk_compras_clientes` (`clientes_id`),
              KEY `fk_compras_usuarios` (`usuarios_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        // Itens das compras (produtos comprados)
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `itens_de_compras` (
              `idItem`       INT(11) NOT NULL AUTO_INCREMENT,
              `compras_id`   INT(11) NOT NULL,
              `produtos_id`  INT(11) NULL DEFAULT NULL,
              `descricao`    VARCHAR(255) NOT NULL,
              `quantidade`   DECIMAL(10,3) NOT NULL DEFAULT 1,
              `preco_unit`   DECIMAL(10,2) NOT NULL DEFAULT 0,
              `subTotal`     DECIMAL(10,2) NOT NULL DEFAULT 0,
              PRIMARY KEY (`idItem`),
              KEY `fk_itens_compra` (`compras_id`),
              KEY `fk_itens_produto` (`produtos_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        // Tabela de saídas manuais de estoque
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `saidas_estoque` (
              `idSaida`      INT(11) NOT NULL AUTO_INCREMENT,
              `produtos_id`  INT(11) NOT NULL,
              `usuarios_id`  INT(11) NOT NULL,
              `quantidade`   DECIMAL(10,3) NOT NULL,
              `motivo`       VARCHAR(255) NOT NULL,
              `observacoes`  TEXT NULL,
              `data_saida`   DATE NOT NULL,
              `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`idSaida`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `itens_de_compras`");
        $this->db->query("DROP TABLE IF EXISTS `compras`");
        $this->db->query("DROP TABLE IF EXISTS `saidas_estoque`");
    }
}
