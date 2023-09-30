<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
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

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "123456", "probando2");

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para actualizar los datos del alumno
    $sql = "UPDATE alumno SET correo = '$correo', nombre = '$nombre', apellidoM = '$apellidoM', apellidoP = '$apellidoP', idCargo = '$idCargo', fechaNacimiento = '$fechaNacimiento', direccion = '$direccion', telefono = '$telefono', genero = '$genero', estadoAcademico = '$estadoAcademico' WHERE rut = '$rut'";

    if ($conexion->query($sql) === TRUE) {
        echo "Los cambios se han guardado correctamente.";
    } else {
        echo "Error al guardar los cambios: " . $conexion->error;
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
} else {
    echo "Acceso no válido.";
}
?>
