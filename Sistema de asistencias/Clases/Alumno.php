<?php

    include_once(__DIR__ . '/../Resources/Traits/Funciones.php');
    

    class Alumno{
        use Funciones;
        
        public $nombre;
        public $apellido;
        protected $dni;
        protected $fecha_nacimiento;

        public function __construct($nombre,$apellido,$dni,$fecha_nacimiento){

            $this->nombre =  $this->uperCase($nombre);
            $this->apellido = $this->uperCase($apellido);
            $this->dni = $dni;
            $this->fecha_nacimiento = $fecha_nacimiento;
        }

        public static function getAlumno($conexion,$id_alumno){
            $sql_materia = 
            "SELECT *
            FROM alumno
            WHERE id = :id";
    
            $resultado = $conexion->prepare($sql_materia);
            $resultado->bindParam(':id', $id_alumno);
            $resultado->execute();
    
            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        public static function validarAlumno($conexion,$dni){
            $sql_materia = 
            "SELECT *
            FROM alumno
            WHERE dni = :dni";
    
            $resultado = $conexion->prepare($sql_materia);
            $resultado->bindParam(':dni', $dni);
            $resultado->execute();
            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($row){
                return false;
            }else{
                return true;
            }
        }

        public function inscribirAlumno($conexion,$instituto_id,$materia_id){

            $sql_alumno =
            "INSERT INTO alumno (nombre,apellido,dni,fecha_nacimiento,instituto_id)
            VALUES (:nombre, :apellido, :dni, :fecha_nacimiento,:instituto_id)";

            $resultado = $conexion->prepare($sql_alumno);
            $resultado->bindParam(':nombre', $this->nombre);
            $resultado->bindParam(':apellido', $this->apellido);
            $resultado->bindParam(':dni', $this->dni);
            $resultado->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
            $resultado->bindParam(':instituto_id', $instituto_id);
            $resultado->execute();

            $alumno_id = $conexion->lastInsertId();

            $sql_materia_alumno = 
            "INSERT INTO materia_alumno(alumno_id,materia_id)
            VALUES (:alumno_id,:materia_id)";

            $resultado = $conexion->prepare($sql_materia_alumno);
            $resultado->bindParam(':alumno_id', $alumno_id);
            $resultado->bindParam(':materia_id',$materia_id);
            $resultado->execute();
        }

        public static function notasAlumno($conexion,$alumno_id){
            $sql_notas = 
            "SELECT *
            FROM notas 
            WHERE alumno_id = :alumno_id";

            $resultado = $conexion->prepare($sql_notas);
            $resultado->bindParam(':alumno_id', $alumno_id);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function estadoAlumno($conexion,$alumno_id,$ram,$asistencias){
            $notas = self::notasAlumno($conexion, $alumno_id);
            $estado = "sin evaluar"; 
        
            $todasNotasParaPromocion = true; 
            $todasNotasParaRegular = true; 

            if($asistencias == NULL){
                $estado = "sin evaluar";
            }else{
                foreach ($notas as $nota) {
                    // Verificar si alguna nota no cumple con la promoción
                    if ($nota['nota'] < $ram['promocion']) {
                        $todasNotasParaPromocion = false;
                    }
            
                    // Verificar si alguna nota no cumple con la regularidad
                    if ($nota['nota'] < $ram['regular']) {
                        $todasNotasParaRegular = false;
                    }
                }
            
    
                if ($todasNotasParaPromocion && $asistencias >= $ram['asistencias_promocion']) {
                    $estado = "promocion"; 
                } elseif ($todasNotasParaRegular && $asistencias >= $ram['asistencias_regular']) {
                    $estado = "regular"; 
                } else {
                    $estado = "desaprobado";
                }
            }

            $sql_estado =
            "UPDATE alumno
            SET estado = :estado
            WHERE id = :id";

            $resultado = $conexion->prepare($sql_estado);
            $resultado->bindParam(':estado', $estado);
            $resultado->bindParam(':id',$alumno_id);
            $resultado->execute();
        
            return $estado;
        }
        

        public static function asistenciasAlumno($conexion,$materia_id,$alumno_id,$total_asistencias,$ram){

            $sql_asistencias = 
            "SELECT SUM(
                CASE 
                    WHEN valor = 1 THEN 1
                    WHEN valor = 0.5 THEN 0.5
                    ELSE 0
                END
            ) AS asistencias
            FROM asistencias
            WHERE materia_id = :materia_id AND alumno_id = :alumno_id";


            $resultado = $conexion->prepare($sql_asistencias);
            $resultado->bindParam(':materia_id',$materia_id);
            $resultado->bindParam(':alumno_id',$alumno_id);
            $resultado->execute();
            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if($total_asistencias['total_fechas'] == 0){
                return NULL;
            }else{
                $asistencias = $row['asistencias'] * 100 / $total_asistencias['total_fechas'];
                return $asistencias;
            }


        } 
    }

?>