// 1. Gestión de Temas (Solo una vez)
const currentTheme = localStorage.getItem('theme') || 'dark';
document.documentElement.setAttribute('data-theme', currentTheme);

function toggleTheme() {
    let theme = document.documentElement.getAttribute('data-theme');
    let newTheme = (theme === 'dark') ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    actualizarIcono(newTheme); // Asegúrate de que esta función exista o esté definida
}

function actualizarIcono(theme) {
    const icon = document.getElementById('theme-icon');
    if (icon) {
        if (theme === 'light') {
            icon.classList.replace('fa-sun', 'fa-moon');
        } else {
            icon.classList.replace('fa-moon', 'fa-sun');
        }
    }
}

// 2. Función para el Login/Registro (Mover desde el HTML)
function cambiarTab(tipo) {
    const formLogin = document.getElementById('form-login');
    const formRegistro = document.getElementById('form-registro');
    const tabLogin = document.getElementById('tab-login');
    const tabRegistro = document.getElementById('tab-registro');

    if (tipo === 'login') {
        formLogin.classList.remove('hidden');
        formRegistro.classList.add('hidden');
        tabLogin.classList.add('Tab-Activo');
        tabRegistro.classList.remove('Tab-Activo');
    } else {
        formLogin.classList.add('hidden');
        formRegistro.classList.remove('hidden');
        tabLogin.classList.remove('Tab-Activo');
        tabRegistro.classList.add('Tab-Activo');
    }
}

// 3. Cambio de secciones en el Dashboard
// 3. Cambio de secciones en el Dashboard
function mostrarSeccion(seccionId) {
    // Ocultar todas las secciones y quitar clase activa del menú
    document.querySelectorAll('.content-section').forEach(sec => sec.classList.add('hidden'));
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('activo'));
    
    const target = document.getElementById(seccionId);
    if (target) {
        target.classList.remove('hidden');

        // Lógica para el mensaje de advertencia
        if (seccionId === 'sec-crear-siniestro') {
            Swal.fire({
                icon: 'info',
                title: 'Instrucción',
                text: 'Primero registre el vehículo involucrado, caso contrario no se podra registrar el siniestro.',
                confirmButtonColor: '#5d5dff',
                background: 'var(--container-bg)', // Usa tus variables de CSS de Main.js
                color: 'var(--text-primary)'
            });
        }
    }
}

// 4. Validación del formulario de registro
document.addEventListener('DOMContentLoaded', () => {
    actualizarIcono(currentTheme);

    // 1. Notificaciones para mensajes que vienen de la URL (PHP)
    const urlParams = new URLSearchParams(window.location.search);
    
    // Si el registro fue exitoso
    if (urlParams.get('registro') === 'exito') {
        Swal.fire({
            icon: 'success',
            title: '¡Bienvenido!',
            text: 'Tu cuenta ha sido creada. Ya puedes iniciar sesión.',
            confirmButtonColor: '#5d5dff',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    }

    // Si hubo error de login
    if (urlParams.get('error') === 'login') {
        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: 'Correo o contraseña incorrectos.',
            confirmButtonColor: '#d33',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    }

    // 2. Validación de contraseña en el Registro
    const formRegistro = document.getElementById('form-registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            const password = document.getElementById('ContrasenaR').value;
            
            // Creamos un arreglo para guardar específicamente lo que falta
            let errores = [];

            // Validaciones individuales
            if (password.length < 8) {
                errores.push("Mínimo 8 caracteres.");
            }
            if (!/[A-Z]/.test(password)) {
                errores.push("Al menos una letra mayúscula.");
            }
            if (!/[a-z]/.test(password)) {
                errores.push("Al menos una letra minúscula.");
            }
            if (!/\d/.test(password)) {
                errores.push("Al menos un número.");
            }
            if (!/[@$!%*?&]/.test(password)) {
                errores.push("Al menos un carácter especial (@$!%*?&).");
            }

            // Si hay errores, detenemos el envío y mostramos SweetAlert2
            if (errores.length > 0) {
                e.preventDefault();
                
                // Construimos la lista de errores para el HTML del modal
                let listaErrores = '<ul style="text-align: left; font-size: 0.85rem; color: #f87171;">';
                errores.forEach(error => {
                    listaErrores += `<li>${error}</li>`;
                });
                listaErrores += '</ul>';

                Swal.fire({
                    icon: 'warning',
                    title: 'Contraseña incompleta',
                    html: `
                        <p style="text-align: left; font-size: 0.9rem; margin-bottom: 10px;">
                            Para que tu cuenta sea segura, te falta:
                        </p>
                        ${listaErrores}
                    `,
                    confirmButtonColor: '#5d5dff',
                    background: 'var(--container-bg)',
                    color: 'var(--text-primary)'
                });
            }
        });
    }

// Notificaciones de Actualización de Perfil
    const updateStatus = urlParams.get('update');

    if (updateStatus) {
        // Limpiamos la URL para que la alerta no se repita si el usuario recarga la página
        window.history.replaceState(null, null, window.location.pathname);

        if (updateStatus === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Tu perfil se ha actualizado correctamente.',
                confirmButtonColor: '#5d5dff',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
        } else if (updateStatus === 'no_changes') {
            Swal.fire({
                icon: 'info',
                title: 'Sin cambios',
                text: 'No modificaste ningún dato nuevo o seleccionaste la misma foto.',
                confirmButtonColor: '#5d5dff',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
        } else if (updateStatus === 'error_peso') {
            Swal.fire({
                icon: 'error',
                title: 'Imagen muy pesada',
                text: 'La imagen supera el límite de tamaño permitido por el servidor.',
                confirmButtonColor: '#d33',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
        } else if (updateStatus === 'error_archivo') {
            Swal.fire({
                icon: 'warning',
                title: 'Error al subir',
                text: 'Hubo un problema procesando la imagen. Intenta con otra.',
                confirmButtonColor: '#f59e0b',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
        } else if (updateStatus === 'error_bd') {
            Swal.fire({
                icon: 'error',
                title: 'Error del sistema',
                text: 'Ocurrió un error en la base de datos. Inténtalo más tarde.',
                confirmButtonColor: '#d33',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
        }
    }

    // Listener para cambios en inputs de archivos
const inputsArchivo = document.querySelectorAll('input[type="file"]');

    inputsArchivo.forEach(input => {
        input.addEventListener('change', function() {
        const label = this.closest('.boton-archivo');
        
        if (this.files.length > 0 && label) {
            label.classList.add('archivo-cargado');
            
            // Cambiamos el texto del span SIN borrar el input oculto
            const spanTexto = label.querySelector('.texto-archivo');
            if (spanTexto) {
                spanTexto.textContent = ' Archivo seleccionado';
            }
            } else if (label) {
            label.classList.remove('archivo-cargado');
            
            // Restauramos el texto original si el usuario cancela la selección
            const spanTexto = label.querySelector('.texto-archivo');
            if (spanTexto) {
                spanTexto.textContent = ' Cambiar Foto de Perfil';
            }
            }
        });
    });
});