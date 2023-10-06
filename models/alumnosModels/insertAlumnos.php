<?php include("../db.php") ?>

<?php
    // Procesar el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        
        // Consulta SQL para insertar un nuevo alumno
        $sql = "INSERT INTO alumno (rut, correo, nombre, apellidoM, apellidoP, idCargo, fechaNacimiento, direccion, telefono, genero, estadoAcademico) VALUES ('$rut', '$correo', '$nombre', '$apellidoM', '$apellidoP', '$idCargo', '$fechaNacimiento', '$direccion', '$telefono', '$genero', '$estadoAcademico')";
        
        if (mysqli_query($conexion, $sql)) {
            echo "Alumno agregado con éxito.";
        } else {
            echo "Error al agregar el alumno: " . mysqli_error($conexion);
        }
        
        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
    }
    ?>