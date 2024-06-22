<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Salir del script después de redireccionar
}

function GetEstado($num_despacho, $conexion)
{
    $result = "Completado";
    $s = $conexion->query("SELECT * FROM `despacho_producto` WHERE num_despacho = {$num_despacho}");
    while ($res = mysqli_fetch_array($s)) {
        if ($res['estado'] == 'pendiente') {
            $result = "Pendiente";
            break; // Una vez que se encuentra 'pendiente', no es necesario seguir revisando
        }
    }
    return $result;
}

$num_despacho = GetIsset('num_despacho');
$s = $conexion->query("SELECT * FROM `despacho_producto` WHERE num_despacho = {$num_despacho}");
$desp = $conexion->query("SELECT * FROM `despacho` WHERE num_despacho = {$num_despacho}");
$rDesp = mysqli_fetch_array($desp);

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h4>Información del Despacho</h4>
            <hr>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <strong>Número de Despacho: <?php echo $num_despacho; ?></strong>
                </div>
                <div class="card-body">
                    <p><strong>Estado:</strong> <?php echo GetEstado($num_despacho, $conexion); ?></p>
                    <p><strong>Fecha de Entrega:</strong> <?php echo $rDesp['fecha_entrega']; ?></p>
                    <hr>
                    <h5 class="card-title">Datos del Cliente</h5>
                    <p><strong>Nombre:</strong> <?php echo $rDesp['nombre_cliente']; ?></p>
                    <p><strong>Número:</strong> <?php echo $rDesp['num_cliente']; ?></p>
                    <p><strong>Dirección:</strong> <?php echo $rDesp['direccion_cliente']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4>Productos del Despacho</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre Producto</th>
                            <th>Estado Producto</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($r = mysqli_fetch_array($s)) {
                            $sen = $conexion->query("SELECT * FROM `producto` WHERE id = {$r['id_producto']}");
                            while ($producto = mysqli_fetch_array($sen)) {
                                $estado = $r['estado'];
                        ?>
                                <tr>
                                    <td><?php echo $r['id']; ?></td>
                                    <td><?php echo $producto['codigo']; ?></td>
                                    <td><?php echo $producto['nombre']; ?></td>
                                    <td><?php echo ($estado == 'pendiente') ? '<span class="text-danger">Pendiente</span>' : 'Entregado'; ?></td>
                                    <td><?php echo number_format($producto['precio'], 2); ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include 'templates/foot.php';
?>
