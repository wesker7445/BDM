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
    <link rel="stylesheet" href="../Estilos/Style.css"> <script src="../Scripts/Main.js" defer></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
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
            <li class="menu-item logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
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

<?php if (isset($_GET['update'])): ?>
<script>
    <?php if ($_GET['update'] == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: 'Tu perfil se ha actualizado correctamente.',
            confirmButtonColor: '#5d5dff',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    <?php elseif ($_GET['update'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar tu perfil. Inténtalo de nuevo.',
            confirmButtonColor: '#d33',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    <?php endif; ?>
</script>
<?php endif; ?>

<button class="theme-switch" onclick="toggleTheme()" style="position: fixed; bottom: 20px; right: 20px;">
    <i id="theme-icon" class="fa-solid fa-sun"></i>
</button>

</body>
</html>