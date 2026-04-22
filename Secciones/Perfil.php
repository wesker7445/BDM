<section id="sec-perfil" class="content-section hidden">
    <header class="top-bar">
        <h2>Mi Perfil</h2>
    </header>
    <div class="form-siniestro-container">
        <div class="perfil-header">
            <?php if (isset($_SESSION['user_foto']) && $_SESSION['user_foto']): ?>
                <img src="data:image/png;base64,<?php echo $_SESSION['user_foto']; ?>"  class="avatar-perfil" alt="Avatar">
            <?php endif; ?>
            <h3><?php echo $_SESSION['user_nombre']; ?></h3>
        </div>
        <form action="Procesos/actualizar_perfil.php" method="POST">
            <div class="grupo-input">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" value="<?php echo $_SESSION['user_nombre']; ?>">
            </div>
            <input type="submit" class="boton-submit" value="Guardar Cambios">
        </form>
    </div>
</section>