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