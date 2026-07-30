<style>
.sv-wrap{max-width:760px;}
.sv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.sv-titulo{font-size:21px;font-weight:800;color:#e8eaf0;}
.sv-equip{font-size:12.5px;color:#9ca3af;margin-top:4px;display:flex;align-items:center;gap:6px;}
.sv-actions{display:flex;gap:8px;}
.sv-btn{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;text-decoration:none;border:none;cursor:pointer;}
.sv-btn-edit{background:rgba(34,197,94,0.15);color:#4ade80;}
.sv-btn-del{background:rgba(239,68,68,0.15);color:#f87171;}

.sv-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:20px;margin-bottom:14px;}
.sv-card h5{font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;}
.sv-card p{color:#c9cad6;font-size:14px;line-height:1.6;white-space:pre-wrap;}

.sv-galeria{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;}
.sv-galeria a{display:block;border-radius:10px;overflow:hidden;aspect-ratio:1;background:#161925;position:relative;}
.sv-galeria img{width:100%;height:100%;object-fit:cover;}
.sv-galeria .video-thumb{display:flex;align-items:center;justify-content:center;height:100%;font-size:30px;color:#60a5fa;}

.sv-meta{font-size:11.5px;color:#6b7280;display:flex;gap:14px;margin-top:10px;}
</style>

<div class="new122 sv-wrap">
    <div class="sv-header">
        <div>
            <div class="sv-titulo"><?= htmlspecialchars($result->titulo) ?></div>
            <?php if (!empty($result->equipamento)): ?>
            <div class="sv-equip"><i class='bx bx-devices'></i> <?= htmlspecialchars($result->equipamento) ?></div>
            <?php endif; ?>
            <div class="sv-meta">
                <span><i class='bx bx-calendar'></i> <?= date('d/m/Y', strtotime($result->dataCriacao)) ?></span>
                <span><i class='bx bx-show'></i> <?= (int)$result->visualizacoes ?> visualizações</span>
            </div>
        </div>
        <div class="sv-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
            <a href="<?= site_url('solucoes/editar/' . $result->id) ?>" class="sv-btn sv-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
            <a href="#" onclick="if(confirm('Excluir esta solução?')){document.getElementById('formDelSol').submit();}return false;" class="sv-btn sv-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
            <?php endif; ?>
        </div>
    </div>

    <div class="sv-card">
        <h5><i class='bx bx-error-circle'></i> Problema</h5>
        <p><?= htmlspecialchars($result->problema) ?></p>
    </div>

    <div class="sv-card">
        <h5><i class='bx bx-check-circle'></i> Solução</h5>
        <p><?= htmlspecialchars($result->solucao) ?></p>
    </div>

    <?php if (!empty($midias)): ?>
    <div class="sv-card">
        <h5><i class='bx bx-images'></i> Fotos e Vídeos</h5>
        <div class="sv-galeria">
            <?php foreach ($midias as $m): ?>
                <?php if ($m->tipo === 'foto'): ?>
                <a href="<?= $m->caminho ?>" target="_blank"><img src="<?= $m->caminho ?>"></a>
                <?php else: ?>
                <a href="<?= $m->caminho ?>" target="_blank"><div class="video-thumb"><i class='bx bx-play-circle'></i></div></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <a href="<?= site_url('solucoes') ?>" style="display:inline-flex;align-items:center;gap:6px;color:#9ca3af;text-decoration:none;font-size:13px;margin-top:8px;">
        <i class='bx bx-arrow-back'></i> Voltar para a lista
    </a>
</div>

<form id="formDelSol" action="<?= site_url('solucoes/excluir') ?>" method="post" style="display:none;">
    <input type="hidden" name="id" value="<?= $result->id ?>">
</form>
