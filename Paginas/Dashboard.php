<?php
session_start();
if (!isset($_SESSION['user_tipo'])) { header("Location: Pagina_Inicio.php"); exit(); }

require_once '../Conexiones/Config.php';
$tipo = $_SESSION['user_tipo'];
$userId = $_SESSION['user_id'];
$userData = null;

try {
    // Llamada a la nueva Opción 5: Consulta por ID
    // Enviamos el ID de la sesión y el resto de los parámetros como NULL
    $stmt = $pdo->prepare("CALL SP_GestionarUsuario(5, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Actualizamos la foto en la sesión por si cambió
    if ($userData && $userData['Foto']) {
        $_SESSION['user_foto'] = base64_encode($userData['Foto']);
    }
} catch (PDOException $e) {
    error_log("Error al cargar perfil: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="../Estilos/Style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../Scripts/Main.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="dashboard-body">
    <nav class="sidebar">
        <div class="sidebar-header"><h3>Mi Seguro</h3></div>
        <ul class="sidebar-menu">
            <li class="menu-item activo"><a href="#" onclick="mostrarSeccion('sec-siniestros')"><i class="fa-solid fa-car"></i> Siniestros</a></li>

            <?php if ($tipo == 3): // Asegurado ?>
                <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-seguimiento')"><i class="fa-solid fa-comments"></i> Mi Seguimiento</a></li>
            
            <?php elseif ($tipo == 2): // Ajustador ?>
                <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-crear-siniestro')"><i class="fa-solid fa-car-burst"></i> Crear Siniestro</a></li>
            
            <?php elseif ($tipo == 1): // Supervisor ?>
                <li class="menu-item">
                    <a href="#" onclick="mostrarSeccion('sec-dictamen')">
                        <i class="fa-solid fa-gavel"></i> Dictaminar
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" onclick="mostrarSeccion('sec-registrar-aseguradora')">
                        <i class="fa-solid fa-building-shield"></i> Registrar Aseguradora
                    </a>
                </li>
            <?php endif; ?>

            <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-perfil')"><i class="fa-solid fa-user"></i> Mi Perfil</a></li>
            <li class="menu-item logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

<main class="main-content">
    <?php 
        // Carga de secciones base
        include '../Secciones/Siniestros.php';
        include '../Secciones/Perfil.php';

        if ($tipo == 1 || $tipo == 3) include '../Secciones/Seguimiento.php';
        if ($tipo == 2) include '../Secciones/FormularioSiniestro.php';
        
        // Secciones exclusivas del Supervisor
        if ($tipo == 1) {
            include '../Secciones/Dictamen.php';
            include '../Secciones/RegistrarAseguradora.php'; // NUEVO ARCHIVO
        }
        
        include '../Secciones/ModalDetalle.php'; 
    ?>
</main>

<button class="theme-switch" onclick="toggleTheme()" style="position: fixed; bottom: 20px; right: 20px;">
    <i id="theme-icon" class="fa-solid fa-sun"></i>
</button>

</body>
</html>