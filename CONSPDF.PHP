<?php
require_once('../tcpdf/tcpdf.php');

// Crear instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('LUCE-T');
$pdf->SetAuthor('Alexis');
$pdf->SetTitle('Ventas del 19 al 29 de Octubre');
$pdf->SetHeaderData('', 0, 'Ventas del 19 al 29 de Octubre', '');

// Agregar página
$pdf->AddPage();

// Realizar la conexión y consulta a la base de datos
$conexion = oci_connect("SYSTEM", "root", "localhost/xe");

if (!$conexion) {
    $m = oci_error();
    echo $m["message"] . "n";
    exit;
}

// Realizar la consulta a la base de datos
$select_query = "SELECT v.id_venta, v.fecha, v.hora, c.nombre AS nombre_cliente, e.nombre AS nombre_empleado, p.nombre AS nombre_producto
                FROM ventasl v
                JOIN clientesl c ON v.id_cliente = c.id_cliente
                JOIN empleados e ON v.id_empleado = e.id_empleado
                JOIN productos p ON v.id_producto = p.id_producto
                WHERE v.fecha BETWEEN TO_DATE('2023-10-19', 'YYYY-MM-DD') AND TO_DATE('2023-10-29', 'YYYY-MM-DD')";
$statement = oci_parse($conexion, $select_query);
oci_execute($statement);

// Crear una variable para almacenar el contenido HTML
$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ff69b4; /* Color rosa */
            color: #fff; /* Texto blanco */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Fondo gris claro para filas pares */
        }

        tr:nth-child(odd) {
            background-color: #ffffff; /* Fondo blanco para filas impares */
        }
    </style>
</head>

<body>
    <h1>VENTAS REALIZADAS DEL 19 AL 29 DE OCTUBRE</h1>
    <table>
        <tr>
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre Cliente</th>
            <th>Nombre Empleado</th>
            <th>Nombre Producto</th>
        </tr>';

// Agregar los datos de la consulta al HTML del PDF
while ($row = oci_fetch_assoc($statement)) {
    $html .= '<tr>';
    $html .= '<td>' . ($row["ID_VENTA"] !== null ? htmlentities($row["ID_VENTA"], ENT_QUOTES) : "&nbsp;") . '</td>';
    $html .= '<td>' . ($row["FECHA"] !== null ? htmlentities($row["FECHA"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["HORA"] !== null ? htmlentities($row["HORA"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["NOMBRE_CLIENTE"] !== null ? htmlentities($row["NOMBRE_CLIENTE"], ENT_QUOTES) : " &nbsp;") . '</td>';
    $html .= '<td>' . ($row["NOMBRE_EMPLEADO"] !== null ? htmlentities($row["NOMBRE_EMPLEADO"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["NOMBRE_PRODUCTO"] !== null ? htmlentities($row["NOMBRE_PRODUCTO"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '</tr>';
}

$html .= '
    </table>
</body>
</html>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html);

// Salida del PDF (descarga o visualización)
$pdf->Output('ventas_19_29_octubre.pdf', 'D'); // 'D' descarga el PDF, 'I' lo muestra en el navegador

// No se necesita más salida HTML aquí ya que se está generando un PDF
?>
