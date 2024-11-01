function redireccion(valor){
    valor = Number(valor);

    switch(valor){
        case 1:
            location.href =  "Funciones-administrador/Agregar-materia.php";
        break

        case 2:
            location.href =  "Funciones-administrador/Agregar-profesor.php";
        break;

        case 3:
            location.href =  "Funciones-administrador/Agregar-instituto.php";
        break;

        case 4: 
            location.href =  "Funciones-administrador/Agregar-administrador.php";
        break;

        case 5:
            location.href =  "../editar-perfil.php";
        break;

        case 6:
            location.href =  "../index.php";
        break;

        case 7:
            location.href = '../Administrador-index.php';
        break;

        case 8:
            location.href = 'Administrador-index.php';
        break;

    }
}

function formularioMateria(valor){
    let formulario = document.getElementById("inscribir-materia");
    let nombre = document.getElementById("nombre_materia").value
    let descripcion = document.getElementById("descripcion_materia").value
    let numero_materia = document.getElementById("numero_materia").value

    const esNumero = /^\d+$/.test(numero_materia);
    const esLetra = /^[a-zA-Z\s]*$/;
    const maxInt = 10000;


    if(nombre =="" && descripcion ==""){
        Swal.fire({
            icon: "error",
            title: "Complete el formulario por favor."
        });
    }

    if(nombre !== ""){
        if(descripcion !==""){
            if(esNumero){
                if(numero_materia > 0){
                    if(numero_materia <= maxInt){
                        if(esLetra.test(nombre)){
                            Swal.fire({
                                title: "Esta seguro de inscribir esta materia?",
                                showCancelButton: true,
                                confirmButtonText: "inscribir",
                                denyButtonText: `Cancelar`
                            }).then((result) => {
                                if (result.isConfirmed) {


                                    let datos = new FormData(formulario);
                                    fetch('agregar-materia.php',{
                                        method: 'POST',
                                        body: datos
                                    })
                                    .then(res => res.json())
                                    .then(data =>{
    
                                        if(data.mensaje == "verdadero"){
                                            Swal.fire({
                                                position: "center",
                                                icon: "success",
                                                title: "Se ha registrado correctamente!",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
    
                                            setTimeout(() => {
                                                formulario.submit();
                                                location.href =  "agregar-materia.php";
                                            }, 1600);
                                        }
    
                                        if(data.mensaje == "falso"){
                                            Swal.fire({
                                                icon: "error",
                                                title: "Materia ya registrada"
                                            });
                                        }
    
                                    })


                                }
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "El nombre de materia solo permite letras"
                            });
                        }
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "El codigo de materia no puede ser mayor a 10.000"
                        });
                    }
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "El codigo de materia debe ser mayor a 0"
                    });
                }

            }else{
                Swal.fire({
                    icon: "error",
                    title: "El codigo de materia solo permite numeros"
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "La descripcion de la materia es obligatoria"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "El nombre de materia obligatorio."
        });
    }

    if(valor == 1){
        
    }
}

function formularioInstituto(valor){
    let formulario = document.getElementById("inscribir-instituto");
    let nombre = document.getElementById("nombre_instituto").value
    let direccion = document.getElementById("direccion_instituto").value
    let cue = document.getElementById("cue_instituto").value

    const esNumero = /^\d+$/.test(cue);
    const esLetra = /^[a-zA-Z\s]*$/.test(nombre);
    maxInt =22000000;

    if(nombre !== ""){
        if(esLetra){
            if(direccion !==""){
                if(cue !==""){
                    if(esNumero){
                        if(cue <= maxInt){
                            Swal.fire({
                                title: "Desea agregar este instituto?",
                                showCancelButton: true,
                                confirmButtonText: "Agregar",
                                denyButtonText: `Cancelar`
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    let datos = new FormData(formulario);
                                    fetch('agregar-instituto.php',{
                                        method: 'POST',
                                        body: datos
                                    })
                                    .then(res => res.json())
                                    .then(data =>{
    
                                        if(data.mensaje == "verdadero"){
                                            Swal.fire({
                                                position: "center",
                                                icon: "success",
                                                title: "Se ha registrado correctamente!",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
    
                                            setTimeout(() => {
                                                formulario.submit();
                                                location.href =  "agregar-instituto.php";
                                            }, 1600);
                                        }
    
                                        if(data.mensaje == "falso"){
                                            Swal.fire({
                                                icon: "error",
                                                title: "Instituto ya registrado"
                                            });
                                        }
    
                                    })

                                }
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "El cue del instituto debe ser menor 22.000.000"
                            });
                        }
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "El cue del instituto solo permite numeros"
                        });
                    }
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "El C.U.E de la institucion es obligatoria"
                    });
                }
    
            }else{
                Swal.fire({
                    icon: "error",
                    title: "La direccion del instituto es obligatoria"
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "El nombre del instituto solo permite letras"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "El nombre del instituto obligatorio."
        });
    }

    if(valor == 1){
        location.href = 'Administrador-index.php';
    }
}

