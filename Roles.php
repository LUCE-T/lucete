<?php
session_start();

// Verificar si el usuario está logueado y tiene un rol asignado
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    if ($_SESSION['role'] === 'user') {
        // Si el usuario tiene un rol de "user", muestra solo las consultas sin permitir acciones de inserción o eliminación
        ?>
        <!DOCTYPE html>
        <html lang="en">       
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUCE-T MODA CON ENCANTO</title>
    <style>
        /* Estilos CSS para el cuerpo del documento */
        body {
            font-family: "Courier New", Courier, monospace;
            background: url('LUCETE.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #fff;
            position: relative;
        }
        /* Estilos del encabezado y barra de navegación */
        header {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        nav {
            text-align: center;
            margin-top: 20px;
        }
        .consultas-section {
            margin-top: 20px;
        }
        .cons-section {
            margin-top: 40px; /* Ajusta este valor según sea necesario para la separación deseada */
        }
        nav a {
            text-decoration: none;
            margin: 10px;
            color: #ff1493;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        nav a:hover {
            background-color: #555;
            color: #fff;
        }
        /* Estilos para el formulario y el texto personalizado (si los tienes) */
        .form-container {
            text-align: center;
            margin-top: 20px;
        }
        .form-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ff1493;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #ff0066;
        }
        /* Estilos para el texto personalizado en la parte inferior de la página */
        .custom-text-container {
            text-align: center;
            margin: 0;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .custom-text {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
        }
    </style>
        </head>

        <body>
        <header>
    <h1><marquee behavior="scroll" direction="left" scrollamount="8">LUCE-T MODA CON ENCANTO</marquee></h1>
    </header>
    <nav>
        <div class="consultas-section">
            <a href="../NuevaC/consultas/consulta1.php">EMPLEADOS</a>
            <a href="../NuevaC/consultas/consulta2.php">PROVEEDORES</a>
            <a href="../NuevaC/consultas/consulta3.php">INVENTARIO</a>
            <a href="../NuevaC/consultas/consulta4.php">PRODUCTO</a>
            <a href="../NuevaC/consultas/consulta5.php">CLIENTES</a>
            <a href="../NuevaC/consultas/consulta6.php">VENTAS</a>
            <a href="../NuevaC/consultas/consulta7.php">CARRITO DE COMPRAS</a>
        </div>
        <div class="cons-section">
            <a href="../NuevaC/CONSULTAS1/Cons1.php">CONSULTA 1</a>

        </div>
    </nav>
        </body>

        </html>
        <?php
 } elseif ($_SESSION['role'] === 'admin') {

    ?>
    <!-- Agregar funcionalidades específicas para el administrador -->
    <div class="admin-section">
        <h2>Panel de administrador</h2>
        <a href="agregar.php">Agregar</a>
        <a href="eliminar.php">Eliminar</a>
        <!-- Agregar más enlaces o botones para las funcionalidades del administrador -->
    </div>
    <?php
}
} else {
    // Si no está logueado, redirige a la página de inicio de sesión
    header("Location: Roles.php");
    exit;
}
?>
