<?php

class ArticuloModel
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
    public static function getArticulos():array|null
    {
        try {
            $db = self::getConnection();
        $res = $db->query('SELECT fecha, titulo FROM articulo');
        $arr = [];
        while ($row = $res->fetch()) {
            $arr[] = $row;
        }
        $res->closeCursor();
        } catch (PDOException $th) {
            error_log($th->getMessage());
            $arr = null;
        } finally{
            $db = null;
        }
        
        return $arr;
    }

    public static function getArticulo($cod_articulo):String{
        $db = null;
        $p = null;
        try {
            $sql = "SELECT titulo FROM articulo WHERE cod_articulo=:cod_articulo";
            
            $db = self::getConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':cod_articulo', $cod_articulo, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row){
                return null;
            } else{
                $arr = $row['titulo'];
            }

        } catch (PDOException $e) {
            error_log("Error en getProyecto: " . $e->getMessage());
            return null;
        } finally {
            $db = null;
        }

        return $arr;
    }
}