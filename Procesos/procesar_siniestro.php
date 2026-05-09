<?php
    session_start();
    require_once '../Conexiones/Config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_ajustador = $_SESSION['user_id']; // El usuario logueado es el ajustador
        $titulo = $_POST['titulo'];
        $id_aseguradora = $_POST['id_aseguradora'];
        $id_asegurado = $_POST['id_asegurado'];
        $num_poliza = $_POST['num_poliza'];
        $placa = $_POST['placas_auto']; // Nota: Tu SP pide INT, asegúrate que el ID del auto sea enviado
        $ubicacion = $_POST['ubicacion'];
        $otras_unidades = $_POST['otras_unidades'];
        $declaracion = $_POST['declaracion'];
        $fecha_siniestro = date('Y-m-d H:i:s');

        try {
            $pdo->beginTransaction();

            // 1. Insertar Siniestro (Opción 2)
            // El SP tiene muchos parámetros, hay que respetarlos todos
            // ANTES: CALL SP_GestionarSiniestro(2, ...)
// AHORA: Cambiamos a 3 para que coincida con el INSERT del nuevo SP
            $stmt = $pdo->prepare("CALL SP_GestionarSiniestro(3, NULL, ?, ?, ?, ?, 'Pendiente', ?, ?, ?, ?, ?, ?, NULL, NULL)");
            
            $stmt->execute([
                $id_aseguradora,
                $id_ajustador,
                $id_asegurado,
                $titulo,
                $num_poliza,
                $placa,
                $fecha_siniestro,
                $ubicacion,
                $otras_unidades,
                $declaracion
            ]);
            
            // Obtenemos el ID del siniestro recién creado
            // Nota: Si el SP no hace SELECT LAST_INSERT_ID(), podrías necesitar una consulta extra
            $stmt->closeCursor();
            $idSiniestro = $pdo->query("SELECT LAST_INSERT_ID()")->fetchColumn();

            // 2. Insertar Multimedia (Opción 0 de SP_GestionarMultimediaSiniestro)
            if (!empty($_FILES['evidencia']['name'][0])) {
                foreach ($_FILES['evidencia']['tmp_name'] as $key => $tmpName) {
                    $contenido = file_get_contents($tmpName);
                    $tipo = pathinfo($_FILES['evidencia']['name'][$key], PATHINFO_EXTENSION);
                    
                    $stmtMulti = $pdo->prepare("CALL SP_GestionarMultimediaSiniestro(0, NULL, ?, ?, ?, ?)");
                    $stmtMulti->bindParam(1, $idSiniestro, PDO::PARAM_INT);
                    $stmtMulti->bindParam(2, $id_ajustador, PDO::PARAM_INT);
                    $stmtMulti->bindParam(3, $contenido, PDO::PARAM_LOB);
                    $stmtMulti->bindParam(4, $tipo, PDO::PARAM_STR);
                    $stmtMulti->execute();
                    $stmtMulti->closeCursor();
                }
            }

            $pdo->commit();
           header("Location: ../Paginas/Dashboard.php?update=success&msg=siniestro_reg");
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Error al registrar: " . $e->getMessage());
        }
    }
?>