<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Alumno</title>
</head>
<body>
    <h1>Agregar Alumno</h1>
    
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

    <!-- Formulario para agregar un nuevo alumno -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="rut">RUT:</label>
        <input type="text" name="rut" required><br><br>
        
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required><br><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        
        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" name="apellidoM" required><br><br>
        
        <label for="apellidoP">Apellido Paterno:</label>
        <input type="text" name="apellidoP" required><br><br>
        
        <label for="idCargo">ID Cargo:</label>
        <input type="text" name="idCargo" required><br><br>
        
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" required><br><br>
        
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br><br>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br><br>
        
        <label for="genero">Género:</label>
        <input type="text" name="genero" required><br><br>
        
        <label for="estadoAcademico">Estado Académico:</label>
        <input type="text" name="estadoAcademico" required><br><br>
        
        <input type="submit" value="Agregar Alumno">
    </form>
</body>
</html>
