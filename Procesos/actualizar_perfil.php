<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 1. Capturar el ID del usuario desde el campo oculto
        $idUsuario = $_POST['id_usuario'];

        // 2. Procesar la foto (si el usuario seleccionó una nueva)
        $fotoBinaria = null;
        if (isset($_FILES['multimedia']) && $_FILES['multimedia']['error'] == 0) {
            $fotoBinaria = file_get_contents($_FILES['multimedia']['tmp_name']);
        }

        // 3. Preparar parámetros para el SP (Opción 4)
        // Enviamos NULL en los campos que no queremos o no podemos cambiar aquí
        $params = [
            4,                          // GU_Opcion: 4 para ACTUALIZAR
            $idUsuario,                 // GU_IdUser
            null,                       // GU_IdTipo (no cambia el rol aquí)
            $_POST['nombre']   ?? null, // GU_Nombre
            $_POST['apellido'] ?? null, // GU_Apellido
            $_POST['fecha']    ?? null, // GU_Fecha
            null,                       // GU_RFC
            $fotoBinaria,               // GU_FOTO (Si es null, IFNULL mantiene la anterior)
            $_POST['genero']   ?? null, // GU_GENERO
            null,                       // GU_TELEFONO
            null,                       // GU_EMAIL (es readonly, no se cambia)
            null,                       // GU_PASSWORD (podrías agregar un campo para esto)
            $_POST['alias']    ?? null  // GU_ALIAS
        ];

        try {
            // Ejecutar el procedimiento
            $stmt = $pdo->prepare("CALL SP_GestionarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($params);

            // Actualizar el nombre en la sesión por si cambió para que el saludo se vea bien
            $_SESSION['user_nombre'] = $_POST['nombre'];

            header("Location: ../Paginas/Dashboard.php?update=success");
        } catch (PDOException $e) {
            error_log("Error al actualizar perfil: " . $e->getMessage());
            header("Location: ../Paginas/Dashboard.php?update=error");
        }
    }
?>