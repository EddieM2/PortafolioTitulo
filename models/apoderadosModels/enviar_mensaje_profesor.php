<?php include("../db.php") ?>
<?php
session_start();

if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];

    // Obtener los datos enviados desde el formulario de envío de mensaje
    $idConversacion = $_POST['idConversacion'];
    $mensaje = $_POST['mensaje'];
    //$rut_pupilo = $_POST['rut_pupilo'];
    $nombre_asignatura = $_POST['nombre_asignatura'];
    $nombre_curso = $_POST['nombre_curso'];
    $rut_profesor = $_POST['rut_profesor'];
    $nombre_apoderado = $_POST['nombre_apoderado'];
    $idCurso = $_POST['idCurso'];
    $idAsignatura = $_POST['idAsignatura'];

  
    // Consulta para obtener el nombre del apoderado
    $consultaApoderado = "SELECT nombre FROM usuarios WHERE rut = '$apoderado_rut'";
    $resultadoApoderado = mysqli_query($conexion, $consultaApoderado);

    if ($resultadoApoderado) {
        $filaApoderado = mysqli_fetch_assoc($resultadoApoderado);

        if ($filaApoderado) {
            $nombreApoderado = $filaApoderado['nombre'];

            // Consulta para obtener el ID del profesor de la conversación
            $consultaProfesor = "SELECT idReceptor FROM mensajes WHERE idConversacion = $idConversacion LIMIT 1";
            $resultadoProfesor = mysqli_query($conexion, $consultaProfesor);

            if ($resultadoProfesor) {
                $filaProfesor = mysqli_fetch_assoc($resultadoProfesor);

                if ($filaProfesor) {
                    $idProfesor = $filaProfesor['idReceptor'];

                    // Insertar el nuevo mensaje en la tabla de mensajes
                    $consultaInsertarMensaje = "INSERT INTO mensajes (idEmisor, idReceptor, mensaje, fechaEnvio, idCurso, idAsignatura, idConversacion, leido)
                    VALUES ('$apoderado_rut', '$rut_profesor', '$mensaje', NOW(), $idCurso, $idAsignatura, $idConversacion, 0)";




                    $resultadoInsertarMensaje = mysqli_query($conexion, $consultaInsertarMensaje);

                    if ($resultadoInsertarMensaje) {
                        // Mensaje enviado con éxito, redirigir a la conversación
                        header("Location: ../../apoderados/ver_conversacion.php?idConversacion=$idConversacion&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombreApoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");


                        exit();
                    } else {
                        echo "Error al enviar el mensaje: " . mysqli_error($conexion);
                    }
                } else {
                    echo "Error: Profesor no encontrado";
                }
            } else {
                echo "Error en la consulta de profesor: " . mysqli_error($conexion);
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