function formularioProfesor(valor){
    let formulario = document.getElementById("inscribir-profesor");
    let nombre = document.getElementById("nombre-profesor").value
    let apellido = document.getElementById("apellido-profesor").value
    let dni = document.getElementById("dni-profesor").value
    let mail = document.getElementById("correo-profesor").value
    let legajo = document.getElementById("legajo-profesor").value

    const comprobar_dni = /^\d+$/.test(dni);
    const comprobar_legajo = /^\d+$/.test(legajo);
    const comprobar_mail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail);
    const comprobar_nombre = /^[a-zA-Z\s]*$/.test(nombre);
    const comprobar_apellido = /^[a-zA-Z\s]*$/.test(apellido);

    if(nombre !== ""){
        if(comprobar_nombre){
            if(comprobar_apellido){
                if(apellido !==""){
                    if(dni !==""){
                        if(mail !==""){
                            if(legajo !==""){
                                if(comprobar_dni){
                                    if(comprobar_legajo){
                                        if(comprobar_mail){
                                            Swal.fire({
                                                title: "Esta seguro de inscribir este profesor?",
                                                showCancelButton: true,
                                                confirmButtonText: "inscribir",
                                                denyButtonText: `Cancelar`
                                            }).then((result) => {
                                                if (result.isConfirmed) {


                                                    let datos = new FormData(formulario);
                                                    fetch('agregar-profesor.php',{
                                                        method: 'POST',
                                                        body: datos
                                                    })
                                                    .then(res => res.json())
                                                    .then(data =>{
                    
                                                        if(data.mensaje == "verdadero"){
                                                            Swal.fire({
                                                                position: "center",
                                                                icon: "success",
                                                                title: "Se ha registrado correctamente!",
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                    
                                                            setTimeout(() => {
                                                                formulario.submit();
                                                                location.href =  "agregar-profesor.php";
                                                            }, 1600);
                                                        }
                    
                                                        if(data.mensaje == "false-legajo"){
                                                            Swal.fire({
                                                                icon: "error",
                                                                title: "Legajo ya registrado"
                                                            });
                                                        }

                                                        if(data.mensaje == "false-dni"){
                                                            Swal.fire({
                                                                icon: "error",
                                                                title: "Profesor ya registrado"
                                                            });
                                                        }

                                                        if(data.mensaje == "false-mail"){
                                                            Swal.fire({
                                                                icon: "error",
                                                                title: "Mail ya registrado"
                                                            });
                                                        }
                    
                                                    })
                  


                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: "error",
                                                title: "El Mail no es valido"
                                            });
                                        }
                                        
                                    }else{
                                        Swal.fire({
                                            icon: "error",
                                            title: "El legajo solo permite numeros"
                                        });
                                    }
                                }else{
                                    Swal.fire({
                                        icon: "error",
                                        title: "El DNI solo permite numeros"
                                    });
                                }
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "El legajo es obligatorio"
                                });
                            }
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "El E-Mail es obligatorio"
                            });
                        }
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "El DNI es obligatorio"
                        });
                    }
        
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "El apellido es obligatorio"
                    });
                }
            }else{
                Swal.fire({
                    icon: "error",
                    title: "El apellido solo permite letras"
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "El nombre solo permite letras"
            });
        }
        }else{
            Swal.fire({
                icon: "error",
                title: "El legajo solo permite letras"
            });
        }

    if(valor == 1){
        location.href = 'Administrador-index.php';
    }
}

function formularioAdministrador(){
    let formulario = document.getElementById("inscribir-administrador");
    let nombre = document.getElementById("nombre-administrador").value
    let apellido = document.getElementById("apellido-administrador").value
    let mail = document.getElementById("correo-administrador").value

    const comprobar_mail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail);
    const comprobar_nombre = /^[a-zA-Z\s]*$/.test(nombre);
    const comprobar_apellido = /^[a-zA-Z\s]*$/.test(apellido);

    if(nombre !==""){
        if(comprobar_nombre){
            if(apellido !==""){
                if(comprobar_apellido){
                    if(mail !==""){
                        if(comprobar_mail){
                            Swal.fire({
                                title: "Desea agregar este administrador?",
                                showCancelButton: true,
                                confirmButtonText: "Agregar",
                                denyButtonText: `Cancelar`
                            }).then((result) => {
                                if (result.isConfirmed) {


                                let datos = new FormData(formulario);
                                fetch('agregar-administrador.php',{
                                    method: 'POST',
                                    body: datos
                                })
                                .then(res => res.json())
                                .then(data =>{

                                    if(data.mensaje == "verdadero"){
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: "Se ha registrado correctamente!",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        setTimeout(() => {
                                            formulario.submit();
                                            location.href =  "agregar-administrador.php";
                                        }, 1600);
                                    }

                                    if(data.mensaje == "falso"){
                                        Swal.fire({
                                            icon: "error",
                                            title: "Mail ya registrado"
                                        });
                                    }

                                })

                                }
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "El mail no es valido"
                            });
                        }
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "El E-Mail es obligatorio"
                        });
                    }
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "El apellido solo permite letras"
                    }); 
                }
            }else{
                Swal.fire({
                    icon: "error",
                    title: "El apellido es obligatorio"
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "El nombre solo permite letras"
            }); 
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "El nombre es obligatorio."
        });
    }
        
}

function EliminarAdmin(button) {
    Swal.fire({
        title: "¿Está seguro de eliminar?",
        text: "¡Esta acción no tiene vuelta atrás!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Se ha eliminado correctamente!",
                showConfirmButton: false,
                timer: 1500
            });


            setTimeout(() => {
                button.closest('form').submit();
            }, 1600);
        }
    });
}

function editarPerfil(){
    let nombre = document.getElementById("nombre").value
    let apellido = document.getElementById("apellido").value
    let mail = document.getElementById("mail").value
    let contraseñaActual = document.getElementById("contraseña-actual").value
    let contraseñaNueva = document.getElementById("contraseña-nueva").value

    if(nombre == "" && apellido == "" && mail == "" && contraseñaActual == "" && contraseñaNueva == ""){
        Swal.fire({
            icon: "error",
            title: "Debe rellenar al menos un campo"
        });
    }else{
        Swal.fire({
            title: "¿Desea actualizar su informacion?",
            showCancelButton: true,
            confirmButtonText: "Actualizar",
            denyButtonText: `Cancelar`
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Se ha cambiado el correo correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    document.getElementById("formulario-editar").submit();
                }, 1600);
            }
        });
    }
}



