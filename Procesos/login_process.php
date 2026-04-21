<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $identificador = $_POST['Correo']; // Campo de Email o Alias
        $pass = $_POST['password'];

        try {
            // Llamada a la Opción 2
            // Los parámetros que no se usan en la validación se envían como NULL
            $stmt = $pdo->prepare("CALL SP_GestionarUsuario(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, ?, ?)");
            $stmt->execute([$identificador, $pass, $identificador]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user['IdUsuario'];
                $_SESSION['user_tipo'] = $user['IdTipo'];
                $_SESSION['user_nombre'] = $user['Nombre'];
                $_SESSION['user_alias'] = $user['Alias'];
                
                header("Location: ../Paginas/Dashboard.php");
            } else {
                header("Location: ../Paginas/Pagina_Inicio.php?error=login");
            }
        } catch (PDOException $e) {
            die("Error crítico: " . $e->getMessage());
        }
    }
?>