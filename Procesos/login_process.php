<?php
session_start();
require_once '../Conexiones/Config.php';
// Supongamos que recibes datos de un formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['correo'];
    $pass = $_POST['password'];

    // Consulta para validar usuario y obtener su tipo
    $stmt = $pdo->prepare("SELECT IdUsuario, IdTipo, Nombre FROM Usuario WHERE Email = ? AND PassW = ?");
    $stmt->execute([$email, $pass]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['IdUsuario'];
        $_SESSION['user_tipo'] = $user['IdTipo']; // 1: Asegurado, 2: Ajustador, 3: Supervisor
        $_SESSION['user_nombre'] = $user['Nombre'];
        header("Location: Dashboard.php");
    } else {
        echo "Datos incorrectos";
    }
}
?>