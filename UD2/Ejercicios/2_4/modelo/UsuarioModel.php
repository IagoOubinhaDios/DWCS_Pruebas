<?php
require_once "Model.php";

class Usuario
{
    public $id;
    public $nombre;
    public $email;
    public $contrasena;
    public $rol_id;
}

class UsuarioModel extends Model
{

    public static function getUsuario(int $id): Usuario|null
    {
        $db = null;
        $p = null;
        try {
            $sql = "SELECT id, nombre, email, rol_id, contrasena
                    FROM USUARIO 
                    WHERE id = :id";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            $p = new Usuario();
            $p->id = $row["id"];
            $p->nombre = $row["nombre"];
            $p->email = $row["email"];
            $p->rol_id = $row["rol_id"];
            $p->contrasena = $row["contrasena"];



        } catch (PDOException $e) {
            error_log("Error en getUsuario: " . $e->getMessage());
            return null;
        } finally {
            $db = null;
        }

        return $p;
    }

    public static function getUsuarios(?string $nombre = null, ?int $rol_id = null, ?string $email = null): array
    {
        $db = null;
        $lista = [];
        try {
            $sql = "SELECT id, nombre, email, rol_id, contrasena
                    FROM USUARIO 
                    WHERE 1=1";

            $db = parent::getConnection();


            if ($nombre !== null) {
                $sql .= " AND nombre LIKE :nombre";
            }

            if ($rol_id !== null) {
                $sql .= " AND rol_id = :rol_id";
            }

            if ($email !== null) {
                $sql .= " AND email LIKE :email";
            }

            // Repreparar con SQL final
            $stmt = $db->prepare($sql);

            if ($nombre !== null) {
                $stmt->bindValue(':nombre', "%" . $nombre . "%", PDO::PARAM_STR);
            }

            if ($rol_id !== null) {
                $stmt->bindValue(':rol_id', $rol_id, PDO::PARAM_INT);
            }

            if ($email !== null) {
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            }

            $stmt->execute();



            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $p = new Usuario();
                $p->id = $row["id"];
                $p->nombre = $row["nombre"];
                $p->email = $row["email"];
                $p->rol_id = $row["rol_id"];
                $p->contrasena = $row["contrasena"];

                $lista[] = $p;
            }



        } catch (PDOException $e) {
            error_log("Error en getUsuarios: " . $e->getMessage());
        } finally {
            $db = null;
        }

        return $lista;
    }

    public static function addUsuario(Usuario $usr): bool
    { //TODO
        $db = null;
        $toret = false;
        try {
            $sql = "INSERT INTO USUARIO (nombre, descripcion, usuario_id) 
                    VALUES (:nombre, :descripcion, :usuario_id)";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':nombre', $usr->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $usr->descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $usr->responsable_id, PDO::PARAM_INT);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en addUsuario: " . $e->getMessage());

        } finally {
            $db = null;
        }

        return $toret;
    }

    public static function updateUsuario(Usuario $usr): bool
    {
        $db = null;
        $toret = false;
        try {
            $sql = "UPDATE USUARIO 
                    SET nombre = :nombre, descripcion = :descripcion, usuario_id = :usuario_id 
                    WHERE id = :id";

            $db = parent::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':nombre', $usr->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $usr->descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $usr->responsable_id, PDO::PARAM_INT);
            $stmt->bindValue(':id', $usr->id, PDO::PARAM_INT);

            $toret = $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en updateUsuario: " . $e->getMessage());

        } finally {
            $db = null;
        }

        return $toret;
    }

}
