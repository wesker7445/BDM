<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idUsuario = $_POST['id_usuario'] ?? null;

        // Si el ID llega vacío, suele ser porque la imagen superó el límite de PHP y vació el POST
        if (empty($idUsuario)) {
            header("Location: ../Paginas/Dashboard.php?update=error_peso");
            exit();
        }

        $fotoBinaria = null; 
        if (isset($_FILES['multimedia'])) {
            $codigoError = $_FILES['multimedia']['error'];
            
            if ($codigoError === 0) {
                $fotoBinaria = file_get_contents($_FILES['multimedia']['tmp_name']);
            } elseif ($codigoError !== 4) { // 4 significa que no subió archivo, lo cual es válido
                header("Location: ../Paginas/Dashboard.php?update=error_archivo");
                exit();
            }
        }

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("CALL SP_GestionarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bindValue(1, 4, PDO::PARAM_INT);
            $stmt->bindValue(2, $idUsuario, PDO::PARAM_INT);
            $stmt->bindValue(3, null);
            $stmt->bindValue(4, $_POST['nombre'] ?? null);
            $stmt->bindValue(5, $_POST['apellido'] ?? null);
            $stmt->bindValue(6, $_POST['fecha'] ?? null);
            $stmt->bindValue(7, null);
            
            if ($fotoBinaria !== null) {
                $stmt->bindValue(8, $fotoBinaria, PDO::PARAM_LOB);
            } else {
                $stmt->bindValue(8, null, PDO::PARAM_NULL);
            }
            
            $stmt->bindValue(9, $_POST['genero'] ?? null);
            $stmt->bindValue(10, null);
            $stmt->bindValue(11, null);
            $stmt->bindValue(12, null);
            $stmt->bindValue(13, $_POST['alias'] ?? null);

            $stmt->execute();
            
            $filas = $stmt->rowCount();
            
            if ($filas == 0) {
                // Se ejecutó bien pero no se modificó nada (datos iguales)
                header("Location: ../Paginas/Dashboard.php?update=no_changes");
            } else {
                // ¡Éxito!
                $_SESSION['user_nombre'] = $_POST['nombre'];
                header("Location: ../Paginas/Dashboard.php?update=success");
            }
            exit();

        } catch (PDOException $e) {
            // Guardamos el error real en los logs del servidor por seguridad
            error_log("Error SQL perfil: " . $e->getMessage());
            header("Location: ../Paginas/Dashboard.php?update=error_bd");
            exit();
        }
    }
?>