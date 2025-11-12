<?php
require_once "control_acceso.php";
require_once "modelo/ProyectoModel.php";
require_once "modelo/UsuarioModel.php";

try {
    if (!ControlAcceso::hasAccessCurrentUser(ControlAcceso::PAGE_CREAR_PROYECTO)) {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
} catch (UserNotLogedException $th) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $id_responsable = $_POST['responsable'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    $error = [];

    //Comprobaciones 

    if (empty($nombre)) {
        $error[] = "Nombre obligatorio";
    }
    if (empty($descripcion)) {
        $error[] = "Descripcion obligatoria";
    }

    if (count($error) == 0) {
        $proyecto = new Proyecto();
        $proyecto->nombre = $nombre;
        $proyecto->descripcion = $descripcion;
        $proyecto->responsable_id = $id_responsable;
        if (!ProyectoModel::addProyecto($proyecto)) {
            $error[] = "Se ha producido un error registrando el usuario. Por favor, contacte con el servicio técnico.";
        } else {
            header("Location: administrar_proyectos.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo proyecto</title>
</head>

<body>
    <h1>Nuevo Proyecto</h1>
    <form action="" method="post">
        <label for="nombre">Nombre del proyecto</label><br>
        <input type="text" name="nombre"><br>

        <label for="descripcion">Responsable</label><br>
        <?php
        $responsables = UsuarioModel::getUsuarios(null, 2, null);
        echo '<select name="responsable">';
        foreach ($responsables as $r) {
            echo "<option value='", $r->id, "'>", $r->nombre, "</option>";
        }
        echo '</select>';
        ?>
        <br>

        <label for="descripcion">Descripción</label><br>
        <input type="text" name="descripcion"><br>

        <button type="button">Cancelar</button>
        <button type="submit">Crear</button>
    </form>
</body>

</html>