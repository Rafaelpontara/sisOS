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
</style>

<div class="new122 sf-wrap">
    <div class="pg-title" style="font-size:20px;font-weight:800;color:#e8eaf0;margin-bottom:18px;display:flex;align-items:center;gap:9px;">
        <i class='bx bx-bulb' style="color:#a78bfa;font-size:22px;"></i> Nova Solução Técnica
    </div>

    <?php if (!empty($custom_error)) echo $custom_error; ?>

    <form method="post" action="<?= site_url('solucoes/adicionar') ?>" enctype="multipart/form-data" class="sf-card">
        <div class="sf-row">
            <label class="sf-label">Título *</label>
            <input type="text" name="titulo" class="sf-input" placeholder="Ex: iPhone 11 não carrega mesmo com cabo novo" required>
        </div>
        <div class="sf-row">
            <label class="sf-label">Equipamento / Modelo</label>
            <input type="text" name="equipamento" class="sf-input" placeholder="Ex: iPhone 11">
        </div>
        <div class="sf-row">
            <label class="sf-label">Problema *</label>
            <textarea name="problema" class="sf-textarea" rows="3" placeholder="Descreva o sintoma/problema encontrado" required></textarea>
        </div>
        <div class="sf-row">
            <label class="sf-label">Solução *</label>
            <textarea name="solucao" class="sf-textarea" rows="5" placeholder="Descreva passo a passo como foi resolvido" required></textarea>
        </div>

        <div class="sf-row">
            <label class="sf-label">Fotos (pode escolher várias)</label>
            <div class="sf-upload">
                <input type="file" name="fotos[]" accept="image/*" multiple>
                <div class="sf-hint">JPG, PNG ou WEBP — até 5MB cada</div>
            </div>
        </div>

        <div class="sf-row">
            <label class="sf-label">Vídeo (opcional — envie um arquivo OU cole um link)</label>
            <div class="sf-upload">
                <input type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                <div class="sf-hint">MP4, WEBM ou MOV — até 30MB</div>
            </div>
            <input type="text" name="video_url" class="sf-input" style="margin-top:8px;" placeholder="Ou cole um link (YouTube, Google Drive, etc.)">
        </div>

        <div style="display:flex;gap:10px;margin-top:18px;">
            <button type="submit" class="sf-btn"><i class='bx bx-save'></i> Salvar Solução</button>
            <a href="<?= site_url('solucoes') ?>" style="padding:10px 22px;border-radius:8px;background:#1e2235;color:#c9cad6;text-decoration:none;font-size:13px;font-weight:700;">Cancelar</a>
        </div>
    </form>
</div>
