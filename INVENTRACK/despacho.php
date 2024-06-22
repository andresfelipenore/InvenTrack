<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; // Salir del script después de redireccionar
} else {
    // Función para obtener el estado de los despachos
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

    // Contador de despachos pendientes
    $cant = 0;
    $v = $conexion->query("SELECT * FROM `despacho_producto` WHERE estado = 'pendiente';");
    while ($z = mysqli_fetch_array($v)) {
        $cant++;
    }

    // Procesar acción de marcar completado
    if (isset($_POST['accionBoton']) && $_POST['accionBoton'] == 'marcar_completado') {
        $num_despacho = $_POST['num_despacho'];
        // Aquí deberías tener la lógica para marcar el despacho como completado en tu base de datos
        // Por simplicidad, aquí supondré que marcar como completado es cambiar el estado a 'completado'
        $conexion->query("UPDATE `despacho_producto` SET estado = 'completado' WHERE num_despacho = {$num_despacho}");
        // Redirigir para evitar reenvíos de formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit; // Salir del script después de redireccionar
    }

    // Procesar acción de borrar historial de despachos completados
    if (isset($_POST['accionBoton']) && $_POST['accionBoton'] == 'borrar_historial') {
        // Aquí deberías tener la lógica para borrar los despachos completados de tu base de datos
        $conexion->query("DELETE FROM `despacho_producto` WHERE estado = 'completado'");
        // Redirigir para evitar reenvíos de formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit; // Salir del script después de redireccionar
    }

    // Obtener los despachos ordenados por fecha de entrega ASC
    $s = $conexion->query("SELECT * FROM `despacho` ORDER BY `despacho`.`fecha_entrega` ASC;");
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
        <?php if ($cant != 0) { ?>
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
                        while ($r = mysqli_fetch_array($s)) {
                            $sentence2 = $conexion->query("SELECT * FROM `despacho_producto` WHERE estado = 'pendiente' AND num_despacho = {$r['num_despacho']} LIMIT 1");
                            while ($res = mysqli_fetch_array($sentence2)) {
                                $num_despacho = $res['num_despacho'];
                                $estado = $res['estado'];
                                $fecha_entrega = $r['fecha_entrega'];
                                $nombre_cliente = $r['nombre_cliente'];
                                $num_cliente = $r['num_cliente'];
                                $direccion_cliente = $r['direccion_cliente'];
                        ?>
                                <tr>
                                    <td><?php echo $num_despacho; ?></td>
                                    <td><span class="text-pending"><?php echo $estado; ?></span></td>
                                    <td><?php echo $fecha_entrega; ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="verDespacho.php" method="post">
                                                <input type="hidden" name="num_despacho" value="<?php echo $num_despacho; ?>">
                                                <input type="hidden" name="estado" value="<?php echo $estado; ?>">
                                                <input type="hidden" name="fecha_entrega" value="<?php echo $fecha_entrega; ?>">
                                                <input type="hidden" name="nombre_cliente" value="<?php echo $nombre_cliente; ?>">
                                                <input type="hidden" name="num_cliente" value="<?php echo $num_cliente; ?>">
                                                <input type="hidden" name="direccion_cliente" value="<?php echo $direccion_cliente; ?>">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    Ver despacho
                                                </button>
                                            </form>
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <input type="hidden" name="num_despacho" value="<?php echo $num_despacho; ?>">
                                                <button class="btn btn-outline-success" type="submit" name="accionBoton" value="marcar_completado">
                                                    Marcar completado
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
                    <?php
                    $s = $conexion->query("SELECT * FROM `despacho` ORDER BY `despacho`.`fecha_entrega` ASC;");
                    while ($r = mysqli_fetch_array($s)) {
                        $sentence2 = $conexion->query("SELECT * FROM `despacho_producto` WHERE estado = 'completado' AND num_despacho = {$r['num_despacho']} LIMIT 1");
                        while ($res = mysqli_fetch_array($sentence2)) {
                            $num_despacho = $res['num_despacho'];
                            $estado = $res['estado'];
                            $fecha_entrega = $r['fecha_entrega'];
                            $nombre_cliente = $r['nombre_cliente'];
                            $num_cliente = $r['num_cliente'];
                            $direccion_cliente = $r['direccion_cliente'];
                    ?>
                            <tr>
                                <td><?php echo $num_despacho; ?></td>
                                <td><span class="text-completed"><?php echo $estado; ?></span></td>
                                <td><?php echo $fecha_entrega; ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="verDespacho.php" method="post">
                                            <input type="hidden" name="num_despacho" value="<?php echo $num_despacho; ?>">
                                            <input type="hidden" name="estado" value="<?php echo $estado; ?>">
                                            <input type="hidden" name="fecha_entrega" value="<?php echo $fecha_entrega; ?>">
                                            <input type="hidden" name
                                            ="nombre_cliente" value="<?php echo $nombre_cliente; ?>">
                                            <input type="hidden" name="num_cliente" value="<?php echo $num_cliente; ?>">
                                            <input type="hidden" name="direccion_cliente" value="<?php echo $direccion_cliente; ?>">
                                            <button type="submit" class="btn btn-outline-primary">
                                                Ver despacho
                                            </button>
                                        </form>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                            <input type="hidden" name="num_despacho" value="<?php echo $num_despacho; ?>">
                                            <button class="btn btn-outline-success" type="submit" name="accionBoton" value="marcar_completado" disabled>
                                                Completado
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
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
