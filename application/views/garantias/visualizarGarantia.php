<style>
.vg *,.vg *::before,.vg *::after{box-sizing:border-box;}
.vg{max-width:860px;margin:0 auto;font-family:inherit;}

/* Header */
.vg-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.vg-title{font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.vg-title i{color:#34d399;font-size:22px;}
.vg-actions{display:flex;gap:7px;flex-wrap:wrap;}

/* Buttons */
.vg-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 15px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;white-space:nowrap;}
.vg-btn:hover{transform:translateY(-1px);text-decoration:none;}
.vg-btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;}
.vg-btn-ghost{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}

/* Card */
.vg-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.vg-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.vg-card-head i{font-size:15px;}
.vg-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.vg-card-body{padding:16px;}

/* Emitente header */
.vg-emitente{display:flex;align-items:center;gap:16px;padding:16px;background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.06);}
.vg-emitente img{height:52px;object-fit:contain;border-radius:6px;}
.vg-emitente-info{flex:1;}
.vg-emitente-name{font-size:16px;font-weight:800;color:#e8eaf0;}
.vg-emitente-detail{font-size:12px;color:#9ca3af;margin-top:2px;}
.vg-emitente-id{text-align:right;font-size:12px;color:#6b7280;}
.vg-emitente-id strong{display:block;font-size:18px;font-weight:800;color:#34d399;}

/* Info row */
.vg-info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
@media(max-width:580px){.vg-info-grid{grid-template-columns:1fr 1fr;}}
.vg-info-item{background:#13151f;border-radius:8px;padding:10px 12px;}
.vg-info-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;}
.vg-info-value{font-size:13px;font-weight:600;color:#e8eaf0;}

/* Responsável */
.vg-resp{background:#13151f;border-radius:10px;padding:12px 14px;}
.vg-resp-title{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;}
.vg-resp-name{font-size:15px;font-weight:800;color:#e8eaf0;margin-bottom:4px;}
.vg-resp-row{font-size:12px;color:#9ca3af;display:flex;align-items:center;gap:5px;margin-bottom:2px;}

/* Texto garantia */
.vg-texto{background:#13151f;border-radius:10px;padding:16px;font-size:13px;color:#c9cad6;line-height:1.8;border-left:3px solid #34d399;}
</style>

<div class="vg new122">

    <!-- Header -->
    <div class="vg-header">
        <div class="vg-title">
            <i class='bx bx-shield-check'></i>
            Termo de Garantia
            <span style="color:#6b7280;font-size:14px;font-weight:400;">#<?= $result->idGarantias ?></span>
        </div>
        <div class="vg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eGarantia')): ?>
            <a href="<?= base_url() ?>index.php/garantias/editar/<?= $result->idGarantias ?>" class="vg-btn vg-btn-success">
                <i class='bx bx-edit'></i> Editar
            </a>
            <?php endif; ?>
            <a href="<?= site_url() ?>/garantias/imprimir/<?= $result->idGarantias ?>" target="_blank" class="vg-btn vg-btn-ghost">
                <i class='bx bx-printer'></i> Imprimir
            </a>
            <a href="<?= base_url() ?>index.php/garantias" class="vg-btn vg-btn-ghost">
                <i class='bx bx-arrow-back'></i> Voltar
            </a>
        </div>
    </div>

    <!-- Emitente -->
    <?php if ($emitente): ?>
    <div class="vg-card">
        <div class="vg-emitente">
            <?php if ($emitente->url_logo): ?>
            <img src="<?= $emitente->url_logo ?>" alt="Logo">
            <?php endif; ?>
            <div class="vg-emitente-info">
                <div class="vg-emitente-name"><?= htmlspecialchars($emitente->nome) ?></div>
                <div class="vg-emitente-detail">
                    <?= $emitente->cnpj ?> &nbsp;|&nbsp;
                    <?= htmlspecialchars($emitente->rua . ', ' . $emitente->numero . ', ' . $emitente->bairro . ' — ' . $emitente->cidade . '/' . $emitente->uf) ?>
                </div>
                <div class="vg-emitente-detail">
                    <?= $emitente->email ?> &nbsp;|&nbsp; <?= $emitente->telefone ?>
                </div>
            </div>
            <div class="vg-emitente-id">
                <strong>#<?= $result->idGarantias ?></strong>
                Emissão: <?= date('d/m/Y') ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 16px;margin-bottom:14px;font-size:13px;color:#fca5a5;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-error-circle'></i>
        Configure os dados do emitente. <a href="<?= base_url() ?>index.php/sisos/emitente" style="color:#f87171;text-decoration:underline;margin-left:4px;">Configurar</a>
    </div>
    <?php endif; ?>

    <!-- Dados do Termo -->
    <div class="vg-card">
        <div class="vg-card-head"><i class='bx bx-calendar' style="color:#34d399;"></i><span>Dados do Termo</span></div>
        <div class="vg-card-body">
            <div class="vg-info-grid">
                <div class="vg-info-item">
                    <div class="vg-info-label">Data</div>
                    <div class="vg-info-value"><?= date('d/m/Y', strtotime($result->dataGarantia)) ?></div>
                </div>
                <div class="vg-info-item">
                    <div class="vg-info-label">Ref. Termo</div>
                    <div class="vg-info-value"><?= htmlspecialchars($result->refGarantia) ?></div>
                </div>
                <div class="vg-info-item">
                    <div class="vg-info-label">Nº Garantia</div>
                    <div class="vg-info-value" style="color:#34d399;">#<?= $result->idGarantias ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsável -->
    <div class="vg-card">
        <div class="vg-card-head"><i class='bx bx-user' style="color:#60a5fa;"></i><span>Responsável</span></div>
        <div class="vg-card-body">
            <div class="vg-resp">
                <div class="vg-resp-name"><?= htmlspecialchars($result->nome) ?></div>
                <?php if ($result->telefone): ?>
                <div class="vg-resp-row"><i class='bx bx-phone'></i> <?= $result->telefone ?></div>
                <?php endif; ?>
                <?php if ($result->email): ?>
                <div class="vg-resp-row"><i class='bx bx-envelope'></i> <?= $result->email ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Texto da Garantia -->
    <div class="vg-card">
        <div class="vg-card-head"><i class='bx bx-file-blank' style="color:#a78bfa;"></i><span>Texto da Garantia</span></div>
        <div class="vg-card-body">
            <div class="vg-texto">
                <?= printSafeHtml($result->textoGarantia) ?>
            </div>
        </div>
    </div>

</div>
