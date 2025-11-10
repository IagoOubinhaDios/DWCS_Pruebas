<?php
require_once "modelo/UsuarioModel.php";
require_once "modelo/RolModel.php";
//Cuando entra por POST con datos de formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $mail = $_POST['mail'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $contrasena2 = $_POST['contrasena2'] ?? '';
    $idRol = $_POST['rol'] ?? '';
    $error = [];

    //Comprobaciones 
    if (empty($nombre)) {
        $error[] = "Nombre obligatorio";
    }
    if (empty($mail)) {
        $error[] = "Correo obligatorio";
    }
    if (empty($contrasena)) {
        $error[] = "Contraseña obligatorio";
    }
    if (empty($contrasena2)) {
        $error[] = "Es necesario introducir la segunda contraseña";
    }
    if (empty($idRol)) {
        $error[] = "Es necesario seleccionar un rol";
    }

    if ($contrasena !== $contrasena2) {
        $error[] = "Las contraseñas no coinciden.";
    }

    if (count($error) == 0) {
        $usuario = new Usuario();
        $usuario->rol_id = $idRol;
        $usuario->nombre = $nombre;
        $usuario->email = $mail;
        $usuario->contrasena = $contrasena;
        if (!UsuarioModel::addUsuario($usuario)) {
            $error[] = "Se ha producido un error registrando el usuario. Por favor, contacte con el servicio técnico.";
        } else {
            header("Location: login.php");
            exit;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <h1>Registro</h1>
    <form action="" method="post">
        <label for="mail">Correo</label><br>
        <input type="text" name="mail" required><br>

        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" required><br>

        <label for="rol">Rol</label><br>
        <!-- Esto tiene que ser dinámico -->
        <select name="rol">
            <?php
            $roles = RolModel::getRoles();
            foreach ($roles as $r) {
                echo "<option value='", $r->id, "'>", $r->nombre, "</option>";
            }
            ?>

        </select><br>

        <label for="contrasena">Contraseña</label><br>
        <input type="password" name="contrasena" required><br>

        <label for="contrasena2">Repita la contraseña</label><br>
        <input type="password" name="contrasena2" required><br>


        <button type="submit">Guardar</button>

    </form>
    <?php
    if (isset($error) && count($error) > 0) {
        echo "<div style= 'color:red;'><ul>";
        foreach ($error as $e) {
            echo "<li>$e</li>";
        }
        echo "</ul></div>";

    }
    ?>
    <a href="login.php">Login</a>
</body>

</html>