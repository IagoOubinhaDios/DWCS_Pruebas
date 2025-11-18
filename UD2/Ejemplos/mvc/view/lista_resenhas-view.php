<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista productos</title>
</head>

<body>
    <h1>Listado de Reseñas</h1>
    <table>
        <tr>
            <th>Artículo</th>
            <th>Descripción</th>
            <th>Fecha y hora</th>
        </tr>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT']."/Ejemplos/mvc/globals.php";
        require_once MODEL_PATH."ResenhaModel.php";
        $data = ResenhaModel::getResenhas();
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>', $row['titulo'], '</td>';
            echo '<td>', $row['descripcion'], '</td>';
            echo '<td>', $row['fecha_hora'] ?? 'No especificado', '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>

</html>