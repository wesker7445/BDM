<?php

?>

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
                <button class="boton-contacto">Contactar Soporte</button>
            </div>
        </div>
    </div>
</div>