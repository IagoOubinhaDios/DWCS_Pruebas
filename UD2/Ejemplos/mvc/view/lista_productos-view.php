<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista productos</title>
</head>

<body>
    <h1>Listado de Artículos</h1>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Titulo</th>
        </tr>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT']."/Ejemplos/mvc/model/ArticuloModel.php";
        $data = ArticuloModel::getArticulos();
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>', $row['fecha'], '</td>';
            echo '<td>', $row['titulo'], '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>

</html>