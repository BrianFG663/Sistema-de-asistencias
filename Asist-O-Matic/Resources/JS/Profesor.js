function redireccion(valor){
    valor = Number(valor);

    switch(valor){
        case 1:
            location.href =  "profesores-index.php";
        break

        case 2:
            location.href =  "../profesores-index.php";
        break

        case 3:
            location.href = "crear-alumnos.php";
        break

        case 4:
            location.href = "tomar-asistencia.php";
        break

        case 5:
            location.href = "Materias-index.php";
        break

        case 6:
            location.href = "../Materias-index.php";
        break

    }
}

function formularioAsistencias(){

    Swal.fire({
        title: "¿Desea subir las asistencias?",
        showCancelButton: true,
        confirmButtonText: "Subir",
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Asistencias registradas!",
                showConfirmButton: false,
                timer: 1500
              });
            
            setTimeout(() => {
                document.getElementById("formulario-asistencias").submit()
            }, 1600);

        }
      });

}


function formularioEditarAlumno(){


Swal.fire({
        title: "¿Desea actualizar los datos?",
        showCancelButton: true,
        confirmButtonText: "actualizar",
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "datos actualizadss!",
                showConfirmButton: false,
                timer: 1500
              });
            setTimeout(() => {
                document.getElementById("editar-alumno").submit()
            }, 1600);

        }
      });
        
}

function formularioSalida(){

    Swal.fire({
        title: "¿Desea actualizar la asistencia?",
        showCancelButton: true,
        confirmButtonText: "actualizar",
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Asistencias actualizadas!",
                showConfirmButton: false,
                timer: 1500
              });
            setTimeout(() => {
                document.getElementById("formulario-salida").submit()
            }, 1600);

        }
      });
}

function formularioLlegada(){

    Swal.fire({
        title: "¿Desea marcar las llegadas?",
        showCancelButton: true,
        confirmButtonText: "Subir",
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Llegadas registradas!",
                showConfirmButton: false,
                timer: 1500
              });
            setTimeout(() => {
                document.getElementById("formulario-tarde").submit()
            }, 1600);

        }
      });
}

function formularioInscribirMateria(button){
    Swal.fire({
        title: "¿Desea inscribirse a esta materia?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire("Se ha inscrito a la materia!", "", "success");

            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha inscrito a la materia correctamente!",
                showConfirmButton: false,
                timer: 1500
            });
    
            setTimeout(() => {
                button.closest('form').submit();
            }, 1600);

        }
      });

}

function formularioInscribirInstituto(button) {
    Swal.fire({
        title: "¿Desea inscribirse a este instituto?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha inscripto al instituto correctamente!",
                showConfirmButton: false,
                timer: 1500
            });

            // Enviar el formulario al que pertenece el botón
            setTimeout(() => {
                button.closest('form').submit(); // Envía el formulario correspondiente
            }, 1600);
        }
    });
}

function formularioEliminarAsistencia(button) {
    Swal.fire({
        title: "¿Desea eliminar esta asistencia?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha eliminado la asistencia correctamente!",
                showConfirmButton: false,
                timer: 1500
            });

            setTimeout(() => {
                button.closest('form').submit(); 
            }, 1600);
        }
    });
}

function formularioMarcarSalida(button){
    Swal.fire({
        title: "¿Desea marcar salida de este alumno?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha marcado la salida correctamente!",
                showConfirmButton: false,
                timer: 1500
            });


            setTimeout(() => {
                button.closest('form').submit(); // Envía el formulario correspondiente
            }, 1600);
        }
    });
}

function formularioMarcarEntrada(button){
    Swal.fire({
        title: "¿Desea marcar entrada de este alumno?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha marcado la entrada correctamente!",
                showConfirmButton: false,
                timer: 1500
            });


            setTimeout(() => {
                button.closest('form').submit(); // Envía el formulario correspondiente
            }, 1600);
        }
    });
}

