<!DOCTYPE html>
<html>
<head>
    <title>Agregar Alumno</title>
</head>
<body>
    <h1>Agregar Alumno</h1>

    <!-- Formulario para agregar un nuevo alumno -->
    <form method="POST" action="../models/alumnosModels/insertAlumnos.php">
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
        
        <input type="submit" value="InsertAlumno">
    </form>
</body>
</html>
