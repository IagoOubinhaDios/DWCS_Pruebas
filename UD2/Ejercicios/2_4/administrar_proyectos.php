<?php
require_once "control_acceso.php";
require_once "modelo/UsuarioModel.php";
require_once "modelo/ProyectoModel.php";

try {
    if (!ControlAcceso::hasAccessCurrentUser(ControlAcceso::PAGE_ADMINISTRAR_PROYECTOS)) {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
} catch (UserNotLogedException $th) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar proyectos</title>
</head>

<body>
    <h1>PROYECTOS</h1>
    <form action="" method="post">
    <a href="crear_proyecto.php">Nuevo</a>
    <section>
        <?php
        $proyectos = ProyectoModel::getProyectos(null, null);
        $responsables = UsuarioModel::getUsuarios(null, 2, null);
        foreach($proyectos as $p){
            echo "<label>",$p->nombre,"</label><br>";
            echo "<textarea>",$p->descripcion,"</textarea><br>";
            echo "<label>Responsable</label><br>";
            echo '<select name="responsable">';
            foreach ($responsables as $r) {
                echo "<option value='", $r->id, "' ", $r->id == $p->responsable_id ? 'selected' : '', ">", $r->nombre, "</option>";
            }
            echo '</select><br>';
        }
        ?>
    </section>
</body>

</html>