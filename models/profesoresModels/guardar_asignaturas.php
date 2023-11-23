<?php
include("../db.php");

if (isset($_POST['guardar_asignaturas'])) {
    // Obtener datos del formulario
    $nombresAsignatura = isset($_POST['asignatura_nombre']) ? $_POST['asignatura_nombre'] : [];
    $profesoresAsignatura = isset($_POST['asignatura_profesor']) ? $_POST['asignatura_profesor'] : [];
    $idsAsignatura = isset($_POST['asignatura_id']) ? $_POST['asignatura_id'] : [];

    // Iterar sobre los datos y realizar la actualización en la base de datos
    for ($i = 0; $i < count($nombresAsignatura); $i++) {
        $nombre = mysqli_real_escape_string($conexion, $nombresAsignatura[$i]);
        $profesor = mysqli_real_escape_string($conexion, $profesoresAsignatura[$i]);

        // Verificar si la clave 'asignatura_id' está presente y no es vacía
        if (isset($idsAsignatura[$i]) && !empty($idsAsignatura[$i])) {
            $idAsignatura = mysqli_real_escape_string($conexion, $idsAsignatura[$i]);

            // Consulta SQL para actualizar la asignatura
            $query = "UPDATE asignatura SET nombre = '$nombre', rutProfesor = '$profesor' WHERE idAsignatura = $idAsignatura";
            $result = mysqli_query($conexion, $query);

            // Verificar el resultado de la consulta
            if (!$result) {
                echo "Error al actualizar las asignaturas.";
                exit;
            }
        }
    }

    // Redirigir a la página de administración con un mensaje de éxito
    header("Location: administrarCursosAsignaturas.php?success=true");
    exit();
}
?>
