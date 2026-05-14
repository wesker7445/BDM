<?php
// Secciones/Siniestros.php
$listaSiniestros = [];

try {
    // Llamada al SP (Opción 3)
    $stmtS = $pdo->prepare("CALL SP_GestionarSiniestro(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    $stmtS->execute();
    $listaSiniestros = $stmtS->fetchAll(PDO::FETCH_ASSOC);
    $stmtS->closeCursor(); 
} catch (PDOException $e) {
    error_log("Error al listar siniestros: " . $e->getMessage());
}
?>

<section id="sec-siniestros" class="content-section">
    <header class="top-bar">
        <h2>Listado de Siniestros</h2>
        <div class="user-info-top">
            <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span>
            <?php if (isset($_SESSION['user_foto']) && $_SESSION['user_foto']): ?>
                <img src="data:image/png;base64,<?php echo $_SESSION['user_foto']; ?>" class="avatar-mini">
           <?php endif; ?>
        </div>
    </header>
    
    <div class="siniestros-grid">
        <?php if (!empty($listaSiniestros)): ?>
            <?php foreach ($listaSiniestros as $s): ?>
                <?php 
                    // Lógica de imagen (si no hay, se pone una por defecto)
                    $imagenSrc = "../Multimedia/Imagen/Default_Siniestro.png"; 
                    if (!empty($s['Multimedia'])) {
                        $imagenSrc = "data:" . $s['TipoArchivo'] . ";base64," . base64_encode($s['Multimedia']);
                    }
                    $fechaFormateada = date("d M, Y", strtotime($s['FechaHoraSiniestro']));
                ?>
                    <div class="siniestro-card" onclick="abrirDetalleSiniestro(
                        '<?php echo addslashes($s['Titulo']); ?>', 
                        '<?php echo $imagenSrc; ?>', 
                        '<?php echo $s['StatusSiniestro']; ?>', 
                        '<?php echo addslashes($s['NombreAjustador']); ?>', 
                        '<?php echo $fechaFormateada; ?>', 
                        '<?php echo addslashes($s['DeclaracionAsegurado']); ?>',
                        '<?php echo addslashes($s['NombreAseguradora']); ?>',
                        '<?php echo $s['NumPoliza']; ?>',
                        '<?php echo $s['Placa']; ?>',
                        '<?php echo addslashes($s['Ubicacion']); ?>',
                        '<?php echo addslashes($s['OtrasUnidades']); ?>',
                        '<?php echo $s['FechaPromesa']; ?>'
                    )">
                    <div class="card-image">
                        <img src="<?php echo $imagenSrc; ?>" alt="Siniestro">
                        <span class="status-badge"><?php echo htmlspecialchars($s['StatusSiniestro']); ?></span>
                    </div>
                    <div class="card-info">
                        <div class="card-text">
                            <h4 class="card-title"><?php echo htmlspecialchars($s['Titulo']); ?></h4>
                            <p class="card-date"><?php echo $fechaFormateada; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="no-datos-container" style="grid-column: 1 / -1; text-align: center; padding: 50px; color: var(--text-primary);">
                <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                <h3 style="font-weight: 400;">No existen siniestros registrados actualmente.</h3>
            </div>
        <?php endif; ?>
    </div>
</section>