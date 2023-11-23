<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

include("../models/db.php");

function haRecibidoNotificacion($conexion, $rutEstudiante, $idAsignatura, $calificacionTipo) {
    $consulta = "SELECT * FROM notificaciones WHERE rutEstudiante = '$rutEstudiante' AND asignatura = '$idAsignatura' AND calificacion_tipo = '$calificacionTipo'";
    $resultado = $conexion->query($consulta);
    return $resultado->num_rows > 0;
}

function enviarNotificacion($conexion, $rutEstudiante, $rutApoderado, $nombreEstudiante, $nombreAsignatura, $idAsignatura, $calificacionTipo) {
    
    $fechaActual = date("Y-m-d");

    if (!haRecibidoNotificacion($conexion, $rutEstudiante, $idAsignatura, $calificacionTipo)) {
        $consulta_apoderado = "SELECT correo FROM apoderado WHERE rut = '$rutApoderado'";
        $resultado_apoderado = $conexion->query($consulta_apoderado);

        if ($resultado_apoderado->num_rows > 0) {
            $fila_apoderado = $resultado_apoderado->fetch_assoc();
            $correoApoderado = $fila_apoderado['correo'];

            
            $insertarNotificacion = "INSERT INTO notificaciones (rutEstudiante, calificacion_tipo, fechaUltimoCorreo, asignatura) 
                            VALUES ('$rutEstudiante', '$calificacionTipo', '$fechaActual', '$idAsignatura')";
            $conexion->query($insertarNotificacion);

            
            $mensaje = "Estimado apoderado,\n\nEl estudiante $nombreEstudiante ha obtenido una calificación por debajo de 4.0 en la asignatura $nombreAsignatura (Calificación Tipo: $calificacionTipo). Por favor, póngase en contacto con la institución educativa para discutir el rendimiento académico de su hijo(a).";


            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'marcelo26atenas@gmail.com'; 
                $mail->Password = 'phvo osum kwpj bknx'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('marcelo26atenas@gmail.com', 'Escuela'); // Reemplaza con tu nombre y correo
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
    }
}

$consulta = "SELECT a.rut AS estudiante_rut, a.nombre AS estudiante_nombre, a.rutApoderado, 
                c.calificacion1, c.calificacion2, c.calificacion3, c.calificacion4, asignatura.idAsignatura AS id_asignatura, asignatura.nombre AS nombreAsignatura
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
        $idAsignatura = $fila['id_asignatura'];
        $nombreAsignatura = $fila['nombreAsignatura'];

        if ($estudiante_rut != $estudiante_anterior) {
            $estudiante_anterior = $estudiante_rut;
        }

        if ($calificacion1 < 4.00) {
            if (!empty($rutApoderado)) {
                enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $nombreAsignatura, $idAsignatura, 'calificacion1');
            }
        }
        if ($calificacion2 < 4.00) {
            if (!empty($rutApoderado)) {
                enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $nombreAsignatura, $idAsignatura, 'calificacion2');
            }
        }
        if ($calificacion3 < 4.00) {
            if (!empty($rutApoderado)) {
                enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $nombreAsignatura, $idAsignatura, 'calificacion3');
            }
        }
        if ($calificacion4 < 4.00) {
            if (!empty($rutApoderado)) {
                enviarNotificacion($conexion, $estudiante_rut, $rutApoderado, $estudiante_nombre, $nombreAsignatura, $idAsignatura, 'calificacion4');
            }
        }
    }
} else {
    echo "No se encontraron calificaciones en la base de datos.";
}

$conexion->close();
