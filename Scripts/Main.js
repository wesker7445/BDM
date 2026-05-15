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

function abrirDetalleSiniestro(titulo, imagen, estado, ajustador, fecha, descripcion, aseguradora, poliza, placa, ubicacion, unidades, promesa) {
    const modal = document.getElementById('modal-detalle');
    const contenedor = document.getElementById('contenedor-media-modal');

    // 1. Manejo de Multimedia (Imagen o Video)
    if (imagen.toLowerCase().includes('video') || imagen.toLowerCase().endsWith('.mp4')) {
        contenedor.innerHTML = `<video src="${imagen}" controls autoplay muted style="width:100%; height:100%; object-fit:cover;"></video>`;
    } else {
        contenedor.innerHTML = `<img src="${imagen}" alt="Evidencia" style="width:100%; height:100%; object-fit:cover;">`;
    }
    
    // 2. Inyección de datos dinámicos
    document.getElementById('detalle-titulo').innerText = titulo;
    document.getElementById('detalle-status').innerText = estado;
    document.getElementById('det-ajustador').innerText = ajustador;
    document.getElementById('det-aseguradora').innerText = aseguradora;
    document.getElementById('det-poliza').innerText = poliza;
    document.getElementById('det-placa').innerText = placa;
    document.getElementById('det-ubicacion').innerText = ubicacion;
    document.getElementById('det-fecha').innerText = fecha;
    document.getElementById('det-promesa').innerText = promesa;
    document.getElementById('det-descripcion').innerText = descripcion;
    document.getElementById('det-unidades').innerText = unidades || "Ninguna";

    // 3. Mostrar el modal
    modal.classList.remove('hidden');
}

async function cargarMultimedia(idSiniestro) {
    const contenedor = document.getElementById('contenedor-multimedia-dinamico');
    const formExtra = document.getElementById('form-nueva-multimedia');
    const inputId = document.getElementById('id_siniestro_input');

    if (!idSiniestro) {
        contenedor.innerHTML = '<p>Seleccione un siniestro.</p>';
        formExtra.classList.add('hidden');
        return;
    }

    // Mostrar formulario de carga y asignar ID
    formExtra.classList.remove('hidden');
    inputId.value = idSiniestro;

    contenedor.innerHTML = '<p>Cargando evidencia...</p>';

    try {
        // Llamada a un pequeño archivo PHP que consulta la BD
        const response = await fetch(`../Procesos/obtener_evidencia.php?id=${idSiniestro}`);
        const data = await response.json();

    // Modificación dentro de cargarMultimedia en Main.js
    if (data.length === 0) {
        contenedor.innerHTML = '<p>Este siniestro no tiene fotos registradas.</p>';
    } else {
    // Modificar el bloque data.map dentro de cargarMultimedia() en Main.js
    contenedor.innerHTML = data.map(item => `
        <div class="siniestro-card" style="width: 200px; display: inline-block; margin: 10px;">
            <div class="card-image" style="height: 130px; overflow: hidden; position: relative;">
                ${item.tipo.includes('video') 
                    ? `<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; opacity: 0.8; z-index: 1; pointer-events: none;"><i class="fa-solid fa-play"></i></div>
                    <video src="${item.src}#t=0.1" preload="metadata" muted style="width:100%; height:100%; object-fit:cover;"></video>` 
                    : `<img src="${item.src}" style="width:100%; height:100%; object-fit:cover;">`}
            </div>
            <div class="card-info" style="padding: 10px; display: flex; justify-content: space-around; align-items: center;">
                <label style="color: #5d5dff; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-pen-to-square"></i> Cambiar
                    <input type="file" accept="image/*,video/*" style="display: none;" onchange="reemplazarMultimedia(${item.id}, this)">
                </label>
                <button onclick="eliminarFoto(${item.id})" style="background:none; border:none; color:#ff5d5d; cursor:pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    `).join('');
}
    } catch (error) {
        contenedor.innerHTML = '<p>Error al cargar multimedia.</p>';
    }
}

// Agregar al final de Main.js
async function reemplazarMultimedia(idMultimedia, input) {
    if (input.files.length === 0) return;
    
    const file = input.files[0];
    const formData = new FormData();
    formData.append('id_multimedia', idMultimedia);
    formData.append('nuevo_archivo', file);

    // Feedback visual de carga utilizando SweetAlert2
    Swal.fire({
        title: 'Reemplazando archivo...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    try {
        const response = await fetch('../Procesos/reemplazar_multimedia.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'El archivo multimedia ha sido modificado con éxito.',
                timer: 1500,
                showConfirmButton: false,
                background: 'var(--container-bg)',
                color: 'var(--text-primary)'
            });
            
            // Recargar la galería del siniestro actual de forma reactiva
            const idSiniestro = document.getElementById('selectSiniestro').value;
            cargarMultimedia(idSiniestro);
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No se pudo reemplazar el archivo.' });
        }
    } catch (error) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'No se logró establecer comunicación con el servidor.' });
    }
}

// Añadir al final de Main.js para controlar el cierre del modal
function cerrarModal() {
    const modal = document.getElementById('modal-detalle');
    if (modal) {
        modal.classList.add('hidden');
        
        // Limpiamos el contenedor multimedia para detener la reproducción de videos al cerrar
        const contenedor = document.getElementById('contenedor-media-modal');
        if (contenedor) contenedor.innerHTML = '';
    }
}

// Cerrar el modal automáticamente si el usuario hace clic fuera del recuadro del contenido
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modal-detalle');
    if (event.target === modal) {
        cerrarModal();
    }
});

function cambiarSiniestro(id) {
    if(!id) return;
    // Redirecciona al Dashboard pasando el parámetro y una bandera extra (ver paso 3)
    window.location.href = "Dashboard.php?id_siniestro=" + id + "&seccion=seguimiento";
}