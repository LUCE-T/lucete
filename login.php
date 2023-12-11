<?php
include 'conexion.php'; // Incluir el archivo de conexión
session_start();

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y validar los datos del formulario
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $query = oci_parse($conexion, "SELECT * FROM usuarios WHERE username = :username AND password = :password");
    oci_bind_by_name($query, ':username', $input_username);
    oci_bind_by_name($query, ':password', $input_password);
    oci_execute($query);

    // Verificar si se encontraron resultados
    if (($row = oci_fetch_assoc($query)) !== false) {
        // Autenticación exitosa, establecer la sesión y redirigir al usuario
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        // Autenticación fallida, mostrar un mensaje de error
        echo "<p class='error-message'>Invalid username or password. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Estilos y CSS -->
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

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
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
            text-align: center;
            margin-top: 10px;
        }
        /* Estilos adicionales para el enlace de registro */
        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Estilos adicionales para el enlace de restablecer contraseña */
        .reset-password {
            margin-top: 20px; /* Espacio hacia arriba */
            text-align: center; /* Centrar el enlace */
        }

        .reset-password a {
            color: #007bff; /* Color azul */
            text-decoration: none; /* Sin subrayado */
        }

        .reset-password a:hover {
            /* Estilos al pasar el cursor si deseas alguna modificación visual */
        }
        </style>
</head>

<body>
    <div class="login-container">
        <!-- Formulario de inicio de sesión -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['logged_in']) && !$_SESSION['logged_in']) { ?>
                <p class="error-message">Invalid username or password. Please try again.</p>
            <?php } ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>

            <!-- Agregar enlace para restablecer contraseña -->
            <div class="reset-password">
                <a href="Recuperacion.php">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
        </div>
    </div>
</body>

</html>