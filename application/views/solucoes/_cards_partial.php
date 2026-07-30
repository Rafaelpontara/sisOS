<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="sol-empty">
        <i class='bx bx-bulb'></i>
        Nenhuma solução cadastrada ainda.<br>Clique em "Nova Solução" para começar sua base de conhecimento.
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r): ?>
<a href="<?= base_url() ?>index.php/solucoes/visualizar/<?= $r->id ?>" class="sol-card" data-search="<?= htmlspecialchars(mb_strtolower($r->titulo . ' ' . $r->equipamento)) ?>">
    <div class="sol-icon"><i class='bx bx-bulb'></i></div>
    <div class="sol-titulo"><?= htmlspecialchars($r->titulo) ?></div>
    <?php if (!empty($r->equipamento)): ?>
    <div class="sol-equip"><i class='bx bx-devices'></i> <?= htmlspecialchars($r->equipamento) ?></div>
    <?php endif; ?>
    <div class="sol-resumo"><?= htmlspecialchars(mb_substr(strip_tags($r->problema), 0, 90)) ?>...</div>
    <div class="sol-foot">
        <span><i class='bx bx-show'></i> <?= (int)$r->visualizacoes ?></span>
        <span><?= date('d/m/Y', strtotime($r->dataCriacao)) ?></span>
    </div>
</a>
<?php endforeach; endif; ?>
