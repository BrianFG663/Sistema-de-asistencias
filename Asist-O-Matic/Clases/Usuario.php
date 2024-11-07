<?php
    include_once(__DIR__ . '/../Resources/Traits/Funciones.php');


    class Usuario{
        use Funciones;

        public $nombre;
        public $apellido;
        protected $mail;
        protected $pass;
        protected $rol;

        public function __construct($nombre,$apellido,$mail,$pass,$rol){
            $this->nombre = $this->uperCase($nombre);
            $this->apellido = $this->uperCase($apellido);
            $this->mail = $mail;
            $this->pass = $pass;
            $this->rol = $rol;
        }

        public function buscarUsuario($conexion,$id){

            $sql_buscar =
            "SELECT *
            FROM usuario
            WHERE id = :id";

            $resultado = $conexion->prepare($sql_buscar);
            $resultado->bindParam(':id', $id);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public static function getUser($conexion,$mail){
            $sql_login =
            "SELECT *
            FROM usuario
            WHERE mail = :mail";
    
            $resultado = $conexion->prepare($sql_login);
            $resultado->bindParam(':mail', $mail);
            $resultado->execute();
            
            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public function comprobarMail($conexion,$mail){
            $sql_mail = 
            "SELECT mail
            FROM usuario
            WHERE mail = :mail";

            $resultado = $conexion->prepare($sql_mail);
            $resultado->bindParam(':mail', $mail);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($row){
                return false;
            }else{
                return true;
            }

        }

        public function validarCanditadAdmin($conexion){
            $sql_validar =
            "SELECT COUNT(id) AS total_admin
            FROM usuario
            WHERE rol = 'administrador'";

            $resultado = $conexion->prepare($sql_validar);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        public function comprobarContraseña($contraseña_actual){

            if(password_verify($contraseña_actual, $this->pass)){
                return true;
            }else{
                return false;
            }
        }

        

        public function insertUserAdmin($conexion){
            $contraseña = password_hash("admin", PASSWORD_DEFAULT);

            $sql_insert =
            "INSERT INTO  usuario(nombre,apellido,mail,passw,rol)
            VALUE (:nombre,:apellido,:mail,:passw,:rol)";

            $resultado = $conexion->prepare($sql_insert);
            $resultado->bindParam(':nombre', $this->apellido);
            $resultado->bindParam(':apellido', $this->nombre);
            $resultado->bindParam(':mail', $this->mail);
            $resultado->bindParam(':passw', $contraseña);
            $resultado->bindParam(':rol', $this->rol);
            $resultado->execute();
        }

        public function insertUserProfesor($conexion,$dni){
            $contraseña = password_hash($this->pass, PASSWORD_DEFAULT);
            $sql_dni = 
            "SELECT id
            FROM profesor
            WHERE dni = :dni";

            $resultado = $conexion->prepare($sql_dni);
            $resultado->bindParam(':dni', $dni);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);
            if($row){
                $profesor_id = (int)$row['id'];
            }


            $sql_insert =
            "INSERT INTO  usuario(nombre,apellido,mail,passw,rol,id_profesor)
            VALUE (:nombre,:apellido,:mail,:passw,:rol,:id_profesor)";

            $resultado = $conexion->prepare($sql_insert);

            $resultado->bindParam(':nombre', $this->apellido);
            $resultado->bindParam(':apellido', $this->nombre);
            $resultado->bindParam(':mail', $this->mail);
            $resultado->bindParam(':passw', $contraseña);
            $resultado->bindParam(':rol', $this->rol);
            $resultado->bindParam(':id_profesor', $profesor_id);
            $resultado->execute();
        }

        public function eliminarUsuario($conexion,$id){
            
            $sql_eliminar = 
            "DELETE FROM usuario 
            WHERE id = :id";
            $resultado_eliminar = $conexion->prepare($sql_eliminar);
            $resultado_eliminar->bindParam(':id', $id);
            $resultado_eliminar->execute();
        }


        public static function cambiarContraseña($conexion,$id,$contraseña_nueva){
            $contraseña_nueva = password_hash($contraseña_nueva, PASSWORD_BCRYPT);

            $sql_cambiar_pass = 
            "UPDATE usuario
            SET passw = :pass
            WHERE id = :id";

            $resultado_cambio = $conexion->prepare($sql_cambiar_pass);
            $resultado_cambio->bindParam(':id', $id);
            $resultado_cambio->bindParam(':pass', $contraseña_nueva);
            $resultado_cambio->execute();

        }

        public static function verificarMail($conexion,$mail){
            $sql_mail = 
            "SELECT mail
            FROM usuario
            WHERE mail = :mail";

            $resultado = $conexion->prepare($sql_mail);
            $resultado->bindParam(':mail', $mail);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($row){
                return false;
            }else{
                return true;
            }

        }

    }


?>