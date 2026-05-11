<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Migration_Add_logo_favicon_to_configuracoes extends CI_Migration
{
    public function up()
    {
        // Ampliar o campo config para suportar chaves maiores
        $this->db->query("ALTER TABLE `configuracoes` MODIFY COLUMN `config` VARCHAR(60) NOT NULL");

        // Inserir configurações de logo e favicon
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('app_logo', '')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('app_favicon', '')");

        // Inserir configurações da Focus NF-e
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_enabled', '0')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_provider', 'focusnfe')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_ambiente', 'homologacao')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_token', '')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_cnpj_emitente', '')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('nfe_natureza_operacao', 'Venda de mercadoria')");
        $this->db->query("INSERT IGNORE INTO `configuracoes` (`config`, `valor`) VALUES ('venda_sem_estoque', '0')");
    }

    public function down()
    {
        $this->db->query("DELETE FROM `configuracoes` WHERE `config` IN ('app_logo','app_favicon','nfe_enabled','nfe_provider','nfe_ambiente','nfe_token','nfe_cnpj_emitente','nfe_natureza_operacao')");
    }
}
