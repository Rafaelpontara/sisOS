<div class="new122">
    <div class="widget-title" style="margin:-20px 0 10px">
        <span class="icon"><i class="bx bx-store"></i></span>
        <h5>Relatório PDV — <?= date('d/m/Y', strtotime($data)) ?></h5>
        <div style="float:right;padding:5px">
            <a href="<?= site_url('pdv') ?>" class="button btn btn-mini btn-success">
                <i class='bx bx-store'></i> Abrir PDV
            </a>
        </div>
    </div>

    <!-- Filtro de data -->
    <form method="get" action="<?= site_url('pdv/relatorio') ?>" style="margin-bottom:15px">
        <div class="span3">
            <input type="date" name="data" class="span12" value="<?= $data ?>">
        </div>
        <div class="span2">
            <button class="button btn btn-inverse btn-mini"><i class='bx bx-search-alt'></i> Filtrar</button>
        </div>
    </form>

    <?php
    $totalDia    = array_sum(array_map(fn($v) => $v->valor_desconto > 0 ? $v->valor_desconto : $v->valorTotal, $vendas));
    $countVendas = count($vendas);
    $formas = [];
    foreach ($vendas as $v) {
        $f = $v->forma_pgto ?: 'Não informado';
        $formas[$f] = ($formas[$f] ?? 0) + ($v->valor_desconto > 0 ? $v->valor_desconto : $v->valorTotal);
    }
    ?>

    <!-- Cards resumo -->
    <div class="row-fluid" style="margin-bottom:15px">
        <div class="span4">
            <div style="background:#27ae60;color:#fff;border-radius:8px;padding:15px;text-align:center">
                <small style="opacity:.8">TOTAL DO DIA</small>
                <h2 style="margin:5px 0;font-size:28px;font-weight:700">R$ <?= number_format($totalDia, 2, ',', '.') ?></h2>
            </div>
        </div>
        <div class="span4">
            <div style="background:#2980b9;color:#fff;border-radius:8px;padding:15px;text-align:center">
                <small style="opacity:.8">VENDAS REALIZADAS</small>
                <h2 style="margin:5px 0;font-size:28px;font-weight:700"><?= $countVendas ?></h2>
            </div>
        </div>
        <div class="span4">
            <div style="background:#8e44ad;color:#fff;border-radius:8px;padding:15px;text-align:center">
                <small style="opacity:.8">TICKET MÉDIO</small>
                <h2 style="margin:5px 0;font-size:28px;font-weight:700">R$ <?= $countVendas > 0 ? number_format($totalDia / $countVendas, 2, ',', '.') : '0,00' ?></h2>
            </div>
        </div>
    </div>

    <!-- Resumo por forma de pagamento -->
    <?php if (!empty($formas)): ?>
    <div class="widget-box" style="margin-bottom:15px;padding:12px 15px">
        <strong>Por forma de pagamento:</strong>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:8px">
            <?php foreach ($formas as $forma => $valor): ?>
            <div style="background:#f8f9fa;border:1px solid #e0e0e0;border-radius:6px;padding:8px 14px;font-size:13px">
                <strong><?= htmlspecialchars($forma) ?></strong><br>
                <span style="color:#27ae60;font-weight:700">R$ <?= number_format($valor, 2, ',', '.') ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tabela de vendas -->
    <div class="widget-box">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Forma Pgto</th>
                        <th>Itens</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($vendas): foreach ($vendas as $v):
                    $total = $v->valor_desconto > 0 ? $v->valor_desconto : $v->valorTotal;
                    $itensCount = $this->db->where('vendas_id', $v->idVendas)->count_all_results('itens_de_vendas');
                ?>
                <tr>
                    <td><?= $v->idVendas ?></td>
                    <td><?= date('H:i', strtotime($v->dataVenda . ' 00:00:00')) ?></td>
                    <td><?= htmlspecialchars($v->nomeCliente ?? 'Consumidor final') ?></td>
                    <td><?= htmlspecialchars($v->forma_pgto ?? '—') ?></td>
                    <td class="text-center"><?= $itensCount ?></td>
                    <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                    <td>
                        <a href="<?= site_url('vendas/visualizar/'.$v->idVendas) ?>" class="btn btn-mini btn-info" title="Ver venda"><i class="bx bx-show"></i></a>
                        <a href="<?= site_url('pdv/cupom/'.$v->idVendas) ?>" target="_blank" class="btn btn-mini btn-inverse" title="Imprimir cupom"><i class="bx bx-printer"></i></a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center muted" style="padding:30px">Nenhuma venda PDV neste dia.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
