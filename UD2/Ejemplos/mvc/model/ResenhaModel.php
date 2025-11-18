<?php

class ResenhaModel
{
    private static function getConnection()
    {
        $db = new PDO('mysql:host=mariadb; dbname=articulos', 'root', 'bitnami');
        return $db;
    }

    /**
     * Devuelve un array con todos los articulos. Cada articulo es un array asociativo con las
     * claves [fecha, titulo].
     * @return null|array Si se produce un error el la obtencion devuelve null
     */
    public static function getResenhas(): array|null
    {
        try {
            $db = self::getConnection();
            $res = $db->query('SELECT r.descripcion AS descripcion, r.fecha_hora AS fecha_hora, a.titulo AS titulo 
                                      FROM resena r INNER JOIN articulo a ON r.cod_articulo = a.cod_articulo');
            $arr = [];
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            $res->closeCursor();
        } catch (PDOException $e) {
            error_log("Error en getProyectos: " . $e->getMessage());
        } finally {
            $db = null;
        }

        return $arr;
    }

    public static function getResenhasArticulo($cod_articulo)
    {
        $db = null;
        try {
            $sql = "SELECT r.descripcion AS descripcion, r.fecha_hora AS fecha_hora
                    FROM resena r LEFT JOIN articulo a ON r.cod_articulo = a.cod_articulo
                    WHERE r.cod_articulo=:cod_articulo";
            $db = self::getConnection();

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':cod_articulo', $cod_articulo, PDO::PARAM_INT);

            $stmt->execute();

            $arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            $stmt->closeCursor();

        } catch (PDOException $e) {
            error_log("Error en getProyectos: " . $e->getMessage());
        } finally {
            $db = null;
        }

        return $arr;
    }
}