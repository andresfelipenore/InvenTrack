<?php include 'templates/head.php'; ?>

<div class="container mt-4">
    <div class="card border border-dark p-4">
        <h5 class="card-title"><strong>Ingreso de productos</strong></h5>
        <form action="ingresoProducto.php" method="post">
            <div class="mb-3">
                <label for="nombreProducto" class="form-label">Nombre del producto</label>
                <input type="text" class="form-control" name="producto" id="nombreProducto" aria-describedby="helpId" placeholder="Nombre del producto" required>
            </div>
            <div class="mb-3">
                <label for="cantidadProducto" class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="cantidad" id="cantidadProducto" aria-describedby="helpId" placeholder="Cantidad" required>
            </div>
            <div class="mb-3">
                <button type="submit" name="boton" value="crear" class="btn btn-outline-primary">Ingresar producto</button>
            </div>
        </form>
    </div>
</div>

<?php include 'templates/foot.php'; ?>
