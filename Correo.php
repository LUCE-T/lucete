<?php
// Establecer la conexión a Oracle
$usuario = 'SYSTEM';
$contraseña = 'root';
$servidor = 'localhost/xe'; // O la dirección de tu servidor Oracle
$conexion = oci_connect($usuario, $contraseña, $servidor);

if (!$conexion) {
    $error = oci_error();
    echo "Falló la conexión a la base de datos: " . $error['message'];
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];

        // Consulta para buscar el correo en la base de datos Oracle
        $query = oci_parse($conexion, "SELECT username FROM usuarios WHERE email = :email");
        oci_bind_by_name($query, ':email', $email);
        oci_execute($query);

        // Verificar si se encuentra un usuario asociado al correo
        $row = oci_fetch_assoc($query);

        if ($row) {
            $nombreUsuario = $row['USERNAME'];
            $token = bin2hex(random_bytes(32)); // Generar un token único

            // Guardar el token en la base de datos junto con el nombre de usuario
            $guardarToken = oci_parse($conexion, "INSERT INTO reset_password (username, token) VALUES (:username, :token)");
            oci_bind_by_name($guardarToken, ':username', $nombreUsuario);
            oci_bind_by_name($guardarToken, ':token', $token);
            oci_execute($guardarToken);

            // Crear el enlace para restablecer contraseña
            $enlace = "http://tudominio.com/restablecer.php?user=" . $nombreUsuario . "&token=" . $token;

            // Lógica para enviar el correo electrónico con el enlace
            $mensaje = "Hola, has solicitado restablecer tu contraseña. Para continuar, haz clic en el siguiente enlace: " . $enlace;

            // Aquí deberías implementar la lógica para enviar el correo electrónico
            // mail($email, "Restablecer Contraseña", $mensaje);

            echo "Se ha enviado un correo con instrucciones para restablecer tu contraseña.";
        } else {
            echo "El correo ingresado no está asociado a una cuenta.";
        }
    }

    oci_close($conexion); // Cerrar la conexión a Oracle al finalizar
}
?>

