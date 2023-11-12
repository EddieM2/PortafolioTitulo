<?php include("../db.php") ?>

<?php
session_start();

// Obtener el RUT del profesor desde la sesión
$rut_Profesor = $_SESSION['rut'];

// Obtener los datos del formulario (rutAlumno, rut_Apoderado, idCurso, idAsignatura, mensaje)
if (isset($_POST['rutAlumno'], $_POST['rut_Apoderado'], $_POST['idCurso'], $_POST['idAsignatura'], $_POST['mensaje'])) {
    $rutAlumno = $_POST['rutAlumno'];
    $rut_Apoderado = $_POST['rut_Apoderado'];
    $idCurso = $_POST['idCurso'];
    $idAsignatura = $_POST['idAsignatura'];
    $mensaje = $_POST['mensaje'];
} else {
    // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
    header("Location: ver_mensajes.php?idCurso=$idCurso&idAsignatura=$idAsignatura");
    exit();
}

// Conectar a la base de datos (ajusta la configuración de conexión según tu entorno)

// Verificar si existe una conversación entre el profesor y el apoderado de este alumno
$verificar_conversacion_query = "SELECT idConversacion FROM mensajes 
                                 WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                                 AND ((idEmisor = '$rut_Profesor' AND idReceptor = '$rut_Apoderado') 
                                 OR (idEmisor = '$rut_Apoderado' AND idReceptor = '$rut_Profesor'))";

$verificar_conversacion_result = mysqli_query($conexion, $verificar_conversacion_query);

if (!$verificar_conversacion_result) {
    die("Error al verificar la conversación: " . mysqli_error($conexion));
}

if ($row = mysqli_fetch_assoc($verificar_conversacion_result)) {
    // Si existe una conversación, redirigir a la página de ver conversación existente
    $idConversacionExistente = $row['idConversacion'];
    // Redirigir a la página de ver conversación existente con la URL completa
    header("Location: ../../profesores/ver_conversacion_profesor.php?idConversacion=$idConversacionExistente&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$rut_Apoderado");
    exit();
} else {
    // Si no existe una conversación, crear una nueva conversación y luego redirigir
    $crear_conversacion_query = "INSERT INTO conversaciones (idUsuario1, idUsuario2)
                                VALUES ('$rut_Apoderado', '$rut_Profesor')";
    
    if (mysqli_query($conexion, $crear_conversacion_query)) {
        // Obtener el ID de la conversación recién creada
        $idConversacion = mysqli_insert_id($conexion);
        
        // Insertar el mensaje en la base de datos
        $insertar_mensaje_query = "INSERT INTO mensajes (idConversacion, idCurso, idAsignatura, idEmisor, idReceptor, mensaje, leido)
                                   VALUES ('$idConversacion', '$idCurso', '$idAsignatura', '$rut_Profesor', '$rut_Apoderado', '$mensaje', 0)";
        
        if (mysqli_query($conexion, $insertar_mensaje_query)) {
            // Éxito al enviar el mensaje, redirigir a la página de ver conversación
            header("Location: ../../portafolioTitulo3/profesores/ver_conversacion_profesor.php?idConversacion=$idConversacion&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$rut_Apoderado");
            exit();
        } else {
            // Error al enviar el mensaje, manejar de acuerdo a tus necesidades
            echo "Error al enviar el mensaje: " . mysqli_error($conexion);
        }
    } else {
        // Error al crear la conversación, manejar de acuerdo a tus necesidades
        echo "Error al crear la conversación: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
