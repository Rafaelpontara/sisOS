?>
<!-- application/views/os/_senha_celular.php -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="bx bx-lock-alt me-2"></i>Senha do Celular</h5>
    </div>
    <div class="card-body">
        <?php
            $senhaAtual  = isset($result->senha_tipo)  ? $result->senha_tipo  : '';
            $valorAtual  = isset($result->senha_valor) ? $result->senha_valor : '';
        ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tipo de Senha</label>
                <select name="senha_tipo" id="senhaTipo" class="form-select" onchange="sisosToggleSenha()">
                    <option value=""       <?= $senhaAtual==''           ? 'selected':'' ?>>Sem senha</option>
                    <option value="pin"    <?= $senhaAtual=='pin'        ? 'selected':'' ?>>PIN / Código</option>
                    <option value="padrao" <?= $senhaAtual=='padrao'     ? 'selected':'' ?>>Padrão (Android)</option>
                    <option value="face"   <?= $senhaAtual=='face'       ? 'selected':'' ?>>Reconh. Facial</option>
                    <option value="digital"<?= $senhaAtual=='digital'    ? 'selected':'' ?>>Digital</option>
                    <option value="iphone_face"   <?= $senhaAtual=='iphone_face'    ? 'selected':'' ?>>Face ID (iPhone)</option>
                    <option value="iphone_digital"<?= $senhaAtual=='iphone_digital' ? 'selected':'' ?>>Touch ID (iPhone)</option>
                </select>
            </div>

            <div class="col-md-8" id="wrapSenhaPin" style="display:<?= in_array($senhaAtual,['pin']) ? 'block':'none' ?>">
                <label class="form-label">PIN / Código</label>
                <input type="password" name="senha_valor" id="senhaValor"
                       class="form-control" maxlength="8"
                       inputmode="numeric" pattern="[0-9]*"
                       value="<?= htmlspecialchars($valorAtual) ?>"
                       placeholder="Dígitos do código">
                <div class="form-text">Somente números. Será impresso no comprovante.</div>
            </div>

            <div class="col-md-8" id="wrapSenhaPadrao" style="display:<?= $senhaAtual=='padrao' ? 'block':'none' ?>">
                <label class="form-label">Sequência do Padrão</label>
                <input type="text" name="senha_valor" id="senhaValorPadrao"
                       class="form-control"
                       value="<?= htmlspecialchars($valorAtual) ?>"
                       placeholder="Ex: 1-2-5-8 (posições 1-9 do grid 3x3)">
                <div class="form-text">Use posições de 1 a 9 separadas por traço. Será impresso no comprovante.</div>
                <!-- Mini-grid de padrão -->
                <div id="padraoGrid" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;max-width:140px;">
                    <?php for($i=1;$i<=9;$i++): ?>
                    <div class="padrao-pt" data-n="<?= $i ?>"
                         style="width:36px;height:36px;border-radius:50%;background:#252a3a;border:1.5px solid #2e3447;
                                display:flex;align-items:center;justify-content:center;cursor:pointer;
                                font-size:13px;font-weight:700;color:#9ca3af;transition:all .15s;"
                         onclick="sisosPatternClick(<?= $i ?>)">
                        <?= $i ?>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="button" onclick="sisosPatternClear()" class="btn btn-sm btn-outline-danger mt-2">
                    <i class="bx bx-refresh"></i> Limpar
                </button>
            </div>

            <div class="col-md-8" id="wrapSenhaBio"
                 style="display:<?= in_array($senhaAtual,['face','digital','iphone_face','iphone_digital']) ? 'block':'none' ?>">
                <div class="alert alert-warning py-2 px-3 mb-0">
                    <i class="bx bx-info-circle me-1"></i>
                    Biometria registrada. Será indicada no comprovante.
                </div>
            </div>
        </div>
    </div>
</div>