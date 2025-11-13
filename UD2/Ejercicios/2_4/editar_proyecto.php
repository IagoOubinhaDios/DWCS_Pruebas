<?php
require_once "control_acceso.php";
require_once "modelo/ProyectoModel.php";
require_once "modelo/UsuarioModel.php";
try {
    if (!ControlAcceso::hasAccessCurrentUser(ControlAcceso::PAGE_EDITAR_PROYECTO)) {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
} catch (UserNotLogedException $th) {
    header("Location: login.php");
    exit;
}

if (isset($_COOKIE['id_proyecto'])) {
    $id = $_COOKIE['id_proyecto'];
    $proyecto = ProyectoModel::getProyecto($id);
}

if (isset($_POST['descripcion'])){
    $nuevo_proyecto = new Proyecto();
    $nuevo_proyecto->id = $proyecto->id;
    $nuevo_proyecto->nombre = $proyecto->nombre;
    $nuevo_proyecto->descripcion = $_POST['descripcion'];
    ProyectoModel::updateProyecto($nuevo_proyecto);
    header("Location: editar_proyectos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $proyecto->nombre ?></title>

</head>

<body>
    <h1><?= $proyecto->nombre ?></h1>
    <form action="" method="post">
        <label for="descripcion">Descripción</label><br>
        <textarea name="descripcion"><?= $proyecto->descripcion ?></textarea><br>
        <label>Programadores</label><br>
        <form>
        <?php
        $programadores = UsuarioModel::getProgramadoresProyecto($proyecto->id);
        foreach ($programadores as $pr) {
            echo "<input name='programadores_asignados[]' type='checkbox' value=", $pr->id, " ",
                isset($pr->proyecto_id) ? 'checked' : '', ">", $pr->nombre, '<br>';
        }
        ?>
        </form><br>
        <button type="submit">Guardar</a>
    </form>
</body>

</html>