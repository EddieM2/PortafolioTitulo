<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

include("../models/db.php");

function haRecibidoNotificacion($conexion, $rutEstudiante, $asignatura, $calificacionTipo) {
    $consulta = "SELECT * FROM notificaciones WHERE rutEstudiante = '$rutEstudiante' AND asignatura = '$asignatura' AND calificacion_tipo = '$calificacionTipo'";
    $resultado = $conexion->query($consulta);
    return $resultado->num_rows > 0;
}

function enviarNotificacion($conexion, $rutEstudiante, $rutApoderado, $nombreEstudiante, $asignatura, $calificacionTipo) {
    $consulta_apoderado = "SELECT correo FROM apoderado WHERE rut = '$rutApoderado'";
    $resultado_apoderado = $conexion->query($consulta_apoderado);

    if ($resultado_apoderado->num_rows > 0) {
        $fila_apoderado = $resultado_apoderado->fetch_assoc();
        $correoApoderado = $fila_apoderado['correo'];

        if (!empty($correoApoderado)) {
            $mensaje = "Estimado apoderado,\n\nEl estudiante $nombreEstudiante ha obtenido calificaciones por debajo de 4.0 en la asignatura $asignatura (Calificación Tipo: $calificacionTipo). Por favor, póngase en contacto con la institución educativa para discutir el rendimiento académico de su hijo(a).";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tu_correo@gmail.com'; // Reemplaza con tu correo
                $mail->Password = 'tu_contraseña'; // Reemplaza con tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tu_correo@gmail.com', 'Tu Nombre'); // Reemplaza con tu nombre y correo
                $mail->addAddress($correoApoderado, 'Apoderado');

                $mail->isHTML(false);
                $mail->Subject = 'Informe de Rendimiento Académico';
                $mail->Body = $mensaje;

                $mail->send();
                echo 'El correo ha sido enviado al apoderado correctamente.';
            } catch (Exception $e) {
                echo 'Error al enviar el correo: ' . $e->getMessage();
            }
        } else {
            echo "El correo del apoderado está vacío o no es válido.";
        }

        $fechaActual = date("Y-m-d");
        $insertarNotificacion = "INSERT INTO notificaciones (rutEstudiante, calificacion_tipo, fechaUltimoCorreo, asignatura) 
                            VALUES ('$rutEstudiante', '$calificacionTipo', '$fechaActual', '$asignatura')";
        $conexion->query($insertarNotificacion);
    }
}

$consulta = "SELECT a.rut AS estudiante_rut, a.nombre AS estudiante_nombre, a.rutApoderado, 
                c.calificacion1, c.calificacion2, c.calificacion3, c.calificacion4, asignatura.nombre AS nombre_asignatura
            FROM calificaciones c
            JOIN alumno a ON c.idAlumno = a.rut
            JOIN asignatura ON c.idAsignatura = asignatura.idAsignatura
            ORDER BY a.rut, asignatura.idAsignatura, c.fecha";

$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $estudiante_anterior = null;
    $asignatura_anterior = null;

    while ($fila = $resultado->fetch_assoc()) {
        $estudiante_rut = $fila['estudiante_rut'];
        $estudiante_nombre = $fila['estudiante_nombre'];
        $rutApoderado = $fila['rutApoderado'];
        $calificacion1 = $fila['calificacion1'];
        $calificacion2 = $fila['calificacion2'];
        $calificacion3 = $fila['calificacion3'];
        $calificacion4 = $fila['calificacion4'];
        $asignatura = $fila['nombre_asignatura'];

        if ($estudiante_rut != $estudiante_anterior || $asignatura != $asignatura_anterior) {
            $estudiante_anterior = $estudiante_rut;
            $asignatura_anterior = $asignatura;
        }

        if (
            ($calificacion1 < 4.00 || $calificacion2 < 4.00 || $calificacion3 < 4.00 || $calificacion4 < 4.00)
        ) {
            if (!haRecibidoNotificacion($conexion, $estudiante_rut, $asignatura, 'calificacion1')) {
                if (!empty($rutApoderado)) {
                    enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $asignatura, 'calificacion1');
                }
            } elseif (!haRecibidoNotificacion($conexion, $estudiante_rut, $asignatura, 'calificacion2')) {
                if (!empty($rutApoderado)) {
                    enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $asignatura, 'calificacion2');
                }
            } elseif (!haRecibidoNotificacion($conexion, $estudiante_rut, $asignatura, 'calificacion3')) {
                if (!empty($rutApoderado)) {
                    enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $asignatura, 'calificacion3');
                }
            } elseif (!haRecibidoNotificacion($conexion, $estudiante_rut, $asignatura, 'calificacion4')) {
                if (!empty($rutApoderado)) {
                    enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $asignatura, 'calificacion4');
                }
            }
        }
    }
} else {
    echo "No se encontraron calificaciones en la base de datos.";
}

$conexion->close();
?>

$conexion->close();
?>