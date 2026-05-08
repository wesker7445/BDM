<?php
session_start();
require_once '../Conexiones/Config.php';

// Verificamos que llegue la placa por GET
if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    try {
        // Llamamos al SP con la Opción 2 (Baja Lógica)
        // El SP solo requiere la Placa para esta acción
        $stmt = $pdo->prepare("CALL SP_GestionarVehiculo(2, ?, NULL, NULL, NULL, NULL, NULL)");
        $stmt->execute([$placa]);
        
        // Redirigimos con un mensaje de éxito
        header("Location: ../Paginas/Dashboard.php?update=success");
    } catch (PDOException $e) {
        error_log("Error al eliminar vehículo: " . $e->getMessage());
        header("Location: ../Paginas/Dashboard.php?update=error_bd");
    }
} else {
    header("Location: ../Dashboard.php");
}
?>