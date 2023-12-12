<?php include("../db.php") ?>
<?php


if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];

    // Obtener los datos enviados desde el formulario de envío de mensaje
    //$rut_pupilo = $_POST['rut_pupilo'];
    $nombre_asignatura = $_POST['nombre_asignatura'];
    $nombre_curso = $_POST['nombre_curso'];
    $rut_profesor = $_POST['rut_profesor'];
    $nombre_apoderado = $_POST['nombre_apoderado'];
    $idCurso = $_POST['idCurso'];
    $idAsignatura = $_POST['idAsignatura'];
    $mensaje = $_POST['mensaje'];



    // Insertar un nuevo registro en la tabla de conversaciones
    $consultaInsertarConversacion = "INSERT INTO conversaciones (IdUsuario1, IdUsuario2)
                                     VALUES ('$apoderado_rut', '$rut_profesor')";

    $resultadoInsertarConversacion = mysqli_query($conexion, $consultaInsertarConversacion);

    if ($resultadoInsertarConversacion) {
        // Obtener el ID de la conversación recién creada
        $idConversacion = mysqli_insert_id($conexion);

        // Insertar el nuevo mensaje en la tabla de mensajes
        $consultaInsertarMensaje = "INSERT INTO mensajes (idEmisor, idReceptor, mensaje, fechaEnvio, idCurso, idAsignatura, idConversacion)
                                     VALUES ('$apoderado_rut', '$rut_profesor', '$mensaje', NOW(), $idCurso, $idAsignatura, $idConversacion)";

        $resultadoInsertarMensaje = mysqli_query($conexion, $consultaInsertarMensaje);

        if ($resultadoInsertarMensaje) {
            // Mensaje enviado con éxito, redirigir a la página de visualización de mensajes
            header("Location: ../../apoderados/ver_conversacion.php?idConversacion=$idConversacion&rut_pupilo=$rut_pupilo&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura&mensaje=$mensaje");
exit();

            exit();
            
            
        } else {
            echo "Error al enviar el mensaje: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al iniciar la conversación: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: inicioSesionApoderado.php");
    exit();
}
?>
