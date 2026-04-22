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
function mostrarSeccion(seccionId) {
    document.querySelectorAll('.content-section').forEach(sec => sec.classList.add('hidden'));
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('activo'));
    const target = document.getElementById(seccionId);
    if (target) target.classList.remove('hidden');
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

    const updateStatus = urlParams.get('update');

    if (updateStatus === 'success') {
        Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: 'Tu perfil se ha actualizado correctamente.',
            confirmButtonColor: '#5d5dff',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    } else if (updateStatus === 'error') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar tu perfil. Inténtalo de nuevo.',
            confirmButtonColor: '#d33',
            background: 'var(--container-bg)',
            color: 'var(--text-primary)'
        });
    }

    // Listener para cambios en inputs de archivos
const inputsArchivo = document.querySelectorAll('input[type="file"]');

    inputsArchivo.forEach(input => {
        input.addEventListener('change', function() {
            // Buscamos el label que contiene o está asociado al input
            const label = this.closest('.boton-archivo') || 
                        this.parentElement.querySelector('.boton-archivo') ||
                        document.querySelector(`label[for="${this.id}"]`);

            if (this.files.length > 0 && label) {
                label.classList.add('archivo-cargado');
                // Opcional: Cambiar el texto para mostrar que ya hay un archivo
                const icono = label.querySelector('i');
                label.innerHTML = '';
                if (icono) label.appendChild(icono);
                label.innerHTML += ' Archivo seleccionado';
            } else if (label) {
                label.classList.remove('archivo-cargado');
            }
        });
    });
});