<?php

class UserNotLogedException extends Exception
{
    public function __construct($message='', $code = 255, ?Throwable $previous = null) {
        $message = 'No hay usuario registrado en $_SESSION["user"]. '.$message;
        parent::__construct($message, $code, $previous);
    }

    public function __toStrin() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    
}
class ControAcceso{
    public const string PAGE_VER_PROYECTOS = "ver_proyectos";
    public const string PAGE_EDITAR_PROYECTOS = "editar_proyectos";
    public const string PAGE_EDITAR_PROYECTO = "editar_proyecto";

    public const string PAGE_ADMINISTRAR_PROYECTOS = "administrar_proyectos";

    public const string PAGE_CREAR_PROYECTO = "crear_proyecto"; 

    /**
     * Determina si el usuario logueado tiene acceso a la página indicada.
     * @param string $page
     * @return void
     */
    public static function hasAccessCurrentUser(string $page){
        //TODO
    }
}