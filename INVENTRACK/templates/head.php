<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/Styles/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .navbar-custom {
            background-color: #6c757d;
        }

        .navbar-nav .nav-link {
            color: white;
        }

        .content-container {
            margin-top: 20px;
        }
    </style>

    <title>INVENTRACK</title>
    <?php
    $mensaje = '';
    ?>
</head>

<body>
    <div class="container border mt-4">
        <div class="row">
            <div class="col-12 p-0">
                <nav class="navbar navbar-expand-md navbar-custom navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="nuevaOrden.view.php">Nueva orden</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="despacho.php">Despachos</a>
                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand mx-3" href="contenido.php">INVENTRACK</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ventas.php">Ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="informes.php">Informes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cerrar.php">Cerrar sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        
        <div class="content-container">
            <!-- Aquí puedes colocar el contenido de tu inventario o cualquier otro contenido que necesites -->
        </div>
    </div>
</body>

</html>
