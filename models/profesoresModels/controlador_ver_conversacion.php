<?php
session_start();

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];

// Obtener los demás parámetros necesarios de la conversación desde la solicitud POST
if (isset($_POST['mensaje']) && isset($_POST['idConversacion']) && isset($_POST['idCurso']) && isset($_POST['idAsignatura']) && isset($_POST['idEmisor'])) {
    $mensaje_a_enviar = $_POST['mensaje'];
    $idConversacion = $_POST['idConversacion'];
    $idCurso = $_POST['idCurso'];
    $idAsignatura = $_POST['idAsignatura'];
    $idEmisor = $_POST['idEmisor'];
} else {
    // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
    
    exit();
}

// Conectar a la base de datos (ajusta la configuración de conexión según tu entorno)
$conn = mysqli_connect('localhost', 'root', '', 'probando2');

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Insertar el nuevo mensaje en la base de datos con la misma idConversacion
$insertar_mensaje_query = "INSERT INTO mensajes (idConversacion, idCurso, idAsignatura, idEmisor, idReceptor, mensaje, fechaenvio, leido)
                      VALUES ('$idConversacion', '$idCurso', '$idAsignatura', '$rut_profesor','$idEmisor', '$mensaje_a_enviar', NOW(), 0)";

$resultado_insertar_mensaje = mysqli_query($conn, $insertar_mensaje_query);

if (!$resultado_insertar_mensaje) {
    die("Error al enviar el mensaje: " . mysqli_error($conn));
}

// Redirigir de vuelta a la página de ver_conversacion.php después de enviar el mensaje

// Redirigir de vuelta a la página de ver_conversacion.php después de enviar el mensaje
header("../profesores/ver_conversacion_profesor.php?idConversacion=$idConversacion&idCurso=$idCurso&idAsignatura=$idAsignatura&idEmisor=$idEmisor");
exit();
?>
