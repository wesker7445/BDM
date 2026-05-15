<?php
// Dashboard.php ya inició sesión e incluyó Config.php
$userId = $_SESSION['user_id'] ?? null;
$tipoUsuario = $_SESSION['user_tipo'] ?? null;

$siniestrosDisponibles = [];
$mensajes = [];
$idSiniestro = null;
$statusActual = ''; // <--- NUEVA VARIABLE PARA ALMACENAR EL ESTATUS

try {
    // 1. Cargar la lista de siniestros permitidos para el selector
    $stmtLista = $pdo->prepare("CALL SP_ObtenerSiniestrosPorRol(?, ?)");
    $stmtLista->execute([$userId, $tipoUsuario]);
    $siniestrosDisponibles = $stmtLista->fetchAll(PDO::FETCH_ASSOC);
    $stmtLista->closeCursor();

    // 2. Determinar cuál es el siniestro seleccionado actualmente
    if (isset($_GET['id_siniestro'])) {
        $idSiniestro = intval($_GET['id_siniestro']);
        $_SESSION['id_siniestro_activo'] = $idSiniestro; 
    } elseif (isset($_SESSION['id_siniestro_activo'])) {
        $idSiniestro = $_SESSION['id_siniestro_activo'];
    } elseif (!empty($siniestrosDisponibles)) {
        $idSiniestro = $siniestrosDisponibles[0]['IdSiniestro'];
    }

    // 2.5 INTERCEPTAR EL ESTATUS DEL SINIESTRO SELECCIONADO
    if ($idSiniestro) {
        foreach ($siniestrosDisponibles as $sin) {
            if ($sin['IdSiniestro'] == $idSiniestro) {
                $statusActual = $sin['StatusSiniestro'];
                break;
            }
        }
    }

    // 3. Si hay un siniestro activo, cargamos sus mensajes y los marcamos como leídos
    if ($idSiniestro) {
        // Opción 1 del SP anterior: Cargar conversación
        $stmtChat = $pdo->prepare("CALL SP_GestionarChatSeguimiento(1, NULL, ?, NULL, NULL, NULL, NULL, NULL)");
        $stmtChat->execute([$idSiniestro]);
        $mensajes = $stmtChat->fetchAll(PDO::FETCH_ASSOC);
        $stmtChat->closeCursor();

        // Opción 2 del SP anterior: Marcar como leídos
        $stmtRead = $pdo->prepare("CALL SP_GestionarChatSeguimiento(2, NULL, ?, ?, NULL, NULL, NULL, NULL)");
        $stmtRead->execute([$idSiniestro, $userId]);
        $stmtRead->closeCursor();
    }

} catch (PDOException $e) {
    error_log("Error en la sección de seguimiento: " . $e->getMessage());
}

// LÓGICA DE COLORES PARA EL BADGE DEL ESTATUS
$bgBadge = '#475569'; // Color gris por defecto
switch ($statusActual) {
    case 'Pendiente': 
        $bgBadge = '#d97706'; // Naranja
        break;
    case 'Aceptado':
    case 'Aceptado con pago de deducible':
    case 'Aceptado sin pago de deducible':
    case 'Aplica pago para reparación':
        $bgBadge = '#16a34a'; // Verde
        break;
    case 'Finalizado':
        $bgBadge = '#2563eb'; // Azul
        break;
    case 'Rechazado':
    case 'Pérdida total':
        $bgBadge = '#dc2626'; // Rojo
        break;
}
?>

<section id="sec-seguimiento" class="content-section hidden">
    <header class="top-bar" style="display: flex; justify-content: space-between; align-items: center; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <h2>Seguimiento de Unidad</h2>
            
            <?php if (!empty($statusActual)): ?>
                <span class="status-chat-badge" style="background-color: <?= $bgBadge ?>; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                    <?= htmlspecialchars($statusActual) ?>
                </span>
            <?php endif; ?>
        </div>
        
        <div class="selector-siniestro-container">
            <label for="select-siniestro-activo" style="font-weight: bold; margin-right: 5px; font-size: 0.9rem;">Siniestro:</label>
            <select id="select-siniestro-activo" class="chat-input-field" style="width: auto; padding: 5px 10px; height: auto;" onchange="cambiarSiniestro(this.value)">
                <?php if (empty($siniestrosDisponibles)): ?>
                    <option value="">No tienes siniestros asignados</option>
                <?php else: ?>
                    <?php foreach ($siniestrosDisponibles as $sin): ?>
                        <option value="<?= $sin['IdSiniestro'] ?>" <?= ($sin['IdSiniestro'] == $idSiniestro) ? 'selected' : '' ?>>
                            #<?= $sin['IdSiniestro'] ?> - <?= htmlspecialchars($sin['Titulo']) ?> 
                            <?= ($tipoUsuario != 3) ? " (" . htmlspecialchars($sin['NombreAsegurado']) . ")" : "" ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </header>
    
    <div class="chat-container">
        <?php if (!$idSiniestro): ?>
            <div style="text-align: center; padding: 5px; color: gray;">
                <p><i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 10px;"></i></p>
                <p>No se encontraron siniestros disponibles para tu usuario.</p>
            </div>
        <?php else: ?>
            <div class="chat-messages" id="chat-box">
                <?php if (empty($mensajes)): ?>
                    <p class="no-messages" style="text-align:center; color:gray; padding:20px;">Inicio del chat. Escribe un mensaje para comenzar.</p>
                <?php else: ?>
                    <?php foreach ($mensajes as $msg): 
                        $claseMensaje = ($msg['IdUsuario'] == $userId) ? 'outgoing' : 'incoming';
                        if ($msg['EsSistema']) $claseMensaje = 'system-message'; 
                    ?>
                        <div class="message <?= $claseMensaje ?>">
                            <div class="message-content">
                                <span class="message-user" style="font-size: 0.75rem; display:block; font-weight:bold; color: var(--primary-color);">
                                    <?= htmlspecialchars($msg['NombreRemitente']) ?>
                                </span>
                                
                                <?php if (!empty($msg['Mensaje'])): ?>
                                    <p><?= htmlspecialchars($msg['Mensaje']) ?></p>
                                <?php endif; ?>

                                <?php if (!empty($msg['Multimedia'])): ?>
                                    <?php 
                                        $base64 = base64_encode($msg['Multimedia']);
                                        $src = "data:" . $msg['TipoArchivo'] . ";base64," . $base64;
                                    ?>
                                    <img src="<?= $src ?>" class="chat-img" style="max-width: 250px; display:block; border-radius:8px; margin-top:5px;">
                                <?php endif; ?>

                                <span class="message-time"><?= $msg['HoraFormateada'] ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form class="chat-input-area" action="../Procesos/procesar_mensaje.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_siniestro" value="<?= $idSiniestro ?>">

                <label for="file-input" class="chat-icon-btn">
                    <i class="fa-solid fa-paperclip"></i>
                </label>
                <input type="file" id="file-input" name="multimedia" class="hidden" accept="image/*,video/*">
                
                <input type="text" name="mensaje" placeholder="Escribe un mensaje..." class="chat-input-field" required>
                
                <button type="submit" class="chat-send-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        <?php endif; ?>
    </div>
</section>