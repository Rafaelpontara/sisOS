<?php
$margem = ($result->precoVenda > 0) ? round(($result->precoVenda - $result->precoCompra) / $result->precoVenda * 100, 1) : 0;
$estoqueOk = $result->estoque > ($result->estoqueMinimo ?? 0);
$estoqueCritico = $result->estoque <= ($result->estoqueMinimo ?? 0) && ($result->estoqueMinimo ?? 0) > 0;
?>
<style>
.vp-wrap *,.vp-wrap *::before,.vp-wrap *::after{box-sizing:border-box;}
.vp-wrap .accordion,.vp-wrap .accordion-group,.vp-wrap .widget-box{all:unset;display:block;}
.vp-wrap{max-width:860px;margin:0 auto;}
.vp-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.vp-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.vp-card-head i{font-size:15px;}
.vp-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.vp-card-body{padding:16px;}
.vp-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.vp-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.vp-grid,.vp-grid-3{grid-template-columns:1fr;}}
.vp-row{margin-bottom:12px;}
.vp-lbl{font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.6px;display:block;margin-bottom:2px;}
.vp-val{font-size:13px;color:#e8eaf0;}
.vp-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.vp-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.vp-btn:hover{transform:translateY(-1px);text-decoration:none;}
.vp-kpis{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;margin-bottom:14px;}
.vp-kpi{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px;display:flex;align-items:center;gap:12px;}
.vp-kpi-icon{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.vp-kpi-val{font-size:22px;font-weight:800;color:#e8eaf0;line-height:1;}
.vp-kpi-label{font-size:11px;color:#9ca3af;font-weight:600;margin-top:3px;}
</style>

<div class="vp-wrap new122">

    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
                <i class='bx bx-package' style="color:#8b5cf6;"></i>
                <?= htmlspecialchars($result->descricao) ?>
            </h2>
            <?php if ($estoqueCritico): ?>
            <span class="vp-badge" style="background:rgba(239,68,68,0.15);color:#f87171;"><i class='bx bx-error'></i> Estoque Crítico</span>
            <?php elseif ($result->estoque <= 0): ?>
            <span class="vp-badge" style="background:rgba(239,68,68,0.15);color:#f87171;">Zerado</span>
            <?php endif; ?>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="<?= site_url('produtos/editar/'.$result->idProdutos) ?>" class="vp-btn" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;"><i class='bx bx-edit'></i> Editar</a>
            <a href="<?= base_url() ?>index.php/produtos" class="vp-btn" style="background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);"><i class='bx bx-arrow-back'></i></a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="vp-kpis">
        <div class="vp-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="vp-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-dollar' style="color:#22c55e;"></i></div>
            <div><div class="vp-kpi-val" style="font-size:14px;color:#4ade80;">R$ <?= number_format($result->precoVenda,2,',','.') ?></div><div class="vp-kpi-label">Preço de Venda</div></div>
        </div>
        <div class="vp-kpi" style="border-color:rgba(156,163,175,0.2);">
            <div class="vp-kpi-icon" style="background:rgba(156,163,175,0.1);"><i class='bx bx-purchase-tag' style="color:#9ca3af;"></i></div>
            <div><div class="vp-kpi-val" style="font-size:14px;color:#9ca3af;">R$ <?= number_format($result->precoCompra,2,',','.') ?></div><div class="vp-kpi-label">Preço de Compra</div></div>
        </div>
        <div class="vp-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="vp-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-trending-up' style="color:#fbbf24;"></i></div>
            <div><div class="vp-kpi-val" style="font-size:18px;color:<?= $margem>=30?'#4ade80':($margem>=10?'#fbbf24':'#f87171') ?>;"><?= $margem ?>%</div><div class="vp-kpi-label">Margem</div></div>
        </div>
        <div class="vp-kpi" style="border-color:rgba(<?= $estoqueCritico?'239,68,68':'34,197,94' ?>,0.3);">
            <div class="vp-kpi-icon" style="background:rgba(<?= $estoqueCritico?'239,68,68':'34,197,94' ?>,0.15);"><i class='bx bx-box' style="color:<?= $estoqueCritico?'#f87171':'#4ade80' ?>;"></i></div>
            <div><div class="vp-kpi-val" style="color:<?= $estoqueCritico?'#f87171':'#e8eaf0' ?>;"><?= $result->estoque ?> <?= htmlspecialchars($result->unidade) ?></div><div class="vp-kpi-label">Estoque Atual</div></div>
        </div>
    </div>

    <!-- Dados principais -->
    <div class="vp-card">
        <div class="vp-card-head"><i class='bx bx-barcode' style="color:#8b5cf6;"></i><span>Identificação</span></div>
        <div class="vp-card-body">
            <div class="vp-grid">
                <div class="vp-row"><span class="vp-lbl">Código de Barras</span><span class="vp-val"><?= htmlspecialchars($result->codDeBarra??'—') ?></span></div>
                <div class="vp-row"><span class="vp-lbl">Unidade</span><span class="vp-val"><?= htmlspecialchars($result->unidade??'—') ?></span></div>
                <?php if (!empty($result->marca)): ?><div class="vp-row"><span class="vp-lbl">Marca</span><span class="vp-val"><?= htmlspecialchars($result->marca) ?></span></div><?php endif; ?>
                <?php if (!empty($result->modelo)): ?><div class="vp-row"><span class="vp-lbl">Modelo</span><span class="vp-val"><?= htmlspecialchars($result->modelo) ?></span></div><?php endif; ?>
                <?php if (!empty($result->ncm)): ?><div class="vp-row"><span class="vp-lbl">NCM</span><span class="vp-val"><?= htmlspecialchars($result->ncm) ?></span></div><?php endif; ?>
                <?php if (!empty($result->localizacao)): ?><div class="vp-row"><span class="vp-lbl">Localização</span><span class="vp-val"><?= htmlspecialchars($result->localizacao) ?></span></div><?php endif; ?>
                <div class="vp-row"><span class="vp-lbl">Estoque Mínimo</span><span class="vp-val"><?= $result->estoqueMinimo??0 ?></span></div>
                <?php if (!empty($result->garantia_dias)): ?><div class="vp-row"><span class="vp-lbl">Garantia</span><span class="vp-val"><?= $result->garantia_dias ?> dia(s)</span></div><?php endif; ?>
                <div class="vp-row">
                    <span class="vp-lbl">Movimentos</span>
                    <div style="display:flex;gap:6px;margin-top:2px;">
                        <?php if($result->entrada): ?><span class="vp-badge" style="background:rgba(34,197,94,0.15);color:#4ade80;font-size:10px;">Entrada</span><?php endif; ?>
                        <?php if($result->saida): ?><span class="vp-badge" style="background:rgba(59,130,246,0.15);color:#60a5fa;font-size:10px;">Saída</span><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Foto + Observações -->
    <?php if (!empty($result->foto) || !empty($result->observacoes)): ?>
    <div class="vp-card">
        <div class="vp-card-head"><i class='bx bx-image' style="color:#60a5fa;"></i><span>Foto & Observações</span></div>
        <div class="vp-card-body">
            <div class="vp-grid">
                <?php if (!empty($result->foto)): ?>
                <div><img src="<?= $result->foto ?>" style="max-height:160px;max-width:100%;object-fit:contain;border-radius:10px;border:1px solid rgba(255,255,255,0.07);background:#13151f;padding:6px;" alt="Foto"></div>
                <?php endif; ?>
                <?php if (!empty($result->observacoes)): ?>
                <div class="vp-row"><span class="vp-lbl">Observações</span><div style="background:#13151f;border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:10px 14px;font-size:13px;color:#c9cad6;margin-top:4px;line-height:1.6;"><?= nl2br(htmlspecialchars($result->observacoes)) ?></div></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Valor em estoque -->
    <div class="vp-card">
        <div class="vp-card-head"><i class='bx bx-dollar' style="color:#fbbf24;"></i><span>Valor em Estoque</span></div>
        <div class="vp-card-body">
            <div class="vp-grid-3">
                <div style="background:#13151f;border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:11px;color:#9ca3af;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Valor de Custo</div>
                    <div style="font-size:16px;font-weight:800;color:#9ca3af;">R$ <?= number_format($result->estoque * $result->precoCompra,2,',','.') ?></div>
                </div>
                <div style="background:#13151f;border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:11px;color:#9ca3af;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Valor de Venda</div>
                    <div style="font-size:16px;font-weight:800;color:#fbbf24;">R$ <?= number_format($result->estoque * $result->precoVenda,2,',','.') ?></div>
                </div>
                <div style="background:#13151f;border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:11px;color:#9ca3af;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Lucro Potencial</div>
                    <div style="font-size:16px;font-weight:800;color:#4ade80;">R$ <?= number_format($result->estoque * ($result->precoVenda - $result->precoCompra),2,',','.') ?></div>
                </div>
            </div>
        </div>
    </div>

</div>
