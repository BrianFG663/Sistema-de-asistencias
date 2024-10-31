<?php

include_once(__DIR__ . '/../Resources/Traits/Funciones.php');

class Instituto{
    use Funciones;
    
    public $nombre;
    public $direccion;
    public $gestion;
    public $cue;

    public function __construct($nombre,$direccion,$gestion,$cue){

        $this->nombre = $this->mayuscula($nombre);
        $this->direccion = $direccion;
        $this->gestion = $gestion;
        $this->cue = $cue;
    }

    public function ramInstituto($conexion){
        $instituto_id = $conexion->lastInsertId();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $ano_actual = date('Y');

        $sql_ram = 
        "INSERT INTO ram(regular,promocion,asistencias_regular,asistencias_promocion,fecha_funcionamiento,instituto_id,tolerancia)
        VALUE(6,8,60,70,:ano_actual,:instituto_id,10)"; //arreglar

        $resultado = $conexion->prepare($sql_ram);
        $resultado->bindParam(':ano_actual',$ano_actual);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->execute();
    }

    public function insertInstituto($conexion){
        $sql_insert =
        "INSERT INTO instituto (nombre,direccion,gestion,cue)
        VALUE (:nombre, :direccion, :gestion,:cue)";

        $resultado = $conexion->prepare($sql_insert);
        $resultado->bindParam(':nombre', $this->nombre);
        $resultado->bindParam(':direccion', $this->direccion);
        $resultado->bindParam(':gestion', $this->gestion);
        $resultado->bindParam(':cue', $this->cue);
        $resultado->execute();
    }

    public function comprobarCue($conexion){
        $sql_cue = 
        "SELECT cue
        FROM instituto
        WHERE cue = :cue";

        $resultado = $conexion->prepare($sql_cue);
        $resultado->bindParam(':cue', $this->cue);
        $resultado->execute();
        $row = $resultado->fetch(PDO::FETCH_ASSOC);

        if($row){
            return false;
        }else{
            return true;
        }
    }

    public function comprobarNombre($conexion){
        $sql_cue = 
        "SELECT nombre
        FROM instituto
        WHERE nombre = :nombre";

        $resultado = $conexion->prepare($sql_cue);
        $resultado->bindParam(':nombre', $this->nombre);
        $resultado->execute();
        $row = $resultado->fetch(PDO::FETCH_ASSOC);

        if($row){
            return false;
        }else{
            return true;
        }
    }

    public function eliminarInstituto($conexion,$id){
        $sql_eliminar = 
        "DELETE FROM instituto
        WHERE id = :id";
        $resultado_eliminar = $conexion->prepare($sql_eliminar);
        $resultado_eliminar->bindParam(':id', $id);
        $resultado_eliminar->execute();

        $sql_eliminar_materia_instituto = 
        "DELETE FROM materia_instituto
        WHERE instituto_id = :id";
        $resultado_eliminar_materia_instituto = $conexion->prepare($sql_eliminar_materia_instituto);
        $resultado_eliminar_materia_instituto->bindParam(':id', $id);
        $resultado_eliminar_materia_instituto->execute();
    }

    public static function buscarInstituto($conexion,$id_instituto){

        $sql_buscar_instituto= 
        "SELECT *
        FROM instituto
        WHERE id = :id";

        $resultado = $conexion->prepare($sql_buscar_instituto);
        $resultado->bindParam(':id', $id_instituto);
        $resultado->execute();

        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public static function institutosLibres($conexion,$profesor_id){

        $sql_institutos = 
        "SELECT i.id, i.nombre, i.cue, i.direccion, i.gestion
        FROM instituto i
        WHERE i.id NOT IN (
            SELECT id_instituto
            FROM instituto_profesor
            WHERE id_profesor = :profesor_id
        )";

        $resultado = $conexion->prepare($sql_institutos);
        $resultado->bindParam(':profesor_id',$profesor_id);
        $resultado->execute();

        return $resultado->fetchall(PDO::FETCH_ASSOC);
    }

    public static function asignarProfesor($conexion,$materia_id,$instituto_id){

        $sql_asignar_profesor =
        "INSERT INTO materia_instituto(materia_id,instituto_id)
        VALUE (:materia_id,:instituto_id)";

        $resultado = $conexion->prepare($sql_asignar_profesor);
        $resultado->bindParam(':materia_id',$materia_id);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->execute();
    }

    public static function getRam($conexion,$id_instituto){
        $sql_ram = 
        "SELECT *
        FROM ram
        WHERE instituto_id = :instituto_id";

        $resultado = $conexion->prepare($sql_ram);
        $resultado->bindParam(':instituto_id', $id_instituto);
        $resultado->execute();

        return $resultado->fetch(PDO::FETCH_ASSOC);
    }


}

?>