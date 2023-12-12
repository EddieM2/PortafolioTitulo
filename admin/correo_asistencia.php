<?php
//conexion a la base de datos
include("../models/db.php");

// Consulta para obtener los datos de los estudiantes que faltaron a clases
$query = "SELECT a.rut AS alumno_rut, a.nombre AS alumno_nombre, a.apellidoP AS alumno_apellidoP, a.correo AS alumno_correo,
                 ap.nombre AS apoderado_nombre, ap.apellidoP AS apoderado_apellidoP, ap.correo AS apoderado_correo,
                 asi.fecha AS fecha_falta
          FROM asistencia AS asi
          JOIN alumno AS a ON asi.rutAlumno = a.rut
          JOIN apoderado AS ap ON a.rutApoderado = ap.rut
          WHERE asi.presente = 0";

// Realiza la consulta a la base de datos
$result = $conexion->query($query);

// Configuración de SMTP
$smtp_server = '';
$smtp_port = ; // Puerto SMTP
$smtp_username = 'notificaciones@proyectocolaborativo.cl'; // Nombre de usuario del correo
$smtp_password = ''; // Contraseña del correo
$smtp_timeout = 30; // Tiempo de espera (opcional)

// Configura el servidor SMTP
ini_set('SMTP', $smtp_server);
ini_set('smtp_port', $smtp_port);

while ($row = $result->fetch_assoc()) {
    $alumno_rut = $row['alumno_rut'];
    $alumno_nombre = $row['alumno_nombre'];
    $alumno_apellidoP = $row['alumno_apellidoP'];
    $alumno_correo = $row['alumno_correo'];
    $apoderado_nombre = $row['apoderado_nombre'];
    $apoderado_apellidoP = $row['apoderado_apellidoP'];
    $apoderado_correo = $row['apoderado_correo'];
    $fecha_falta = $row['fecha_falta'];

    // Verificar si se envió un correo en la misma fecha
    $consultaFechaCorreo = "SELECT * FROM fecha_ultimo_correo WHERE rutEstudiante = '$alumno_rut' AND fecha = '$fecha_falta'";
    $resultadoFechaCorreo = $conexion->query($consultaFechaCorreo);

    if ($resultadoFechaCorreo->num_rows === 0) {
        // No se envió un correo en la misma fecha, puedes enviar el correo
        $mensaje = "Estimado apoderado $apoderado_nombre $apoderado_apellidoP,\n\nEl estudiante $alumno_nombre $alumno_apellidoP faltó a clases el $fecha_falta. Por favor, póngase en contacto con la institución educativa para discutir la asistencia de su hijo(a).";

        // Configuración de SMTP
        $smtp_server = 'srv13.cpanelhost.cl';
        $smtp_port = 465; // Puerto SMTP
        $smtp_username = 'notificaciones@proyectocolaborativo.cl'; // Nombre de usuario del correo
        $smtp_password = 'b*pjG~=}tsF_'; // Contraseña del correo
        $smtp_timeout = 30; // Tiempo de espera (opcional)

        // Configura el servidor SMTP
        ini_set('SMTP', $smtp_server);
        ini_set('smtp_port', $smtp_port);

        // Configuración del correo
        $asunto = 'Informe de Falta de Asistencia';
        $headers = 'From: notificaciones@proyectocolaborativo.cl' . "\r\n" .
                   'Reply-To: notificaciones@proyectocolaborativo.cl' . "\r\n";

        // Envía el correo utilizando la función mail() con la configuración de SMTP
        if (mail($apoderado_correo, $asunto, $mensaje, $headers)) {
            echo 'El correo ha sido enviado al apoderado correctamente.';
        } else {
            echo 'Error al enviar el correo.';
        }

        // Registrar la fecha del último correo en la tabla fecha_ultimo_correo
        $insertarFechaCorreo = "INSERT INTO fecha_ultimo_correo (rutEstudiante, fecha) VALUES ('$alumno_rut', '$fecha_falta')";
        $conexion->query($insertarFechaCorreo);

        echo "Correo enviado al apoderado $apoderado_nombre $apoderado_apellidoP.<br>";
    } else {
        echo "El correo del apoderado está vacío o no es válido.";
    }
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
