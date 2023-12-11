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

        h1 {
            background-color: #ff69b4; /* Color rosa */
            color: #000; /* Texto negro */
            padding: 20px;
        }

        form {
            background-color: #fff; /* Fondo blanco */
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #ff69b4; /* Color rosa */
            color: #fff; /* Texto blanco */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ff1493; /* Cambia de color al pasar el cursor sobre él */
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
            background-color: #ff1493; /* Cambia de color al pasar el cursor sobre él */
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
        echo "<h1>BIENVENIDO, AHORA ERES PARTE DE LUCE-T</h1>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_carrito = $_POST["id_carrito"];
        $fecha = $_POST["fecha"];
        $cantidad = $_POST["cantidad"];
        $total = $_POST["total"];
        $id_cliente = $_POST["id_cliente"];
        $id_producto = $_POST["id_producto"];

        $insert_query = "INSERT INTO carrito_de_compras (id_carrito, fecha, cantidad, total, id_cliente, id_producto) VALUES (:id_carrito, TO_DATE(:fecha, 'YYYY-MM-DD'), :cantidad, :total, :id_cliente, :id_producto)";

        $statement = oci_parse($conexion, $insert_query);

        oci_bind_by_name($statement, ":id_carrito", $id_carrito);
        oci_bind_by_name($statement, ":fecha", $fecha);
        oci_bind_by_name($statement, ":cantidad", $cantidad);
        oci_bind_by_name($statement, ":total", $total);
        oci_bind_by_name($statement, ":id_cliente", $id_cliente);
        oci_bind_by_name($statement, ":id_producto", $id_producto);

        if (oci_execute($statement)) {
            echo "AGREGADO CON ÉXITO";
        } else {
            $error = oci_error($statement);
            echo "Error: " . $error['message'];
        }
    }
    ?>

    <form method="post" action="">
        <label for="id_carrito">ID Carrito:</label>
        <input type="number" name="id_carrito" id="id_carrito" required><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required><br>

        <label for="total">Total:</label>
        <input type="number" name="total" id="total" step="0.01" required><br>

        <label for="id_cliente">ID Cliente:</label>
        <input type="number" name="id_cliente" id="id_cliente" required><br>

        <label for="id_producto">ID Producto:</label>
        <input type="number" name="id_producto" id="id_producto" required><br>

        <input type="submit" value="Insertar Datos">
    </form>

    <a href="../consultas/consulta7.php">REGRESAR</a>

</body>
</html>