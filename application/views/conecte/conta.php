<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-user-circle' style="color:#6366f1;"></i> Minha Conta
    </h2>
    <a href="<?= base_url() ?>index.php/mine/editarDados/<?= $result->idClientes ?>" class="mc-btn mc-btn-primary">
        <i class='bx bx-edit'></i> Editar Dados
    </a>
</div>

<!-- Dados pessoais -->
<div class="mc-card">
    <div class="mc-card-head">
        <div class="mc-card-head-left"><i class='bx bx-id-card' style="color:#6366f1;"></i><span>Dados Pessoais</span></div>
    </div>
    <div class="mc-card-body">
        <div class="mc-grid-2">
            <div class="mc-info-row"><span class="mc-info-lbl">Nome</span><span class="mc-info-val" style="font-weight:700;"><?= htmlspecialchars($result->nomeCliente) ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">Contato</span><span class="mc-info-val"><?= htmlspecialchars($result->contato??'—') ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">CPF / CNPJ</span><span class="mc-info-val"><?= htmlspecialchars($result->documento??'—') ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">Cliente desde</span><span class="mc-info-val"><?= date('d/m/Y',strtotime($result->dataCadastro)) ?></span></div>
        </div>
    </div>
</div>

<!-- Contatos -->
<div class="mc-card">
    <div class="mc-card-head">
        <div class="mc-card-head-left"><i class='bx bx-phone' style="color:#22c55e;"></i><span>Contatos</span></div>
    </div>
    <div class="mc-card-body">
        <div class="mc-grid-2">
            <div class="mc-info-row">
                <span class="mc-info-lbl">Telefone</span>
                <span class="mc-info-val"><?= htmlspecialchars($result->telefone??'—') ?></span>
            </div>
            <div class="mc-info-row">
                <span class="mc-info-lbl">Celular / WhatsApp</span>
                <span class="mc-info-val">
                    <?php if (!empty($result->celular)): ?>
                    <a href="https://wa.me/55<?= preg_replace('/\D/','',$result->celular) ?>" target="_blank" style="color:#4ade80;text-decoration:none;">
                        <i class='bx bxl-whatsapp'></i> <?= htmlspecialchars($result->celular) ?>
                    </a>
                    <?php else: ?>—<?php endif; ?>
                </span>
            </div>
            <div class="mc-info-row" style="grid-column:span 2;">
                <span class="mc-info-lbl">E-mail</span>
                <span class="mc-info-val">
                    <?php if (!empty($result->email)): ?>
                    <a href="mailto:<?= htmlspecialchars($result->email) ?>" style="color:#60a5fa;text-decoration:none;">
                        <i class='bx bx-envelope'></i> <?= htmlspecialchars($result->email) ?>
                    </a>
                    <?php else: ?>—<?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Endereço -->
<div class="mc-card">
    <div class="mc-card-head">
        <div class="mc-card-head-left"><i class='bx bx-map' style="color:#60a5fa;"></i><span>Endereço</span></div>
    </div>
    <div class="mc-card-body">
        <div class="mc-grid-2">
            <?php
            $end = array_filter([$result->rua??'', $result->numero?'nº '.$result->numero:'', $result->complemento??'']);
            ?>
            <div class="mc-info-row" style="grid-column:span 2;">
                <span class="mc-info-lbl">Logradouro</span>
                <span class="mc-info-val"><?= !empty($end)?htmlspecialchars(implode(', ',$end)):'—' ?></span>
            </div>
            <div class="mc-info-row"><span class="mc-info-lbl">Bairro</span><span class="mc-info-val"><?= htmlspecialchars($result->bairro??'—') ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">CEP</span><span class="mc-info-val"><?= htmlspecialchars($result->cep??'—') ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">Cidade</span><span class="mc-info-val"><?= htmlspecialchars($result->cidade??'—') ?></span></div>
            <div class="mc-info-row"><span class="mc-info-lbl">Estado</span><span class="mc-info-val"><?= htmlspecialchars($result->estado??'—') ?></span></div>
        </div>
    </div>
</div>
