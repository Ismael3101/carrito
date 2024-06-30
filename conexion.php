<?php
// Configuración de la conexión a la base de datos
$host = "localhost"; // Nombre del servidor de la base de datos (usualmente "localhost")
$usuario = "root"; // Usuario de la base de datos
$contrasena = ""; // Contraseña de la base de datos
$base_de_datos = "almacenamiento"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión

?>
