<?php
// Establecer la conexión a la base de datos Oracle
$conexion = oci_connect("SYSTEM", "root", "localhost/xe");

if (!$conexion) {
    $error = oci_error();
    echo "Falló la conexión a la base de datos: " . $error['message'];
} else {
    // Si el método es POST, se procesará la información del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener y validar los datos del formulario
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        $role = $_POST['role']; // Obtener el rol del formulario
    
        // Consulta para verificar si el usuario ya existe
        $query = oci_parse($conexion, "SELECT * FROM usuarios WHERE username = :username");
        oci_bind_by_name($query, ':username', $input_username);
        oci_execute($query);
    
        // Verificar si el usuario ya existe
        if (($row = oci_fetch_assoc($query)) !== false) {
            echo "<p class='error-message'>El nombre de usuario ya está en uso. Por favor, elige otro.</p>";
        } else {
            // Insertar nuevo usuario en la tabla con el rol correspondiente
            $query_insert = oci_parse($conexion, "INSERT INTO usuarios (username, password, role) VALUES (:username, :password, :role)");
            oci_bind_by_name($query_insert, ':username', $input_username);
            oci_bind_by_name($query_insert, ':password', $input_password);
            oci_bind_by_name($query_insert, ':role', $role); // Asignar el rol seleccionado
    
            // Ejecutar la consulta de inserción y verificar el resultado
            if (oci_execute($query_insert)) {
                echo "Registro exitoso como " . $role;
                // Redirigir a la página de inicio de sesión después del registro exitoso
                header("Location: login.php");
                exit;
            } else {
                $error = oci_error($query_insert);
                echo "Error al insertar en la base de datos: " . $error['message'];
            }
        }
    }

    // Cerrar la conexión a la base de datos
    oci_close($conexion);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .register-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        input[type="text"]:hover,
        input[type="text"]:focus,
        input[type="password"]:hover,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Registro</h2>
            <?php
            // Mostrar mensajes de error aquí si es necesario
            ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
    <label for="role">Role:</label>
    <select id="role" name="role">
        <option value="admin">Administrador</option>
        <option value="user">Usuario</option>
    </select>
</div>
            <button type="submit">Registrar</button>
        </form>
        <div class="login-link">
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
        </div>
    </div>
</body>

</html>
