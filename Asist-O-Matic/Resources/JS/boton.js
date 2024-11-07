// boton editar notas


const divsNotas = document.querySelectorAll(".notas");

divsNotas.forEach((divNotas) => {
    const botonEliminar = divNotas.querySelector(".eliminar-nota");

    // Mostrar el botón al pasar el cursor
    divNotas.addEventListener("mouseenter", () => {
        botonEliminar.style.display = "block";
    });

    // Ocultar el botón al quitar el cursor
    divNotas.addEventListener("mouseleave", () => {
        botonEliminar.style.display = "none";
    });
});




// boton formulario dia listado 

document.addEventListener("DOMContentLoaded", function() {
    const cantidadAsistencias = document.getElementById("cantidad-asistencias");
    const imagenCalendario = document.getElementById("imagen-calendario");
    const fechaTexto = document.getElementById("fecha-texto");
    const formularioBusqueda = document.getElementById("formulario-busqueda");

    if (cantidadAsistencias && imagenCalendario && fechaTexto && formularioBusqueda) {
        // Mostrar formulario y ocultar imagen y texto al pasar el ratón
        cantidadAsistencias.addEventListener("mouseenter", function() {
            imagenCalendario.style.display = "none";
            fechaTexto.style.display = "none";
            formularioBusqueda.style.display = "block";
        });

        // Restaurar imagen y texto al quitar el ratón
        cantidadAsistencias.addEventListener("mouseleave", function() {
            imagenCalendario.style.display = "inline";
            fechaTexto.style.display = "inline";
            formularioBusqueda.style.display = "none";
        });
    } else {
        console.error("No se encontraron uno o más elementos con los ID especificados.");
    }
});


//menu cumpleaños

window.addEventListener('load', function() {
    const desplegable = document.getElementById('desplegable');
    desplegable.classList.add('visible');
});


