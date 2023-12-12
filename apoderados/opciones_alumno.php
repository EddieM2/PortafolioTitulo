<?php include("../models/db.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apoderado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
    <style>
        body { padding-top: 20px; }
        .container { overflow: auto; max-height: 80vh; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <?php include("../models/db.php") ?>
                <?php
                // Verificar si el usuario ha iniciado sesión como apoderado
                if (isset($_SESSION['rut'])) {
                    $apoderado_rut = $_SESSION['rut'];
                    // Rut del alumno seleccionado 
                    $rut_pupilo = $_POST['rut_pupilo'];
                    // Consulta para obtener el nombre y apellido paterno del apoderado
                    $consultaApoderado = "SELECT nombre, apellidoP FROM apoderado WHERE rut = '$apoderado_rut'";
                    $resultadoApoderado = mysqli_query($conexion, $consultaApoderado);
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
                            $resultadoAlumno = mysqli_query($conexion, $consultaAlumno);
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
                                    $resultadoAsignaturas = mysqli_query($conexion, $consultaAsignaturas);
                                    if ($resultadoAsignaturas) {
                                        echo "Asignaturas inscritas:<br>";
                                        while ($filaAsignatura = mysqli_fetch_assoc($resultadoAsignaturas)) {
                                            $idAsignatura = $filaAsignatura['idAsignatura'];
                                            $nombreAsignatura = $filaAsignatura['nombre_asignatura'];
                                            $rutProfesor = $filaAsignatura['rutProfesor'];
                                            $idCurso = $filaAsignatura['idCurso'];
                                            // Consulta para obtener el nombre del profesor
                                            $consultaProfesor = "SELECT nombre FROM profesor WHERE rut = '$rutProfesor'";
                                            $resultadoProfesor = mysqli_query($conexion, $consultaProfesor);
                                            $filaProfesor = mysqli_fetch_assoc($resultadoProfesor);
                                            $nombreProfesor = $filaProfesor['nombre'];
                                            // Consulta para obtener la cantidad de mensajes no leídos en esta asignatura
                                            $consultaMensajesNoLeidos = "SELECT COUNT(*) AS cantidad FROM mensajes WHERE idCurso = '$idCurso' AND idAsignatura = '$idAsignatura' AND leido = 0 AND idReceptor = $apoderado_rut";
                                            $resultadoMensajesNoLeidos = mysqli_query($conexion, $consultaMensajesNoLeidos);
                                            $filaMensajesNoLeidos = mysqli_fetch_assoc($resultadoMensajesNoLeidos);
                                            $cantidadMensajesNoLeidos = $filaMensajesNoLeidos['cantidad'];
                                    
                                            echo "- $nombreAsignatura (Profesor: $nombreProfesor) - Mensajes no leídos: $cantidadMensajesNoLeidos<br>";
                                            // Redirigir al apoderado a verificar la conversación con el profesor
                                            echo "<form method='post' action='verificar_conversacion.php'>";
                                            echo "<input type='hidden' name='rut_pupilo' value='$rut_pupilo'>";
                                            echo "<input type='hidden' name='nombre_asignatura' value='$nombreAsignatura'>";
                                            echo "<input type='hidden' name='nombre_curso' value='$nombreCurso'>";
                                            echo "<input type='hidden' name='rut_profesor' value='$rutProfesor'>"; 
                                            echo "<input type='hidden' name='nombre_apoderado' value='$nombreApoderado'>"; 
                                            echo "<input type='hidden' name='idCurso' value='$idCurso'>"; 
                                            echo "<input type='hidden' name='idAsignatura' value='$idAsignatura'>";
                                            echo '<button type="submit" class="btn btn-primary">Verificar conversación con el profesor</button>';
                                            echo "</form>";
                                        }
                                    } else {
                                        echo "Error en la consulta de asignaturas: " . mysqli_error($conexion);
                                    }
                                } else {
                                    echo "Error: Alumno no encontrado";
                                }
                            } else {
                                echo "Error en la consulta de alumno: " . mysqli_error($conexion);
                            }
                        } else {
                            echo "Error: Apoderado no encontrado";
                        }
                    } else {
                        echo "Error en la consulta de apoderado: " . mysqli_error($conexion);
                    }
                
                    // Cerrar la conexión a la base de datos
                    mysqli_close($conexion);
                } else {
                    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
                    header("Location: inicioSesionApoderado.php");
                    exit();
                }
                ?>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="inicioSesionApoderado.php">Cerrar sesión</a>
</body>
</html>
