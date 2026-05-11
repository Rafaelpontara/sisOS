<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #111; background: #fff; }

/* ── Cabeçalho ── */
.rp-head { width: 100%; border-bottom: 1px solid #1e3a5f; padding-bottom: 4px; margin-bottom: 3px; }
.rp-head td { vertical-align: middle; padding: 0; }
.rp-head .td-logo { width: 90px; vertical-align:top; padding-top:2px; }
.rp-head .td-logo img { max-height: 40px; max-width: 80px; }
.rp-head .td-info { text-align: right; font-size: 9.5px; line-height: 1.55; padding-left: 8px; }
.rp-head .td-info b { color: #1e3a5f; }

/* ── Título ── */
.rp-titulo { text-align: center; font-size: 12px; font-weight: bold; color: #111; margin: 3px 0 5px; }

/* ── Tabela ── */
.rp-tbl { width: 100%; border-collapse: collapse; font-size: 10.5px; }
.rp-tbl thead tr { background-color: #1e3a5f; color: #ffffff; }
.rp-tbl thead th { padding: 4px 5px; font-size: 9.5px; font-weight: bold; border: 1px solid #143060; text-align: left; color: #fff; }
.rp-tbl thead th.c { text-align: center; }
.rp-tbl thead th.r { text-align: right; }
.rp-tbl tbody tr.par { background-color: #f0f4fb; }
.rp-tbl tbody tr.impar { background-color: #ffffff; }
.rp-tbl tbody td { padding: 3px 5px; border: 1px solid #d0d7e8; vertical-align: middle; }
.rp-tbl tbody td.c { text-align: center; }
.rp-tbl tbody td.r { text-align: right; }
.rp-tbl tr.tot td { background-color: #dde3f0; font-weight: bold; border: 1px solid #b5bed8; padding: 4px 5px; }
.rp-tbl tr.tot td.r { text-align: right; }

/* ── Resumo totais (financeiro) ── */
.rp-res { width: 100%; border-collapse: collapse; margin-top: 6px; }
.rp-res td { padding: 4px 10px; border: 1px solid #d0d7e8; font-size: 11px; font-weight: bold; }
.res-rec  { background-color: #ecfdf5; color: #065f46; }
.res-desp { background-color: #fef2f2; color: #991b1b; }
.res-sal  { background-color: #eff6ff; color: #1e3a5f; }
.res-neg  { background-color: #fef2f2; color: #991b1b; }

/* ── Rodapé ── */
.rp-foot { text-align: right; font-size: 9px; color: #888; margin-top: 5px; padding-top: 3px; border-top: 1px solid #ddd; }

/* ── Badges ── */
.b { padding: 1px 5px; border-radius: 2px; font-size: 9px; font-weight: bold; }
.b-g  { background-color: #d1fae5; color: #065f46; }
.b-r  { background-color: #fee2e2; color: #991b1b; }
.b-a  { background-color: #fef3c7; color: #92400e; }
.b-b  { background-color: #dbeafe; color: #1e3a5f; }
.b-gr { background-color: #f3f4f6; color: #374151; }
</style>

<table class="rp-head" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="td-logo">
            <?php if ($emitente && !empty($emitente->url_logo) && file_exists(convertUrlToUploadsPath($emitente->url_logo))): ?>
            <img src="<?= convertUrlToUploadsPath($emitente->url_logo) ?>" alt="" width="80" height="40" style="width:80px;height:40px;object-fit:contain;">
            <?php endif; ?>
        </td>
        <td class="td-info">
            <?php if ($emitente): ?>
            <b>EMPRESA:</b> <?= htmlspecialchars($emitente->nome) ?><?php if (!empty($emitente->cnpj) && $emitente->cnpj != '00.000.000/0000-00'): ?> &nbsp;<b>CNPJ:</b> <?= htmlspecialchars($emitente->cnpj) ?><?php endif; ?><br>
            <b>ENDEREÇO:</b> <?= htmlspecialchars($emitente->rua.', '.$emitente->numero.', '.$emitente->bairro.', '.$emitente->cidade.' - '.$emitente->uf) ?><br>
            <?php endif; ?>
            <b>RELATÓRIO:</b> <?= htmlspecialchars(ucfirst($title ?? '')) ?>
            <?php
            $di = $dataInicial ?? '';
            $df = $dataFinal ?? '';
            $epoch = '31/12/1969';
            $mostrar = ($di && $di !== $epoch) || ($df && $df !== $epoch);
            if ($mostrar):
            ?><br>
            <?php if ($di && $di !== $epoch): ?><b>DATA INICIAL:</b> <?= $di ?> &nbsp;<?php endif; ?>
            <?php if ($df && $df !== $epoch): ?><b>DATA FINAL:</b> <?= $df ?><?php endif; ?>
            <?php endif; ?>
        </td>
    </tr>
</table>

<div class="rp-titulo"><?= htmlspecialchars(ucfirst($title ?? '')) ?></div>
