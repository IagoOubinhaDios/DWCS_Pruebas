<?php
require_once "control_acceso.php";
require_once "modelo/ProyectoModel.php";
require_once "modelo/UsuarioModel.php";
session_start();

try {
    if (!ControlAcceso::hasAccessCurrentUser(ControlAcceso::PAGE_EDITAR_PROYECTOS)) {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
} catch (UserNotLogedException $th) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["editar"])){
    $id = $_GET["editar"];
    setcookie("id_proyecto", $id, time()+1000);
    header("Location: editar_proyecto.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar proyectos</title>
</head>

<body>
    <h1>PROYECTOS</h1>
    <?php
    if (isset($_SESSION['current_user'])) {
        $usuario = $_SESSION['current_user'];
        $proyectos = ProyectoModel::getProyectos(null, $usuario->id);
        foreach ($proyectos as $p) {
            echo "<label>", $p->nombre, "</label><br>";
            echo "<label>Responsable: ", $usuario->nombre, "</label><br>";
            echo "<textarea>", $p->descripcion, "</textarea><br>";
            echo '<a href="?editar=', $p->id ,'">Editar</a><br>';
        }
    }
    ?>
        
</body>

</html>