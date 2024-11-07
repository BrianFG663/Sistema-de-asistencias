function verificarFormulario(){
    let formulario = document.getElementById("formulario-login");
    let valoremail = document.getElementById("login-nombre").value;
    let valorpass = document.getElementById("login-pass").value;
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    

    if(valoremail !==""){
        if(regex.test(valoremail)){
            if(valorpass !==""){

                let datos = new FormData(formulario);
                fetch('main-login.php', {
                    method: 'POST',
                    body: datos
                })
                .then(res => res.json())
                .then(data => {
                    if (data.mensaje === "verdadero") {
                        
                        window.location.href = data.url; //redirijo a la url pasada por fetch
                    }

                    if(data.mensaje == "mail-invalido"){
                        Swal.fire({
                            icon: "error",
                            title: "Mail no registrado"
                        });
                    
                        setTimeout(() => {
                            location.href = "index.php";
                        }, 1200);
                    }

                    if(data.mensaje == "falso"){
                         Swal.fire({
                            icon: "error",
                            title: "Contraseña incorrecta"
                        });
                    
                        setTimeout(() => {
                            location.href = "index.php";
                        }, 1200);
                    }

                    
                })
                .catch(error => console.error('Error en la solicitud:', error));
                


                
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Ingrese contraseña."
                });
            }
        }else{
            Swal.fire({
                icon: "error",
                title: "Ingrese correo electronico valido"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "Ingrese correo."
        });
    }

    if(valoremail=="" && valorpass==""){
        Swal.fire({
            icon: "error",
            title: "Complete el formulario."
        });
    }
}

function cambiarContraseña(){
    let formulario = document.getElementById("formulario-contrasena");
    let contraseña = document.getElementById("contrasena").value;
    let ncontraseña = document.getElementById("ncontrasena").value;

    if(contraseña !=="" && ncontraseña !==""){
        if(contraseña == ncontraseña){
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Contraseña actualizada!",
                showConfirmButton: false,
                timer: 1500
              });
            
            setTimeout(() => {
                document.getElementById("formulario-contrasena").submit()
            }, 1600);
        }else{
            Swal.fire({
                icon: "error",
                title: "Las contraseñas deben coincidir"
            });
        }
    }else{
        Swal.fire({
            icon: "error",
            title: "Por favor, rellene ambos campos"
        });
    }

}