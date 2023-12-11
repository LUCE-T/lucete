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

        form {
            background-color: #fff;
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

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #ff69b4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ff1493;
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
        echo "<h1>BORRAR CLIENTE :( </h1>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_cliente = $_POST["id_cliente"];

        $delete_query = "DELETE FROM clientesl WHERE id_cliente = :id_cliente";

        $statement = oci_parse($conexion, $delete_query);

        oci_bind_by_name($statement, ":id_cliente", $id_cliente);

        if (oci_execute($statement)) {
            echo "ELIMINADO CON ÉXITO";
        } else {
            $error = oci_error($statement);
            echo "Error: " . $error['message'];
        }
    }
    ?>

    <form method="post" action="">
        <label for="id_cliente">ID Cliente a Eliminar:</label>
        <input type="number" name="id_cliente" id="id_cliente" required><br>
        <input type="submit" value="Eliminar Datos">
    </form>

    <a href="../consultas/consulta5.php">REGRESAR</a>
</body>

</html>