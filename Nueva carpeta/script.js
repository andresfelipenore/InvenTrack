$(document).ready(function() {
    const usuarios = [];
    const bodegas = {};

    function mostrarMensaje(mensaje) {
        var mensajeHTML = '<div class="mensaje">' + mensaje + '</div>';
        $('#mensaje-contenedor').html(mensajeHTML);
        setTimeout(function() {
            $('#mensaje-contenedor').html('');
        }, 3000); // El mensaje desaparecerá después de 3 segundos
    }

    function agregarProducto(bodega, nombre, cantidad, precio, imagen) {
        var productoHTML = `<li><span class="producto">${nombre} - Cantidad: ${cantidad} - Precio: $${precio} <img src="${imagen}" alt="${nombre}" style="width:50px; height:50px; margin-left: 10px;"></span> <button class="eliminar">Eliminar</button></li>`;
        $(`#${bodega}-lista-productos`).append(productoHTML);
    }

    function cambiarVista(vista) {
        $('.view').hide();
        $(`#${vista}`).show();
    }

    $('#login-btn').click(function() {
        var username = $('#login-username').val();
        var password = $('#login-password').val();

        var usuario = usuarios.find(u => u.username === username && u.password === password);
        if (usuario) {
            cambiarVista('bodega-container');
        } else {
            mostrarMensaje('Usuario o contraseña incorrectos.');
        }
    });

    $('#register-btn').click(function() {
        var username = $('#register-username').val();
        var password = $('#register-password').val();

        if (username.trim() !== '' && password.trim() !== '') {
            usuarios.push({ username, password });
            mostrarMensaje('Usuario registrado exitosamente.');
            cambiarVista('login-container');
        }
    });

    $('#show-register').click(function(e) {
        e.preventDefault();
        cambiarVista('register-container');
    });

    $('#show-login').click(function(e) {
        e.preventDefault();
        cambiarVista('login-container');
    });

    $('#crear-bodega-btn').click(function() {
        var nombreBodega = $('#nueva-bodega').val();
        if (nombreBodega.trim() !== '') {
            bodegas[nombreBodega] = [];
            $('#select-bodega').append(`<option value="${nombreBodega}">${nombreBodega}</option>`);
            $('#nueva-bodega').val('');
            mostrarMensaje('Bodega "' + nombreBodega + '" creada.');
        }
    });

    $('#select-bodega-btn').click(function() {
        var bodegaSeleccionada = $('#select-bodega').val();
        if (bodegaSeleccionada) {
            $('#bodega-nombre').text(bodegaSeleccionada);
            cambiarVista('inventory-container');
        }
    });

    $('#show-add-product').click(function() {
        $('#form-title').text('Crear Producto');
        $('#product-form').show();
        $('#save-product-btn').off('click').on('click', function() {
            var nombreProducto = $('#nombre-producto').val();
            var cantidadProducto = $('#cantidad-producto').val();
            var precioProducto = $('#precio-producto').val();
            var imagenProducto = $('#imagen-producto')[0].files[0];
            var bodegaActual = $('#bodega-nombre').text();

            if (nombreProducto.trim() !== '' && cantidadProducto.trim() !== '' && precioProducto.trim() !== '') {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagenURL = e.target.result;
                    bodegas[bodegaActual].push({
                        nombre: nombreProducto,
                        cantidad: cantidadProducto,
                        precio: precioProducto,
                        imagen: imagenURL
                    });
                    agregarProducto(bodegaActual, nombreProducto, cantidadProducto, precioProducto, imagenURL);
                    $('#nombre-producto').val('');
                    $('#cantidad-producto').val('');
                    $('#precio-producto').val('');
                    $('#imagen-producto').val('');
                    mostrarMensaje('Producto "' + nombreProducto + '" agregado a la bodega "' + bodegaActual + '".');
                };
                reader.readAsDataURL(imagenProducto);
            }
        });
    });

    $('#show-modify-product').click(function() {
        mostrarMensaje('Función de modificar producto aún no implementada.');
    });

    $('#show-delete-product').click(function() {
        mostrarMensaje('Función de eliminar producto aún no implementada.');
    });

    $('#buscar-producto-btn').click(function() {
        var textoBusqueda = $('#buscar-producto').val().toLowerCase();
        var bodegaActual = $('#bodega-nombre').text();
        var productoEncontrado = bodegas[bodegaActual].find(producto => producto.nombre.toLowerCase() === textoBusqueda);

        if (productoEncontrado) {
            $('#producto-detalles').html(`
                Nombre: ${productoEncontrado.nombre}<br>
                Cantidad: ${productoEncontrado.cantidad}<br>
                Precio: $${productoEncontrado.precio}<br>
                <img src="${productoEncontrado.imagen}" alt="${productoEncontrado.nombre}" style="width:100px; height:100px;">
            `);
            $('#producto-vista-previa').show();

            $('#eliminar-producto-btn').off('click').on('click', function() {
                var index = bodegas[bodegaActual].indexOf(productoEncontrado);
                if (index !== -1) {
                    bodegas[bodegaActual].splice(index, 1);
                    $(`#${bodegaActual}-lista-productos li:contains('${productoEncontrado.nombre}')`).remove();
                    $('#producto-vista-previa').hide();
                    mostrarMensaje('Producto "' + productoEncontrado.nombre + '" eliminado.');
                }
            });

            $('#modificar-producto-btn').off('click').on('click', function() {
                $('#form-title').text('Modificar Producto');
                $('#product-form').show();
                $('#nombre-producto').val(productoEncontrado.nombre);
                $('#cantidad-producto').val(productoEncontrado.cantidad);
                $('#precio-producto').val(productoEncontrado.precio);
                // Nota: No podemos preestablecer el archivo en el input de imagen

                $('#save-product-btn').off('click').on('click', function() {
                    var nuevoNombre = $('#nombre-producto').val();
                    var nuevaCantidad = $('#cantidad-producto').val();
                    var nuevoPrecio = $('#precio-producto').val();
                    var nuevaImagen = $('#imagen-producto')[0].files[0];

                    if (nuevoNombre.trim() !== '' && nuevaCantidad.trim() !== '' && nuevoPrecio.trim() !== '') {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var nuevaImagenURL = nuevaImagen ? e.target.result : productoEncontrado.imagen;
                            productoEncontrado.nombre = nuevoNombre;
                            productoEncontrado.cantidad = nuevaCantidad;
                            productoEncontrado.precio = nuevoPrecio;
                            productoEncontrado.imagen = nuevaImagenURL;

                            $(`#${bodegaActual}-lista-productos li:contains('${productoEncontrado.nombre}')`).replaceWith(`
                                <li>
                                    <span class="producto">${nuevoNombre} - Cantidad: ${nuevaCantidad} - Precio: $${nuevoPrecio} 
                                    <img src="${nuevaImagenURL}" alt="${nuevoNombre}" style="width:50px; height:50px; margin-left: 10px;">
                                    </span> 
                                    <button class="eliminar">Eliminar</button>
                                </li>
                            `);

                            $('#nombre-producto').val('');
                            $('#cantidad-producto').val('');
                            $('#precio-producto').val('');
                            $('#imagen-producto').val('');
                            $('#product-form').hide();
                            $('#producto-vista-previa').hide();
                            mostrarMensaje('Producto "' + nuevoNombre + '" modificado.');
                        };
                        if (nuevaImagen) {
                            reader.readAsDataURL(nuevaImagen);
                        } else {
                            reader.onload({ target: { result: productoEncontrado.imagen } });
                        }
                    }
                });
            });
        } else {
            mostrarMensaje('Producto no encontrado.');
        }
    });

    $('#lista-productos').on('click', '.eliminar', function() {
        var producto = $(this).siblings('.producto').text();
        $(this).parent().remove();
        mostrarMensaje('Producto "' + producto + '" eliminado.');
    });
});
