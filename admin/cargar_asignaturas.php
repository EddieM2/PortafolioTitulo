<?php
// Realizar la conexión a la base de datos
include("../models/db.php");

// Cargar asignaturas para el curso seleccionado
if (isset($_GET['curso'])) {
    $cursoId = $_GET['curso'];

    // Realiza la consulta a la base de datos para obtener las asignaturas de este curso
    $consultaAsignaturas = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $cursoId";
    $resultadoAsignaturas = mysqli_query($conexion, $consultaAsignaturas);

    // Verifica si la consulta fue exitosa
    if ($resultadoAsignaturas) {
        $asignaturas = array();
        while ($row = mysqli_fetch_assoc($resultadoAsignaturas)) {
            $asignaturas[] = array(
                'id' => $row['idAsignatura'],
                'nombre' => $row['nombre']
            );
        }

        // Devuelve las asignaturas como respuesta JSON
        echo json_encode($asignaturas);
    } else {
        echo json_encode(array('error' => 'Error en la consulta SQL.'));
    }
} else {
    // Si no se proporciona el parámetro "curso," devuelve un mensaje de error
    echo json_encode(array('error' => 'Curso no proporcionado.'));
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);


?>
