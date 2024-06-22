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

    $m = "de hoy: $";
    date_default_timezone_set("America/Santiago");
    $f = date('Y-m-d');

    if (isset($_POST['fecha'])) {
        $f = $_POST['fecha'];
        $fecha = date("d-m-Y", strtotime($f));
        $m = "del día {$fecha}: $";
    }

    $sql = $conexion->query("SELECT * FROM `orden` WHERE orden.fecha = '{$f}' ORDER BY orden.fecha DESC");

    $ganancia = 0;
    ?>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Total ganancias <?php echo $m; ?> <?php echo number_format($ganancia); ?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">N° Orden</th>
                                <th scope="col">Fecha de emisión</th>
                                <th scope="col">Total venta</th>
                                <th scope="col">Detalles</th>
                                <th scope="col">Estado despacho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res = mysqli_fetch_array($sql)) {
                                $fecha = date("d-m-Y", strtotime($res['fecha']));
                                ?>
                                <tr>
                                    <td><?php echo $res['num_orden']; ?></td>
                                    <td><?php echo $fecha; ?></td>
                                    <td><strong>$</strong><?php echo number_format($res['total_venta']); ?></td>
                                    <td>
                                        <form action="ventas_detalles.php" method="post">
                                            <input type="hidden" name="num_orden" value="<?php echo $res['num_orden']; ?>">
                                            <button class="btn btn-outline-success btn-sm" type="submit">Ver detalles</button>
                                        </form>
                                    </td>
                                    <td>
                                        <?php
                                        $descont = 0;
                                        $sdes = $conexion->query("SELECT * FROM `despacho` WHERE num_despacho = '{$res['num_orden']}'");
                                        while ($rSdes = mysqli_fetch_array($sdes)) {
                                            $descont++;
                                        }
                                        if ($descont == 0) {
                                            echo '<span class="text-muted"><i class="bi bi-x-lg"></i> No despachado</span>';
                                        } else {
                                            echo '<span class="text-success"><i class="bi bi-check-lg"></i> Despachado</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
}
include 'templates/foot.php';
?>
