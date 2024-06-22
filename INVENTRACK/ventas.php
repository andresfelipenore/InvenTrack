<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Ensure to stop script execution after redirecting
}

// Default SQL query to fetch orders sorted by date descending
$sql = $conexion->query("SELECT * FROM `orden` ORDER BY `fecha` DESC");

// Check if form was submitted with date range criteria
if (isset($_POST['desde']) && isset($_POST['hasta'])) {
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];

    // Construct SQL query with date range filter
    $sql = $conexion->query("SELECT * FROM `orden` WHERE `fecha` BETWEEN '$desde' AND '$hasta' ORDER BY `fecha` DESC");
}

?>

<div class="row">
    <script type="text/javascript">
        function BuscarVentas() {
            var desde = document.getElementById('desde').value;
            var hasta = document.getElementById('hasta').value;

            $.ajax({
                url: 'buscar_venta.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    desde: desde,
                    hasta: hasta
                },
                success: function(response) {
                    $("#datos").html(response);
                },
                error: function() {
                    console.log("Error in AJAX request.");
                }
            });
        }
    </script>

    <form class="form-group" method="post">
        <div class="w-50">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Desde</span>
                <input type="date" class="form-control" name="desde" id="desde">
            </div>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Hasta</span>
                <input type="date" class="form-control" name="hasta" id="hasta">
            </div>
        </div>
        <button id="busca_fecha" class="btn btn-outline-dark mt-3" type="button" onclick="BuscarVentas()">
            <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </span>
        </button>
    </form>
</div>

<div class="p-3">
    <div class="table-responsive border p-3 table-scrollable">
        <table class="table table-responsive border table-striped table-hover">
            <thead>
                <tr>
                    <th>N° Orden</th>
                    <th>Fecha de emisión</th>
                    <th>TOTAL VENTA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="datos">
                <?php
                while ($r = mysqli_fetch_array($sql)) {
                    $fecha = date("d-m-Y", strtotime($r['fecha']));
                ?>
                    <tr>
                        <td><?php echo $r['num_orden']; ?></td>
                        <td><?php echo $fecha; ?></td>
                        <td><strong><?php echo ('$' . number_format($r['total_venta'])); ?></strong></td>
                        <td>
                            <form action="ventas_detalles.php" method="post">
                                <input type="hidden" name="num_orden" value="<?php echo $r['num_orden']; ?>">
                                <button class="btn btn-outline-success" type="submit">Ver detalles</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'templates/foot.php';
?>
