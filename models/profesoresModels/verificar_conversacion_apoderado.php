<?php
session_start();
include("../db.php");

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];

// Obtener los parámetros de la URL (rutAlumno, idCurso, idAsignatura)
if (isset($_GET['rutAlumno'], $_GET['idCurso'], $_GET['idAsignatura'])) {
    $rutAlumno = $_GET['rutAlumno'];
    $idCurso = $_GET['idCurso'];
    $idAsignatura = $_GET['idAsignatura'];
} else {
    // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
    header("Location: ver_mensajes.php?idCurso=$idCurso&idAsignatura=$idAsignatura");
    exit();
}




// Obtener el RUT del apoderado del alumno seleccionado
$obtener_apoderado_query = "SELECT rutApoderado FROM alumno WHERE rut = '$rutAlumno'";
$apoderado_result = mysqli_query($conexion, $obtener_apoderado_query);

if (!$apoderado_result) {
    die("Error al obtener el RUT del apoderado: " . mysqli_error($conexion));
}

if ($apoderado_row = mysqli_fetch_assoc($apoderado_result)) {
    // Obtener el RUT del apoderado
    $apoderado_rut = $apoderado_row['rutApoderado'];
    
    // Verificar si existe una conversación entre el profesor y el apoderado de este alumno
    $verificar_conversacion_query = "SELECT idConversacion FROM mensajes 
                                     WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura
                                     AND ((idEmisor = '$apoderado_rut' AND idReceptor = '$rut_profesor') 
                                     OR (idEmisor = '$rut_profesor' AND idReceptor = '$apoderado_rut'))";
    
    $verificar_conversacion_result = mysqli_query($conexion, $verificar_conversacion_query);
    
    if (!$verificar_conversacion_result) {
        die("Error al verificar la conversación: " . mysqli_error($conexion));
    }
    
    if ($row = mysqli_fetch_assoc($verificar_conversacion_result)) {
        // Si existe una conversación, redirigir a la página de ver conversación existente
        $idConversacionExistente = $row['idConversacion'];
        header("Location: ../../profesores/ver_conversacion_profesor.php?idConversacion=$idConversacionExistente&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$apoderado_rut");
        exit();
    } else {
        header("Location: ../../profesores/enviar_mensaje_apoderado.php?rutAlumno=$rutAlumno&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$apoderado_rut");
        exit();
    }
} else {
    // No se pudo obtener el RUT del apoderado
   
    echo ("No se pudo obtener el RUT del apoderado");
}
?>
