<?php
session_start();

// Verifica si el usuario ha iniciado sesión como alumno
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $alumno_rut = $_SESSION['rut'];

    // Conexión a la base de datos
    $conn = mysqli_connect('localhost', 'root', '123456', 'probando2');

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Realiza una consulta SQL para obtener el nombre del alumno
    $query = "SELECT nombre FROM alumno WHERE rut = '$alumno_rut'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nombreAlumno = $row['nombre'];

        // Cierra la conexión a la base de datos
        mysqli_close($conn);

        // Muestra el nombre del alumno en la página
        echo "Bienvenido, $nombreAlumno";
    } else {
        // Manejo de errores si la consulta falla
        echo "Error al obtener la información del alumno.";
    }

    // Aquí puedes mostrar el contenido adicional de la página "inicioAlum.php"
} else {
    // Si el usuario no ha iniciado sesión como alumno, redirige o muestra un mensaje de error
    header("Location: login.php"); // Cambia "login.php" al archivo de inicio de sesión real o muestra un mensaje de error
    exit();
}
?>
