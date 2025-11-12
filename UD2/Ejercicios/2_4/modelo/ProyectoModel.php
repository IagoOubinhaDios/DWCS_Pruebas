<?php
require_once "Model.php";

class Proyecto{
    public $id;
    public $nombre;
    public $descripcion;
    public $responsable_id;
}

class ProyectoModel extends Model{

    public static function getProyecto(int $id): Proyecto|null{
        $db = null;
        $p = null;
        try {
            $sql = "SELECT id, nombre, descripcion, usuario_id 
                    FROM PROYECTO 
                    WHERE id = :id";
            
            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row){
                return null;
            }

            $p = new Proyecto();
            $p->id = $row["id"];
            $p->nombre = $row["nombre"];
            $p->descripcion = $row["descripcion"];
            $p->responsable_id = $row["usuario_id"];

            

        } catch (PDOException $e) {
            error_log("Error en getProyecto: " . $e->getMessage());
            return null;
        } finally {
            $db = null;
        }

        return $p;
    }

    public static function getProyectos(?string $nombre = null, ?int $responsable_id = null): array{
        $db = null;
        $lista = [];
        try {
            $sql = "SELECT id, nombre, descripcion, usuario_id 
                    FROM PROYECTO 
                    WHERE 1=1";
            
            $db = parent::getConnection();
            

            if($nombre !== null){
                $sql .= " AND nombre LIKE :nombre";
            }

            if($responsable_id !== null){
                $sql .= " AND usuario_id = :responsable_id";
            }

            // Repreparar con SQL final
            $stmt = $db->prepare($sql);

            if($nombre !== null){
                $stmt->bindValue(':nombre', "%".$nombre."%", PDO::PARAM_STR);
            }

            if($responsable_id !== null){
                $stmt->bindValue(':responsable_id', $responsable_id, PDO::PARAM_INT);
            }

            $stmt->execute();

            

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $p = new Proyecto();
                $p->id = $row["id"];
                $p->nombre = $row["nombre"];
                $p->descripcion = $row["descripcion"];
                $p->responsable_id = $row["usuario_id"];

                $lista[] = $p;
            }

            

        } catch (PDOException $e) {
            error_log("Error en getProyectos: " . $e->getMessage());
        } finally {
            $db = null;
        }

        return $lista;
    }

    public static function addProyecto(Proyecto $proy): bool{
        $db = null;
        $toret = false;
        try {
            $sql = "INSERT INTO PROYECTO (nombre, descripcion, usuario_id) 
                    VALUES (:nombre, :descripcion, :usuario_id)";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':nombre', $proy->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $proy->descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $proy->responsable_id, PDO::PARAM_INT);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en addProyecto: " . $e->getMessage());
            
        } finally {
            $db = null;
        }

        return $toret;
    }

    public static function updateProyecto(Proyecto $proy): bool{
        $db = null;
        $toret = false;
        try {
            $sql = "UPDATE PROYECTO 
                    SET nombre = :nombre, descripcion = :descripcion, usuario_id = :usuario_id 
                    WHERE id = :id";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':nombre', $proy->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $proy->descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $proy->responsable_id, PDO::PARAM_INT);
            $stmt->bindValue(':id', $proy->id, PDO::PARAM_INT);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en updateProyecto: " . $e->getMessage());
            
        } finally {
            $db = null;
        }

        return $toret;
    }

}