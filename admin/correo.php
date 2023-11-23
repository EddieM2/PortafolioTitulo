<?php
include("../models/db.php");


$consulta = "SELECT a.rut AS estudiante_rut, a.nombre AS estudiante_nombre, a.rutApoderado, c.calificacion1, c.calificacion2
             FROM calificaciones c
             JOIN alumno a ON c.idAlumno = a.rut
             ORDER BY a.rut, c.fecha";

$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $estudiante_anterior = null;
    $calificaciones_bajo_4 = 0;

    while ($fila = $resultado->fetch_assoc()) {
        $estudiante_rut = $fila['estudiante_rut'];
        $estudiante_nombre = $fila['estudiante_nombre'];
        $rutApoderado = $fila['rutApoderado'];
        $calificacion1 = $fila['calificacion1'];
        $calificacion2 = $fila['calificacion2'];

        if ($estudiante_rut != $estudiante_anterior) {
            $calificaciones_bajo_4 = 0;
            $estudiante_anterior = $estudiante_rut;
        }

        if ($calificacion1 < 4.0 || $calificacion2 < 4.0) {
            $calificaciones_bajo_4++;
            if ($calificaciones_bajo_4 >= 2 && !empty($rutApoderado)) {
                // Consulta para obtener el correo del apoderado
                $consulta_apoderado = "SELECT correo FROM apoderado WHERE rut = '$rutApoderado'";
                $resultado_apoderado = $conexion->query($consulta_apoderado);

                if ($resultado_apoderado->num_rows > 0) {
                    $fila_apoderado = $resultado_apoderado->fetch_assoc();
                    $correo_apoderado = $fila_apoderado['correo'];
                    
                    echo "Enviar correo al apoderado de $estudiante_nombre (RUT: $rutApoderado) al correo $correo_apoderado<br>";
                }
            }
        }
    }
} else {
    echo "No se encontraron calificaciones en la base de datos.";
}
// Cerrar la conexión a la base de datos
$conexion->close();
?>
