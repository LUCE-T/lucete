<?php
// Aquí se recibe el token enviado al correo electrónico y se muestra un formulario para restablecer la contraseña

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar si el token es válido y está dentro del tiempo límite

    // Mostrar el formulario para restablecer la contraseña
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Restablecer Contraseña</title>
    </head>
    <body>
        <h2>Restablecer Contraseña</h2>
        <form action="procesar_nueva_contrasena.php" method="post">
            <input type="hidden" name="token" value="' . $token . '">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Restablecer Contraseña</button>
        </form>
    </body>
    </html>';
}
?>
