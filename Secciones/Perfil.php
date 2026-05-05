<section id="sec-perfil" class="content-section hidden">
    <header class="top-bar">
        <h2>Mi Perfil</h2>
    </header>
    
    <div class="form-siniestro-container">
        <div class="perfil-header">
            <?php if (!empty($userData['Foto'])): ?>
                <img src="data:image/png;base64,<?php echo base64_encode($userData['Foto']); ?>" class="avatar-perfil" alt="Avatar">
            <?php else: ?>
                <img src="../Multimedia/Imagen/Asegurado.png" class="avatar-perfil" alt="Avatar">
            <?php endif; ?>
            
            <h3><?php echo htmlspecialchars($userData['Nombre'] . " " . $userData['Apellidos']); ?></h3>
            <p>@<?php echo htmlspecialchars($userData['Alias']); ?></p>
        </div>

        <form action="../Procesos/actualizar_perfil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['user_id']; ?>">

            <div class="grupo-input">
                <label>Nombre(s)</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($userData['Nombre']); ?>">
            </div>

            <div class="grupo-input">
                <label>Apellidos</label>
                <input type="text" name="apellido" value="<?php echo htmlspecialchars($userData['Apellidos']); ?>">
            </div>

            <div class="grupo-input">
                <label>Alias / Nombre de Usuario</label>
                <input type="text" name="alias" value="<?php echo htmlspecialchars($userData['Alias']); ?>">
            </div>

            <div class="grupo-input">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha" value="<?php echo $userData['FechaNacimiento']; ?>">
            </div>

            <div class="grupo-input">
                <label>Género</label>
                <select name="genero">
                    <option value="Hombre" <?php echo ($userData['Genero'] == 'Hombre') ? 'selected' : ''; ?>>Hombre</option>
                    <option value="Mujer" <?php echo ($userData['Genero'] == 'Mujer') ? 'selected' : ''; ?>>Mujer</option>
                </select>
            </div>

            <div class="grupo-input">
                <label>Correo Electrónico (No editable)</label>
                <input type="email" name="correroR" id="CorreoR" 
                    value="<?php echo htmlspecialchars($userData['Email']); ?>" 
                    readonly class="input-readonly">
            </div>

            <div class="grupo-input">
                <label class="boton-archivo">
                    <i class="fa-solid fa-camera"></i> 
                    <!-- Agregamos este span para proteger el texto -->
                    <span class="texto-archivo">Cambiar Foto de Perfil</span> 
                    <input type="file" name="multimedia" accept="image/*" style="display: none;">
                </label>
            </div>

            <div class="perfil-acciones">
                <input type="submit" class="boton-submit" value="Guardar Cambios">
                <button type="button" class="boton-cancelar" onclick="mostrarSeccion('sec-siniestros')">Cancelar</button>
            </div>
        </form>
    </div>
</section>