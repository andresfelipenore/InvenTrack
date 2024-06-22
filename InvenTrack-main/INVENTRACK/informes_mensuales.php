<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Asegura que se detiene la ejecución después de redirigir
} else {
    include './templates/header_informes.php';

    date_default_timezone_set("America/Santiago");
    $f = date('Y-m-d');
    $fechaFormat = strtotime($f);
    $mesActual = date("m", $fechaFormat);
    $anio = date("Y", $fechaFormat); // Asegúrate de que $anio esté definido aquí

    $m = "de este mes: $";

    if (isset($_POST['mes'])) {
        $mes = $_POST['mes'];
        $mesArray = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $m = "del mes de {$mesArray[$mes - 1]}: $";
    } else {
        $mes = $mesActual;
    }

    if (isset($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $fechaFormat = strtotime($fecha);
        $mes = date("m", $fechaFormat);
        $anio = date("Y", $fechaFormat); // Asegúrate de actualizar $anio aquí si es necesario
        $m = "del día $fecha: $";
    }

    // Obtener el número de días del mes actual
    $DiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

    $sql = $conexion->query("SELECT * FROM `orden` WHERE YEAR(orden.fecha) = '{$anio}' AND MONTH(orden.fecha) = '{$mes}'");

    $ganancia = 0;
    while ($r = mysqli_fetch_array($sql)) {
        $ganancia += $r['total_venta'];
    }
?>

<div class="container mt-4">
    <div class="p-3">
        <h1 class="mb-4">Total ganancias <?php echo $m; ?> <?php echo number_format($ganancia); ?></h1>

        <?php
        for ($i = 1; $i <= $DiasMes; $i++) {
            $dia = $conexion->query("SELECT * FROM `orden` WHERE YEAR(orden.fecha) = '{$anio}' 
                AND MONTH(orden.fecha) = '{$mes}' 
                AND DAY(orden.fecha) = '{$i}' 
                ORDER BY orden.fecha ASC");

            $cdias = 0;
            $totalDia = 0;

            while ($rdia = mysqli_fetch_array($dia)) {
                $cdias++;
                $totalDia += $rdia['total_venta'];
            }

            if ($cdias > 0) {
        ?>
                <div class="table-responsive border p-3 mt-4">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Fecha</th>
                            <td><?php echo "{$i}-{$mes}-{$anio}"; ?></td>
                        </tr>
                        <tr>
                            <th>Cantidad de órdenes vendidas</th>
                            <td><?php echo $cdias; ?></td>
                        </tr>
                        <tr>
                            <th>Total de dinero ganado</th>
                            <td>$<?php echo number_format($totalDia); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <form action="informes.php" method="post">
                                    <input type="hidden" name="fecha" value="<?php echo "{$anio}-{$mes}-{$i}"; ?>">
                                    <button type="submit" class="btn btn-outline-success">Ver detalles</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<?php
}
include 'templates/foot.php';
?>
