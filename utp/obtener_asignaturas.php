<?php
// Conexión a la base de datos
include("../models/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del curso seleccionado
    $selectedCurso = $_POST["curso"];

    // Consulta SQL para obtener las asignaturas relacionadas con el curso seleccionado
    $queryAsignaturas = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $selectedCurso";
    $resultAsignaturas = mysqli_query($conexion, $queryAsignaturas);

    if ($resultAsignaturas) {
        // Construye las opciones de asignaturas
        $options = "<option value=''>Selecciona una asignatura</option>";
        while ($rowAsignatura = mysqli_fetch_assoc($resultAsignaturas)) {
            $idAsignatura = $rowAsignatura['idAsignatura'];
            $nombreAsignatura = $rowAsignatura['nombre'];
            $options .= "<option value='$idAsignatura'>$nombreAsignatura</option>";
        }

        // Devuelve las opciones de asignaturas
        echo $options;
    } else {
        echo "<option value=''>No se encontraron asignaturas</option>";
    }
} else {
    echo "<option value=''>Solicitud no válida</option>";
}
?>
