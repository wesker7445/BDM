<?php
// Secciones/RegistrarAseguradora.php
$listaAseguradoras = [];
try {
    $stmtAseg = $pdo->prepare("CALL SP_GestionarAseguradora(0, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    $stmtAseg->execute();
    $listaAseguradoras = $stmtAseg->fetchAll(PDO::FETCH_ASSOC);
    $stmtAseg->closeCursor(); 
} catch (PDOException $e) {
    error_log("Error al listar aseguradoras: " . $e->getMessage());
}
?>

<section id="sec-registrar-aseguradora" class="content-section hidden">
    <header class="top-bar">
        <h2><i class="fa-solid fa-building-shield"></i> Gestión de Aseguradoras</h2>
    </header>

    <div class="form-siniestro-container">
        <form action="../Procesos/procesar_aseguradora.php" method="POST" id="form-aseguradora">
            <h3 style="color: var(--text-primary); margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
                Registrar Nueva Aseguradora
            </h3>
            
            <input type="hidden" name="id_aseguradora" id="id_aseguradora">

            <div class="grupo-input">
                <label>Nombre de la Empresa</label>
                <input type="text" name="nombre_aseguradora" placeholder="Ej. Seguros Atlas" required>
            </div>

            <div class="grupo-input">
                <label>Representante legal</label>
                <input type="text" name="Representante_legal" placeholder="Ej. Alberto Mendez" required>
            </div>

            <div class="grupo-input">
                <label>RFC del representante</label>
                <input type="text" name="RFC" placeholder="Ej. MCD15CX23" required>
            </div>

            <div class="grid-2-columnas" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="grupo-input">
                    <label>Teléfono de Contacto</label>
                    <input type="tel" name="telefono" placeholder="811-000-0000">
                </div>
                <div class="grupo-input">
                    <label>Correo Electrónico de Soporte</label>
                    <input type="email" name="email_soporte" placeholder="contacto@seguro.com">
                </div>
            </div>

            <div class="grupo-input">
                <label>Dirección de la empresa</label>
                <input type="text" name="Direccion" placeholder="Ej. Av. Fidel Velazquez" required>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 15px;">
                <input type="submit" class="boton-submit" value="Guardar Aseguradora">
                <button type="reset" class="boton-cancelar">Limpiar</button>
            </div>
        </form>
    </div>

    <div class="form-siniestro-container" style="max-width: 850px; margin-top: 20px;">
        <h3>Aseguradoras en el Sistema</h3>
        <table style="width: 100%; color: var(--text-primary); border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="border-bottom: 2px solid #5d5dff;">
                    <th style="padding: 10px;">Nombre</th>
                    <th>RFC</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listaAseguradoras)): ?>
                    <?php foreach ($listaAseguradoras as $aseg): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center;">
                        <td style="padding: 10px; font-weight: bold;"><?php echo htmlspecialchars($aseg['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($aseg['RFC']); ?></td>
                        <td><?php echo htmlspecialchars($aseg['Telefono']); ?></td>
                        <td>
                            <button class="chat-icon-btn" style="color: #ff5d5d;" 
                                    onclick="eliminarAseguradora(<?php echo $aseg['IdAseguradora']; ?>, '<?php echo addslashes($aseg['Nombre']); ?>')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--text-primary);">
                            No hay aseguradoras registradas o activas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>