<?php

?>


<section id="sec-siniestros" class="content-section">
    <header class="top-bar">
        <h2>Listado de Siniestros</h2>
        <div class="user-info-top">
            <span>Bienvenido, <?php echo $_SESSION['user_nombre']; ?></span>
            <?php if (isset($_SESSION['user_foto']) && $_SESSION['user_foto']): ?>
                <img src="data:image/png;base64,<?php echo $_SESSION['user_foto']; ?>" class="avatar-mini">
           <?php endif; ?>
        </div>
    </header>
    
    <div class="siniestros-grid">
        <div class="siniestro-card" onclick="abrirDetalleSiniestro('Choque lateral - Aveo 2022', 'Multimedia/Imagen/aveo.png', 'En Reparación', 'Alejandro Villarreal', '28 de Feb, 2026', 'Daño en puerta delantera.')">
            <div class="card-image">
                <img src="Multimedia/Imagen/aveo.png" alt="Siniestro">
                <span class="status-badge">En Reparación</span>
            </div>
            <div class="card-info">
                <div class="card-text">
                    <h4 class="card-title">Choque lateral - Aveo 2022</h4>
                    <p class="card-date">28 de Feb, 2026</p>
                </div>
            </div>
        </div>
    </div>
</section>