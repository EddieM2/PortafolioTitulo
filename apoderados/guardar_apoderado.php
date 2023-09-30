<?php
// Recoge los valores del formulario
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellidoP = $_POST['apellidoP'];
$apellidoM = $_POST['apellidoM'];
$correo = $_POST['correo'];
$idCargo = $_POST['idCargo'];
$direccion = $_POST['direccion'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$telefono = $_POST['telefono'];

// Conexión a la base de datos
$conn = mysqli_connect('localhost', 'root', '', 'probando2');

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Prepara la consulta SQL con los valores recogidos
$query = "INSERT INTO apoderado (rut, nombre, apellidoP, apellidoM, correo, idCargo, direccion, fechaNacimiento, telefono) 
          VALUES ('$rut', '$nombre', '$apellidoP', '$apellidoM', '$correo', $idCargo, '$direccion', '$fechaNacimiento', $telefono)";

// Ejecuta la consulta
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Apoderado agregado exitosamente.";
} else {
    echo "Error al agregar apoderado: " . mysqli_error($conn);
}

// Cierra la conexión
mysqli_close($conn);
?>