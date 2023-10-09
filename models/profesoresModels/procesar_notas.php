<?php
include("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se han proporcionado los parámetros necesarios
    if (isset($_POST['asignatura_id']) && isset($_POST['idCurso']) && isset($_POST['calificaciones'])) {
        $asignatura_id = $_POST['asignatura_id'];
        $idCurso = $_POST['idCurso'];
        $calificaciones = $_POST['calificaciones'];

        // Obtiene el RUT del profesor de la sesión (asumiendo que está almacenado en la sesión)
        $profesor_rut = $_SESSION['rut'];

        // Itera a través de las calificaciones y las guarda en la base de datos
        foreach ($calificaciones as $rut_alumno => $notas) {
            // Asegúrate de validar y sanitizar los datos antes de ejecutar la consulta en un entorno de producción
            $nota1 = isset($notas['calificacion1']) ? floatval($notas['calificacion1']) : 0.0;
            $nota2 = isset($notas['calificacion2']) ? floatval($notas['calificacion2']) : 0.0;
            $nota3 = isset($notas['calificacion3']) ? floatval($notas['calificacion3']) : 0.0;
            $nota4 = isset($notas['calificacion4']) ? floatval($notas['calificacion4']) : 0.0;

            // Verifica si ya existen calificaciones para este alumno y esta asignatura
            $query_verificar_calificaciones = "SELECT * FROM calificaciones WHERE idAlumno = '$rut_alumno' AND idAsignatura = '$asignatura_id' AND idCurso = '$idCurso'";
            $result_verificar_calificaciones = mysqli_query($conexion, $query_verificar_calificaciones);

            if (mysqli_num_rows($result_verificar_calificaciones) > 0) {
                // Si ya existen calificaciones, realiza una actualización en lugar de una inserción
                $query_actualizar_calificaciones = "UPDATE calificaciones SET calificacion1 = '$nota1', calificacion2 = '$nota2', calificacion3 = '$nota3', calificacion4 = '$nota4', fecha = NOW() WHERE idAlumno = '$rut_alumno' AND idAsignatura = '$asignatura_id' AND idCurso = '$idCurso'";
                $result_actualizar_calificaciones = mysqli_query($conexion, $query_actualizar_calificaciones);

                if (!$result_actualizar_calificaciones) {
                    echo "Error al actualizar las calificaciones para el alumno con RUT $rut_alumno.";
                }
            } else {
                // Si no existen calificaciones, realiza una inserción
                $query_insertar_calificaciones = "INSERT INTO calificaciones (idAlumno, idProfesor, idAsignatura, calificacion1, calificacion2, calificacion3, calificacion4, fecha, idCurso) 
                                                VALUES ('$rut_alumno', '$profesor_rut', '$asignatura_id', '$nota1', '$nota2', '$nota3', '$nota4', NOW(), '$idCurso')";

                $result_insertar_calificaciones = mysqli_query($conexion, $query_insertar_calificaciones);

                if (!$result_insertar_calificaciones) {
                    echo "Error al insertar las calificaciones para el alumno con RUT $rut_alumno.";
                }
            }
        }

        // Redirige de vuelta a la página de ingreso de notas con un mensaje de éxito
        header("Location: ingresar_notas.php?asignatura=$asignatura_id&idCurso=$idCurso&success=true");
        exit();
    } else {
        // Falta uno o más parámetros necesarios
        echo "Faltan parámetros necesarios para procesar las notas.";
    }
} else {
    // Redirige si no se recibió una solicitud POST
    header("Location: ingresar_notas.php");
    exit();
}
?>
