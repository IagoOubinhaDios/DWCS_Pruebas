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
            <option value="id">nombre_rol</option>
        </select><br>

        <label for="contrasena">Contraseña</label><br>
        <input type="password" name="contrasena" required><br>
        
        <label for="contrasena2">Repita la contraseña</label><br>
        <input type="password" name="contrasena2" required><br>
        <!-- Aqui los errores (si los hay) -->
        
        <button type="submit">Guardar</button>        

    </form>
</body>

</html>