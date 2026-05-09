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

    if (updateStatus === 'success') {
            const msgType = urlParams.get('msg');
            let titulo = '¡Logrado!';
            let texto = 'Operación realizada con éxito.';

            // Busca esta sección en tu Main.js y agrega la línea de siniestro_reg:
            const mensajes = {
                'vehiculo_reg': 'El vehículo ha sido registrado correctamente.',
                'vehiculo_upd': 'Los datos del vehículo se han actualizado.',
                'vehiculo_del': 'El vehículo ha sido desactivado del sistema.',
                'aseg_reg': 'La aseguradora se registró exitosamente.',
                'aseg_upd': 'La información de la aseguradora fue actualizada.',
                'aseg_del': 'La aseguradora ha sido dada de baja.',
                'siniestro_reg': 'El siniestro y su evidencia se han guardado correctamente.' // <--- Agrega esta línea
            };

            // Si existe el mensaje en el diccionario, lo usamos
            if (mensajes[msgType]) {
                texto = mensajes[msgType];
            } else {
                // Mensaje por defecto si no viene un 'msg' específico (como el perfil)
                titulo = '¡Actualizado!';
                texto = 'Tu perfil se ha actualizado correctamente.';
            }

            // UNICA LLAMADA A SWAL.FIRE
            Swal.fire({
                icon: 'success',
                title: titulo,
                text: texto,
                confirmButtonColor: '#5d5dff',
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });

            // ELIMINA ESTO:
            /* Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Tu perfil se ha actualizado correctamente.',
                ...
            }); 
            */
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

function limpiarFormularioVehiculo() {
    document.getElementById('form-vehiculo').reset();
    document.getElementById('id_vehiculo').value = "";
    document.getElementById('form-vehiculo-titulo').innerText = "Registrar Nuevo Vehículo";
    document.getElementById('btn-submit-vehiculo').value = "Guardar Vehículo"; // Restaurar texto
    
    // Desbloquear placa
    document.getElementById('v_placas').readOnly = false;
    document.getElementById('v_placas').style.opacity = "1";
}

function editarVehiculo(placa, marca, modelo, serie, color, tipo) {
    // Cambiar títulos y textos
    document.getElementById('form-vehiculo-titulo').innerText = "Editando Vehículo: " + placa;
    document.getElementById('btn-submit-vehiculo').value = "Actualizar Datos"; // Cambia el texto del botón
    
    // Asignar valores a los inputs
    document.getElementById('id_vehiculo').value = placa; 
    document.getElementById('v_placas').value = placa;
    document.getElementById('v_marca').value = marca;
    document.getElementById('v_modelo').value = modelo;
    document.getElementById('v_serie').value = serie;
    document.getElementById('v_color').value = color;
    document.getElementById('v_tipo').value = tipo;
    
    // Bloquear el input de placa (opcional, ya que es la llave primaria y no debería cambiar)
    document.getElementById('v_placas').readOnly = true;
    document.getElementById('v_placas').style.opacity = "0.7";

    // Desplazar suavemente al formulario
    document.getElementById('form-vehiculo').scrollIntoView({ behavior: 'smooth' });
}

function eliminarVehiculo(placa) {
    Swal.fire({
        title: '¿Desactivar vehículo?',
        text: `El vehículo con placas ${placa} ya no aparecerá en los nuevos reportes.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#475569',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar',
        background: 'var(--container-bg)',
        color: 'var(--text-primary)'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigimos al proceso enviando la placa
            window.location.href = `../Procesos/eliminar_vehiculo.php?placa=${placa}`;
        }
    });
}

function eliminarAseguradora(id, nombre) {
    Swal.fire({
        title: '¿Desactivar aseguradora?',
        text: `La aseguradora "${nombre}" será dada de baja lógicamente y ya no aparecerá en los registros activos.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#475569',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar',
        background: 'var(--container-bg)',
        color: 'var(--text-primary)'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigimos al proceso enviando el ID
            window.location.href = `../Procesos/eliminar_aseguradora.php?id=${id}`;
        }
    });
}

function editarAseguradora(id, nombre, representante, rfc, telefono, email, direccion) {
    // 1. Cambiar visuales
    document.getElementById('form-aseguradora-titulo').innerText = "Editando: " + nombre;
    document.getElementById('btn-submit-aseguradora').value = "Actualizar Aseguradora";
    
    // 2. Llenar campos ocultos y visibles
    document.getElementById('id_aseguradora').value = id;
    document.getElementById('aseg_nombre').value = nombre;
    document.getElementById('aseg_representante').value = representante;
    document.getElementById('aseg_rfc').value = rfc;
    document.getElementById('aseg_telefono').value = telefono;
    document.getElementById('aseg_email').value = email;
    document.getElementById('aseg_direccion').value = direccion;

    // 3. Scroll al formulario
    document.getElementById('form-aseguradora').scrollIntoView({ behavior: 'smooth' });
}

function limpiarFormularioAseguradora() {
    // Resetear el formulario
    document.getElementById('form-aseguradora').reset();
    
    // Limpiar ID oculto y restaurar textos
    document.getElementById('id_aseguradora').value = "";
    document.getElementById('form-aseguradora-titulo').innerText = "Registrar Nueva Aseguradora";
    document.getElementById('btn-submit-aseguradora').value = "Guardar Aseguradora";
}