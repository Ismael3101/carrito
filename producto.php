<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontEnd Store - Producto</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .camisa__imagen {
            width: 100%;
            max-width: 300px; /* Ajusta el ancho máximo según tu preferencia */
            height: auto; /* Mantiene la proporción de la imagen */
        }

        .camisa {
            display: flex;
            align-items: flex-start; /* Alinea los elementos en la parte superior */
        }

        .camisa__detalle {
            margin-left: 20px; /* Espacio entre la imagen y el detalle */
        }

        .formulario {
            margin-top: 10px; /* Espacio entre el detalle y el formulario */
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace navegacion__enlace--activo" href="index.php">Tienda</a>
        <a class="navegacion__enlace" href="nosotros.php">Nosotros</a>
    </nav>

    <main class="contenedor">
        <h1>Detalle del Producto</h1>

        <div class="camisa">
            <img id="camisaImagen" class="camisa__imagen" src="" alt="Imagen del Producto">
            
            <div class="camisa__detalle">
                <p id="nombreProducto" class="camisa__nombre"></p> <!-- Nombre del producto -->
                
                <form id="carritoFormulario" class="formulario" action="carrito.php" method="POST">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="formulario__input">
                    
                    <label for="talla">Talla:</label>
                    <select id="talla" name="talla" class="formulario__input">
                        <option value="S">S</option>
                        <option value="M" selected>M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    
                    <input type="hidden" name="producto_id" id="producto_id" value="1"> <!-- ID del producto -->
                    <input type="hidden" name="nombre" id="nombre" value="Camiseta"> <!-- Nombre del producto -->
                    <input type="hidden" name="precio" id="precio" value="25.00"> <!-- Precio del producto -->
                    <input class="formulario__submit" type="submit" name="agregar" value="Agregar al Carrito">
                </form>
            </div>
        </div>
        <div id="mensaje" class="mensaje" style="display: none;">Producto agregado al carrito</div>
    </main>

    <footer class="footer">
        <p class="footer__texto">Front End Store - Todos los derechos Reservados 2022.</p>
    </footer>

    <script>
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(window.location.search);
        const img = params.get('img');
        const nombreProducto = params.get('nombre');

        // Establecer la fuente de la imagen basada en el parámetro de la URL
        if (img) {
            document.getElementById('camisaImagen').src = 'img/' + img;
        }

        // Establecer el nombre del producto basado en el parámetro de la URL
        if (nombreProducto) {
            document.getElementById('nombreProducto').textContent = nombreProducto;
            document.getElementById('nombre').value = nombreProducto; // Establecer el nombre en el formulario
        }

        // Obtener el ID del producto basado en el parámetro de la URL
        const productoId = params.get('producto_id');
        if (productoId) {
            document.getElementById('producto_id').value = productoId; // Establecer el ID en el formulario
        }

        // Manejar el evento de envío del formulario
        document.getElementById('carritoFormulario').addEventListener('submit', function(event) {
            // Aquí puedes obtener dinámicamente la cantidad y talla seleccionada
            const cantidad = document.getElementById('cantidad').value;
            const talla = document.getElementById('talla').value;
            
            // Actualizar los campos ocultos del formulario con la cantidad y talla seleccionada
            document.getElementById('cantidad').value = cantidad;
            document.getElementById('talla').value = talla;

            // Mostrar el mensaje de confirmación
            const mensaje = document.getElementById('mensaje');
            mensaje.style.display = 'block';
            
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 3000);
        });
    </script>
</body>
</html>
