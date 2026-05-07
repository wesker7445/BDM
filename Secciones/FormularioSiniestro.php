<?php

?>


<section id="sec-crear-siniestro" class="content-section hidden">
    <header class="top-bar">
        <h2>Reportar Nuevo Siniestro </h2>
    </header>

        <div class="form-siniestro-container">
        <h2>Datos del Vehículo Involucrado</h2>

        <div class="grupo-input">
            <label>Placas</label>
            <input type="text" name="placas" placeholder="ABC-123-A" required>
        </div>

        <div class="grupo-input">
            <label>Marca</label>
            <input type="text" name="vehiculo" placeholder="Ej. Chevrolet" required>
        </div>

        <div class="grupo-input">
            <label>Modelo</label>
            <input type="text" name="vehiculo" placeholder="Ej. Aveo 2022" required>
        </div>

        <div class="grupo-input">
            <label>Tipo</label>
            <input type="text" name="vehiculo" placeholder="Ej. Sedan, pickup, suv, etc." required>
        </div>

        <div class="grupo-input">
            <label>Número de Serie (VIN)</label>
            <input type="text" name="serie" placeholder="17 dígitos" required>
        </div>

        <div class="grupo-input">
            <label>Color</label>
            <input type="text" name="color" placeholder="Ej. Rojo Brillante">
        </div>

        <input type="submit" class="boton-submit" value="Registrar el vehiculo">
    </div>

    <div class="form-siniestro-container">
        <form action="Procesos/procesar_siniestro.php" method="POST" enctype="multipart/form-data">
            
            <div class="grupo-input">
                <label>Título del Siniestro</label>
                <input type="text" name="titulo" placeholder="Ej. Choque lateral Aveo" required>
            </div>

            <input type="submit" class="boton-submit" value="Dar de Alta Siniestro e Involucrado">
        </form>
    </div>
</section>