<?php
// Conexión a la base de datos (ajusta los datos de conexión según tu configuración)
$conn = mysqli_connect('localhost', 'root', '123456', 'probando2');

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verifica si se ha proporcionado el parámetro 'rut' en la URL
if (isset($_GET['rut'])) {
    // Recupera el RUT del profesor desde la URL
    $rut = $_GET['rut'];

    // Realiza una consulta SQL para eliminar al profesor de la base de datos
    $query = "DELETE FROM profesor WHERE rut = '$rut'";

    // Ejecuta la consulta
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al eliminar al profesor: " . mysqli_error($conn);
    }
}

// Cierra la conexión
mysqli_close($conn);

// Redirige de vuelta a la página de lista de profesores
header("Location: inicioProf.php");
exit();
?>
