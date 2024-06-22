<?php
include './templates/head.php';
include 'conexion.php';

$id_producto = GetIsset('id_producto');
$numDespacho = GetIsset('num_despacho');
$conexion->query("UPDATE `despacho_producto` SET `estado` = 'completado' WHERE `despacho_producto`.`id` = {$id_producto}; ");

$p = $conexion->query("select * from producto where id = {$id_producto}; ");
$rP = mysqli_fetch_array($p);

?>
<div class="alert alert-success" role="alert">
    El producto ha sido entregado exisotamente.
</div>
<form action="verDespacho.php" method="post">
    <input type="hidden" id="num_despacho" name="num_despacho" value="<?php echo $numDespacho; ?>">
    <button type="submit" class="btn btn-outline-success mb-4">Volver al despacho</button>

</form>
<?php
