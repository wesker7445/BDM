// Gestión de Temas (Modo Día/Noche)
const currentTheme = localStorage.getItem('theme') || 'dark';
document.documentElement.setAttribute('data-theme', currentTheme);

function toggleTheme() {
    let theme = document.documentElement.getAttribute('data-theme');
    let newTheme = (theme === 'dark') ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
}

// Cambio de secciones en el Dashboard
function mostrarSeccion(seccionId) {
    document.querySelectorAll('.content-section').forEach(sec => sec.classList.add('hidden'));
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('activo'));
    document.getElementById(seccionId).classList.remove('hidden');
}

// Modal de detalles
function abrirDetalleSiniestro(titulo, imagen, estado, ajustador, fecha, descripcion) {
    const modal = document.getElementById('modal-detalle');
    const contenedor = document.getElementById('contenedor-media-modal');

    if (imagen.toLowerCase().endsWith('.mp4')) {
        contenedor.innerHTML = `<video src="${imagen}" controls autoplay muted style="width:100%; height:100%; object-fit:cover;"></video>`;
    } else {
        contenedor.innerHTML = `<img id="detalle-img" src="${imagen}" alt="Evidencia" style="width:100%; height:100%; object-fit:cover;">`;
    }
    
    document.getElementById('detalle-titulo').innerText = titulo;
    document.getElementById('detalle-status').innerText = estado;
    
    const infoParagraphs = document.querySelectorAll('.detalle-info p');
    infoParagraphs[0].innerHTML = `<strong><i class="fa-solid fa-user-tie"></i> Ajustador:</strong> ${ajustador}`;
    infoParagraphs[1].innerHTML = `<strong><i class="fa-solid fa-clock"></i> Fecha:</strong> ${fecha}`;
    
    document.querySelector('.descripcion-texto').innerText = descripcion;
    modal.classList.remove('hidden');
}