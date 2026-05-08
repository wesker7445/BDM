<?php
session_start();
require_once '../Conexiones/Config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_aseguradora = !empty($_POST['id_aseguradora']) ? $_POST['id_aseguradora'] : null;
    $nombre = $_POST['nombre_aseguradora'];
    $representante = $_POST['Representante_legal'];
    $rfc = $_POST['RFC'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email_soporte'];
    $direccion = $_POST['Direccion'];
    
    // Si el ID está vacío es 1 (Insertar), si tiene ID es 3 (Actualizar)
    $opcion = !empty($id_aseguradora) ? 3 : 1;

    try {
        $stmt = $pdo->prepare("CALL SP_GestionarAseguradora(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$opcion, $id_aseguradora, $nombre, $representante, $rfc, $telefono, $email, $direccion]);
        
        $msg = ($opcion == 3) ? 'aseg_upd' : 'aseg_reg';
        header("Location: ../Paginas/Dashboard.php?update=success&msg=$msg");
        exit();
    } catch (PDOException $e) {
        die("Error en la Base de Datos: " . $e->getMessage());
    }
}
?>