<?php
require_once "modelo/UsuarioModel.php";
require_once "modelo/RolModel.php";
require_once "control_acceso.php";
session_start();

//Cuando entra por POST con datos de formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = $_POST['mail'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $error = [];

    //Comprobaciones 

    if (empty($mail)) {
        $error[] = "Correo obligatorio";
    }
    if (empty($contrasena)) {
        $error[] = "Contraseña obligatorio";
    }

    if (count($error) == 0) {
        $usuario = UsuarioModel::getUsuarios(email:$mail);
        if(count($usuario)==1){
            $usuario = $usuario[0];
            if(password_verify($contrasena, $usuario->contrasena)){
                //Login correcto
                $_SESSION['current_user'] = $usuario;
                ControlAcceso::redirectPaginaProyectos();
                exit;
            }
        }else{
            $error = "Correo o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form action="" method="post">
        <label for="mail">Correo</label><br>
        <input type="text" name="mail" required><br>

        <label for="contrasena">Contraseña</label><br>
        <input type="password" name="contrasena" required><br>
        
        <button type="submit">Login</button>        
        <!-- Aqui los errores (si los hay) -->
        

    </form>
    <a href="registro.php">Registrar nuevo usuario</a>
</body>

</html>