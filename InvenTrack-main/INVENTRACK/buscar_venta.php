<?php
include './templates/head.php';
include 'conexion.php';

$sql = $conexion->query("SELECT * FROM `orden` ORDER BY orden.fecha DESC ");

if (isset($_POST['desde']) && isset($_POST['hasta'])) {
    $d = $_POST['desde'];
    $ha = $_POST['hasta'];
    $sql = $conexion->query("SELECT * FROM `orden` WHERE orden.fecha BETWEEN '{$d}' AND '{$ha}' ORDER BY orden.fecha DESC ");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Ventas</title>
    <style>
        .table-container {
            margin-top: 20px;
        }

        .table-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table-footer {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .total-ganancia {
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .total-ganancia span {
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container table-container">
        <div class="table-responsive border p-3">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-header">
                    <tr>
                        <th>N° Orden</th>
                        <th>Fecha de emisión</th>
                        <th>Total Venta</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGananciaHoy = 0;
                    while ($r = mysqli_fetch_array($sql)) {
                        $fecha = date("d-m-Y", strtotime($r['fecha']));
                        $totalGananciaHoy += $r['total_venta'];
                    ?>
                        <tr>
                            <td><?php echo $r['num_orden']; ?></td>
                            <td><?php echo $fecha; ?></td>
                            <td><strong>$</strong><?php echo number_format($r['total_venta']); ?></td>
                            <td>
                                <form action="ventas_detalles.php" method="post">
                                    <input type="hidden" name="num_orden" id="num_orden" value="<?php echo $r['num_orden']; ?>">
                                    <button class="btn btn-outline-success" type="submit">Ver detalles</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="total-ganancia">
            Total Ganancia Hoy: <span>$<?php echo number_format($totalGananciaHoy); ?></span>
        </div>
    </div>
</body>

</html>
