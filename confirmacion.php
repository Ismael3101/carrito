<?php
session_start();

// Verificar si el carrito está vacío o no existe
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: index.php"); // Redirigir si el carrito está vacío o no está definido
    exit;
}

// Inicializar variables para datos personales y método de pago
$nombre_personal = isset($_POST['nombre_personal']) ? htmlspecialchars($_POST['nombre_personal']) : '';
$direccion = isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : '';
$telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '';
$metodo_pago = isset($_POST['metodo_pago']) ? htmlspecialchars($_POST['metodo_pago']) : '';

// Procesar confirmación de pago si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pago'])) {
    // Validar que se hayan ingresado los datos personales
    if (empty($nombre_personal) || empty($direccion) || empty($telefono) || empty($metodo_pago)) {
        $error_message = "Por favor complete todos los campos requeridos.";
    } else {
        try {
            // Guardar datos del cliente en la base de datos o archivos según prefieras
            // En este ejemplo, se muestra cómo guardar en archivos

            // Guardar datos personales en archivo de texto
            $datos_personales = "Nombre: $nombre_personal\nDirección: $direccion\nTeléfono: $telefono";
            file_put_contents('datos_personales.txt', $datos_personales);

            // Obtener datos del carrito desde la sesión
            $carrito = $_SESSION['carrito'];

            // Guardar detalles de la compra en archivo de texto
            $detalles_compra = "";
            if (!empty($carrito)) {
                foreach ($carrito as $producto) {
                    $nombre_producto = htmlspecialchars($producto['nombre']);
                    $talla_producto = htmlspecialchars($producto['talla']);
                    $cantidad_producto = htmlspecialchars($producto['cantidad']);
                    $precio_unitario = htmlspecialchars($producto['precio']);
                    $total_producto = $cantidad_producto * $precio_unitario;

                    $detalles_compra .= "Producto: $nombre_producto\nTalla: $talla_producto\nCantidad: $cantidad_producto\nPrecio Unitario: $precio_unitario\nTotal: $total_producto\n\n";
                }
                file_put_contents('detalles_compra.txt', $detalles_compra);
            }

            // Limpiar el carrito después de confirmar la compra
            unset($_SESSION['carrito']);
            session_destroy();

            // Redirigir a una página de confirmación exitosa
            header("Location: confirmacion_exitosa.php");
            exit;
        } catch (Exception $e) {
            echo 'Error al procesar la compra: ' . $e->getMessage(); // Mostrar mensaje de error
            // Puedes manejar el error de manera más específica según sea necesario
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra - FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace navegacion__enlace--activo" href="index.php">Tienda</a>
        <a class="navegacion__enlace" href="nosotros.html">Nosotros</a>
    </nav>

    <main class="contenedor">
        <h1>Confirmación de Compra</h1>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="confirmacion_compra.php" method="POST">
            <h2>Datos Personales</h2>
            <div class="detalles-personales">
                <label for="nombre_personal">Nombre:</label>
                <input type="text" id="nombre_personal" name="nombre_personal" value="<?php echo $nombre_personal; ?>" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
            </div>

            <h2>Detalles de la Compra</h2>
            <div class="detalles-compra">
                <?php if (!empty($_SESSION['carrito'])): ?>
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <p><strong>Producto:</strong> <?php echo htmlspecialchars($producto['nombre']); ?></p>
                        <p><strong>Talla:</strong> <?php echo htmlspecialchars($producto['talla']); ?></p>
                        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                        <p><strong>Precio Unitario:</strong> $<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <hr>
                    <?php endforeach; ?>

                    <h3>Total de la Compra: $<?php
                        $totalCompra = array_reduce($_SESSION['carrito'], function($total, $producto) {
                            return $total + ($producto['cantidad'] * $producto['precio']);
                        }, 0);
                        echo htmlspecialchars($totalCompra);
                    ?></h3>
                <?php else: ?>
                    <p>No se encontraron productos en el carrito.</p>
                <?php endif; ?>

                <h2>Método de Pago:</h2>
                <label>
                    <input type="radio" name="metodo_pago" value="tarjeta" <?php if ($metodo_pago === 'tarjeta') echo 'checked'; ?>>
                    Tarjeta de Crédito
                </label>
                <label>
                    <input type="radio" name="metodo_pago" value="paypal" <?php if ($metodo_pago === 'paypal') echo 'checked'; ?>>
                    PayPal
                </label>
                <label>
                    <input type="radio" name="metodo_pago" value="efectivo" <?php if ($metodo_pago === 'efectivo') echo 'checked'; ?>>
                    Efectivo
                </label>

                <button type="submit" name="confirmar_pago">Confirmar Pago</button>
            </div>
        </form>
    </main>

    <footer class="footer">
        <p class="footer__texto">Front End Store - Todos los derechos Reservados 2022.</p>
    </footer>
</body>
</html>
