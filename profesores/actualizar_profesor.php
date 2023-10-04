<?php include("../models/db.php") ?>

<?php

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verifica si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se han proporcionado los datos necesarios del formulario
    if (isset($_POST['rut'], $_POST['nombre'], $_POST['apellidoP'], $_POST['apellidoM'], $_POST['correo'], $_POST['fechaNacimiento'], $_POST['telefono'], $_POST['genero'])) {
        // Recupera los datos del formulario
        $rut = $_POST['rut'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $correo = $_POST['correo'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $telefono = $_POST['telefono'];
        $genero = $_POST['genero'];

        // Realiza una consulta SQL para actualizar los datos del profesor en la base de datos
        $query = "UPDATE profesor
                  SET nombre = '$nombre', apellidoP = '$apellidoP', apellidoM = '$apellidoM', correo = '$correo', fechaNacimiento = '$fechaNacimiento', telefono = '$telefono', genero = '$genero'
                  WHERE rut = '$rut'";

        // Ejecuta la consulta
        $result = mysqli_query($conexion, $query);

        if ($result) {
            echo "Los datos del profesor se actualizaron correctamente.";
        } else {
            echo "Error al actualizar los datos del profesor: " . mysqli_error($conexion);
        }

        // Redirige al usuario a la página de inicioProf
        header("Location: inicioProf.php");
        exit();
    } else {
        echo "Faltan datos del formulario.";
    }
} else {
    echo "No se ha enviado una solicitud POST.";
}

// Cierre de la conexión
mysqli_close($conexion);
?>