function formularioEliminarInstituto(button) {
  Swal.fire({
      title: "¿Desea quitar este instituto?",
      showCancelButton: true,
      confirmButtonText: "Confirmar"
  }).then((result) => {
      if (result.isConfirmed) {
          Swal.fire({
              position: "center",
              icon: "success",
              title: "Se ha quitado al instituto correctamente!",
              showConfirmButton: false,
              timer: 1500
          });

          // Enviar el formulario al que pertenece el botón
          setTimeout(() => {
              button.closest('form').submit(); // Envía el formulario correspondiente
          }, 1600);
      }
  });
}

function formularioEliminarAlumno(button) {
    Swal.fire({
        title: "¿Desea quitar este alumno?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha eliminado el alumno correctamente!",
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(() => {
                button.closest('form').submit();
            }, 1600);
        }
    });
  }


function formularioAlumno(){
    nombre = document.getElementById("nombre-alumno").value
    apellido = document.getElementById("apellido-alumno").value
    dni = document.getElementById("dni-alumno").value
    fecha = document.getElementById("fecha-alumno").value
    const formulario = document.getElementById("inscribir-alumno");


    const comprobar_dni = /^\d+$/.test(dni);
    const comprobar_nombre = /^[a-zA-Z\s]*$/.test(nombre);
    const comprobar_apellido = /^[a-zA-Z\s]*$/.test(apellido);
    const intMax = 100000000;

    if(dni !== ""){
        if(apellido !== ""){
            if(nombre !==""){
                if (comprobar_dni) {
                    if(dni <= intMax){
                        if (comprobar_nombre) {
                            if (comprobar_apellido) {
                                if(fecha !== ""){
                                    Swal.fire({
                                        title: "¿Desea inscribir al alumno?",
                                        showCancelButton: true,
                                        confirmButtonText: "Inscribir"
                                      }).then((result) => {
                                        if (result.isConfirmed) {
                                                               

                                            let datos = new FormData(formulario);
                                            fetch('crear-alumnos.php', {
                                                method: 'POST',
                                                body: datos
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                
                                                if(data.mensaje == "verdadero"){
                                                    Swal.fire({
                                                        position: "center",
                                                        icon: "success",
                                                        title: "Se ha registrado el alumno correctamente!",
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                    setTimeout(() => {
                                                        formulario.submit();
                                                        location.href = "crear-alumnos.php";
                                                    }, 1600);
                                                }

                                                if(data.mensaje == "falso"){
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "El alumno ya esta inscripto",
                                                    });
                                                }

                                            });


                                        }
                                    });
                                }else{
                                    Swal.fire({
                                        icon: "error",
                                        title: "Debe asignar una fecha de nacimiento",
                                    });
                                }
                            }else {
                                Swal.fire({
                                    icon: "error",
                                    title: "El apellido no permite caracteres especiales o numeros",
                                });
                            }
                        }else {
                            Swal.fire({
                                icon: "error",
                                title: "El nombre no permite caracteres especiales o numeros",
                            });
                        }
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "el DNI no puede ser mayor a 100.000.000",
                        });
                    }    
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "El  DNI no permite caracteres especiales o letras",
                    });
                }

            }else{
                Swal.fire({
                    icon: "error",
                    title: "Por favor completa el formulario"
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "Por favor completa el formulario"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "Por favor completa el formulario"
        });
    }
}

