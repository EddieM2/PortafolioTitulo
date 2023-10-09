<?php include("db.php") ?>

<?php

session_start(); // Asegúrate de iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se ha proporcionado el parámetro 'asignatura_id' en el formulario
    if (isset($_POST['asignatura_id'])) {
        $asignatura_id = $_POST['asignatura_id'];

        // Obtiene el RUT del profesor de la sesión (asumiendo que está almacenado en la sesión)
        $profesor_rut = $_SESSION['rut'];

// Obtén el arreglo de calificaciones desde el formulario
// Obtén el arreglo de calificaciones desde el formulario
// Obtén el arreglo de calificaciones desde el formulario
$calificaciones = $_POST['calificaciones'];

// Itera a través de las calificaciones y guárdalas en la base de datos
foreach ($calificaciones as $rut_alumno => $notas) {
    $nota1 = isset($notas['nota1']) ? $notas['nota1'] : 0.0;
    $nota2 = isset($notas['nota2']) ? $notas['nota2'] : 0.0;
    $nota3 = isset($notas['nota3']) ? $notas['nota3'] : 0.0;
    $nota4 = isset($notas['nota4']) ? $notas['nota4'] : 0.0;

    // Realiza una consulta SQL para insertar las cuatro notas en la tabla "calificaciones"
    // Asegúrate de sanitizar y validar los datos antes de ejecutar la consulta en un entorno de producción
    $query_insertar_calificaciones = "INSERT INTO calificaciones (idAlumno, idProfesor, idAsignatura, nota1, nota2, nota3, nota4, fecha, idInscripcion) 
                                    VALUES ('$rut_alumno', '$profesor_rut', '$asignatura_id', '$nota1', '$nota2', '$nota3', '$nota4', NOW(), 1)";

    // Ejecuta la consulta
    $result_insertar_calificaciones = mysqli_query($conn, $query_insertar_calificaciones);

    // Verifica si la consulta se ejecutó con éxito
    if (!$result_insertar_calificaciones) {
        echo "Error al insertar las calificaciones para el alumno con RUT $rut_alumno.";
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
