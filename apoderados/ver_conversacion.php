<?php include("../models/db.php") ?>
<?php


if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];

    // Obtener el ID de la conversación de la URL
    $idConversacion = $_GET['idConversacion'];

    // Obtener otras variables de la URL
    $nombre_asignatura = $_GET['nombre_asignatura'];
    $nombre_curso = $_GET['nombre_curso'];
    $rut_profesor = $_GET['rut_profesor'];
    $nombre_apoderado = $_GET['nombre_apoderado'];
    $idCurso = $_GET['idCurso'];
    $idAsignatura = $_GET['idAsignatura'];



    // Consulta para obtener el nombre del profesor
    $consultaNombreProfesor = "SELECT nombre FROM profesor WHERE rut = '$rut_profesor'";
    $resultadoNombreProfesor = mysqli_query($conexion, $consultaNombreProfesor);

    if (!$resultadoNombreProfesor) {
        die("Error en la consulta de nombre del profesor: " . mysqli_error($conexion));
    }

    $nombreProfesor = mysqli_fetch_assoc($resultadoNombreProfesor)['nombre'];

    // Consulta para obtener los mensajes de la conversación con nombres de emisor
    $consultaMensajes = "SELECT m.idMensaje, m.idEmisor, m.mensaje, m.fechaEnvio, u.nombre AS nombreEmisor
                        FROM mensajes AS m
                        INNER JOIN usuarios AS u ON m.idEmisor = u.rut
                        WHERE m.idConversacion = $idConversacion
                        ORDER BY m.fechaEnvio ASC";

    $resultadoMensajes = mysqli_query($conexion, $consultaMensajes);

    if ($resultadoMensajes) {
        echo "<h1>Conversación con $nombreProfesor</h1>";
        echo "<p>Apoderado: $nombre_apoderado</p>";
        echo "<p>Profesor: $nombreProfesor</p>";

        while ($filaMensaje = mysqli_fetch_assoc($resultadoMensajes)) {
            $idMensaje = $filaMensaje['idMensaje'];
            $idEmisor = $filaMensaje['idEmisor'];
            $mensaje = $filaMensaje['mensaje'];
            $fechaEnvio = $filaMensaje['fechaEnvio'];
            $nombreEmisor = $filaMensaje['nombreEmisor'];

            echo "<p><strong>$nombreEmisor</p>";
            echo "<p><em>Mensaje: $mensaje</em></p>";
            echo "<p><em>Fecha de Envío: $fechaEnvio</em></p>";

            // Marcar el mensaje como leído
            $marcarLeidoQuery = "UPDATE mensajes SET leido = 1 WHERE idMensaje = $idMensaje AND idReceptor = '$apoderado_rut'";
            mysqli_query($conexion, $marcarLeidoQuery);
        }            
        
        // Formulario para enviar otro mensaje
        echo "<h2>Enviar otro mensaje:</h2>";
        echo "<form method='post' action='../models/apoderadosModels/enviar_mensaje_profesor.php'>";

        

        //echo "<input type='hidden' name='rut_pupilo' value='$rut_pupilo'>";
        echo "<input type='hidden' name='nombre_asignatura' value='$nombre_asignatura'>";
        echo "<input type='hidden' name='nombre_curso' value='$nombre_curso'>";
        echo "<input type='hidden' name='rut_profesor' value='$rut_profesor'>";
        echo "<input type='hidden' name='nombre_apoderado' value='$nombre_apoderado'>";
        echo "<input type='hidden' name='idConversacion' value='$idConversacion'>";
        echo "<input type='hidden' name='idCurso' value='$idCurso'>";
        echo "<input type='hidden' name='idAsignatura' value='$idAsignatura'>";
        echo "<textarea name='mensaje' placeholder='Escribe tu mensaje aquí' rows='4' cols='50'></textarea><br>";
        echo "<input type='submit' value='Enviar mensaje a $nombreProfesor'>";
        echo "</form>";
    } else {
        echo "Error en la consulta de mensajes: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: inicioSesionApoderado.php");
    exit();
}
?>
