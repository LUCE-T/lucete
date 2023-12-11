<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUCE-T</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b0e0e6;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            background-color: #ff69b4;
            color: #000;
            padding: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 15px;
        }

        th {
            background-color: #ff69b4;
            color: #fff;
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

        a:hover {
            background-color: #ff1493;
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
        echo "<h1>TOTAL DE VENTAS POR EMPLEADO EN LA FECHA 2023-11-09</h1>";
    }

    $select_query = "SELECT e.nombre AS nombre_empleado, COUNT(v.id_venta) AS total_ventas
    FROM empleados e
    JOIN ventas v ON e.id_empleado = v.id_empleado
    WHERE v.fecha = TO_DATE('2023-11-09', 'YYYY-MM-DD')
    GROUP BY e.nombre";
    $statement = oci_parse($conexion, $select_query);
    oci_execute($statement);
    ?>

    <table>
        <tr>
            <th>Nombre Empleado</th>
            <th>Total Ventas</th>
        </tr>

        <?php
        while ($row = oci_fetch_assoc($statement)) {
            echo "<tr>";
            echo "<td>" . $row['NOMBRE_EMPLEADO'] . "</td>";
            echo "<td>" . $row['TOTAL_VENTAS'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="../Index.php">REGRESAR</a>

</body>

</html>
