<?php
//conexion a la base de datos
include("../models/db.php"); 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['curso'])) {
    $idCurso = $_GET['curso'];

    // Consultar los estudiantes del curso seleccionado
    $estudiantes_query = "SELECT idEstudiante, nombre FROM estudiantes WHERE idCurso = $idCurso";
    $estudiantes_result = mysqli_query($conexion, $estudiantes_query);

    if (!$estudiantes_result) {
        die("Error en la consulta de estudiantes: " . mysqli_error($conexion));
    }

    $estudiantes = array();

    while ($estudiante = mysqli_fetch_assoc($estudiantes_result)) {
        $estudiantes[] = array(
            'id' => $estudiante['idEstudiante'],
            'nombre' => $estudiante['nombre']
        );
    }

    // Devolver la lista de estudiantes en formato JSON
    header('Content-Type: application/json');
    echo json_encode($estudiantes);
} else {
    // Enviar un mensaje de error si no se proporcionaron los parámetros adecuados
    header('HTTP/1.1 400 Bad Request');
    echo "Parámetros incorrectos";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
