<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OneSignal Push Notification Helper
 *
 * Como configurar:
 * 1. Crie conta gratuita em https://onesignal.com
 * 2. Crie um App → plataforma Android
 * 3. Copie o App ID e a REST API Key para as constantes abaixo
 * 4. No app Flutter, instale onesignal_flutter e configure com o mesmo App ID
 *
 * Uso no controller:
 *   $this->load->helper('onesignal_helper');
 *   onesignal_push('Nova OS #123', 'Cliente: João Silva', ['osId' => 123]);
 */

define('ONESIGNAL_APP_ID',    'SEU_APP_ID_AQUI');     // ex: 'a1b2c3d4-...'
define('ONESIGNAL_API_KEY',   'SEU_API_KEY_AQUI');    // ex: 'os_v2_...'
define('ONESIGNAL_API_URL',   'https://onesignal.com/api/v1/notifications');

/**
 * Envia notificação push para todos os usuários do app.
 *
 * @param string $titulo   Título da notificação
 * @param string $mensagem Corpo da notificação
 * @param array  $dados    Dados extras (ex: ['osId' => 123, 'tela' => 'os'])
 * @param array  $filtros  Filtros OneSignal (vazio = todos os usuários)
 * @return array           Resposta da API do OneSignal
 */
function onesignal_push(string $titulo, string $mensagem, array $dados = [], array $filtros = []): array
{
    if (ONESIGNAL_APP_ID === 'SEU_APP_ID_AQUI') {
        // OneSignal ainda não configurado — loga e retorna sem erro
        log_message('info', 'OneSignal: notificação ignorada (App ID não configurado)');
        return ['status' => false, 'message' => 'OneSignal não configurado'];
    }

    $payload = [
        'app_id'            => ONESIGNAL_APP_ID,
        'headings'          => ['en' => $titulo, 'pt' => $titulo],
        'contents'          => ['en' => $mensagem, 'pt' => $mensagem],
        'data'              => $dados,
        'android_accent_color' => 'FFFF6B35', // laranja SISOS
        'small_icon'        => 'ic_stat_onesignal_default',
    ];

    // Se não passar filtros, envia para TODOS os usuários
    if (empty($filtros)) {
        $payload['included_segments'] = ['All'];
    } else {
        $payload['filters'] = $filtros;
    }

    $ch = curl_init(ONESIGNAL_API_URL);
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . ONESIGNAL_API_KEY,
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true) ?? [];
    $result['http_code'] = $httpCode;

    if ($httpCode === 200) {
        log_message('info', "OneSignal: push enviado — \"{$titulo}\"");
    } else {
        log_message('error', "OneSignal: erro {$httpCode} — {$response}");
    }

    return $result;
}

/**
 * Notificação específica: nova OS criada
 */
function onesignal_nova_os(int $idOs, string $cliente, string $equipamento): array
{
    return onesignal_push(
        "🔧 Nova OS #{$idOs}",
        "Cliente: {$cliente} — {$equipamento}",
        ['tela' => 'os', 'osId' => $idOs]
    );
}

/**
 * Notificação específica: status da OS mudou
 */
function onesignal_status_os(int $idOs, string $novoStatus): array
{
    return onesignal_push(
        "OS #{$idOs} atualizada",
        "Novo status: {$novoStatus}",
        ['tela' => 'os', 'osId' => $idOs]
    );
}

/**
 * Notificação específica: estoque mínimo atingido
 */
function onesignal_estoque_minimo(string $produto): array
{
    return onesignal_push(
        '⚠️ Estoque baixo',
        "Produto \"{$produto}\" atingiu o estoque mínimo",
        ['tela' => 'produtos']
    );
}

/**
 * Notificação específica: nova venda pelo PDV
 */
function onesignal_nova_venda(int $idVenda, float $total): array
{
    return onesignal_push(
        "💰 Nova venda #{$idVenda}",
        'Total: R$ ' . number_format($total, 2, ',', '.'),
        ['tela' => 'vendas', 'vendaId' => $idVenda]
    );
}
