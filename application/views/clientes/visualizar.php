<style>
/* ── Layout ── */
.vcli-wrap{max-width:1000px;margin:0 auto;}
.vcli-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.vcli-title{display:flex;align-items:center;gap:10px;}
.vcli-title i{font-size:24px;color:#3b82f6;}
.vcli-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}

/* ── Tabs ── */
.vcli-tabs{display:flex;gap:4px;border-bottom:2px solid rgba(255,255,255,0.07);margin-bottom:16px;}
.vcli-tab{display:inline-flex;align-items:center;gap:6px;padding:10px 18px;font-size:13px;font-weight:700;color:#6b7280;cursor:pointer;border:none;background:none;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .15s;}
.vcli-tab:hover{color:#e8eaf0;}
.vcli-tab.active{color:#3b82f6;border-bottom-color:#3b82f6;}
.vcli-tab i{font-size:15px;}
.vcli-pane{display:none;}
.vcli-pane.active{display:block;}

/* ── Cards de seção ── */
.vcli-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:12px;}
.vcli-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.vcli-card-head i{font-size:15px;color:#3b82f6;}
.vcli-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.vcli-card-body{padding:16px;}

/* ── Grid de info ── */
.vcli-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:600px){.vcli-info-grid{grid-template-columns:1fr;}}
.vcli-field{display:flex;flex-direction:column;gap:3px;}
.vcli-field-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.vcli-field-val{font-size:13px;color:#e8eaf0;font-weight:500;}
.vcli-field-val.muted{color:#9ca3af;}

/* ── Bloqueado badge ── */
.vcli-blocked{display:inline-flex;align-items:center;gap:4px;background:rgba(239,68,68,0.15);color:#f87171;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;margin-left:8px;}
.vcli-type-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;}
.vcli-type-cli{background:rgba(59,130,246,0.15);color:#60a5fa;}
.vcli-type-forn{background:rgba(168,85,247,0.15);color:#c084fc;}

/* ── Tabelas ── */
.vcli-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:12px;}
.vcli-tbl{width:100%;border-collapse:collapse;}
.vcli-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;border-bottom:1px solid rgba(255,255,255,0.07);}
.vcli-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.vcli-tbl tbody tr:hover{background:rgba(59,130,246,0.04);}
.vcli-tbl tbody td{padding:9px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.vcli-tbl .empty-row td{text-align:center;padding:28px;color:#6b7280;}

/* ── Status OS badges ── */
.os-status{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.st-aberto{background:rgba(59,130,246,0.15);color:#60a5fa;}
.st-andamento{background:rgba(99,102,241,0.15);color:#a5b4fc;}
.st-orcamento{background:rgba(251,191,36,0.15);color:#fbbf24;}
.st-finalizado{background:rgba(34,197,94,0.15);color:#4ade80;}
.st-cancelado{background:rgba(239,68,68,0.15);color:#f87171;}
.st-default{background:rgba(156,163,175,0.15);color:#9ca3af;}

/* ── Ações ── */
.vcli-acts{display:flex;gap:5px;}
.act-btn{width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:all .12s;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;} .ab-v:hover{background:rgba(96,165,250,0.3);}
.ab-e{background:rgba(251,191,36,0.15);color:#fbbf24;} .ab-e:hover{background:rgba(251,191,36,0.3);}

/* ── Footer ── */
.vcli-footer{display:flex;justify-content:flex-end;gap:8px;margin-top:4px;}
.vcli-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.vcli-btn:hover{transform:translateY(-1px);text-decoration:none;}
.vcli-btn-edit{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.vcli-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.vcli-btn-back:hover{color:#e8eaf0;}
</style>

<?php
// Helper status badge
function vcliStatusBadge($status) {
    $map = [
        'Aberto'           => 'st-aberto',
        'Em Andamento'     => 'st-andamento',
        'Orçamento'        => 'st-orcamento',
        'Finalizado'       => 'st-finalizado',
        'Faturado'         => 'st-finalizado',
        'Cancelado'        => 'st-cancelado',
    ];
    $cls = isset($map[$status]) ? $map[$status] : 'st-default';
    return '<span class="os-status '.$cls.'">'.htmlspecialchars($status).'</span>';
}
?>

<div class="vcli-wrap new122">

    <!-- Header -->
    <div class="vcli-header">
        <div class="vcli-title">
            <i class='bx bx-user-circle'></i>
            <h2><?= htmlspecialchars($result->nomeCliente) ?></h2>
            <?php if (!empty($result->bloqueado)): ?>
            <span class="vcli-blocked"><i class='bx bx-lock'></i> BLOQUEADO</span>
            <?php endif; ?>
        </div>
        <a href="<?= site_url('clientes') ?>" class="vcli-btn vcli-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <!-- Tabs -->
    <div class="vcli-tabs">
        <button class="vcli-tab active" data-tab="vcliTab1">
            <i class='bx bx-id-card'></i> Dados do Cliente
        </button>
        <button class="vcli-tab" data-tab="vcliTab2">
            <i class='bx bx-file'></i> Ordens de Serviço
            <?php
            $totalOs = is_array($results) ? count($results) : 0;
            if ($totalOs > 0): ?>
            <span style="background:rgba(59,130,246,0.2);color:#60a5fa;font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;"><?= $totalOs ?></span>
            <?php endif; ?>
        </button>
        <button class="vcli-tab" data-tab="vcliTab3">
            <i class='bx bx-shopping-bag'></i> Vendas
            <?php
            $totalVendas = is_array($result_vendas) ? count($result_vendas) : 0;
            if ($totalVendas > 0): ?>
            <span style="background:rgba(168,85,247,0.2);color:#c084fc;font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;"><?= $totalVendas ?></span>
            <?php endif; ?>
        </button>
    </div>

    <!-- ── TAB 1: Dados ── -->
    <div class="vcli-pane active" id="vcliTab1">

        <!-- Dados Pessoais -->
        <div class="vcli-card">
            <div class="vcli-card-head"><i class='bx bx-user'></i><span>Dados Pessoais</span></div>
            <div class="vcli-card-body">
                <div class="vcli-info-grid">
                    <div class="vcli-field">
                        <span class="vcli-field-label">Nome / Razão Social</span>
                        <span class="vcli-field-val"><?= htmlspecialchars($result->nomeCliente) ?></span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Tipo</span>
                        <span class="vcli-field-val">
                            <span class="vcli-type-badge <?= $result->fornecedor ? 'vcli-type-forn' : 'vcli-type-cli' ?>">
                                <i class='bx <?= $result->fornecedor ? 'bx-building' : 'bx-user' ?>'></i>
                                <?= $result->fornecedor ? 'Fornecedor' : 'Cliente' ?>
                            </span>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">CPF / CNPJ</span>
                        <span class="vcli-field-val <?= empty($result->documento) ? 'muted' : '' ?>">
                            <?= !empty($result->documento) ? htmlspecialchars($result->documento) : '—' ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Data de Cadastro</span>
                        <span class="vcli-field-val"><?= date('d/m/Y', strtotime($result->dataCadastro)) ?></span>
                    </div>
                    <div class="vcli-field" style="grid-column:span 2;">
                        <span class="vcli-field-label">TAGs</span>
                        <span class="vcli-field-val">
                            <?php
                            try {
                                $this->db->select('ct.*');
                                $this->db->from('cliente_tags ct');
                                $this->db->join('clientes_tags clt', 'clt.cliente_tags_id = ct.idTag');
                                $this->db->where('clt.clientes_id', $result->idClientes);
                                $r_tags = $this->db->get();
                                $tagsCliente = $r_tags ? $r_tags->result() : [];
                            } catch (Exception $e) { $tagsCliente = []; }
                            foreach ($tagsCliente as $t): ?>
                            <span style="background:<?= htmlspecialchars($t->cor) ?>;color:#fff;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;margin:2px;">
                                <?= htmlspecialchars($t->tag) ?>
                            </span>
                            <?php endforeach; ?>
                            <?php if (empty($tagsCliente)): ?>
                            <span class="vcli-field-val muted">Nenhuma tag</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if (!empty($result->bloqueado) && !empty($result->motivo_bloqueio)): ?>
                    <div class="vcli-field" style="grid-column:span 2;">
                        <span class="vcli-field-label">Motivo do Bloqueio</span>
                        <span class="vcli-field-val" style="color:#f87171;"><?= htmlspecialchars($result->motivo_bloqueio) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Contatos -->
        <div class="vcli-card">
            <div class="vcli-card-head"><i class='bx bx-phone'></i><span>Contatos</span></div>
            <div class="vcli-card-body">
                <div class="vcli-info-grid">
                    <div class="vcli-field">
                        <span class="vcli-field-label">Contato</span>
                        <span class="vcli-field-val <?= empty($result->contato) ? 'muted' : '' ?>">
                            <?= !empty($result->contato) ? htmlspecialchars($result->contato) : '—' ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Telefone</span>
                        <span class="vcli-field-val <?= empty($result->telefone) ? 'muted' : '' ?>">
                            <?php if (!empty($result->telefone)): ?>
                            <a href="tel:<?= preg_replace('/\D/','',$result->telefone) ?>" style="color:#60a5fa;text-decoration:none;">
                                <i class='bx bx-phone' style="font-size:13px;"></i> <?= htmlspecialchars($result->telefone) ?>
                            </a>
                            <?php else: ?>—<?php endif; ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Celular / WhatsApp</span>
                        <span class="vcli-field-val <?= empty($result->celular) ? 'muted' : '' ?>">
                            <?php if (!empty($result->celular)): ?>
                            <a href="https://wa.me/55<?= preg_replace('/\D/','',$result->celular) ?>" target="_blank" style="color:#4ade80;text-decoration:none;">
                                <i class='bx bxl-whatsapp' style="font-size:13px;"></i> <?= htmlspecialchars($result->celular) ?>
                            </a>
                            <?php else: ?>—<?php endif; ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">E-mail</span>
                        <span class="vcli-field-val <?= empty($result->email) ? 'muted' : '' ?>">
                            <?php if (!empty($result->email)): ?>
                            <a href="mailto:<?= htmlspecialchars($result->email) ?>" style="color:#60a5fa;text-decoration:none;">
                                <i class='bx bx-envelope' style="font-size:13px;"></i> <?= htmlspecialchars($result->email) ?>
                            </a>
                            <?php else: ?>—<?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endereço -->
        <div class="vcli-card">
            <div class="vcli-card-head"><i class='bx bx-map'></i><span>Endereço</span></div>
            <div class="vcli-card-body">
                <div class="vcli-info-grid">
                    <div class="vcli-field" style="grid-column:span 2;">
                        <span class="vcli-field-label">Logradouro</span>
                        <span class="vcli-field-val <?= empty($result->rua) ? 'muted' : '' ?>">
                            <?php
                            $end = array_filter([
                                $result->rua ?? '',
                                $result->numero ? 'nº '.$result->numero : '',
                                $result->complemento ?? '',
                            ]);
                            echo !empty($end) ? htmlspecialchars(implode(', ', $end)) : '—';
                            ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Bairro</span>
                        <span class="vcli-field-val <?= empty($result->bairro) ? 'muted' : '' ?>">
                            <?= !empty($result->bairro) ? htmlspecialchars($result->bairro) : '—' ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">CEP</span>
                        <span class="vcli-field-val <?= empty($result->cep) ? 'muted' : '' ?>">
                            <?= !empty($result->cep) ? htmlspecialchars($result->cep) : '—' ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Cidade</span>
                        <span class="vcli-field-val <?= empty($result->cidade) ? 'muted' : '' ?>">
                            <?= !empty($result->cidade) ? htmlspecialchars($result->cidade) : '—' ?>
                        </span>
                    </div>
                    <div class="vcli-field">
                        <span class="vcli-field-label">Estado</span>
                        <span class="vcli-field-val <?= empty($result->estado) ? 'muted' : '' ?>">
                            <?= !empty($result->estado) ? htmlspecialchars($result->estado) : '—' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /#vcliTab1 -->

    <!-- ── TAB 2: OS ── -->
    <div class="vcli-pane" id="vcliTab2">
        <div class="vcli-tbl-wrap">
            <table class="vcli-tbl">
                <thead>
                    <tr>
                        <th style="width:70px;">N° OS</th>
                        <th style="width:110px;">Data Inicial</th>
                        <th style="width:110px;">Data Final</th>
                        <th>Descrição</th>
                        <th>Defeito</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:80px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($results)): foreach ($results as $r): ?>
                    <tr>
                        <td style="color:#6b7280;font-size:12px;">#<?= str_pad($r->idOs, 4, '0', STR_PAD_LEFT) ?></td>
                        <td style="font-size:12px;"><?= date('d/m/Y', strtotime($r->dataInicial)) ?></td>
                        <td style="font-size:12px;color:#9ca3af;">
                            <?= ($r->dataFinal && $r->dataFinal != '0000-00-00') ? date('d/m/Y', strtotime($r->dataFinal)) : '—' ?>
                        </td>
                        <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;">
                            <?= htmlspecialchars(strip_tags($r->descricaoProduto ?? '')) ?: '—' ?>
                        </td>
                        <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;color:#9ca3af;">
                            <?= htmlspecialchars(strip_tags($r->defeito ?? '')) ?: '—' ?>
                        </td>
                        <td><?= vcliStatusBadge($r->status) ?></td>
                        <td>
                            <div class="vcli-acts">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')): ?>
                                <a href="<?= base_url() ?>index.php/os/visualizar/<?= $r->idOs ?>" class="act-btn ab-v" title="Visualizar">
                                    <i class='bx bx-show'></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
                                <a href="<?= base_url() ?>index.php/os/editar/<?= $r->idOs ?>" class="act-btn ab-e" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr class="empty-row"><td colspan="7">Nenhuma OS cadastrada para este cliente.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /#vcliTab2 -->

    <!-- ── TAB 3: Vendas ── -->
    <div class="vcli-pane" id="vcliTab3">
        <div class="vcli-tbl-wrap">
            <table class="vcli-tbl">
                <thead>
                    <tr>
                        <th style="width:80px;">N° Venda</th>
                        <th style="width:120px;">Data</th>
                        <th style="width:100px;">Faturado</th>
                        <th style="width:130px;">Total</th>
                        <th style="width:80px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($result_vendas)): foreach ($result_vendas as $r): ?>
                    <tr>
                        <td style="color:#6b7280;font-size:12px;">#<?= str_pad($r->idVendas, 4, '0', STR_PAD_LEFT) ?></td>
                        <td style="font-size:12px;"><?= date('d/m/Y', strtotime($r->dataVenda)) ?></td>
                        <td>
                            <?php if ($r->faturado): ?>
                            <span class="os-status st-finalizado">Sim</span>
                            <?php else: ?>
                            <span class="os-status st-orcamento">Não</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:700;color:#fbbf24;">
                            R$ <?= number_format($r->valorTotal, 2, ',', '.') ?>
                        </td>
                        <td>
                            <div class="vcli-acts">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')): ?>
                                <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $r->idVendas ?>" class="act-btn ab-v" title="Visualizar">
                                    <i class='bx bx-show'></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')): ?>
                                <a href="<?= base_url() ?>index.php/vendas/editar/<?= $r->idVendas ?>" class="act-btn ab-e" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr class="empty-row"><td colspan="5">Nenhuma venda cadastrada para este cliente.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /#vcliTab3 -->

    <!-- Footer -->
    <div class="vcli-footer">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')): ?>
        <a href="<?= base_url() ?>index.php/clientes/editar/<?= $result->idClientes ?>" class="vcli-btn vcli-btn-edit">
            <i class='bx bx-edit'></i> Editar Cliente
        </a>
        <?php endif; ?>
        <a href="<?= site_url('clientes') ?>" class="vcli-btn vcli-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

</div><!-- /.vcli-wrap -->

<script>
$(document).ready(function() {
    $('.vcli-tab').on('click', function() {
        var target = $(this).data('tab');
        $('.vcli-tab').removeClass('active');
        $('.vcli-pane').removeClass('active');
        $(this).addClass('active');
        $('#' + target).addClass('active');
    });
});
</script>
