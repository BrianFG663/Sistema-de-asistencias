<?php
    include_once(__DIR__ . '/../Resources/Traits/Funciones.php');

    class Profesor{
        use Funciones;

        public $nombre;
        public $apellido;
        protected $dni;
        protected $legajo;

        public function __construct($nombre,$apellido,$dni,$legajo){
            $this->nombre = $this->uperCase($nombre);
            $this->apellido = $this->uperCase($apellido);
            $this->dni = $dni;
            $this->legajo = $legajo;
        }

        public static function getProfesor($conexion,$id){
            $sql_id = 
            "SELECT *
            FROM profesor
            WHERE id = :id";

            $resultado = $conexion->prepare($sql_id);
            $resultado->bindParam(':id', $id);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public static function cambiarContraseña($conexion,$id,$contraseña_nueva){
            $contraseña_nueva = password_hash($contraseña_nueva, PASSWORD_BCRYPT);

            $sql_cambiar_pass = 
            "UPDATE usuario
            SET passw = :pass
            WHERE id_profesor = :id_profesor";

            $resultado_cambio = $conexion->prepare($sql_cambiar_pass);
            $resultado_cambio->bindParam(':id_profesor', $id);
            $resultado_cambio->bindParam(':pass', $contraseña_nueva);
            $resultado_cambio->execute();

        }

        public static function getUsuario($conexion,$id){
            $sql_usuario = 
            "SELECT *
            FROM usuario
            WHERE id_profesor = :id_profesor";

            $resultado = $conexion->prepare($sql_usuario);
            $resultado->bindParam(':id_profesor',$id);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public static function editarNota($conexion,$id_nota,$nota){
            $sql_notas = 
            "UPDATE notas
            SET nota = :nota
            WHERE id = :id";

            $resultado = $conexion->prepare($sql_notas);
            $resultado->bindParam(':nota',$nota);
            $resultado->bindParam(':id',$id_nota);
            $resultado->execute();
        }

        public static function eliminarNota($conexion,$id_nota){
            $sql_notas = 
            "DELETE
            FROM notas
            WHERE id = :id";

            $resultado = $conexion->prepare($sql_notas);
            $resultado->bindParam(':id',$id_nota);
            $resultado->execute();
        }

        public static function institutosProfesor($conexion, $id) {
            $sql_profesor = "
                SELECT id_instituto
                FROM instituto_profesor
                WHERE id_profesor = :id";
        
            $resultado = $conexion->prepare($sql_profesor);
            $resultado->bindParam('id', $id, PDO::PARAM_INT);
            $resultado->execute();
        
            $instituto_ids = $resultado->fetchAll(PDO::FETCH_COLUMN);
        
            $array_ids = implode(',', array_fill(0, count($instituto_ids), '?'));
        
            $sql_institutos = 
            "SELECT *
            FROM instituto
            WHERE id IN ($array_ids)";
        
            $resultado = $conexion->prepare($sql_institutos);
        
            if(count($instituto_ids) > 0){
                $resultado->execute($instituto_ids); //le pasa como parametro el array con los ids
                return $resultado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }

        }

        public static function verificarCalificacion($conexion,$materia_id,$fecha){
            $sql_calificacion = 
            "SELECT *
            FROM notas
            WHERE materia_id = :materia_id AND fecha_nota = :fecha_nota";

            $resultado = $conexion->prepare($sql_calificacion);
            $resultado->bindParam(':materia_id',$materia_id);
            $resultado->bindParam(':fecha_nota',$fecha);
            $resultado->execute();
            $row = $resultado->fetchAll(PDO::FETCH_ASSOC);

            if(!$row){
                return false;
            }else{
                return true;
            }


        } 

        public static function quitarInstituto($conexion,$id_profesor,$instituto_ids){

            $sql_eliminar = 
            "DELETE
            FROM instituto_profesor
            WHERE id_profesor = :id_profesor AND id_instituto = :id_instituto";

            $resultado = $conexion->prepare($sql_eliminar);
            $resultado->bindParam(':id_profesor',$id_profesor);
            $resultado->bindParam(':id_instituto',$instituto_ids);
            $resultado->execute();

            $sql_quitar_id = 
            "UPDATE materias m
            JOIN materia_instituto mi ON m.id = mi.materia_id
            SET m.profesor_id = NULL
            WHERE m.profesor_id = :profesor_id AND mi.instituto_id = :instituto_id";

            $resultado = $conexion->prepare($sql_quitar_id);
            $resultado->bindParam(':profesor_id',$id_profesor);
            $resultado->bindParam(':instituto_id',$instituto_ids);
            $resultado->execute();
        }
        

        public function insertProfesor($conexion){

            $sql_insert = 
            "INSERT INTO profesor(nombre,apellido,dni,legajo)
            VALUE (:nombre, :apellido, :dni, :legajo)";

            $resultado = $conexion->prepare($sql_insert);
            $resultado->bindParam(':nombre', $this->nombre);
            $resultado->bindParam(':apellido', $this->apellido);
            $resultado->bindParam(':dni', $this->dni);
            $resultado->bindParam(':legajo',$this->legajo);
            $resultado->execute();
        }

        public function comprobarDni($conexion){
            $sql_dni = 
            "SELECT dni
            FROM profesor
            WHERE dni = :dni";

            $resultado = $conexion->prepare($sql_dni);
            $resultado->bindParam(':dni', $this->dni);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($row){
                return false;
            }else{
                return true;
            }

        }

        public function comprobarlegajo($conexion){
            $sql_dni = 
            "SELECT legajo
            FROM profesor
            WHERE legajo = :legajo";

            $resultado = $conexion->prepare($sql_dni);
            $resultado->bindParam(':legajo', $this->legajo);
            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($row){
                return false;
            }else{
                return true;
            }

        }

        public static function eliminarProfesor($conexion,$id){
            $sql_eliminar_id = 
            "UPDATE materias
            SET profesor_id = NULL
            WHERE profesor_id = :id";

            $resultado = $conexion->prepare($sql_eliminar_id);
            $resultado->bindParam(':id', $id);
            $resultado->execute();

            $sql_eliminar_profesor = 
            "DELETE FROM profesor 
            WHERE id = :id";
            $resultado_eliminar = $conexion->prepare($sql_eliminar_profesor);
            $resultado_eliminar->bindParam(':id', $id);
            $resultado_eliminar->execute();
        }

        public static function mostrarMaterias($conexion,$id_profesor,$id_instituto){
            $sql_materias =
            "SELECT DISTINCT m.id, m.nombre, m.descripcion, m.fecha_creacion, m.codigo_materia
            FROM materias m
            JOIN profesor p ON m.profesor_id = p.id
            JOIN instituto_profesor ip ON p.id = ip.id_profesor
            JOIN materia_instituto mi ON m.id = mi.materia_id
            WHERE p.id = :id_profesor AND mi.instituto_id = :id_instituto;";

            $resultado = $conexion->prepare($sql_materias);
            $resultado->bindParam(':id_profesor',$id_profesor);
            $resultado->bindParam(':id_instituto',$id_instituto);
            $resultado->execute();

            return $resultado->fetchall(PDO::FETCH_ASSOC);
        }

        public function mostrarAlumnos($conexion,$id_materia,$id_instituto){
            $sql_alumnos =
            "SELECT DISTINCT *
            FROM alumno a
            JOIN materia_alumno m ON m.alumno_id = a.id
            WHERE m.materia_id = :materia_id AND a.instituto_id = :id_instituto;";

            
            $resultado = $conexion->prepare($sql_alumnos);
            $resultado->bindParam(':materia_id',$id_materia);
            $resultado->bindParam(':id_instituto',$id_instituto);
            $resultado->execute();
            $row = $resultado->fetchall(PDO::FETCH_ASSOC);


            if(!$row){
                return false;
            }else{
                return $row;
            }


        }

        public static function asignarInstituto($conexion,$profesor_id,$instituto_id){
            $sql_asignar_instituto = 
            "INSERT INTO instituto_profesor(id_profesor,id_instituto)
            VALUES (:profesor_id,:instituto_id)";

            $resultado = $conexion->prepare($sql_asignar_instituto);
            $resultado->bindParam(':profesor_id', $profesor_id);
            $resultado->bindParam(':instituto_id',$instituto_id);
            $resultado->execute();
        }
        
        public static function listadoPresentes($conexion,$instituto_id,$id_materia,$fecha){
            
            $sql_alumnos_presentes = 
            "SELECT DISTINCT a.*
            FROM alumno a
            JOIN materia_alumno ma ON ma.alumno_id = a.id
            JOIN asistencias asi ON asi.alumno_id = a.id AND asi.materia_id = ma.materia_id
            WHERE ma.materia_id = :materia_id 
                AND a.instituto_id = :id_instituto
                AND DATE(asi.fecha_asistencia) = :fecha";

            $resultado = $conexion->prepare($sql_alumnos_presentes);
            $resultado->bindParam(':materia_id',$id_materia);
            $resultado->bindParam(':id_instituto',$instituto_id);
            $resultado->bindParam(':fecha', $fecha);
            $resultado->execute();

            return $resultado->fetchall(PDO::FETCH_ASSOC);
        }

        public static function listadoAusentes($conexion,$instituto_id,$id_materia,$fecha){
            $sql_alumnos_ausentes =
            "SELECT DISTINCT a.*
            FROM alumno a
            JOIN materia_alumno ma ON ma.alumno_id = a.id
            LEFT JOIN asistencias asi ON asi.alumno_id = a.id AND asi.materia_id = ma.materia_id AND DATE(asi.fecha_asistencia) = :fecha
            WHERE ma.materia_id = :materia_id 
            AND a.instituto_id = :id_instituto
            AND asi.id IS NULL";

            $resultado = $conexion->prepare($sql_alumnos_ausentes);
            $resultado->bindParam(':materia_id',$id_materia);
            $resultado->bindParam(':id_instituto',$instituto_id);
            $resultado->bindParam(':fecha', $fecha);
            $resultado->execute();

            return $resultado->fetchall(PDO::FETCH_ASSOC);
        }

        public static function eliminarAlumno($id,$conexion){
            $sql_eliminar = 
            "DELETE FROM alumno
            WHERE id = :id";
            
            $resultado_eliminar = $conexion->prepare($sql_eliminar);
            $resultado_eliminar->bindParam(':id', $id);
            $resultado_eliminar->execute();
        }

        public static function verificarCumpleanos($conexion,$id_materia){
            $sql_cumpleanos = 
            "SELECT nombre, apellido
            FROM alumno a
            JOIN materia_alumno ma ON a.id = ma.alumno_id
            WHERE DATE_FORMAT(fecha_nacimiento, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d') AND materia_id = :materia_id";
            
            $resultado = $conexion->prepare($sql_cumpleanos);
            $resultado->bindParam(':materia_id',$id_materia);
            $resultado->execute();
            $row = $resultado->fetchall(PDO::FETCH_ASSOC);

   
            if($row){
                return $row;
            }else{
                return false;
            }
    
        }

    }

?>