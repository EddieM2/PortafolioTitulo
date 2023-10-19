<?php include("../models/db.php") ?>
<?php



// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];

// Obtener los parámetros de la URL (rutAlumno, idCurso, idAsignatura)
if (isset($_GET['rutAlumno']) && isset($_GET['idCurso']) && isset($_GET['idAsignatura'])) {
    $rutAlumno = $_GET['rutAlumno'];
    $idCurso = $_GET['idCurso'];
    $idAsignatura = $_GET['idAsignatura'];
} else {
    // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
    header("Location: ver_mensajes.php?idCurso=$idCurso&idAsignatura=$idAsignatura");
    exit();
}

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el RUT del apoderado del alumno seleccionado
$obtener_apoderado_query = "SELECT rutApoderado FROM alumno WHERE rut = '$rutAlumno'";
$apoderado_result = mysqli_query($conn, $obtener_apoderado_query);

if (!$apoderado_result) {
    die("Error al obtener el RUT del apoderado: " . mysqli_error($conn));
}

if ($apoderado_row = mysqli_fetch_assoc($apoderado_result)) {
    // Obtener el RUT del apoderado
    $apoderado_rut = $apoderado_row['rutApoderado'];
    
    // Verificar si existe una conversación entre el profesor y el apoderado de este alumno
    $verificar_conversacion_query = "SELECT idConversacion FROM mensajes 
                                     WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                                     AND idEmisor = '$apoderado_rut' AND idReceptor = '$rut_profesor'";
    
    $verificar_conversacion_result = mysqli_query($conn, $verificar_conversacion_query);
    
    if (!$verificar_conversacion_result) {
        die("Error al verificar la conversación: " . mysqli_error($conn));
    }
    
    if ($row = mysqli_fetch_assoc($verificar_conversacion_result)) {
        // Si existe una conversación, redirigir a la página de ver conversación existente
        $idConversacionExistente = $row['idConversacion'];
        header("Location: ver_conversacion_profesor.php?idConversacion=$idConversacionExistente&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$apoderado_rut");
        exit();
    } else {
        // Si no existe una conversación, redirigir al formulario para enviar un nuevo mensaje
        header("Location: enviar_mensaje_apoderado.php?rutAlumno=$rutAlumno&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$apoderado_rut");
        exit();
    }
} else {
    // No se pudo obtener el RUT del apoderado
    // Maneja este caso de acuerdo a tus necesidades, como mostrar un mensaje de error o redirigir a una página específica.
}
?>