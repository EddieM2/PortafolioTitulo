<?php
include("../db.php");

// Validar y obtener los datos del formulario
$rut = $_POST["rut"];
$correo = $_POST["correo"];
$nombre = $_POST["nombre"];
$apellidoM = $_POST["apellidoM"];
$apellidoP = $_POST["apellidoP"];
$idCargo = $_POST["idCargo"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$genero = $_POST["genero"];
$estadoAcademico = $_POST["estadoAcademico"];
$apoderado = $_POST["apoderado"];
$idCurso = $_POST["idCurso"];

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si el alumno ya existe en la tabla alumno
$sqlVerificarAlumno = "SELECT * FROM alumno WHERE rut = '$rut'";
$resultVerificarAlumno = mysqli_query($conexion, $sqlVerificarAlumno);

// Verificar si el alumno ya está inscrito en el curso
$sqlVerificarInscripcion = "SELECT * FROM inscripcion WHERE idCurso = '$idCurso' AND rutAlumno = '$rut'";
$resultVerificarInscripcion = mysqli_query($conexion, $sqlVerificarInscripcion);

if (mysqli_num_rows($resultVerificarAlumno) == 0 && mysqli_num_rows($resultVerificarInscripcion) == 0) {
    // Si el alumno no existe y no está inscrito, realizar el INSERT del alumno
    $sqlInsertAlumno = "INSERT INTO alumno (rut, correo, nombre, apellidoM, apellidoP, idCargo, fechaNacimiento, direccion, telefono, genero, estadoAcademico, rutApoderado, idCurso) VALUES ('$rut', '$correo', '$nombre', '$apellidoM', '$apellidoP', '$idCargo', '$fechaNacimiento', '$direccion', '$telefono', '$genero', '$estadoAcademico', '$apoderado', '$idCurso')";

    try {
        if (mysqli_query($conexion, $sqlInsertAlumno)) {
            header("Location: vistaAlumnos.php");

            // Obtener el ID del último alumno insertado
            $idAlumno = mysqli_insert_id($conexion);

            // Realizar el INSERT de la inscripción
            $sqlInsertInscripcion = "INSERT INTO inscripcion (idCurso, rutAlumno) VALUES ('$idCurso', '$rut')";

            if (mysqli_query($conexion, $sqlInsertInscripcion)) {
                 header("Location: vistaAlumnos.php");

                // Redirigir a la página deseada
                header("Location: vistaAlumnos.php");
                exit();
            } else {
                echo "Error al agregar la inscripción: " . mysqli_error($conexion);
            }
        } else {
            echo "Error al agregar el alumno.";
        }
    } catch (mysqli_sql_exception $e) {
        
        header("Location: vistaAlumnos.php");
    }
} else {
    echo "El alumno ya existe en la base de datos o está inscrito en este curso
    .";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>


