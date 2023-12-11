<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUCE-T</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b0e0e6; /* Color de fondo azul cielo */
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #ff69b4; /* Color rosa */
            color: #000; /* Texto negro */
            text-align: center;
            padding: 10px;
        }

        h1 {
            background-color: #ff69b4; /* Fondo rosa */
            color: #fff; /* Cambia el color de fuente a blanco */
            padding: 20px;
        }

        .welcome-section {
            text-align: center;
            padding: 40px;
            background-color:  #ffc0cb; /* Fondo rosa más claro */
        }

        .welcome-section h2 {
            color: #000; /* Texto negro */
            font-size: 28px;
        }

        a {
            text-decoration: none;
            background-color: #ff69b4;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000; /* Borde negro */
            padding: 10px;
        }

        th {
            background-color: #ff69b4; /* Color rosa */
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #fff; /* Fondo blanco para filas pares */
        }

        tr:nth-child(odd) {
            background-color: #f0f0f0; /* Fondo gris claro para filas impares */
        }
    </style>
</head>

<body>
    <?php
    $conexion = oci_connect("SYSTEM", "root", "localhost/xe");

    if (!$conexion) {
        $m = oci_error();
        echo $m['message'], "n";
        exit;
    } else {
        echo "<h1>BIENVENIDO AL INVENTARIO</h1>"; /* Título con fondo rosa y texto blanco */
    }

    $query = 'SELECT * FROM inventario';
    $statement = oci_parse($conexion, $query);
    oci_execute($statement);
    ?>
     <a href="../consultas/consulta3.php">REGRESAR</a>

    <table border="1">
        <tr>
            <th>Id_inventario</th>
            <th>Categoria</th>
            <th>cantidad</th>
            <th> Id_producto </th>


        </tr>

        <?php
        while ($row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            echo "<td>" . ($row['ID_INVENTARIO'] !== null ? htmlentities($row['ID_INVENTARIO'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            echo "<td>" . ($row['CATEGORIA'] !== null ? htmlentities($row['CATEGORIA'], ENT_QUOTES) : "&nbsp; ") . "</td>\n";
            echo "<td>" . ($row['CANTIDAD'] !== null ? htmlentities($row['CANTIDAD'], ENT_QUOTES) : "&nbsp; ") . "</td>\n";
            echo "<td>" . ($row['ID_PRODUCTO'] !== null ? htmlentities($row['ID_PRODUCTO'], ENT_QUOTES) : " &nbsp;") . "</td>\n";

            echo "</tr>\n";
        }
        ?>

    </table>
</body>

</html>