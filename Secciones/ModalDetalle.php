<?php

?>

<div id="modal-detalle" class="modal-overlay hidden">
    <div class="modal-content">
        <button class="modal-close" onclick="cerrarModal()">&times;</button>
        <div class="detalle-container">
            <div class="detalle-media" id="contenedor-media-modal"></div>
            <div class="detalle-info">
                <h2 id="detalle-titulo">Detalles del Siniestro</h2>
                <span class="status-badge" id="detalle-status">Estado</span>
                
                <div class="info-grid">
                    <p><strong><i class="fa-solid fa-user-tie"></i> Ajustador:</strong> <span id="det-ajustador"></span></p>
                    <p><strong><i class="fa-solid fa-building"></i> Aseguradora:</strong> <span id="det-aseguradora"></span></p>
                    <p><strong><i class="fa-solid fa-file-contract"></i> Póliza:</strong> <span id="det-poliza"></span></p>
                    <p><strong><i class="fa-solid fa-id-card"></i> Placas:</strong> <span id="det-placa"></span></p>
                    <p><strong><i class="fa-solid fa-location-dot"></i> Ubicación:</strong> <span id="det-ubicacion"></span></p>
                    <p><strong><i class="fa-solid fa-calendar-check"></i> Fecha Promesa:</strong> <span id="det-promesa"></span></p>
                    <p><strong><i class="fa-solid fa-clock"></i> Ocurrido el:</strong> <span id="det-fecha"></span></p>
                </div>

                <h3>Descripción del Asegurado</h3>
                <p id="det-descripcion" class="descripcion-texto"></p>
                
                <div id="cont-unidades-extra" style="margin-top: 10px; font-size: 0.9rem; color: #aaa;">
                    <strong>Otras unidades:</strong> <span id="det-unidades"></span>
                </div>
            </div>
        </div>
    </div>
</div>