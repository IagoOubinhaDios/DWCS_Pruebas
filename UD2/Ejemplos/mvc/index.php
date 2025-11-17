<?php
require_once "globals.php";

$controller = $_REQUEST['controller'] ?? "ErrorController";
try {
    require_once $_SERVER['DOCUMENT_ROOT']."/Ejemplos/mvc/controller.php";
    $objeto = new $controller();
    $action = $_REQUEST['action'] ?? 'pageNotFound';
} catch (\Throwable $th) {
    require_once "controller/ErrorController.php";
    $objeto = new ErrorController();
    $action = "pageNotFound";
}

try {
    $objeto->$action();
} catch (\Throwable $th) {
    require_once "controller/ErrorController.php";
    $objeto = new ErrorController();
    $objeto->pageNotFound();
}