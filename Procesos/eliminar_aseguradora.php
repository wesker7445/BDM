<?php
session_start();
require_once '../Conexiones/Config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Llamamos al SP con la Opción 2 (Baja Lógica)
        $stmt = $pdo->prepare("CALL SP_GestionarAseguradora(2, ?, NULL, NULL, NULL, NULL, NULL, NULL)");
        $stmt->execute([$id]);
        
        header("Location: ../Paginas/Dashboard.php?update=success");
    } catch (PDOException $e) {
        error_log("Error al eliminar aseguradora: " . $e->getMessage());
        header("Location: ../Paginas/Dashboard.php?update=error_bd");
    }
} else {
    header("Location: ../Paginas/Dashboard.php");
}
?>