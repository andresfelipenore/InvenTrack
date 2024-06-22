<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferretería Castillo - Registrarse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales personalizados si es necesario */
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registrarse</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <?php if (!empty($errores)) : ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php echo $errores; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingrese su usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label for="password2" class="form-label">Confirmar Contraseña</label>
                                <input type="password" id="password2" name="password2" class="form-control" placeholder="Confirme su contraseña" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Registrarse</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            ¿Ya tienes cuenta? <a href="login.php" class="btn btn-link">Iniciar Sesión aquí</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
