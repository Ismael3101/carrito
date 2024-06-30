<?php
session_start();

// Verificar si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    header("Location: index.php"); // Redirigir si el carrito está vacío
    exit;
}

// Obtener datos del carrito desde la sesión
$carrito = $_SESSION['carrito'];

// Inicializar variables para datos personales
$nombre_personal = isset($_POST['nombre_personal']) ? htmlspecialchars($_POST['nombre_personal']) : 'No especificado';
$direccion = isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : 'No especificado';
$telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : 'No especificado';

// Procesar confirmación de pago si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pago'])) {
    $metodo_pago = isset($_POST['metodo_pago']) ? htmlspecialchars($_POST['metodo_pago']) : 'No especificado';

    // Guardar datos del cliente en la base de datos
    require_once 'conexion.php'; // Incluir archivo de conexión

    try {
        // Insertar datos del cliente
        $sql_cliente = "INSERT INTO cliente (nombre, direccion, telefono) VALUES (?, ?, ?)";
        $stmt_cliente = $conexion->prepare($sql_cliente);
        $stmt_cliente->bind_param("sss", $nombre_personal, $direccion, $telefono);

        if ($stmt_cliente->execute()) {
            // Obtener el ID del cliente insertado
            $id_cliente = $stmt_cliente->insert_id;

            // Insertar detalles de la compra
            foreach ($carrito as $producto) {
                $nombre_producto = htmlspecialchars($producto['nombre']);
                $talla_producto = htmlspecialchars($producto['talla']);
                $cantidad_producto = htmlspecialchars($producto['cantidad']);
                $precio_unitario = htmlspecialchars($producto['precio']);
                $total_producto = $cantidad_producto * $precio_unitario;

                $sql_compra = "INSERT INTO compra (id_cliente, producto, talla, cantidad, precio_unitario, total) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_compra = $conexion->prepare($sql_compra);
                $stmt_compra->bind_param("isssid", $id_cliente, $nombre_producto, $talla_producto, $cantidad_producto, $precio_unitario, $total_producto);

                $stmt_compra->execute();
            }

            // Limpiar el carrito después de confirmar la compra
            unset($_SESSION['carrito']);
            session_destroy();
        } else {
            echo "Error al insertar cliente: " . $stmt_cliente->error . "<br>";
        }
    } catch (Exception $e) {
        echo "Error general al procesar la compra: " . $e->getMessage() . "<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido - FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .contenedor {
            text-align: center;
            margin-top: 50px;
        }
        .btn-finalizar {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
        }
        .btn-finalizar:hover {
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

    <main class="contenedor">
        <h1>Pedido Realizado</h1>
        <p>Su pedido ha sido procesado correctamente.</p>
        <a href="index.php" class="btn-finalizar">Finalizar</a>
    </main>

    <footer class="footer">
        <p class="footer__texto">Front End Store - Todos los derechos Reservados 2022.</p>
    </footer>
</body>
</html>
