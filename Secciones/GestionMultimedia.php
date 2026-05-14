<?php
// Obtener la lista de siniestros para el selector
$stmt = $pdo->prepare("CALL SP_GestionarSiniestro(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
$stmt->execute();
$siniestrosParaSelect = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
?>

<section id="sec-gestion-multimedia" class="content-section hidden">
    <div class="form-siniestro-container">
        <h3>Gestionar Evidencia de Siniestros</h3>
        
        <div class="grupo-input">
            <label>Seleccionar Siniestro:</label>
            <select id="selectSiniestro" onchange="cargarMultimedia(this.value)">
                <option value="">-- Seleccione un siniestro --</option>
                <?php foreach($siniestrosParaSelect as $s): ?>
                    <option value="<?= $s['IdSiniestro'] ?>"><?= htmlspecialchars($s['Titulo']) ?> (ID: <?= $s['IdSiniestro'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="contenedor-multimedia-dinamico" class="siniestros-grid" style="margin-top: 20px;">
            <p style="color: gray;">Seleccione un siniestro para ver su multimedia.</p>
        </div>

        <div id="form-nueva-multimedia" class="hidden" style="margin-top: 20px; border-top: 1px solid #444; padding-top: 20px;">
            <h4>Agregar Nueva Foto/Video</h4>
            <form action="../Procesos/actualizar_multimedia.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_siniestro_input" id="id_siniestro_input">
                <div class="grupo-input">
                    <label class="boton-archivo">
                        <i class="fa-solid fa-plus"></i> Seleccionar Archivos
                        <input type="file" name="nueva_evidencia[]" multiple accept="image/*,video/*" required style="display:none;">
                    </label>
                </div>
                <input type="submit" class="boton-submit" value="Subir Archivos">
            </form>
        </div>
    </div>
</section>