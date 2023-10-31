<?php
// Incluye el archivo de conexión a la base de datos
 include("../models/db.php") ;// Asegúrate de cambiar el nombre de archivo según tu configuración.

// Recoge los valores del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];

    // Define la sentencia SQL para insertar la denuncia en la base de datos
    $sql = "INSERT INTO denuncias (titulo, descripcion, tipo, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Ejecuta la sentencia SQL con los valores recogidos
        $stmt->execute([$titulo, $descripcion, $tipo]);

        // Redirige al usuario a una página de confirmación o a donde lo desees
        header("Location: denuncia_exitosa.php"); // Cambia esto según tu estructura de archivos.
        exit;
    } else {
        echo "Error al preparar la consulta.";
    }
}
?>
