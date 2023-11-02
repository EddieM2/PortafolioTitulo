<!DOCTYPE html>
<html>
<head>
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css"> <!-- Agrega tu archivo de estilos CSS personalizado -->
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Agregar Alumno</h1>
                <form method="POST" action="../models/alumnosModels/insertAlumnos.php">
                    <label for="rut">RUT:</label>
                    <input type="text" name="rut" class="form-control" required>

                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" class="form-control" required>

                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>

                    <label for="apellidoM">Apellido Materno:</label>
                    <input type="text" name="apellidoM" class="form-control" required>

                    <label for="apellidoP">Apellido Paterno:</label>
                    <input type="text" name="apellidoP" class="form-control" required>

                    <label for="idCargo">ID Cargo:</label>
                    <input type="text" name="idCargo" class="form-control" required>

                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fechaNacimiento" class="form-control" required>

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" class="form-control" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control" required>

                    <label for="genero">Género:</label>
                    <input type="text" name="genero" class="form-control" required>

                    <label for="estadoAcademico">Estado Académico:</label>
                    <input type="text" name="estadoAcademico" class="form-control" required>

                    <button type="submit" class="btn btn-primary">Insertar Alumno</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
