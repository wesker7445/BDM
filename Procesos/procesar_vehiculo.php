<?php
session_start();
require_once '../Conexiones/Config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placas'];
    $marca = $_POST['marca'];
    $color = $_POST['color'];
    $tipo_v = $_POST['tipo'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    
    // Si id_vehiculo está vacío, enviará 1 (INSERTAR) al SP
    $opcion = !empty($_POST['id_vehiculo']) ? 3 : 1;

    // Busca estas líneas cerca del final:
    try {
        $stmt = $pdo->prepare("CALL SP_GestionarVehiculo(?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$opcion, $placa, $marca, $color, $tipo_v, $modelo, $serie]);
        
        header("Location: ../Paginas/Dashboard.php?update=success");
        exit();
    } catch (PDOException $e) {
        die("Error en la Base de Datos: " . $e->getMessage());
    }
}
?>