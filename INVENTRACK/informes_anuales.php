<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
} else {
    include './templates/header_informes.php';
    date_default_timezone_set("America/Santiago");
    $f = date('Y-m-d');
    $anio = date("Y", strtotime($f));

    $sql = $conexion->query("SELECT * FROM orden WHERE YEAR(orden.fecha) = '{$anio}'");

    $ganancia = 0;
    while ($r = mysqli_fetch_array($sql)) {
        $ganancia += $r['total_venta'];
    }

    $con = $conexion->query("SELECT * FROM orden WHERE YEAR(orden.fecha) = '{$anio}' ORDER BY orden.fecha DESC");

    $mesArray = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Informes Anuales</title>
    <style>
        .table-scrollable {
            overflow-y: auto;
            max-height: 300px;
        }

        .section-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table-header {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #e9ecef;
        }

        .btn-outline-success {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="section-title">Informe Anual</div>
        <p><strong>Total ganancias en este año: </strong>$<?php echo number_format($ganancia); ?></p>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $mes = $conexion->query("SELECT * FROM orden WHERE YEAR(orden.fecha) = '{$anio}' 
                AND MONTH(orden.fecha) = '{$i}' 
                ORDER BY orden.fecha ASC");

            $cmes = 0;
            $totalMes = 0;

            while ($rMes = mysqli_fetch_array($mes)) {
                $cmes++;
                $totalMes += $rMes['total_venta'];
            }

            if ($cmes != 0) {
        ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong><?php echo $mesArray[$i - 1]; ?></strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Cantidad de órdenes vendidas</th>
                                <td><?php echo $cmes; ?></td>
                            </tr>
                            <tr>
                                <th>Total de dinero ganado</th>
                                <td>$<?php echo number_format($totalMes); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <form action="informes_mensuales.php" method="post">
                                        <input type="hidden" name="mes" id="mes" value="<?php echo $i; ?>">
                                        <button type="submit" class="btn btn-outline-success">Ver detalles</button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php
}
include 'templates/foot.php';
?>
