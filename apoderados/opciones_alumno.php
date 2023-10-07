<?php
session_start();

// Verificar si el usuario ha iniciado sesión como apoderado
if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];

    // Rut del alumno seleccionado (enviado desde la página anterior)
    $rut_pupilo = $_POST['rut_pupilo'];

    // Conectar a la base de datos
    $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'probando2'
    );

    // Consulta para obtener el nombre y apellido paterno del apoderado
    $consultaApoderado = "SELECT nombre, apellidoP FROM apoderado WHERE rut = '$apoderado_rut'";
    $resultadoApoderado = mysqli_query($conn, $consultaApoderado);

    if ($resultadoApoderado) {
        $filaApoderado = mysqli_fetch_assoc($resultadoApoderado);

        if ($filaApoderado) {
            $nombreApoderado = $filaApoderado['nombre'];
            $apellidoPaterno = $filaApoderado['apellidoP'];

            // Consulta para obtener los datos del alumno seleccionado
            $consultaAlumno = "SELECT a.nombre, a.apellidoP, a.apellidoM, c.nombre AS nombre_curso
                               FROM alumno AS a
                               INNER JOIN inscripcion AS i ON a.rut = i.rutAlumno
                               INNER JOIN curso AS c ON i.idCurso = c.idCurso
                               WHERE a.rut = '$rut_pupilo'";
            $resultadoAlumno = mysqli_query($conn, $consultaAlumno);

            if ($resultadoAlumno) {
                $filaAlumno = mysqli_fetch_assoc($resultadoAlumno);

                if ($filaAlumno) {
                    $nombreAlumno = $filaAlumno['nombre'];
                    $apellidoPaternoAlumno = $filaAlumno['apellidoP'];
                    $apellidoMaternoAlumno = $filaAlumno['apellidoM'];
                    $nombreCurso = $filaAlumno['nombre_curso'];

                    // Mostrar los datos del alumno y el curso al que está inscrito
                    echo "Apoderado: $nombreApoderado $apellidoPaterno<br>";
                    echo "Alumno: $nombreAlumno $apellidoPaternoAlumno $apellidoMaternoAlumno<br>";
                    echo "Curso: $nombreCurso<br>";

                    // Consulta para obtener las asignaturas del alumno
                    $consultaAsignaturas = "SELECT asig.idAsignatura, asig.nombre AS nombre_asignatura, asig.rutProfesor, asig.idCurso
                                            FROM asignatura AS asig
                                            INNER JOIN inscripcion AS i ON asig.idCurso = i.idCurso
                                            WHERE i.rutAlumno = '$rut_pupilo'";
                    $resultadoAsignaturas = mysqli_query($conn, $consultaAsignaturas);

                    if ($resultadoAsignaturas) {
                        echo "Asignaturas inscritas:<br>";
                        while ($filaAsignatura = mysqli_fetch_assoc($resultadoAsignaturas)) {
                            $idAsignatura = $filaAsignatura['idAsignatura'];
                            $nombreAsignatura = $filaAsignatura['nombre_asignatura'];
                            $rutProfesor = $filaAsignatura['rutProfesor'];
                            $idCurso = $filaAsignatura['idCurso'];

                            // Consulta para obtener el nombre del profesor
                            $consultaProfesor = "SELECT nombre FROM profesor WHERE rut = '$rutProfesor'";
                            $resultadoProfesor = mysqli_query($conn, $consultaProfesor);
                            $filaProfesor = mysqli_fetch_assoc($resultadoProfesor);
                            $nombreProfesor = $filaProfesor['nombre'];

                            echo "- $nombreAsignatura (Profesor: $nombreProfesor)<br>";

                            // Redirigir al apoderado a verificar la conversación con el profesor
                            echo "<form method='post' action='verificar_conversacion.php'>";
                            echo "<input type='hidden' name='rut_pupilo' value='$rut_pupilo'>";
                            echo "<input type='hidden' name='nombre_asignatura' value='$nombreAsignatura'>";
                            echo "<input type='hidden' name='nombre_curso' value='$nombreCurso'>";
                            echo "<input type='hidden' name='rut_profesor' value='$rutProfesor'>"; // RUT del profesor
                            echo "<input type='hidden' name='nombre_apoderado' value='$nombreApoderado'>"; // Nombre del apoderado
                            echo "<input type='hidden' name='idCurso' value='$idCurso'>"; // ID del curso
                            echo "<input type='hidden' name='idAsignatura' value='$idAsignatura'>"; // ID de la asignatura
                            echo "<input type='submit' value='Verificar conversación con el profesor'>";
                            echo "</form>";
                        }
                    } else {
                        echo "Error en la consulta de asignaturas: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error: Alumno no encontrado";
                }
            } else {
                echo "Error en la consulta de alumno: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Apoderado no encontrado";
        }
    } else {
        echo "Error en la consulta de apoderado: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: inicioSesionApoderado.php");
    exit();
}
?>