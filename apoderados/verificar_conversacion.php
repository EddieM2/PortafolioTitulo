<?php include("../models/db.php") ?>
<?php
if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];
    // Obtener los datos enviados desde el formulario de envío de mensaje
    $rut_pupilo = $_POST['rut_pupilo'];
    $nombre_asignatura = $_POST['nombre_asignatura'];
    $nombre_curso = $_POST['nombre_curso'];
    $rut_profesor = $_POST['rut_profesor'];
    $nombre_apoderado = $_POST['nombre_apoderado'];
    $idCurso = $_POST['idCurso'];
    $idAsignatura = $_POST['idAsignatura'];
    $mensaje = $_POST['mensaje'];

    // Consulta para verificar si existe una conversación con el profesor como emisor
    $consultaConversacionProfesorEmisor = "SELECT idConversacion FROM mensajes 
                         WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                         AND idEmisor = '$rut_profesor' AND idReceptor = '$apoderado_rut'";

    $resultadoConversacionProfesorEmisor = mysqli_query($conexion, $consultaConversacionProfesorEmisor);

    if ($resultadoConversacionProfesorEmisor) {
        $filaConversacionProfesorEmisor = mysqli_fetch_assoc($resultadoConversacionProfesorEmisor);

        if ($filaConversacionProfesorEmisor) {
            // Existe una conversación, obtener el ID de la conversación
            $idConversacion = $filaConversacionProfesorEmisor['idConversacion'];

            // Redirigir a la página de visualización de mensajes
            header("Location: ver_conversacion.php?idConversacion=$idConversacion&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");
            exit();
        }
    } else {
        echo "Error en la consulta de conversación: " . mysqli_error($conexion);
        exit();
    }

    // Si no existe una conversación con el profesor como emisor, realizar la consulta con el apoderado como emisor
    $consultaConversacionApoderadoEmisor = "SELECT idConversacion FROM mensajes 
                         WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                         AND idEmisor = '$apoderado_rut' AND idReceptor = '$rut_profesor'";

    $resultadoConversacionApoderadoEmisor = mysqli_query($conexion, $consultaConversacionApoderadoEmisor);

    if ($resultadoConversacionApoderadoEmisor) {
        $filaConversacionApoderadoEmisor = mysqli_fetch_assoc($resultadoConversacionApoderadoEmisor);

        if ($filaConversacionApoderadoEmisor) {
            // Existe una conversación, obtener el ID de la conversación
            $idConversacion = $filaConversacionApoderadoEmisor['idConversacion'];

            // Redirigir a la página de visualización de mensajes
            header("Location: ver_conversacion.php?idConversacion=$idConversacion&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");
            exit();
        } else {
            // No existe una conversación previa, mostrar un formulario para enviar mensaje
            header("Location: enviar_mensaje.php?rut_pupilo=$rut_pupilo&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");
            exit();
        }
    } else {
        echo "Error en la consulta de conversación: " . mysqli_error($conexion);
        exit();
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    //header("Location: inicioSesionApoderado.php");
  //  exit();
}
?>
