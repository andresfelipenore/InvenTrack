<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Salir del script después de redireccionar
} else {
    // Obtener los despachos pendientes
    $s_pendientes = $conexion->query("SELECT d.num_despacho, d.fecha_entrega, d.nombre_cliente, d.num_cliente, d.direccion_cliente 
                                      FROM despacho d 
                                      INNER JOIN despacho_producto dp ON d.num_despacho = dp.num_despacho 
                                      WHERE dp.estado = 'pendiente'
                                      GROUP BY d.num_despacho");

    // Obtener los despachos completados únicos
    $s_completados = $conexion->query("SELECT d.num_despacho, d.fecha_entrega
                                       FROM despacho d
                                       INNER JOIN despacho_producto dp ON d.num_despacho = dp.num_despacho
                                       WHERE dp.estado = 'completado'
                                       GROUP BY d.num_despacho");

    // Procesar acción de borrar historial de despachos completados
    if (isset($_POST['accionBoton']) && $_POST['accionBoton'] == 'borrar_historial') {
        $conexion->query("DELETE FROM `despacho_producto` WHERE estado = 'completado'");
        // Redirigir para evitar reenvío del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
        <title>Despachos</title>
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

            .text-pending {
                color: #dc3545;
            }

            .text-completed {
                color: #28a745;
            }

            .table-header {
                background-color: #f8f9fa;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <?php if ($s_pendientes->num_rows > 0) { ?>
                <div class="section-title">Despachos Pendientes</div>
                <div class="table-responsive border table-scrollable mb-4">
                    <table class="table table-striped table-bordered">
                        <thead class="table-header">
                            <tr>
                                <th>Nº Despacho</th>
                                <th>Estado</th>
                                <th>Fecha de Entrega</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $despachos_mostrados = array(); // Array para mantener registros de despachos mostrados
                            while ($r = mysqli_fetch_array($s_pendientes)) {
                                // Verificar si el número de despacho ya fue mostrado
                                if (in_array($r['num_despacho'], $despachos_mostrados)) {
                                    continue; // Saltar al siguiente ciclo si ya fue mostrado
                                }
                                $despachos_mostrados[] = $r['num_despacho']; // Agregar a los mostrados
                            ?>
                                <tr>
                                    <td><?php echo $r['num_despacho']; ?></td>
                                    <td><span class="text-pending">Pendiente</span></td>
                                    <td><?php echo $r['fecha_entrega']; ?></td>
                                    <td>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                            <input type="hidden" name="num_despacho" value="<?php echo $r['num_despacho']; ?>">
                                            <button class="btn btn-outline-success" type="submit" name="accionBoton" value="marcar_completado">
                                                Marcar completado
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-info">No hay despachos pendientes.</div>
            <?php } ?>

            <div class="section-title">Despachos Completados</div>
            <div class="table-responsive border table-scrollable">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <button class="btn btn-danger mb-3" type="submit" name="accionBoton" value="borrar_historial">
                        Borrar historial de despachos completados
                    </button>
                </form>
                <table class="table table-striped table-bordered">
                    <thead class="table-header">
                        <tr>
                            <th>Nº Despacho</th>
                            <th>Estado</th>
                            <th>Fecha de Entrega</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysqli_fetch_array($s_completados)) { ?>
                            <tr>
                                <td><?php echo $r['num_despacho']; ?></td>
                                <td><span class="text-completed">Completado</span></td>
                                <td><?php echo $r['fecha_entrega']; ?></td>
                                <td>
                                    <form action="verDespacho.php" method="post">
                                        <input type="hidden" name="num_despacho" value="<?php echo $r['num_despacho']; ?>">
                                       
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>

<?php
}
include 'templates/foot.php';
?>
