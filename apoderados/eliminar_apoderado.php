<?php
// Verificar si se proporcionó un RUT de apoderado válido en la URL
if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];

    // Conexión a la base de datos (ajusta los datos de conexión según tu configuración)
    $conn = mysqli_connect('localhost', 'root', '123456', 'probando2');

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para eliminar al apoderado
    $deleteQuery = "DELETE FROM apoderado WHERE rut = '$rut'";

    if (mysqli_query($conn, $deleteQuery)) {
        // Redirigir de vuelta a la lista de apoderados después de la eliminación
        header("Location: apoderados.php");
        exit();
    } else {
        echo "Error al eliminar el apoderado: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    echo "RUT de apoderado no válido.";
}
?>
