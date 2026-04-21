<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Ajustador</title>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="dashboard-body">

    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>Mi Seguro</h3>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item activo">
                <a href="#" onclick="mostrarSeccion('sec-mis-siniestros')">
                    <i class="fa-solid fa-car"></i> Siniestros
                </a>
            </li>
            <li class="menu-item">
                <a href="#" onclick="mostrarSeccion('sec-crear-siniestro')"> 
                    <i class="fa-solid fa-car-burst"></i> Crear Siniestro
                </a>
            </li>
            <hr>
            <li class="menu-item">
                <a href="Pagina_Principal.php"><i class="fa-solid fa-user-gear"></i> Pagina de Principal del Asegurado</a>
            </li>

            <li class="menu-item">
                <a href="Pagina_PrincipalS.php"><i class="fa-solid fa-user-tie"></i> Pagina de Principal del Supervisor</a>
            </li>

            <li class="menu-item">
                <a href="#" onclick="mostrarSeccion('sec-perfil')">
                    <i class="fa-solid fa-user"></i> Mi Perfil
                </a>
            </li>
            <hr>
            <li class="menu-item logout">
                <a href="Pagina_Inicio.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
            </li>
        </ul>
    </nav>

<main class="main-content">
    <section id="sec-mis-siniestros" class="content-section">
        <header class="top-bar">
            <h2>Mi Perfil</h2>
            <div class="user-info-top">
                <span>Bienvenido, Samuel David Lugo</span>
                <img src="Multimedia/Imagen/Ajustador.png" class="avatar-mini" alt="Mini">
            </div>
        </header>
        <div class="siniestros-grid">

                <div class="siniestro-card" onclick="abrirDetalleSiniestro('Choque lateral - Aveo 2022', 'Multimedia/Imagen/aveo.png', 'En Reparación', 'Alejandro Villarreal', '28 de Feb, 2026 • 10:30 AM', 'Vehículo presenta daño en puerta delantera izquierda y salpicadera tras impacto lateral en crucero.')">
                        <div class="card-image">
                            <span class="media-type-badge"><i class="fa-solid fa-image"></i> Foto</span>
                            <img src="Multimedia/Imagen/aveo.png" alt="Siniestro">
                            <span class="status-badge">En Reparación</span>
                        </div>
                        <div class="card-info">
                            <div class="card-text">
                                <h4 class="card-title">Choque lateral - Aveo 2022</h4>
                                <p class="card-date"><i class="fa-regular fa-calendar"></i> 28 de Feb, 2026 • 18:15</p>
                            </div>
                        </div>
                    </div>

                <div class="siniestro-card" onclick="abrirDetalleSiniestro('Inundación por lluvias', 'Multimedia/Video/Inundado.mp4', 'Pérdida Total', 'Juan Pérez', '15 de Feb, 2026 • 16:15', 'Daños severos por ingreso de agua al motor y cabina durante tormenta.')">
                    <div class="card-image">
                        <div class="video-overlay"><i class="fa-solid fa-play"></i></div>
                        <video src="Multimedia/Video/Inundado.mp4" muted loop></video>
                        <span class="status-badge loss">Pérdida Total</span>
                    </div>
                    <div class="card-info">
                        <div class="avatar-mini"></div>
                        <div class="card-text">
                            <h4 class="card-title">Inundación por lluvias</h4>
                            <p class="card-author">Ajustador: Samuel David Lugo</p>
                            <p class="card-date">15 de Feb, 2026 • 16:15</p>
                        </div>
                    </div>
                </div>
        </div>
    </section>

    <section id="sec-crear-siniestro" class="content-section hidden">
        <header class="top-bar">
            <h2>Reportar Nuevo Siniestro</h2>
        </header>

        <div class="form-siniestro-container">
            <form action="procesar_siniestro.php" method="POST" enctype="multipart/form-data">
                
                <div class="grupo-input">
                    <label for="tituloS">Título del Siniestro</label>
                    <input type="text" id="tituloS" name="titulo" placeholder="Ej. Choque lateral - Aveo 2022" required>
                </div>
                
                <div class="grupo-input">
                    <label for="tipoLS">Tipo de Siniestro</label>
                    <select name="tipo" id="tipoLS">
                        <option value="reparacion">En Reparación</option>
                        <option value="perdida">Pérdida Total</option>
                        <option value="revision">En Revisión</option>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="tipoA">Aseguradora</label>
                    <select name="tipoA" id="tipoA">
                        <option value="SeguroTotal">Seguro Total</option>
                        <option value="MiAuto">MiAuto</option>
                        <option value="AutosSalud">Autos Salud</option>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="Placas">Placas del auto</label>
                    <input type="text" id="Placas" name="Placas" placeholder="5CAH...">
                </div>

                <div class="grupo-input">
                    <label for="Marca">Marca del auto</label>
                    <select name="Marca" id="Marca">
                        <option value="Chevrolet">Chevrolet</option>
                        <option value="Honda">Honda</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Ford">Ford</option>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="Color">Color del auto</label>
                    <input type="text" id="Color" name="Color" placeholder="Rojo...">
                </div>

                <div class="grupo-input">
                    <label for="TipoAuto">Tipo de auto</label>
                    <select name="TipoAuto" id="TipoAuto">
                        <option value="Sedan">Sedan</option>
                        <option value="4x4">4x4</option>
                        <option value="Camioneta">Camioneta</option>
                        <option value="Muscle">Muscle</option>
                    </select>
                </div>
                
                <div class="grupo-input">
                    <label for="ModeloA">Modelo del auto</label>
                    <input type="text" id="ModeloA" name="ModeloA" placeholder="Ej. 2022...">
                </div>

                <div class="grupo-input">
                    <label for="SedeAuto">Número de la sede</label>
                    <input type="number" id="SedeAuto" name="SedeAuto" placeholder="15...">
                </div>
                
                <div class="grupo-input">
                    <label for="descS">Descripción de los hechos</label>
                    <textarea id="descS" name="descripcion" placeholder="Describe lo ocurrido..."></textarea>
                </div>

                <div class="grupo-input">
                    <label for="FechaS">Fecha que ocurrio el hecho</label>
                    <input type="date" id="FechaS" placeholder="Fecha de los hechos">
                </div>

                <div class="grupo-input">
                    <label class="boton-archivo">
                        <i class="fa-solid fa-camera"></i> Subir Evidencia
                        <input type="file" name="evidencia[]" multiple accept="image/*,video/*" style="display: none;">
                    </label>
                </div>

                <input type="submit" class="boton-submit" value="Dar de Alta Siniestro">
            </form>
        </div>
    </section>

    <section id="sec-perfil" class="content-section hidden">
        <header class="top-bar">
            <h2>Mi Perfil</h2>
        </header>

        <div class="form-siniestro-container">
            <div class="perfil-header">
                <img src="Multimedia/Imagen/Ajustador.png" class="avatar-perfil" alt="Avatar">
                <div class="perfil-info">
                    <h3> Samuel David Lugo</h3>
                    <p>ID: 15xxxxxx</p>
                </div>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="grupo-input">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" value="Juan Pérez">
                </div>

                <div class="grupo-input">
                    <label>Correo Electrónico</label>
                    <input type="text" name="correo" value="juan.perez@uanl.edu.mx">
                </div>

                <div class="grupo-input">
                    <label class="boton-archivo">
                        <i class="fa-solid fa-camera"></i> Seleccionar Nueva Foto
                        <input type="file" name="avatar" style="display: none;">
                    </label>
                </div>

                <div class="perfil-acciones">
                    <input type="submit" class="boton-submit" value="Guardar Cambios">
                    <button type="button" class="boton-cancelar" onclick="mostrarSeccion('sec-siniestros')">Regresar</button>
                </div>
            </form>
        </div>
    </section>

    <div id="modal-detalle" class="modal-overlay hidden">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarModal()">&times;</button>
            <div class="detalle-container">
                <div class="detalle-media" id="contenedor-media-modal">
                    </div>
                <div class="detalle-info">
                    <h2 id="detalle-titulo">Detalles del Siniestro</h2>
                    <span class="status-badge" id="detalle-status">Estado</span>
                    <div class="info-grid">
                        <p><strong><i class="fa-solid fa-user-tie"></i> Ajustador:</strong> <span id="detalle-ajustador"></span></p>
                        <p><strong><i class="fa-solid fa-clock"></i> Fecha:</strong> <span id="detalle-fecha"></span></p>
                    </div>
                    <h3>Descripción</h3>
                    <p class="descripcion-texto">No hay descripción disponible.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<button class="theme-switch" onclick="toggleTheme()">
    <i id="theme-icon" class="fa-solid fa-sun"></i>
