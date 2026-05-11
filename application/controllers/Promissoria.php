<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promissoria extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Busca dados do emitente com colunas corretas da tabela
        $emitente_raw = $this->db->get('emitente')->row();

        // Garante todas as propriedades com fallback seguro
        // A tabela emitente usa 'uf' para estado
        $emitente = (object)[
            'nome'    => isset($emitente_raw->nome)     ? $emitente_raw->nome     : '',
            'cidade'  => isset($emitente_raw->cidade)   ? $emitente_raw->cidade   : '',
            'estado'  => isset($emitente_raw->uf)       ? $emitente_raw->uf       : '',
            'cnpj'    => isset($emitente_raw->cnpj)     ? $emitente_raw->cnpj     : '',
            'telefone'=> isset($emitente_raw->telefone) ? $emitente_raw->telefone : '',
            'rua'     => isset($emitente_raw->rua)      ? $emitente_raw->rua      : '',
            'numero'  => isset($emitente_raw->numero)   ? $emitente_raw->numero   : '',
            'bairro'  => isset($emitente_raw->bairro)   ? $emitente_raw->bairro   : '',
        ];

        $this->data['emitente']        = $emitente;
        $this->data['menuPromissoria'] = true;
        $this->data['view']            = 'sisos/promissoria';
        return $this->layout();
    }
}
