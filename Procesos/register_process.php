<?php
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 1. Procesamiento de la imagen para LONGBLOB
        $fotoBinaria = null;
        if (isset($_FILES['multimedia']) && $_FILES['multimedia']['error'] == 0) {
            // Leemos el contenido temporal del archivo subido
            $fotoBinaria = file_get_contents($_FILES['multimedia']['tmp_name']);
        }

        // 2. Mapeo de parámetros para SP_GestionarUsuario (Opción 1)
        // El orden debe ser idéntico a los IN de tu procedimiento
        $params = [
            1,                  // GU_Opcion: 1 para INSERTAR
            null,               // GU_IdUser: null para nuevo registro
            3,                  // GU_IdTipo: 3 por defecto (Asegurado)
            $_POST['nombre'],   // GU_Nombre
            $_POST['apellido'], // GU_Apellido
            $_POST['Fecha'],    // GU_Fecha
            $_POST['RFC'],      // GU_RFC
            $fotoBinaria,       // GU_FOTO (Aquí enviamos los datos binarios)
            $_POST['genero'],   // GU_GENERO
            $_POST['Telefono'], // GU_TELEFONO
            $_POST['correroR'], // GU_EMAIL
            $_POST['passwordR'],// GU_PASSWORD
            $_POST['Alias']     // GU_ALIAS
        ];

        try {
            $stmt = $pdo->prepare("CALL SP_GestionarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($params);
            header("Location: ../Paginas/Pagina_Inicio.php?registro=exito");
        } catch (PDOException $e) {
            echo "Error en el registro: " . $e->getMessage();
        }
    }
?>