function formularioParametros(){
    regular = document.getElementById("regular").value;
    promocion = document.getElementById("promocion").value;
    asistenciaRegular = document.getElementById("asistencia-regular").value;
    asistenciaPromocion = document.getElementById("asistencia-promocion").value;
    tolerancia = document.getElementById("tolerancia").value;

    if(regular == "" && promocion == "" && asistenciaPromocion == "" && asistenciaRegular == "" && tolerancia == ""){
        Swal.fire({
            icon: "error",
            title: "Debe rellenar al menos un campo"
        });
    }else{
        if(regular >= 0 && promocion >= 0){
            if(regular <= 10 && promocion <= 10){
                Swal.fire({
                    title: "¿Desea cambiar los parametros?",
                    showCancelButton: true,
                    confirmButtonText: "Inscribir"
                  }).then((result) => {
            
                    if (result.isConfirmed) {
                      Swal.fire("Parametros cambiados!", "", "success");
                      setTimeout(() => {
                        document.getElementById("formulario-parametros").submit();
                    }, 1000);
                    }
                });
            }else{
                Swal.fire({
                    icon: "error",
                    title: "No se puede asignar una nota mayor a diez"
                });   
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "No se puede asignar una nota menor a cero"
            }); 
        }
    }
}

function formularioCalificaciones(button) {
    const fecha = document.getElementById("fecha").value;
    const formulario = document.getElementById("formulario-calificaciones");
    const notasNuevas = document.querySelectorAll('.input-notas');
    
    const algunaNotaNoVacia = Array.from(notasNuevas).some(input => input.value.trim() !== '');

    if (algunaNotaNoVacia) {
        let notasValidas = true; 
        
        notasNuevas.forEach(input => {
            const nota = parseFloat(input.value);
            if (nota < 0 || nota > 10) {  
                notasValidas = false;
            }
        });
        
        if (notasValidas) {
            if (fecha !== "") {
                Swal.fire({
                    title: "¿Desea subir calificaciones?",
                    showCancelButton: true,
                    confirmButtonText: "Inscribir"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let datos = new FormData(formulario);
                        fetch('calificaciones.php', {
                            method: 'POST',
                            body: datos
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.tipo == "normal" && data.mensaje == "verdadero") {
                                Swal.fire("Calificaciones subidas!", "", "success");
                            }
                            if (data.tipo == "recuperatorio") {
                                if (data.mensaje == "verdadero") {
                                    Swal.fire("Recuperatorios subidos!", "", "success");
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "No se encontró un examen ese día"
                                    });
                                }
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "La fecha es obligatoria"
                });
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "Cada nota ingresada debe estar entre 0 y 10"
            });
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Debe ingresar al menos una nota"
        });
    }
}



function mostrarLabel() {
    const valor = Number(document.getElementById("tipo-examen").value);

    switch(valor){
        case 1:
            document.getElementById("label-fecha").innerHTML = 
            `<label for="fecha-recuperatorio">Seleccione fecha del parcial</label>`;
        break

        case 2:
            document.getElementById("label-fecha").innerHTML = 
            `<label for="fecha-recuperatorio">Seleccione fecha del parcial a recuperar</label>`;
        break

        case 3:
            document.getElementById("label-fecha").innerHTML = 
            `<label for="fecha-recuperatorio">Seleccione fecha del trabajo practico</label>`;
        break
    }
}


function editarEliminarNota(button){
    button.closest('form').submit();
}

function formularioEditarNota(button){
const notasNuevas = document.querySelectorAll('.nota-nueva');

const algunaNotaNoVacia = Array.from(notasNuevas).some(input => input.value.trim() !== '');

const notaInput = button.closest('form').querySelector('.nota-nueva');
const nota = notaInput.value.trim();


    if(algunaNotaNoVacia){
        if(nota >= 0 && nota <= 10){
            Swal.fire({
                title: "¿Desea editar esta nota?",
                showCancelButton: true,
                confirmButtonText: "Confirmar"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Se ha editado la nota correctamente!",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    button.closest('form').submit();
                }, 1600);
            }
            });
        }else{
            Swal.fire({
                icon: "error",
                title: "La nota ingresada debe estar entre 0 y 10"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "Debe ingresar al menos una nota"
        });
    }
        
    
}

function formularioeliminarNota(button){
    Swal.fire({
        title: "¿Desea eliminar esta nota?",
        showCancelButton: true,
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha eliminado la nota correctamente!",
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(() => {
                button.closest('form').submit();
            }, 1600);
        }
    });

}