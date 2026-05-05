<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idUsuario = $_POST['id_usuario'] ?? null;
        
        echo "<h3>1. Revisión de Datos</h3>";
        echo "ID de Usuario a actualizar: " . ($idUsuario ? $idUsuario : "NULO") . "<br>";

        $fotoBinaria = null; 
        if (isset($_FILES['multimedia'])) {
            $codigoError = $_FILES['multimedia']['error'];
            echo "Código de archivo PHP: " . $codigoError . " (0 = Éxito, 4 = Sin archivo)<br>";
            
            if ($codigoError === 0) {
                $fotoBinaria = file_get_contents($_FILES['multimedia']['tmp_name']);
                echo "Peso de la imagen leída por PHP: " . strlen($fotoBinaria) . " bytes<br>";
            }
        } else {
            echo "No se detectó el campo de archivo 'multimedia'.<br>";
        }

        echo "<h3>2. Ejecución en MySQL</h3>";
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
                echo "Mandando la imagen binaria al Procedimiento Almacenado...<br>";
            } else {
                $stmt->bindValue(8, null, PDO::PARAM_NULL);
                echo "Mandando valor NULL al SP (no hay foto nueva)...<br>";
            }
            
            $stmt->bindValue(9, $_POST['genero'] ?? null);
            $stmt->bindValue(10, null);
            $stmt->bindValue(11, null);
            $stmt->bindValue(12, null);
            $stmt->bindValue(13, $_POST['alias'] ?? null);

            $stmt->execute();
            
            $filas = $stmt->rowCount();
            echo "Filas afectadas en la base de datos: " . $filas . "<br><br>";
            
            if ($filas == 0) {
                echo "<strong style='color:orange;'>MySQL procesó todo sin errores, pero afectó 0 filas. Esto pasa si los datos enviados son idénticos a los actuales o si el SP falló silenciosamente.</strong><br>";
            } else {
                echo "<strong style='color:green;'>MySQL afectó 1 fila. La actualización se hizo correctamente.</strong><br>";
                $_SESSION['user_nombre'] = $_POST['nombre'];
            }
            
            // Detenemos la ejecución intencionalmente para ver la pantalla
            die("<br><a href='../Paginas/Dashboard.php'>Regresar al Dashboard</a>");

        } catch (PDOException $e) {
            die("<strong style='color:red;'>Error SQL Detonado:</strong> " . $e->getMessage());
        }
    }
?>