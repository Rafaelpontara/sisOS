<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Library: FocusNfe
 * Integração com a API Focus NF-e (https://focusnfe.com.br)
 * Plano gratuito: até 50 NF-e/mês em homologação (testes)
 * Documentação: https://developer.focusnfe.com.br
 */
class FocusNfe
{
    private $CI;
    private $token;
    private $ambiente;
    private $baseUrl;

    const URL_PRODUCAO    = 'https://api.focusnfe.com.br/v2/';
    const URL_HOMOLOGACAO = 'https://homologacao.focusnfe.com.br/v2/';

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('sisos_model');

        $config = $this->CI->sisos_model->getConfiguracoes();

        $this->token    = $config['nfe_token'] ?? '';
        $this->ambiente = $config['nfe_ambiente'] ?? 'homologacao';
        $this->baseUrl  = $this->ambiente === 'producao' ? self::URL_PRODUCAO : self::URL_HOMOLOGACAO;
    }

    // ─── Métodos públicos ────────────────────────────────────────────────────

    /**
     * Emite uma NF-e a partir dos dados de uma OS
     */
    public function emitirNfePorOs($os)
    {
        $dados = $this->montarDadosNfePorOs($os);
        return $this->enviarNfe($dados);
    }

    /**
     * Emite uma NF-e a partir dos dados de uma Venda
     */
    public function emitirNfePorVenda($venda)
    {
        $dados = $this->montarDadosNfePorVenda($venda);
        return $this->enviarNfe($dados);
    }

    /**
     * Consulta o status de uma NF-e pelo número de referência
     */
    public function consultarNfe($referencia)
    {
        return $this->request('GET', 'nfe/' . $referencia);
    }

    /**
     * Cancela uma NF-e
     */
    public function cancelarNfe($referencia, $justificativa)
    {
        $dados = ['justificativa' => $justificativa];
        return $this->request('DELETE', 'nfe/' . $referencia, $dados);
    }

    /**
     * Baixa o PDF DANFE de uma NF-e
     */
    public function urlDanfe($referencia)
    {
        return $this->baseUrl . 'nfe/' . $referencia . '/danfe?token=' . $this->token;
    }

    /**
     * Baixa o XML de uma NF-e
     */
    public function urlXml($referencia)
    {
        return $this->baseUrl . 'nfe/' . $referencia . '/xml?token=' . $this->token;
    }

    // ─── Montagem dos dados ──────────────────────────────────────────────────

    private function montarDadosNfePorOs($os)
    {
        $config  = $this->CI->sisos_model->getConfiguracoes();
        $emitente = $this->CI->sisos_model->getEmitente();

        $referencia = 'OS' . str_pad($os->idOs, 8, '0', STR_PAD_LEFT);

        $itens = [];
        // Serviços da OS como itens (NFS-e ou NF-e com CFOP de serviço)
        if (!empty($os->servicos)) {
            foreach ($os->servicos as $i => $servico) {
                $itens[] = [
                    'numero_item'              => $i + 1,
                    'codigo_produto'           => 'SERV' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'descricao'                => $servico->descricao ?? 'Serviço',
                    'cfop'                     => '5933',
                    'unidade_comercial'        => 'UN',
                    'quantidade_comercial'     => floatval($servico->quantidade ?? 1),
                    'valor_unitario_comercial' => floatval($servico->valorUnitario ?? 0),
                    'valor_unitario_tributavel'=> floatval($servico->valorUnitario ?? 0),
                    'unidade_tributavel'       => 'UN',
                    'quantidade_tributavel'    => floatval($servico->quantidade ?? 1),
                    'valor_bruto'              => floatval($servico->subTotal ?? 0),
                    'icms_origem'              => 0,
                    'icms_modalidade'          => 40,
                    'pis_modalidade'           => 7,
                    'cofins_modalidade'        => 7,
                ];
            }
        }

        // Produtos da OS
        if (!empty($os->produtos)) {
            $offset = count($itens);
            foreach ($os->produtos as $i => $produto) {
                $itens[] = [
                    'numero_item'              => $offset + $i + 1,
                    'codigo_produto'           => 'PROD' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'descricao'                => $produto->descricao ?? 'Produto',
                    'cfop'                     => '5102',
                    'unidade_comercial'        => 'UN',
                    'quantidade_comercial'     => floatval($produto->quantidade ?? 1),
                    'valor_unitario_comercial' => floatval($produto->valorUnitario ?? 0),
                    'valor_unitario_tributavel'=> floatval($produto->valorUnitario ?? 0),
                    'unidade_tributavel'       => 'UN',
                    'quantidade_tributavel'    => floatval($produto->quantidade ?? 1),
                    'valor_bruto'              => floatval($produto->subTotal ?? 0),
                    'icms_origem'              => 0,
                    'icms_modalidade'          => 40,
                    'pis_modalidade'           => 7,
                    'cofins_modalidade'        => 7,
                ];
            }
        }

        // Fallback: item genérico se sem itens detalhados
        if (empty($itens)) {
            $itens[] = [
                'numero_item'              => 1,
                'codigo_produto'           => 'OS001',
                'descricao'                => 'Ordem de Serviço nº ' . $os->idOs,
                'cfop'                     => '5933',
                'unidade_comercial'        => 'UN',
                'quantidade_comercial'     => 1,
                'valor_unitario_comercial' => floatval($os->valorTotal ?? 0),
                'valor_unitario_tributavel'=> floatval($os->valorTotal ?? 0),
                'unidade_tributavel'       => 'UN',
                'quantidade_tributavel'    => 1,
                'valor_bruto'              => floatval($os->valorTotal ?? 0),
                'icms_origem'              => 0,
                'icms_modalidade'          => 40,
                'pis_modalidade'           => 7,
                'cofins_modalidade'        => 7,
            ];
        }

        return [
            'natureza_operacao'  => $config['nfe_natureza_operacao'] ?? 'Prestação de Serviços',
            'forma_pagamento'    => 0,
            'emitente'           => $this->dadosEmitente($emitente),
            'destinatario'       => $this->dadosDestinatario($os),
            'itens'              => $itens,
            'informacoes_adicionais_contribuinte' => 'Referente à OS nº ' . $os->idOs,
        ];
    }

    private function montarDadosNfePorVenda($venda)
    {
        $config  = $this->CI->sisos_model->getConfiguracoes();
        $emitente = $this->CI->sisos_model->getEmitente();

        $itens = [];
        if (!empty($venda->produtos)) {
            foreach ($venda->produtos as $i => $produto) {
                $itens[] = [
                    'numero_item'              => $i + 1,
                    'codigo_produto'           => 'PROD' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'descricao'                => $produto->descricao ?? 'Produto',
                    'cfop'                     => '5102',
                    'unidade_comercial'        => 'UN',
                    'quantidade_comercial'     => floatval($produto->quantidade ?? 1),
                    'valor_unitario_comercial' => floatval($produto->valorUnitario ?? 0),
                    'valor_unitario_tributavel'=> floatval($produto->valorUnitario ?? 0),
                    'unidade_tributavel'       => 'UN',
                    'quantidade_tributavel'    => floatval($produto->quantidade ?? 1),
                    'valor_bruto'              => floatval($produto->subTotal ?? 0),
                    'icms_origem'              => 0,
                    'icms_modalidade'          => 40,
                    'pis_modalidade'           => 7,
                    'cofins_modalidade'        => 7,
                ];
            }
        }

        if (empty($itens)) {
            $itens[] = [
                'numero_item'              => 1,
                'codigo_produto'           => 'VENDA001',
                'descricao'                => 'Venda nº ' . $venda->idVendas,
                'cfop'                     => '5102',
                'unidade_comercial'        => 'UN',
                'quantidade_comercial'     => 1,
                'valor_unitario_comercial' => floatval($venda->valorTotal ?? 0),
                'valor_unitario_tributavel'=> floatval($venda->valorTotal ?? 0),
                'unidade_tributavel'       => 'UN',
                'quantidade_tributavel'    => 1,
                'valor_bruto'              => floatval($venda->valorTotal ?? 0),
                'icms_origem'              => 0,
                'icms_modalidade'          => 40,
                'pis_modalidade'           => 7,
                'cofins_modalidade'        => 7,
            ];
        }

        return [
            'natureza_operacao'  => $config['nfe_natureza_operacao'] ?? 'Venda de mercadoria',
            'forma_pagamento'    => 0,
            'emitente'           => $this->dadosEmitente($emitente),
            'destinatario'       => $this->dadosDestinatario($venda),
            'itens'              => $itens,
            'informacoes_adicionais_contribuinte' => 'Referente à Venda nº ' . $venda->idVendas,
        ];
    }

    private function dadosEmitente($emitente)
    {
        if (!$emitente) {
            return [];
        }
        $cnpj = preg_replace('/\D/', '', $emitente->cnpj ?? '');
        return [
            'cnpj'                       => $cnpj,
            'nome'                       => $emitente->nome ?? '',
            'logradouro'                 => $emitente->logradouro ?? '',
            'numero'                     => $emitente->numero ?? 'SN',
            'bairro'                     => $emitente->bairro ?? '',
            'municipio'                  => $emitente->cidade ?? '',
            'uf'                         => $emitente->uf ?? '',
            'cep'                        => preg_replace('/\D/', '', $emitente->cep ?? ''),
            'regime_tributario'          => 1, // 1=Simples Nacional, 3=Lucro Real
        ];
    }

    private function dadosDestinatario($registro)
    {
        // Tenta pegar CPF/CNPJ do cliente
        $cpfCnpj = preg_replace('/\D/', '', $registro->cpf ?? $registro->cnpj ?? '');
        $nome    = $registro->nomeCliente ?? $registro->nome ?? 'Consumidor Final';

        $dest = [
            'nome'        => $nome,
            'email'       => $registro->email ?? '',
            'logradouro'  => $registro->logradouro ?? '',
            'numero'      => $registro->numero ?? 'SN',
            'bairro'      => $registro->bairro ?? '',
            'municipio'   => $registro->cidade ?? '',
            'uf'          => $registro->uf ?? '',
            'cep'         => preg_replace('/\D/', '', $registro->cep ?? ''),
        ];

        if (strlen($cpfCnpj) === 11) {
            $dest['cpf'] = $cpfCnpj;
        } elseif (strlen($cpfCnpj) === 14) {
            $dest['cnpj'] = $cpfCnpj;
        } else {
            // Consumidor final sem documento
            $dest['cpf'] = '00000000000';
        }

        return $dest;
    }

    // ─── Comunicação com a API ───────────────────────────────────────────────

    private function enviarNfe($dados)
    {
        return $this->request('POST', 'nfe', $dados);
    }

    private function request($method, $endpoint, $dados = [])
    {
        if (empty($this->token)) {
            return [
                'sucesso' => false,
                'erro'    => 'Token da Focus NF-e não configurado. Acesse Configurações > Nota Fiscal.',
            ];
        }

        $url = $this->baseUrl . $endpoint . '?token=' . $this->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $response   = curl_exec($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError  = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return ['sucesso' => false, 'erro' => 'Erro de conexão: ' . $curlError];
        }

        $resultado = json_decode($response, true);

        if (in_array($httpCode, [200, 201, 202])) {
            return ['sucesso' => true, 'dados' => $resultado, 'http_code' => $httpCode];
        }

        return [
            'sucesso'   => false,
            'erro'      => $resultado['mensagem'] ?? $resultado['message'] ?? 'Erro desconhecido (HTTP ' . $httpCode . ')',
            'dados'     => $resultado,
            'http_code' => $httpCode,
        ];
    }
}