</button>

<script>
    // Al cargar la página, revisar si ya existe una preferencia guardada
    const currentTheme = localStorage.getItem('theme') || 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    actualizarIcono(currentTheme);

    function toggleTheme() {
        let theme = document.documentElement.getAttribute('data-theme');
        let newTheme = (theme === 'dark') ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme); // Guarda la elección para otras páginas
        actualizarIcono(newTheme);
    }

    function actualizarIcono(theme) {
        const icon = document.getElementById('theme-icon');
        if (theme === 'light') {
            icon.classList.replace('fa-sun', 'fa-moon');
        } else {
            icon.classList.replace('fa-moon', 'fa-sun');
        }
    }

    function mostrarSeccion(seccionId) {
        // Solo ocultamos las SECCIONES principales
        document.querySelectorAll('.content-section').forEach(sec => {
            sec.classList.add('hidden');
        });
        
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('activo');
        });

        const seccion = document.getElementById(seccionId);
        if (seccion) {
            seccion.classList.remove('hidden');
        }
        
        if (event && event.currentTarget) {
            event.currentTarget.parentElement.classList.add('activo');
        }
    }

    // Asegúrate de que estas funciones estén disponibles
    function abrirDetalleSiniestro(titulo, imagen, estado, ajustador, fecha, descripcion) {
        const modal = document.getElementById('modal-detalle');
        const contenedor = document.getElementById('contenedor-media-modal');

        // 1. Limpiar y Generar el contenedor multimedia correcto
        if (imagen.toLowerCase().endsWith('.mp4')) {
            contenedor.innerHTML = `<video src="${imagen}" controls autoplay muted style="width:100%; height:100%; object-fit:cover;"></video>`;
        } else {
            contenedor.innerHTML = `<img id="detalle-img" src="${imagen}" alt="Evidencia" style="width:100%; height:100%; object-fit:cover;">`;
        }
        
        // 2. Inyectar los datos de texto
        document.getElementById('detalle-titulo').innerText = titulo;
        document.getElementById('detalle-status').innerText = estado;
        
        // 3. Actualizar los párrafos de información
        const infoParagraphs = document.querySelectorAll('.detalle-info p');
        infoParagraphs[0].innerHTML = `<strong><i class="fa-solid fa-user-tie"></i> Ajustador:</strong> ${ajustador}`;
        infoParagraphs[1].innerHTML = `<strong><i class="fa-solid fa-clock"></i> Fecha:</strong> ${fecha}`;
        
        document.querySelector('.descripcion-texto').innerText = descripcion;

        // 4. Mostrar el modal
        modal.classList.remove('hidden');
    }

    function cerrarModal() {
        const modal = document.getElementById('modal-detalle');
        modal.classList.add('hidden');
        // Si usaste style.display antes, asegúrate de limpiarlo:
        modal.style.display = ''; 
    }

    // Cierre al hacer clic fuera del contenido blanco
    window.onclick = function(event) {
        const modal = document.getElementById('modal-detalle');
        if (event.target == modal) {
            cerrarModal();
        }
    }
</script>
</script>

</body>
</html>