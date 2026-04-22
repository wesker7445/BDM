<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio </title>
    <link rel="stylesheet" href="../Estilos/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../Scripts/Main.js" defer></script>
</head>
<body>
<div class="Inicio-container">

        <div class="Intercambio-container">
            <div id="tab-login" class="Tab Tab-Activo" onclick="cambiarTab('login')">Iniciar Sesión</div>
            <div id="tab-registro" class="Tab" onclick="cambiarTab('registro')">Regístrate</div>
        </div>

        <form action="../Procesos/login_process.php" method="POST" id="form-login">
            <div class="grupo-input">
                <label for="CorreoU">Correo Electronico o tu alias</label>
                <input type="text" name="Correo" id="CorreoU" placeholder="ejemplo@correo.com">
            </div>
             <div class="grupo-input">
                <label for="ContrasenaU">Contraseña</label>
                <input type="password" name="password" id="ContrasenaU" placeholder="••••••••">
            </div>
            <input type="submit" class="boton-submit" value="Iniciar Sesión">
        </form>

        <form action="../Procesos/register_process.php" method="POST" id="form-registro" class="hidden" enctype="multipart/form-data">
            <div class="grupo-input">
                <label for="NombreR">Nombre</label>
                <input type="text" name="nombre" id="NombreR" placeholder="Tu nombre">
            </div>
            <div class="grupo-input">
                <label for="ApellidoR">Apellido</label>
                <input type="text" name="apellido" id="ApellidoR" placeholder="Tu apellido">
            </div>
            <div class="grupo-input">
                <label for="AliasR">Alias</label>
                <input type="text" name="Alias" id="AliasR" placeholder="Tu alias">
            </div>
            <div class="grupo-input">
                <label for="RFC">RFC</label>
                <input type="text" name="RFC" id="RFC" placeholder="Tu RFC">
            </div>
            <div class="grupo-input">
                <label for="Telefono">Telefono</label>
                <input type="text" name="Telefono" id="Telefono" placeholder="Tu Telefono">
            </div>
            <div class="grupo-input">
                <label for="FechaR">Fecha de Nacimiento</label>
                <input type="date" name="Fecha" id="FechaR" name="Fecha" placeholder="Tu fecha de nacimiento">
            </div>
            <div class="grupo-input">
                <label for="genero">Selecciona un genero:</label>
                <select name="genero" id="GeneroR">
                    <option value="HombreR">Hombre</option>
                    <option value="MujerR">Mujer</option>
                </select>
            </div>

            <div class="grupo-input">
                <label for="multimedia" class="boton-archivo">
                    <i class="fa-solid fa-upload"></i> Subir Foto de Perfil
                </label>
                <input type="file" name="multimedia" id="multimedia" accept="image/*" class="input-oculto">
            </div>

            <div class="grupo-input">
                <label for="CorreoR">Correo Electronico</label>
                <input type="email" name="correroR" id="CorreoR" placeholder="nuevo@correo.com">
            </div>
             <div class="grupo-input">
                <label for="ContrasenaR">Contraseña</label>
                <input type="password" name="passwordR" id="ContrasenaR" placeholder="Crea una contraseña">
            </div>
            <input type="submit" class="boton-submit" value="Crear Cuenta">
        </form>
    </div>

    <button class="theme-switch" onclick="toggleTheme()">
        <i id="theme-icon" class="fa-solid fa-sun"></i>
    </button>

</body> 
</html>