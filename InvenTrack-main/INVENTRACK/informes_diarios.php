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

    $sql = $conexion->query("SELECT * FROM `orden` WHERE orden.fecha = '{$f}'");

    $ganancia = 0;
    while ($r = mysqli_fetch_array($sql)) {
        $ganancia += $r['total_venta'];
    }
?>

<div class="container mt-4">
    <h1 class="mb-4">Total ganancias en este mes: $<?php echo number_format($ganancia); ?></h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>N° Orden</th>
                    <th>Fecha de emisión</th>
                    <th>Total venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con = $conexion->query("SELECT * FROM `orden` WHERE orden.fecha = '{$f}' ORDER BY orden.fecha DESC ");

                while ($res = mysqli_fetch_array($con)) {
                    $fecha = date("d-m-Y", strtotime($res['fecha']));
                ?>
                    <tr>
                        <td><?php echo $res['num_orden']; ?></td>
                        <td><?php echo $fecha; ?></td>
                        <td>$<?php echo number_format($res['total_venta']); ?></td>
                        <td>
                            <form action="ventas_detalles.php" method="post">
                                <input type="hidden" name="num_orden" value="<?php echo $res['num_orden']; ?>">
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
</div>

<?php
}
include 'templates/foot.php';
?>
