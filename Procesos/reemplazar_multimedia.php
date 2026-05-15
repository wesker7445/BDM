<?php
// Procesos/reemplazar_multimedia.php
require_once '../Conexiones/Config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nuevo_archivo']) && isset($_POST['id_multimedia'])) {
    $idMultimedia = intval($_POST['id_multimedia']);
    $file = $_FILES['nuevo_archivo'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $tipoArchivo = $file['type'];
        // Leemos el contenido físico temporal para transformarlo en datos binarios (BLOB)
        $contenidoBlob = file_get_contents($file['tmp_name']);

        try {
            // Preparamos la ejecución pasándole la Opción 1 del SP
            $stmt = $pdo->prepare("CALL SP_GestionarMultimediaSiniestro(1, :id, NULL, NULL, :blob, :tipo)");
            
            // Usamos bindParam para asegurar el correcto mapeo de objetos LONGBLOB de gran tamaño
            $stmt->bindParam(':id', $idMultimedia, PDO::PARAM_INT);
            $stmt->bindParam(':blob', $contenidoBlob, PDO::PARAM_LOB);
            $stmt->bindParam(':tipo', $tipoArchivo, PDO::PARAM_STR);
            
            $stmt->execute();
            
            echo json_encode(['status' => 'success']);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error de Base de Datos: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al subir el archivo al servidor.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Acceso denegado o parámetros incompletos.']);
    exit;
}