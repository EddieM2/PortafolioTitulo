<?php
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $rut = $_POST["rut"];
    $correo = $_POST["correo"];
    $nombre = $_POST["nombre"];
    $apellidoM = $_POST["apellidoM"];
    $apellidoP = $_POST["apellidoP"];
    $idCargo = $_POST["idCargo"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $genero = $_POST["genero"];
    $estadoAcademico = $_POST["estadoAcademico"];
    $rutApoderado = $_POST["rutApoderado"];

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para actualizar los datos del alumno utilizando sentencias preparadas
    $sql = "UPDATE alumno SET correo = ?, nombre = ?, apellidoM = ?, apellidoP = ?, idCargo = ?, fechaNacimiento = ?, direccion = ?, telefono = ?, genero = ?, estadoAcademico = ?, rutApoderado = ? WHERE rut = ?";
    
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssisssisss", $correo, $nombre, $apellidoM, $apellidoP, $idCargo, $fechaNacimiento, $direccion, $telefono, $genero, $estadoAcademico, $rutApoderado, $rut);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la vista de alumnos después de guardar los cambios
        header("Location: ../../models/alumnosModels/vistaAlumnos.php");
        exit(); // detiene la ejecucion del script
    } else {
        echo "Error al guardar los cambios: " . $stmt->error;
    }

    // Cierra la declaración
    $stmt->close();

    // Cierra la conexión a la base de datos
    $conexion->close();
} else {
    echo "Acceso no válido.";
}
?>
