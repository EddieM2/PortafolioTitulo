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

// Consulta SQL para insertar un nuevo alumno
$sqlInsertAlumno = "INSERT INTO alumno (rut, correo, nombre, apellidoM, apellidoP, idCargo, fechaNacimiento, direccion, telefono, genero, estadoAcademico, rutApoderado, idCurso) VALUES ('$rut', '$correo', '$nombre', '$apellidoM', '$apellidoP', '$idCargo', '$fechaNacimiento', '$direccion', '$telefono', '$genero', '$estadoAcademico', '$apoderado', '$idCurso')";

// Realizar el INSERT del alumno
if (mysqli_query($conexion, $sqlInsertAlumno)) {
   echo "Alumno agregado con éxito.";

    // Obtener el ID del último alumno insertado
    $idAlumno = mysqli_insert_id($conexion);

    // Consulta SQL para insertar la inscripción
    $sqlInsertInscripcion = "INSERT INTO inscripcion (idCurso, rutAlumno) VALUES ('$idCurso', '$rut')";

    // Realizar el INSERT de la inscripción
    if (mysqli_query($conexion, $sqlInsertInscripcion)) {
        echo "Inscripción agregada con éxito.";
    } else {
        echo "Error al agregar la inscripción: " . mysqli_error($conexion);
    }
} else {
    echo "Error al agregar el alumno: " . mysqli_error($conexion);
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

