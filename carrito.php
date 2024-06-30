<?php
session_start();

// Verificar y inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para agregar productos al carrito
function agregarAlCarrito($producto_id, $nombre, $precio, $cantidad, $talla) {
    // Bandera para verificar si el producto ya está en el carrito
    $productoEnCarrito = false;
    
    // Verificar si el producto ya está en el carrito
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $producto_id && $producto['talla'] == $talla) {
            // Si está en el carrito con la misma talla, actualizar la cantidad
            $producto['cantidad'] += $cantidad;
            $productoEnCarrito = true;
            return; // Salir de la función
        }
    }
    
    // Si no está en el carrito, agregarlo como un nuevo producto
    if (!$productoEnCarrito) {
        $productoNuevo = [
            'id' => $producto_id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'talla' => $talla
        ];

        // Agregar producto al carrito
        $_SESSION['carrito'][] = $productoNuevo;
    }
}

// Función para eliminar productos del carrito
function eliminarDelCarrito($producto_id, $talla) {
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        if ($producto['id'] == $producto_id && $producto['talla'] == $talla) {
            unset($_SESSION['carrito'][$indice]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            break;
        }
    }
}

// Procesar solicitud de agregar producto al carrito si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $talla = $_POST['talla'];
    agregarAlCarrito($producto_id, $nombre, $precio, $cantidad, $talla);
}

// Procesar solicitud de eliminar producto del carrito si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $producto_id = $_POST['producto_id'];
    $talla = $_POST['talla'];
    eliminarDelCarrito($producto_id, $talla);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontEnd Store - Carrito de Compras</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-contenido {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .cerrar {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .cerrar:hover,
        .cerrar:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .error {
            color: red;
            display: none;
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
        <h1>Carrito de Compras</h1>

        <?php
        // Mostrar el contenido del carrito
        if (!empty($_SESSION['carrito'])) {
            echo '<h2>Contenido del Carrito</h2>';
            $totalCarrito = 0;
            foreach ($_SESSION['carrito'] as $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];
                echo '<p>' . $producto['nombre'] . ' - Talla: ' . $producto['talla'] . ' - Cantidad: ' . $producto['cantidad'] . ' - Precio Unitario: $' . $producto['precio'] . ' - Subtotal: $' . $subtotal . '</p>';
                $totalCarrito += $subtotal;
                echo '<form method="POST" style="display:inline;">
                        <input type="hidden" name="producto_id" value="' . $producto['id'] . '">
                        <input type="hidden" name="talla" value="' . $producto['talla'] . '">
                        <input type="submit" name="eliminar" value="Eliminar">
                      </form>';
            }
            echo '<h3>Total del Carrito: $' . $totalCarrito . '</h3>';

            // Botón para confirmar compra y solicitar datos personales
            echo '<button onclick="mostrarModalDatosPersonales()">Confirmar Compra</button>';

        } else {
            echo '<p>El carrito está vacío.</p>';
        }
        ?>
    </main>

    <footer class="footer">
        <p class="footer__texto">Front End Store - Todos los derechos Reservados 2022.</p>
    </footer>

    <!-- Modal para datos personales -->
    <div id="modalDatosPersonales" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalDatosPersonales()">&times;</span>
            <form id="formDatosPersonales" action="confirmacion.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre_personal" required>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>
                <input type="submit" value="Confirmar Datos">
            </form>
        </div>
    </div>

    <script>
    function mostrarModalDatosPersonales() {
        document.getElementById("modalDatosPersonales").style.display = "block";
    }

    function cerrarModalDatosPersonales() {
        document.getElementById("modalDatosPersonales").style.display = "none";
    }
    </script>
</body>
</html>
