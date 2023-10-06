<?php include("../db.php") ?>

<?php
// Verificar si se proporcionó un parámetro "rut" en la URL
if (isset($_GET["rut"])) {
    // Obtener el RUT del alumno desde la URL
    $rut = $_GET["rut"];

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para eliminar al alumno
    $sql = "DELETE FROM alumno WHERE rut = '$rut'";

    if ($conexion->query($sql) === TRUE) {
        // La eliminación fue exitosa
        echo "Alumno eliminado correctamente.";
    } else {
        // Ocurrió un error durante la eliminación
        echo "Error al eliminar el alumno: " . $conexion->error;
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se proporcionó un RUT en la URL, mostrar un mensaje de error
    echo "No se proporcionó un RUT válido.";
}
?>
