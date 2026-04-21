<section id="sec-crear-siniestro" class="content-section hidden">
    <header class="top-bar">
        <h2>Reportar Nuevo Siniestro</h2>
    </header>
    <div class="form-siniestro-container">
        <form action="Procesos/procesar_siniestro.php" method="POST" enctype="multipart/form-data">
            <div class="grupo-input">
                <label>Título del Siniestro</label>
                <input type="text" name="titulo" placeholder="Ej. Choque lateral" required>
            </div>
            <input type="submit" class="boton-submit" value="Dar de Alta Siniestro">
        </form>
    </div>
</section>