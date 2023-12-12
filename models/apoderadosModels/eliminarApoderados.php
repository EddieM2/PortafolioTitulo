<?php include("../db.php") ?>
<?php
// Verificar si se proporcionó un RUT de apoderado válido en la URL
if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    // Consulta para eliminar al apoderado
    $deleteQuery = "DELETE FROM apoderado WHERE rut = '$rut'";

    if (mysqli_query($conexion, $deleteQuery)) {
        // Redirigir de vuelta a la lista de apoderados después de la eliminación
        header("Location: vistaApoderados.php");
        exit();
    } else {
        echo "Error al eliminar el apoderado: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "RUT de apoderado no válido.";
}
?>
