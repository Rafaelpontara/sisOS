<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Migration_Add_categorias_hierarquicas extends CI_Migration
{
    public function up()
    {
        // Adicionar coluna parent_id para hierarquia
        $this->db->query("ALTER TABLE `categorias` ADD COLUMN IF NOT EXISTS `parent_id` INT NULL DEFAULT NULL AFTER `tipo`");
        $this->db->query("ALTER TABLE `categorias` MODIFY COLUMN `categoria` VARCHAR(120) NOT NULL");

        // Categorias de Despesa
        $grupos_despesa = [
            'Conta da Empresa' => ['Aluguel','Energia elétrica','Água','Internet','Telefone'],
            'Financeiro'       => ['Taxas de cartão','Tarifas bancárias','Juros','Multas'],
            'Operacionais'     => ['Peças de reposição','Ferramentas','Material de escritório','Frete'],
            'Pessoal'          => ['Salários','Pró-labore','Vale transporte','Vale alimentação'],
            'Impostos'         => ['ISS','ICMS','Simples Nacional','DAS'],
            'Avarias / Perdas' => ['Avaria de equipamento','Produto danificado','Perda de estoque','Sinistro'],
            'Outros'           => ['Despesa diversa'],
        ];

        // Categorias de Receita
        $grupos_receita = [
            'SERVIÇOS'   => ['Ordem de Serviço','Manutenção preventiva','Consultoria','Instalação'],
            'VENDAS'     => ['Venda de produtos','Venda de peças','Revenda'],
            'CONTRATOS'  => ['Mensalidade','Contrato de suporte','Plano de manutenção'],
            'Outros'     => ['Receita diversa'],
        ];

        $this->_inserirGrupos($grupos_despesa, 'despesa');
        $this->_inserirGrupos($grupos_receita, 'receita');
    }

    private function _inserirGrupos($grupos, $tipo)
    {
        foreach ($grupos as $grupo => $filhos) {
            // Verifica se já existe
            $existe = $this->db->where('categoria', $grupo)->where('tipo', $tipo)->where('parent_id IS NULL', null, false)->get('categorias')->row();
            if ($existe) {
                $parentId = $existe->idCategorias;
            } else {
                $this->db->insert('categorias', [
                    'categoria' => $grupo,
                    'tipo'      => $tipo,
                    'status'    => 1,
                    'cadastro'  => date('Y-m-d'),
                    'parent_id' => null,
                ]);
                $parentId = $this->db->insert_id();
            }

            foreach ($filhos as $filho) {
                $existeFilho = $this->db->where('categoria', $filho)->where('parent_id', $parentId)->get('categorias')->row();
                if (!$existeFilho) {
                    $this->db->insert('categorias', [
                        'categoria' => $filho,
                        'tipo'      => $tipo,
                        'status'    => 1,
                        'cadastro'  => date('Y-m-d'),
                        'parent_id' => $parentId,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `categorias` DROP COLUMN IF EXISTS `parent_id`");
    }
}
