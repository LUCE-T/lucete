<?php
// Establecer la conexión a la base de datos Oracle
$conexion = oci_connect("SYSTEM", "root", "localhost/xe");

if (!$conexion) {
    $error = oci_error();
    echo "Falló la conexión a la base de datos: " . $error['message'];
    exit; // Detener el script si la conexión falla
}
?>
