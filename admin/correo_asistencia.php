<?php
// Configuración de la conexión a la base de datos
// Configuración de la conexión a la base de datos
include("../models/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

// Configuración de PHPMailer para enviar correos
require 'PHPMailer.php';
require 'SMTP.php';

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

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'marcelo26atenas@gmail.com'; // Reemplaza con tu correo
            $mail->Password = 'phvo osum kwpj bknx'; // Reemplaza con tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('marcelo26atenas@gmail.com', 'Escuela'); // Reemplaza con tu nombre y correo
            $mail->addAddress($apoderado_correo, 'Apoderado');

            $mail->isHTML(false);
            $mail->Subject = 'Informe de Falta de Asistencia';
            $mail->Body = $mensaje;

            $mail->send();
            
            // Registrar la fecha del último correo en la tabla fecha_ultimo_correo
            $insertarFechaCorreo = "INSERT INTO fecha_ultimo_correo (rutEstudiante, fecha) VALUES ('$alumno_rut', '$fecha_falta')";
            $conexion->query($insertarFechaCorreo);
            
            echo "Correo enviado al apoderado $apoderado_nombre $apoderado_apellidoP.<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo: ' . $e->getMessage();
        }
    } else {
        // Ya se envió un correo en la misma fecha, omitir el envío
        echo "Correo ya enviado en la misma fecha al apoderado $apoderado_nombre $apoderado_apellidoP.<br>";
    }
}

// Cierra la conexión a la base de datos
$conexion->close();