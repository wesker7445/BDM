<?php
    // Asumiendo que ya tienes la conexión $pdo disponible
    try {
        // Obtener Clientes (Opción 0)
        $stmtClientes = $pdo->prepare("CALL SP_GestionarSiniestro(0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        $stmtClientes->execute();
        $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
        $stmtClientes->closeCursor();

        // Obtener Aseguradoras (Opción 1)
        $stmtAseg = $pdo->prepare("CALL SP_GestionarSiniestro(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        $stmtAseg->execute();
        $aseguradoras = $stmtAseg->fetchAll(PDO::FETCH_ASSOC);
        $stmtAseg->closeCursor();

        $stmtCoches = $pdo->prepare("CALL SP_GestionarSiniestro(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        $stmtCoches->execute();
        $coches = $stmtCoches->fetchAll(PDO::FETCH_ASSOC);
        $stmtCoches->closeCursor();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<section id="sec-crear-siniestro" class="content-section hidden">
    <header class="top-bar">
        <h2>Reportar Nuevo Siniestro</h2>
    </header>

    <div class="form-siniestro-container">
        <form action="../Procesos/procesar_siniestro.php" method="POST" enctype="multipart/form-data">
            
            <div class="grupo-input">
                <label><i class="fa-solid fa-heading"></i> Título del Siniestro</label>
                <input type="text" name="titulo" placeholder="Ej. Choque lateral Aveo" required>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-building-shield"></i> Aseguradora</label>
                <select name="id_aseguradora" required>
                    <option value="" disabled selected>Seleccione una aseguradora</option>
                    <?php foreach($aseguradoras as $a): ?>
                        <option value="<?= $a['IdAseguradora'] ?>"><?= $a['Nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-user"></i> Asegurado Responsable</label>
                <select name="id_asegurado" required>
                    <option value="" disabled selected>Seleccione el cliente</option>
                    <?php foreach($clientes as $c): ?>
                        <option value="<?= $c['IdUsuario'] ?>"><?= $c['Nombre_Completo'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-file-contract"></i> Número de Póliza</label>
                <input type="text" name="num_poliza" placeholder="Ej. POL-123456" required>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-id-card"></i> Placas del Vehículo</label>
                <select name="placas_auto" required>
                    <option value="" disabled selected>Seleccione las placas</option>
                    <?php foreach($coches as $c): ?>
                        <option value="<?= $c['Placa'] ?>"><?= $c['Placa'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-location-dot"></i> Ubicación del Siniestro</label>
                <input type="text" name="ubicacion" placeholder="Ej. Av. Insurgentes Sur #45, CDMX" required>
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-truck-pickup"></i> Otras Unidades Involucradas (Opcional)</label>
                <input type="text" name="otras_unidades" placeholder="Ej. Camión repartidor, Motocicleta">
            </div>

            <div class="grupo-input">
                <label><i class="fa-solid fa-pen-to-square"></i> Declaración del Asegurado</label>
                <textarea name="declaracion" id="descS" placeholder="Describa brevemente lo sucedido..." required></textarea>
            </div>
            
            <div class="grupo-input">
                <label><i class="fa-solid fa-camera"></i> Evidencia Multimedia</label>
                <input type="file" name="evidencia[]" multiple class="input-oculto" id="file-input">
                <label for="file-input" class="boton-archivo">Seleccionar Fotos/Videos</label>
            </div>

            <input type="submit" class="boton-submit" value="Dar de Alta Siniestro e Involucrado">
        </form>
    </div>
</section>