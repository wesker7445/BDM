<section id="sec-registrar-aseguradora" class="content-section hidden">
    <header class="top-bar">
        <h2>Gestión de Aseguradoras</h2>
    </header>

    <div class="form-siniestro-container">
        <form action="../Procesos/procesar_aseguradora.php" method="POST">
            <h3 style="color: var(--text-primary); margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
                Registrar Nueva Aseguradora
            </h3>
            
            <div class="grupo-input">
                <label> Nombre de la Empresa</label>
                <input type="text" name="nombre_aseguradora" placeholder="Ej. Seguros Atlas" required>
            </div>

            <div class="grupo-input">
                <label> Representante legal</label>
                <input type="text" name="Representante_legal" placeholder="Ej. Alberto Mendez" required>
            </div>

            <div class="grupo-input">
                <label> RFC del representante</label>
                <input type="text" name="RFC" placeholder="Ej. MCD15CX23" required>
            </div>

            <div class="grupo-input">
                <label> Teléfono de Contacto</label>
                <input type="tel" name="telefono" placeholder="811-000-0000">
            </div>

            <div class="grupo-input">
                <label> Correo Electrónico de Soporte</label>
                <input type="email" name="email_soporte" placeholder="contacto@seguro.com">
            </div>

            <div class="grupo-input">
                <label> Direccion de la empresa</label>
                <input type="text" name="Direccion" placeholder="Ej. Av. Fidel Velazquez" required>
            </div>

            <div style="margin-top: 20px;">
                <input type="submit" class="boton-submit" value="Guardar Aseguradora">
            </div>
        </form>
    </div>
</section>