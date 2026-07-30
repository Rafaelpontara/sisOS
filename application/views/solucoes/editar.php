<style>
.sf-wrap{max-width:700px;}
.sf-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:22px;}
.sf-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;display:block;}
.sf-input,.sf-textarea{width:100%;background:#1e2133;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:10px 12px;font-size:13px;box-sizing:border-box;}
.sf-input:focus,.sf-textarea:focus{outline:none;border-color:#a78bfa;}
.sf-row{margin-bottom:16px;}
.sf-upload{border:1.5px dashed #444860;border-radius:10px;padding:16px;text-align:center;background:#161925;}
.sf-upload input[type=file]{color:#9ca3af;font-size:12.5px;}
.sf-hint{font-size:11px;color:#6b7280;margin-top:5px;}
.sf-btn{padding:10px 22px;border-radius:8px;background:linear-gradient(135deg,#a78bfa,#7c3aed);color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;}
.sf-midia-atual{display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:10px;margin-bottom:14px;}
.sf-midia-item{position:relative;border-radius:8px;overflow:hidden;background:#161925;aspect-ratio:1;}
.sf-midia-item img{width:100%;height:100%;object-fit:cover;}
.sf-midia-item .video-icon{display:flex;align-items:center;justify-content:center;height:100%;font-size:24px;color:#60a5fa;}
.sf-midia-del{position:absolute;top:4px;right:4px;background:rgba(239,68,68,0.9);color:#fff;border:none;border-radius:50%;width:22px;height:22px;font-size:12px;cursor:pointer;}
</style>

<div class="new122 sf-wrap">
    <div class="pg-title" style="font-size:20px;font-weight:800;color:#e8eaf0;margin-bottom:18px;display:flex;align-items:center;gap:9px;">
        <i class='bx bx-edit' style="color:#a78bfa;font-size:22px;"></i> Editar Solução Técnica
    </div>

    <?php if (!empty($custom_error)) echo $custom_error; ?>

    <form method="post" action="<?= site_url('solucoes/editar/' . $result->id) ?>" enctype="multipart/form-data" class="sf-card">
        <div class="sf-row">
            <label class="sf-label">Título *</label>
            <input type="text" name="titulo" class="sf-input" value="<?= htmlspecialchars($result->titulo) ?>" required>
        </div>
        <div class="sf-row">
            <label class="sf-label">Equipamento / Modelo</label>
            <input type="text" name="equipamento" class="sf-input" value="<?= htmlspecialchars($result->equipamento ?? '') ?>">
        </div>
        <div class="sf-row">
            <label class="sf-label">Problema *</label>
            <textarea name="problema" class="sf-textarea" rows="3" required><?= htmlspecialchars($result->problema) ?></textarea>
        </div>
        <div class="sf-row">
            <label class="sf-label">Solução *</label>
            <textarea name="solucao" class="sf-textarea" rows="5" required><?= htmlspecialchars($result->solucao) ?></textarea>
        </div>

        <?php if (!empty($midias)): ?>
        <div class="sf-row">
            <label class="sf-label">Anexos Atuais</label>
            <div class="sf-midia-atual">
                <?php foreach ($midias as $m): ?>
                <div class="sf-midia-item">
                    <?php if ($m->tipo === 'foto'): ?>
                    <img src="<?= $m->caminho ?>">
                    <?php else: ?>
                    <div class="video-icon"><i class='bx bx-play-circle'></i></div>
                    <?php endif; ?>
                    <button type="button" class="sf-midia-del" onclick="this.closest('.sf-midia-item').style.opacity='0.25';this.nextElementSibling.checked=true;" title="Marcar para remover">&times;</button>
                    <input type="checkbox" name="remover_midia[]" value="<?= $m->id ?>" style="display:none;">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="sf-hint">Clique no "×" pra marcar um anexo para remoção (só será removido ao salvar).</div>
        </div>
        <?php endif; ?>

        <div class="sf-row">
            <label class="sf-label">Adicionar mais fotos</label>
            <div class="sf-upload">
                <input type="file" name="fotos[]" accept="image/*" multiple>
                <div class="sf-hint">JPG, PNG ou WEBP — até 5MB cada</div>
            </div>
        </div>

        <div class="sf-row">
            <label class="sf-label">Adicionar vídeo (opcional)</label>
            <div class="sf-upload">
                <input type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                <div class="sf-hint">MP4, WEBM ou MOV — até 30MB</div>
            </div>
            <input type="text" name="video_url" class="sf-input" style="margin-top:8px;" placeholder="Ou cole um link (YouTube, Google Drive, etc.)">
        </div>

        <div style="display:flex;gap:10px;margin-top:18px;">
            <button type="submit" class="sf-btn"><i class='bx bx-save'></i> Salvar Alterações</button>
            <a href="<?= site_url('solucoes/visualizar/' . $result->id) ?>" style="padding:10px 22px;border-radius:8px;background:#1e2235;color:#c9cad6;text-decoration:none;font-size:13px;font-weight:700;">Cancelar</a>
        </div>
    </form>
</div>
