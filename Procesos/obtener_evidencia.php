<?php
require_once '../Conexiones/Config.php';

$id = $_GET['id'] ?? 0;
$evidencia = [];

if ($id > 0) {
    // Opción 2 del SP de Multimedia
    $stmt = $pdo->prepare("CALL SP_GestionarMultimediaSiniestro(2, NULL, ?, NULL, NULL, NULL)");
    $stmt->execute([$id]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row) {
        $evidencia[] = [
            'id' => $row['IdMultimedia'],
            'tipo' => $row['TipoArchivo'],
            'src' => "data:" . $row['TipoArchivo'] . ";base64," . base64_encode($row['Multimedia'])
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($evidencia);