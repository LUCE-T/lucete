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
        input[type="number"] {
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
        $id_empleado = $_POST["id_empleado"];
        $nombre = $_POST["nombre"];
        $apellido_pat = $_POST["apellido_pat"];
        $apellido_mat = $_POST["apellido_mat"];
        $num_telefonico = $_POST["num_telefonico"];
        $direccion = $_POST["direccion"];
        $edad = $_POST["edad"];
        $salario = $_POST["salario"];

        $insert_query = "INSERT INTO empleados (id_empleado, nombre, apellido_pat, apellido_mat, num_telefonico, direccion, edad, salario) VALUES (:id_empleado, :nombre, :apellido_pat, :apellido_mat, :num_telefonico, :direccion, :edad, :salario)";

        $statement = oci_parse($conexion, $insert_query);

        oci_bind_by_name($statement, ":id_empleado", $id_empleado);
        oci_bind_by_name($statement, ":nombre", $nombre);
        oci_bind_by_name($statement, ":apellido_pat", $apellido_pat);
        oci_bind_by_name($statement, ":apellido_mat", $apellido_mat);
        oci_bind_by_name($statement, ":num_telefonico", $num_telefonico);
        oci_bind_by_name($statement, ":direccion", $direccion);
        oci_bind_by_name($statement, ":edad", $edad);
        oci_bind_by_name($statement, ":salario", $salario);

        if (oci_execute($statement)) {
            echo "AGREGADO CON ÉXITO";
        } else {
            $error = oci_error($statement);
            echo "Error: " . $error['message'];
        }
    }
    ?>

    <form method="post" action="">
        <label for="id_empleado">ID Empleado:</label>
        <input type="number" name="id_empleado" id="id_empleado" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="apellido_pat">Apellido Paterno:</label>
        <input type="text" name="apellido_pat" id="apellido_pat" required><br>

        <label for="apellido_mat">Apellido Materno:</label>
        <input type="text" name="apellido_mat" id="apellido_mat" required><br>

        <label for="num_telefonico">Número Telefónico:</label>
        <input type="text" name="num_telefonico" id="num_telefonico" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required><br>

        <label for="salario">Salario:</label>
        <input type="number" name="salario" id="salario" required><br>

        <input type="submit" value="Insertar Datos">
    </form>

    <a href="../consultas/consulta1.php">REGRESAR</a>

</body>
</html>