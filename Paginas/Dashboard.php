<?php
session_start();
if (!isset($_SESSION['user_tipo'])) { header("Location: Pagina_Inicio.php"); exit(); }

$tipo = $_SESSION['user_tipo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="../Estilos/Style.css"> <script src="../Scripts/Main.js" defer></script> </head>
<body class="dashboard-body">
    <nav class="sidebar">
        <div class="sidebar-header"><h3>Mi Seguro</h3></div>
        <ul class="sidebar-menu">
            <li class="menu-item activo"><a href="#" onclick="mostrarSeccion('sec-siniestros')"><i class="fa-solid fa-car"></i> Siniestros</a></li>

            <?php if ($tipo == 1): // Asegurado ?>
                <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-seguimiento')"><i class="fa-solid fa-comments"></i> Mi Seguimiento</a></li>
            
            <?php elseif ($tipo == 2): // Ajustador ?>
                <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-crear-siniestro')"><i class="fa-solid fa-car-burst"></i> Crear Siniestro</a></li>
            
            <?php elseif ($tipo == 3): // Supervisor ?>
                <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-dictamen')"><i class="fa-solid fa-gavel"></i> Dictaminar</a></li>
            <?php endif; ?>

            <li class="menu-item"><a href="#" onclick="mostrarSeccion('sec-perfil')"><i class="fa-solid fa-user"></i> Mi Perfil</a></li>
            <li class="menu-item logout"><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

<main class="main-content">
    <?php 
        // Carga de secciones
        include '../Secciones/Siniestros.php';
        include '../Secciones/Perfil.php';

        if ($tipo == 1 || $tipo == 3) include '../Secciones/Seguimiento.php';
        if ($tipo == 2) include '../Secciones/FormularioSiniestro.php';
        if ($tipo == 3) include '../Secciones/Dictamen.php';
        
        include '../Secciones/ModalDetalle.php'; 
    ?>
</main>
</body>
</html>