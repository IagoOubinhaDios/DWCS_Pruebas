<?php
class Model{
    private const BD_DSN = "mysql:host=mariadb;dbname=act2_4";
    private const BD_USER = "root";
    private const BD_PASS = "bitnami";

    protected static function getConnection(){
        try {
            $db = new PDO(self::BD_DSN, self::BD_USER, self::BD_PASS);
            return $db;
        } catch (PDOException $th) {
            die($th->getMessage());
        }
    }
}
