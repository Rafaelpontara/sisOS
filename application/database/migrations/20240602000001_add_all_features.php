<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Migration_Add_all_features extends CI_Migration
{
    public function up()
    {
        // ── 1. Categorias hierárquicas ──────────────────────────────────────
        $this->db->query("ALTER TABLE `categorias` ADD COLUMN IF NOT EXISTS `parent_id` INT NULL DEFAULT NULL AFTER `tipo`");
        $this->db->query("ALTER TABLE `categorias` MODIFY COLUMN `categoria` VARCHAR(120) NOT NULL");

        // ── 2. Produtos: foto, categoria, marca, localização, garantia ──────
        $this->db->query("ALTER TABLE `produtos` MODIFY COLUMN `descricao` VARCHAR(255) NOT NULL");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `foto` VARCHAR(255) NULL AFTER `descricao`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `marca` VARCHAR(80) NULL AFTER `foto`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `modelo` VARCHAR(80) NULL AFTER `marca`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `localizacao` VARCHAR(80) NULL AFTER `modelo`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `categorias_id` INT NULL AFTER `localizacao`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `garantia_dias` INT NULL DEFAULT 0 AFTER `categorias_id`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `ncm` VARCHAR(20) NULL AFTER `garantia_dias`");
        $this->db->query("ALTER TABLE `produtos` ADD COLUMN IF NOT EXISTS `observacoes` TEXT NULL AFTER `ncm`");
        $this->db->query("ALTER TABLE `produtos` MODIFY COLUMN `estoque` DECIMAL(10,3) NOT NULL DEFAULT 0");

        // ── 3. Movimentações de estoque ──────────────────────────────────────
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `estoque_movimentacoes` (
              `id`           INT(11) NOT NULL AUTO_INCREMENT,
              `produtos_id`  INT(11) NOT NULL,
              `tipo`         ENUM('entrada','saida') NOT NULL,
              `origem`       VARCHAR(60) NOT NULL COMMENT 'compra|venda|os|avaria|ajuste|inventario',
              `origem_id`    INT(11) NULL,
              `quantidade`   DECIMAL(10,3) NOT NULL,
              `estoque_antes` DECIMAL(10,3) NOT NULL DEFAULT 0,
              `estoque_depois` DECIMAL(10,3) NOT NULL DEFAULT 0,
              `observacao`   VARCHAR(255) NULL,
              `usuarios_id`  INT(11) NOT NULL,
              `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `idx_produto` (`produtos_id`),
              KEY `idx_origem` (`origem`,`origem_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // ── 4. OS: situação financeira separada, checklist, retirada ────────
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `situacao_financeira` VARCHAR(30) NULL DEFAULT 'pendente' AFTER `status`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `data_retirada` DATE NULL AFTER `dataFinal`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `checklist` TEXT NULL AFTER `laudoTecnico`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `checklist_fotos` TEXT NULL AFTER `checklist`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `equipamento` VARCHAR(120) NULL AFTER `descricaoProduto`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `numeroSerie` VARCHAR(80) NULL AFTER `equipamento`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `os_origem_id` INT(11) NULL AFTER `garantias_id` COMMENT 'Para retorno em garantia'");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `is_recorrente` TINYINT(1) NOT NULL DEFAULT 0 AFTER `os_origem_id`");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `recorrencia_tipo` VARCHAR(20) NULL AFTER `is_recorrente` COMMENT 'mensal|bimestral|trimestral|semestral|anual'");
        $this->db->query("ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `recorrencia_proxima` DATE NULL AFTER `recorrencia_tipo`");

        // ── 5. Clientes: bloqueio, tags ──────────────────────────────────────
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `bloqueado` TINYINT(1) NOT NULL DEFAULT 0 AFTER `fornecedor`");
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `motivo_bloqueio` VARCHAR(255) NULL AFTER `bloqueado`");
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `tags` VARCHAR(255) NULL AFTER `motivo_bloqueio` COMMENT 'JSON array de tags'");
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `situacao` TINYINT(1) NOT NULL DEFAULT 1 AFTER `tags`");

        // Tabela de tags de clientes
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `cliente_tags` (
              `id`    INT(11) NOT NULL AUTO_INCREMENT,
              `nome`  VARCHAR(60) NOT NULL,
              `cor`   VARCHAR(20) NOT NULL DEFAULT '#3498db',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        // Tags padrão
        $tags = [
            ['nome'=>'Bronze','cor'=>'#cd7f32'],
            ['nome'=>'Prata','cor'=>'#aaa9ad'],
            ['nome'=>'Ouro','cor'=>'#ffd700'],
            ['nome'=>'VIP','cor'=>'#9b59b6'],
            ['nome'=>'Contrato','cor'=>'#2ecc71'],
            ['nome'=>'Inadimplente','cor'=>'#e74c3c'],
        ];
        foreach ($tags as $t) {
            $exists = $this->db->where('nome', $t['nome'])->count_all_results('cliente_tags');
            if (!$exists) $this->db->insert('cliente_tags', $t);
        }

        // Tabela pivot cliente <-> tag
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `clientes_tags` (
              `clientes_id`    INT(11) NOT NULL,
              `cliente_tags_id` INT(11) NOT NULL,
              PRIMARY KEY (`clientes_id`,`cliente_tags_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // ── 6. Checklist template ────────────────────────────────────────────
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `checklist_templates` (
              `id`     INT(11) NOT NULL AUTO_INCREMENT,
              `item`   VARCHAR(255) NOT NULL,
              `ordem`  INT(11) NOT NULL DEFAULT 0,
              `ativo`  TINYINT(1) NOT NULL DEFAULT 1,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        $itens = [
            'Equipamento ligando?','Tela sem trincas?','Tela sem manchas?',
            'Carcaça íntegra?','Teclado funcionando?','Touchpad funcionando?',
            'Carregador incluído?','Acessórios incluídos?','Bateria carregando?',
            'Portas USB OK?','Câmera funcionando?','Áudio funcionando?',
        ];
        foreach ($itens as $i => $item) {
            $exists = $this->db->where('item', $item)->count_all_results('checklist_templates');
            if (!$exists) $this->db->insert('checklist_templates', ['item'=>$item,'ordem'=>$i]);
        }

        // ── 7. Categorias padrão ─────────────────────────────────────────────
        $this->_inserirCategorias();

        // ── 8. Configurações extras ──────────────────────────────────────────
        $extras = [
            ['app_logo',''],['app_favicon',''],
            ['nfe_enabled','0'],['nfe_provider','focusnfe'],
            ['nfe_ambiente','homologacao'],['nfe_token',''],
            ['nfe_cnpj_emitente',''],['nfe_natureza_operacao','Venda de mercadoria'],
            ['venda_sem_estoque','0'],
            ['gemini_api_key',''],['gemini_enabled','0'],
            ['pdv_enabled','0'],
        ];
        foreach ($extras as $e) {
            $exists = $this->db->where('config', $e[0])->count_all_results('configuracoes');
            if (!$exists) $this->db->insert('configuracoes', ['config'=>$e[0],'valor'=>$e[1]]);
        }
        // Ampliar campo config
        $this->db->query("ALTER TABLE `configuracoes` MODIFY COLUMN `config` VARCHAR(60) NOT NULL");

        // PDV: coluna para identificar venda do PDV + cliente opcional
        $this->db->query("ALTER TABLE `vendas` ADD COLUMN IF NOT EXISTS `pdv` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`");
        $this->db->query("ALTER TABLE `vendas` ADD COLUMN IF NOT EXISTS `forma_pgto` VARCHAR(60) NULL AFTER `pdv`");
        $this->db->query("ALTER TABLE `vendas` MODIFY COLUMN `clientes_id` INT(11) NULL DEFAULT NULL");
        $this->db->query("ALTER TABLE `itens_de_vendas` ADD COLUMN IF NOT EXISTS `produtos_id` INT(11) NULL AFTER `vendas_id`");
        $this->db->query("ALTER TABLE `itens_de_vendas` ADD COLUMN IF NOT EXISTS `descricao` VARCHAR(255) NULL AFTER `produtos_id`");
        $this->db->query("ALTER TABLE `itens_de_vendas` ADD COLUMN IF NOT EXISTS `preco` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `descricao`");
    }

    private function _inserirCategorias()
    {
        $grupos_despesa = [
            'Conta da Empresa' => ['Aluguel','Energia elétrica','Água','Internet','Telefone'],
            'Financeiro'       => ['Taxas de cartão','Tarifas bancárias','Juros','Multas'],
            'Operacionais'     => ['Peças de reposição','Ferramentas','Material de escritório','Frete'],
            'Pessoal'          => ['Salários','Pró-labore','Vale transporte','Vale alimentação'],
            'Impostos'         => ['ISS','ICMS','Simples Nacional','DAS'],
            'Avarias / Perdas' => ['Avaria de equipamento','Produto danificado','Perda de estoque','Sinistro'],
            'Outros'           => ['Despesa diversa'],
        ];
        $grupos_receita = [
            'SERVIÇOS'  => ['Ordem de Serviço','Manutenção preventiva','Consultoria','Instalação'],
            'VENDAS'    => ['Venda de produtos','Venda de peças','Revenda'],
            'CONTRATOS' => ['Mensalidade','Contrato de suporte','Plano de manutenção'],
            'Outros'    => ['Receita diversa'],
        ];
        foreach ($grupos_despesa as $g => $filhos) $this->_insertGrupo($g, $filhos, 'despesa');
        foreach ($grupos_receita as $g => $filhos)  $this->_insertGrupo($g, $filhos, 'receita');
    }

    private function _insertGrupo($grupo, $filhos, $tipo)
    {
        $row = $this->db->where('categoria',$grupo)->where('tipo',$tipo)->where('parent_id IS NULL',null,false)->get('categorias')->row();
        if ($row) { $pid = $row->idCategorias; }
        else {
            $this->db->insert('categorias',['categoria'=>$grupo,'tipo'=>$tipo,'status'=>1,'cadastro'=>date('Y-m-d'),'parent_id'=>null]);
            $pid = $this->db->insert_id();
        }
        foreach ($filhos as $f) {
            $exists = $this->db->where('categoria',$f)->where('parent_id',$pid)->count_all_results('categorias');
            if (!$exists) $this->db->insert('categorias',['categoria'=>$f,'tipo'=>$tipo,'status'=>1,'cadastro'=>date('Y-m-d'),'parent_id'=>$pid]);
        }
    }

    public function down() {}
}
