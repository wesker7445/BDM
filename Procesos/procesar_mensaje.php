<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idUsuario = $_SESSION['user_id'] ?? null;
        $idSiniestro = $_POST['id_siniestro'] ?? null;
        $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
        
        // Si no hay usuario o siniestro, denegar
        if (!$idUsuario || !$idSiniestro) {
            die("Error: Sesión inválida o siniestro no especificado.");
        }

        $contenidoMultimedia = null;
        $tipoArchivo = null;

        // Validar y procesar archivo adjunto (similar a procesar_siniestro.php)
        if (!empty($_FILES['multimedia']['tmp_name']) && is_uploaded_file($_FILES['multimedia']['tmp_name'])) {
            $contenidoMultimedia = file_get_contents($_FILES['multimedia']['tmp_name']);
            $tipoArchivo = $_FILES['multimedia']['type']; // Ej: image/png, image/jpeg
        }

        try {
            // Opción 0: Insertar Mensaje
            // Parámetros: GCS_OPCION, GCS_ID, GCS_SINIESTRO, GCS_USUARIO, GCS_MENSAJE, GCS_MULTIMEDIA, GCS_TIPOARCHIVO, GCS_ESSISTEMA
            $stmt = $pdo->prepare("CALL SP_GestionarChatSeguimiento(0, NULL, ?, ?, ?, ?, ?, 0)");
            
            $stmt->bindParam(1, $idSiniestro, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUsuario, PDO::PARAM_INT);
            
            // Si el mensaje de texto está vacío, mandamos NULL
            $paramMensaje = ($mensaje !== '') ? $mensaje : null;
            $stmt->bindParam(3, $paramMensaje, PDO::PARAM_STR);
            
            // Tratamiento de datos binarios (LONGBLOB)
            $stmt->bindParam(4, $contenidoMultimedia, PDO::PARAM_LOB);
            $stmt->bindParam(5, $tipoArchivo, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();

            // Redireccionar de vuelta al Dashboard
            header("Location: ../Paginas/Dashboard.php?id_siniestro=" . $idSiniestro . "&seccion=seguimiento&status=msg_sent");
            exit();

        } catch (Exception $e) {
            error_log("Error al enviar mensaje: " . $e->getMessage());
            die("Error al enviar el mensaje. Intente más tarde.");
        }
    } else {
        header("Location: ../Paginas/Dashboard.php");
        exit();
    }
?>