<?php
// Secciones/GestionVehiculos.php
$listaCoches = [];
try {
    // Usamos prepare en lugar de query para mayor seguridad con SPs
    $stmtVehiculos = $pdo->prepare("CALL SP_GestionarVehiculo(0, NULL, NULL, NULL, NULL, NULL, NULL)");
    $stmtVehiculos->execute();
    
    // Obtenemos los datos
    $listaCoches = $stmtVehiculos->fetchAll(PDO::FETCH_ASSOC);
    
    // --- IMPORTANTE: Limpiar los resultados pendientes del SP ---
    $stmtVehiculos->closeCursor(); 

} catch (PDOException $e) {
    error_log("Error al listar vehículos: " . $e->getMessage());
}
?>
<section id="sec-gestion-vehiculos" class="content-section hidden">
    <header class="top-bar">
        <h2><i class="fa-solid fa-car-rear"></i> Panel de Vehículos</h2>
    </header>

    <div class="form-siniestro-container">
        <form id="form-vehiculo" class="form-vehiculo" action="../Procesos/procesar_vehiculo.php" method="POST">
            <h3 id="form-vehiculo-titulo">Registrar Nuevo Vehículo</h3>
            <input type="hidden" name="id_vehiculo" id="id_vehiculo"> 
            
            <div class="grid-2-columnas" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="grupo-input">
                    <label>Placas</label>
                    <input type="text" name="placas" id="v_placas" required>
                </div>
                <div class="grupo-input">
                    <label>Número de Serie (VIN)</label>
                    <input type="text" name="serie" id="v_serie" required>
                </div>
            </div>

            <div class="grupo-input">
                <label>Marca</label>
                <input type="text" name="marca" id="v_marca" required>
            </div>

            <div class="grupo-input">
                <label>Modelo</label>
                <input type="text" name="modelo" id="v_modelo" required>
            </div>

            <div class="grid-2-columnas" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="grupo-input">
                    <label>Color</label>
                    <input type="text" name="color" id="v_color" required>
                </div>
                <div class="grupo-input">
                    <label>Tipo</label>
                    <input type="text" name="tipo" id="v_tipo" required>
                </div>
            </div>

            <div class="perfil-acciones">
                <input type="submit" id="btn-submit-vehiculo" class="boton-submit" value="Guardar Vehículo">
                <button type="button" class="boton-cancelar" onclick="limpiarFormularioVehiculo()">Limpiar</button>
            </div>
        </form>
    </div>

    <div class="form-siniestro-container" style="max-width: 850px;">
        <h3>Vehículos en el Sistema</h3>
        <table style="width: 100%; color: var(--text-primary); border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #5d5dff;">
                    <th>Placa</th>
                    <th>Marca/Modelo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>

                <tr style="border-bottom: 1px solid var(--input-border); text-align: center;">
                
            </thead>
                <tbody>
                <?php if (!empty($listaCoches)): ?>
                    <?php foreach ($listaCoches as $coche): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center;">
                        <td style="padding: 10px;"><?php echo htmlspecialchars($coche['Placa']); ?></td>
                        <td><?php echo htmlspecialchars($coche['Marca'] . " " . $coche['Modelo']); ?></td>
                        <td>
                            <span class="status-table"><?php echo htmlspecialchars($coche['EstadoTexto']); ?></span>
                        </td>
                        <td>
                            <button class="chat-icon-btn" style="color: #5d5dff; margin-right: 10px;" 
                                    onclick="editarVehiculo(
                                        '<?php echo $coche['Placa']; ?>', 
                                        '<?php echo $coche['Marca']; ?>', 
                                        '<?php echo $coche['Modelo']; ?>', 
                                        '<?php echo $coche['NumSerie']; ?>', 
                                        '<?php echo $coche['Color']; ?>', 
                                        '<?php echo $coche['Tipo']; ?>'
                                    )">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <button class="chat-icon-btn" style="color: #ff5d5d;" 
                                    onclick="eliminarVehiculo('<?php echo $coche['Placa']; ?>')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--text-primary);">
                            No hay vehículos registrados o activos.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>