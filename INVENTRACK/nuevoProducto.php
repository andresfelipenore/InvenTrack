<?php
include 'templates/head.php';
include 'conexion.php';

$conexion = Conectar();

$codigoProducto = GetIsset('codigoProducto');
$nombreProducto = GetIsset('nombreProducto');
$precio = GetIsset('precio');

// Check if product with the given code already exists
$consultaProducto = $conexion->query("SELECT * FROM producto WHERE codigo = '{$codigoProducto}'");
$contador = $consultaProducto->num_rows;

if ($contador == 0) {
    // Product does not exist, proceed to insert
    $insertQuery = "INSERT INTO producto (codigo, nombre, precio) VALUES (?, ?, ?)";
    
    // Prepare statement
    $stmt = $conexion->prepare($insertQuery);
    $stmt->bind_param("isd", $codigoProducto, $nombreProducto, $precio);
    
    // Execute statement
    if ($stmt->execute()) {
?>
        <div class="alert alert-success" role="alert">
            Se ha creado el producto correctamente. <br><br>
            Código producto: <strong><?php echo $codigoProducto; ?></strong><br>
            Nombre producto: <strong><?php echo $nombreProducto; ?></strong><br>
            Precio producto: <strong>$<?php echo number_format($precio); ?></strong><br>
        </div>
<?php
    } else {
?>
        <div class="alert alert-danger" role="alert">
            Error al crear el producto. Por favor, inténtalo de nuevo más tarde.
        </div>
<?php
    }
    // Close statement
    $stmt->close();
} else {
    // Product already exists
?>
    <div class="alert alert-danger" role="alert">
        El producto que intentas crear ya existe.
    </div>
    <a class="link-dark" href="ingresoProducto.view.php">Click aquí para ingresar stock del producto</a>
<?php
}

include 'templates/foot.php';
?>
