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
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .header__logo {
            max-width: 150px;
        }

        .navegacion {
            background-color: #444;
            text-align: center;
            padding: 10px 0;
        }

        .navegacion__enlace {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 5px;
        }

        .navegacion__enlace--activo {
            background-color: #555;
        }

        .contenedor {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Estilos específicos para el carrito */
        .carrito__producto {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .carrito__info {
            flex: 1;
        }

        .carrito__subtotal {
            font-weight: bold;
        }

        .carrito__eliminar {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .carrito__confirmar {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .carrito__confirmar:hover,
        .carrito__eliminar:hover {
            opacity: 0.8;
        }

        /* Estilos para el modal */
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
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 5px;
            position: relative;
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

        .modal-header {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
            border-radius: 5px 5px 0 0;
        }

        .modal-body {
            padding: 15px;
        }

        .modal-footer {
            text-align: right;
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }

        .modal-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .modal-form input[type="text"],
        .modal-form input[type="tel"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .modal-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .modal-form input[type="submit"]:hover {
            background-color: #45a049;
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
                echo '<div class="carrito__producto">';
                echo '<div class="carrito__info">';
                echo '<p>' . $producto['nombre'] . ' - Talla: ' . $producto['talla'] . ' - Cantidad: ' . $producto['cantidad'] . ' - Precio Unitario: $' . $producto['precio'] . ' - Subtotal: $' . $subtotal . '</p>';
                echo '</div>';
                echo '<form method="POST" style="display:inline;">';
                echo '<input type="hidden" name="producto_id" value="' . $producto['id'] . '">';
                echo '<input type="hidden" name="talla" value="' . $producto['talla'] . '">';
                echo '<input type="submit" name="eliminar" value="Eliminar" class="carrito__eliminar">';
                echo '</form>';
                echo '</div>';
                $totalCarrito += $subtotal;
            }
            echo '<h3 class="carrito__subtotal">Total del Carrito: $' . $totalCarrito . '</h3>';

            // Botón para confirmar compra y solicitar datos personales
            echo '<button onclick="mostrarModalDatosPersonales()" class="carrito__confirmar">Confirmar Compra</button>';

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
            <div class="modal-header">
                <h2>Datos Personales</h2>
            </div>
            <div class="modal-body">
                <form id="formDatosPersonales" class="modal-form" action="confirmacion.php" method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre_personal" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" required>
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required>
                    <input type="submit" value="Confirmar Datos">
                </form>
            </div>
            <div class="modal-footer">
                <p>Front End Store - Todos los derechos Reservados 2022.</p>
            </div>
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

