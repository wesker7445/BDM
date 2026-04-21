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
    // ... resto de tu lógica actual ...
    modal.classList.remove('hidden');
}