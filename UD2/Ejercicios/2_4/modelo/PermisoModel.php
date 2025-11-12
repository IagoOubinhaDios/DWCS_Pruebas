<?php
require_once "Model.php";

class Permiso{
    public $id;
    public $pagina;
}

class PermisoModel extends Model{

    public static function getPermisoRol($rol_id, $pagina): bool{
        $db = null;
        $toret = false;
        try {
            $sql = "SELECT *
                    FROM ROL_PERMISO rp
                    INNER JOIN PERMISO p ON p.id = rp.permiso_id
                    WHERE rp.rol_id = :rol_id AND p.pagina LIKE :pagina";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':rol_id', $rol_id, PDO::PARAM_INT);
            $stmt->bindValue(':pagina', $pagina, PDO::PARAM_STR);
            $toret = $stmt->execute();
            $toret = $stmt->fetch() ? true : false;
            $stmt->closeCursor();

        } catch (PDOException $e) {
            error_log("Error en updateRol: " . $e->getMessage());

        } finally {
            $db = null;
        }

        return $toret;
    }

    public static function getPermiso(int $id): Permiso|null{
        $db = null;
        $p = null;
        try {
            $sql = "SELECT id, pagina 
                    FROM Permiso 
                    WHERE id = :id";
            
            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row){
                return null;
            }

            $p = new Permiso();
            $p->id = $row["id"];
            $p->pagina = $row["pagina"];

        } catch (PDOException $e) {
            error_log("Error en getPermiso: " . $e->getMessage());
            return null;
        } finally {
            $db = null;
        }

        return $p;
    }

    public static function addPermiso(Permiso $perm): bool{
        $db = null;
        $toret = false;
        try {
            $sql = "INSERT INTO PERMISO (pagina) 
                    VALUES (:pagina)";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':pagina', $perm->pagina, PDO::PARAM_STR);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en addPermiso: " . $e->getMessage());
            
        } finally {
            $db = null;
        }

        return $toret;
    }

    public static function updatePermiso(Permiso $perm): bool{
        $db = null;
        $toret = false;
        try {
            $sql = "UPDATE PERMISO 
                    SET pagina = :pagina 
                    WHERE id = :id";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':pagina', $perm->pagina, PDO::PARAM_STR);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en updatePermiso: " . $e->getMessage());
            
        } finally {
            $db = null;
        }

        return $toret;
    }

}
