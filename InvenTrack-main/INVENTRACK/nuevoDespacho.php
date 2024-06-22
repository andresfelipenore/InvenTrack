<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit(); // Ensure script stops execution after redirection
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modo']) && $_POST['modo'] === 'modo') {
    // Retrieve form data
    $numOrden = GetIsset('numOrden');
    $nombreCliente = GetIsset('nombreCliente');
    $direccionCliente = GetIsset('direccionCliente');
    $telefonoCliente = GetIsset('telefonoCliente');
    $fechaEntrega = GetIsset('fecha');

    // Validate form data (basic validation, adjust as per your needs)
    if (empty($numOrden) || empty($nombreCliente) || empty($direccionCliente) || empty($telefonoCliente) || empty($fechaEntrega)) {
        echo '<div class="alert alert-danger" role="alert">Por favor, complete todos los campos del formulario.</div>';
    } else {
        // Perform SQL queries to insert data into your database tables
        // Example SQL queries (replace with your actual SQL statements)
        $insertOrdenSQL = "INSERT INTO ordenes (num_orden, nombre_cliente, direccion_cliente, telefono_cliente, fecha_entrega) 
                            VALUES ('$numOrden', '$nombreCliente', '$direccionCliente', '$telefonoCliente', '$fechaEntrega')";

        // Assuming $conexion is your database connection object
        if (mysqli_query($conexion, $insertOrdenSQL)) {
            // Success message or redirect to a success page
            echo '<div class="alert alert-success" role="alert">Orden completada y despachada exitosamente.</div>';
            // Redirect to another page if needed
            // header('Location: success.php');
            // exit();
        } else {
            // Error message if query fails
            echo '<div class="alert alert-danger" role="alert">Error al completar la orden: ' . mysqli_error($conexion) . '</div>';
        }
    }
}

// Retrieve num_orden if set (adjust as per your needs)
$NUM_ORDEN = GetIsset('num_orden');

?>

<div class="row">
    <form action="" method="post" class="form-group">
        <input type="hidden" id="modo" name="modo" value="modo">
        <div class="col-12 center">
            <div class="table table-responsive border border-dark p-3">
                <table class="table table-light table-striped table-hover">
                    <tr>
                        <th>
                            <div class="input-group p-3 mr-4">
                                <span class="input-group-text" id="basic-addon1">Número de orden</span>
                                <input type="number" class="form-control" required name="numOrden" id="numOrden" aria-describedby="helpId" placeholder="Número de orden" value="<?php echo htmlspecialchars($NUM_ORDEN); ?>">
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="input-group p-3 mr-4">
                                <span class="input-group-text" id="basic-addon1">Nombre del cliente</span>
                                <div class="input-group">
                                    <input type="text" class="form-control" required name="nombreCliente" id="nombreCliente" aria-describedby="helpId" placeholder="Nombre del cliente">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="input-group p-3 mr-4">
                                <span class="input-group-text" id="basic-addon1">Dirección</span>
                                <div class="input-group">
                                    <input type="text" class="form-control" required name="direccionCliente" id="direccionCliente" aria-describedby="helpId" placeholder="Dirección">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="input-group p-3 mr-4">
                                <span class="input-group-text" id="basic-addon1">Teléfono</span>
                                <div class="input-group">
                                    <input type="number" class="form-control" required name="telefonoCliente" id="telefonoCliente" aria-describedby="helpId" placeholder="Teléfono">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="input-group p-3 mr-4">
                                <span class="input-group-text" id="basic-addon1">Fecha de entrega</span>
                                <div class="input-group">
                                    <input type="date" class="form-control" required name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha de entrega">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <button class="btn btn-outline-success mt-4 mb-4" type="submit" name="accionBoton" value="despachar">Completar despacho</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>

<?php
include 'templates/foot.php';
?>
