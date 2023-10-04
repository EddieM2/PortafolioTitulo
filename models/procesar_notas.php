<?php include("db.php") ?>

<?php

session_start(); // Asegúrate de iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se ha proporcionado el parámetro 'asignatura_id' en el formulario
    if (isset($_POST['asignatura_id'])) {
        $asignatura_id = $_POST['asignatura_id'];

        // Obtiene el RUT del profesor de la sesión (asumiendo que está almacenado en la sesión)
        $profesor_rut = $_SESSION['rut'];

        // Obtiene las calificaciones desde el formulario
        $calificaciones = $_POST['calificaciones'];

        // Itera a través de las calificaciones y las guarda en la base de datos
// ...

foreach ($calificaciones as $rut_alumno => $calificacion) {
    // Realiza una consulta SQL para insertar la calificación en la tabla "calificaciones"
    // Asegúrate de sanitizar y validar los datos antes de ejecutar la consulta en un entorno de producción
    $query_insertar_calificacion = "INSERT INTO calificaciones (idAlumno, idProfesor, idAsignatura, valor, fecha, idInscripcion) 
                                    VALUES ('$rut_alumno', '$profesor_rut', '$asignatura_id', '$calificacion', NOW(), 1)";

    // Ejecuta la consulta
    $result_insertar_calificacion = mysqli_query($conn, $query_insertar_calificacion);

    // Verifica si la consulta se ejecutó con éxito
    if (!$result_insertar_calificacion) {
        echo "Error al insertar la calificación para el alumno con RUT $rut_alumno.";
    }
}

// ...


        // Redirige de vuelta a la página de ingreso de notas con un mensaje de éxito
        header("Location: ingresar_notas.php?asignatura_id=$asignatura_id&success=true");
        exit();
    } else {
        // Falta el parámetro 'asignatura_id'
        echo "Falta el parámetro 'asignatura_id'.";
    }
} else {
    // Redirige si no se recibió una solicitud POST
    header("Location: ingresar_nots.php");
    exit();
}
?>
