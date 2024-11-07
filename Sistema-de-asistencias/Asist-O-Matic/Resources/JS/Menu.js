function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("button").style.opacity = "0";  // Desaparece el botón
  setTimeout(() => {
    document.getElementById("button").style.display = "none"; // Lo oculta después de la animación
  }, 300);

  document.getElementById("mySidenav").classList.add("open"); // Añadir la clase para reducir el borde
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("button").style.display = "block"; // Vuelve a mostrar el botón
  setTimeout(() => {
    document.getElementById("button").style.opacity = "1";  // Restaura la visibilidad del botón
  }, 100);

  document.getElementById("mySidenav").classList.remove("open"); // Quitar la clase para restaurar el borde
}
