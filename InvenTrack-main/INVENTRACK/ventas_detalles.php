<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Ensure to stop script execution after redirecting
}

// Get order number from request
$num_orden = GetIsset('num_orden');

// Fetch products related to the order
$sql = "SELECT * FROM factura_producto WHERE num_factura = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $num_orden);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<div class="table-responsive border p-3 table-scrollable">
    <table class="table table-responsive border table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre producto</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r = $result->fetch_assoc()) : ?>
                <?php
                // Fetch product details
                $fac_produc = $conexion->query("SELECT * FROM producto WHERE id = {$r['id_producto']}");
                $producto = $fac_produc->fetch_assoc();

                // Calculate total price
                $total += $r['precio_venta'];
                ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo ('$' . number_format($r['precio_venta'])); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr class="bg bg-dark text-white">
                <td><strong>SUBTOTAL</strong></td>
                <td><strong><?php echo (number_format($total)); ?></strong></td>
            </tr>
            <tr class="bg bg-dark text-white">
                <td><strong>DESCUENTO</strong></td>
                <td><strong>
                        <?php
                        $totalVenta = 0;
                        $d = $conexion->query("SELECT * FROM orden WHERE num_orden = {$num_orden}");
                        $rd = $d->fetch_assoc();
                        $totalVenta = $total - $rd['total_venta'];
                        echo $totalVenta;
                        ?>
                    </strong></td>
            </tr>
            <tr class="bg bg-dark text-white">
                <td><strong>TOTAL</strong></td>
                <td><strong>
                        <?php
                        $totalVenta = 0;
                        $d = $conexion->query("SELECT * FROM orden WHERE num_orden = {$num_orden}");
                        $rd = $d->fetch_assoc();
                        $totalVenta = $total - $rd['total_venta'];
                        echo ('$' . number_format($total - $totalVenta));
                        ?>
                    </strong></td>
            </tr>
        </tfoot>
    </table>

    <?php
    // Check if the order has already been dispatched
    $despacho = $conexion->query("SELECT * FROM despacho WHERE num_despacho = {$num_orden}");
    $contadorDespachos = $despacho->num_rows;

    if ($contadorDespachos == 0) :
    ?>
        <form action="nuevoDespacho.php" method="post">
            <input type="hidden" name="num_orden" id="num_orden" value="<?php echo $num_orden; ?>">
            <button class="btn btn-outline-success" type="submit">Despachar orden</button>
        </form>
    <?php else : ?>
        <button class="btn btn-outline-info" disabled>Esta orden ya ha sido despachada</button>
    <?php endif; ?>
</div>

<?php include 'templates/foot.php'; ?>
