<?php

session_start();

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

    

    // Consulta para verificar si existe una conversación con el profesor
    $consultaConversacion = "SELECT idConversacion FROM mensajes 
                             WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                             AND idEmisor = '$apoderado_rut' AND idReceptor = '$rut_profesor'";

    $resultadoConversacion = mysqli_query($conn, $consultaConversacion);

    if ($resultadoConversacion) {
        $filaConversacion = mysqli_fetch_assoc($resultadoConversacion);

        if ($filaConversacion) {
            // Existe una conversación, obtener el ID de la conversación
            $idConversacion = $filaConversacion['idConversacion'];

            // Redirigir a la página de visualización de mensajes
            header("Location: ../../apoderados/ver_conversacion.php?idConversacion=$idConversacion&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");
            exit()
        } else {
            // No existe una conversación previa, mostrar un formulario para enviar mensaje
            header("Location: ../../enviar_mensaje.php?rut_pupilo=$rut_pupilo&nombre_asignatura=$nombre_asignatura&nombre_curso=$nombre_curso&rut_profesor=$rut_profesor&nombre_apoderado=$nombre_apoderado&idCurso=$idCurso&idAsignatura=$idAsignatura");
            exit();
        }
    } else {
        echo "Error en la consulta de conversación: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: inicioSesionApoderado.php");
    exit();
}
?>