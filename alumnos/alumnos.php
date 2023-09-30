<!DOCTYPE html>
<html>
<head>
    <title>Lista de Alumnos</title>
</head>
<body>
    <h1>Lista de Alumnos</h1>
    
    <!-- Agregar botón "Agregar Alumno" aquí -->
    <a href="agregar_alumno.php">Agregar Alumno</a>
    
    <table border="1">
        <?php
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "123456", "probando2");

        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta SQL para obtener los datos de los alumnos
        $sql = "SELECT rut, correo, nombre, apellidoM, apellidoP, idCargo, fechaNacimiento, direccion, telefono, genero, estadoAcademico, rutApoderado FROM alumno";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            // Imprimir nombres de columnas
            echo "<tr>";
            echo "<th>RUT</th>";
            echo "<th>Correo</th>";
            echo "<th>Nombre</th>";
            echo "<th>Apellido Materno</th>";
            echo "<th>Apellido Paterno</th>";
            echo "<th>ID Cargo</th>";
            echo "<th>Fecha de Nacimiento</th>";
            echo "<th>Dirección</th>";
            echo "<th>Teléfono</th>";
            echo "<th>Género</th>";
            echo "<th>Estado Académico</th>";
            echo "<th>Rut apoderado</th>";
            echo "<th>Editar</th>"; // Agregamos una columna para el botón Editar
            echo "<th>Eliminar</th>"; // Agregamos una columna para el botón Eliminar
            echo "</tr>";

            // Imprimir datos
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["rut"] . "</td>";
                echo "<td>" . $row["correo"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["apellidoM"] . "</td>";
                echo "<td>" . $row["apellidoP"] . "</td>";
                echo "<td>" . $row["idCargo"] . "</td>";
                echo "<td>" . $row["fechaNacimiento"] . "</td>";
                echo "<td>" . $row["direccion"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>" . $row["genero"] . "</td>";
                echo "<td>" . $row["estadoAcademico"] . "</td>";
                echo "<td>" . $row["rutApoderado"] . "</td>";
                echo "<td><a href='editar_alumno.php?rut=" . $row["rut"] . "'>Editar</a></td>"; // Enlazar a la página de edición con el rut como parámetro
                echo "<td><a href='eliminar_alumno.php?rut=" . $row["rut"] . "'>Eliminar</a></td>"; // Enlazar a la página de eliminación con el rut como parámetro
                echo "</tr>";
            }
        } else {
            echo "No se encontraron alumnos.";
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
    </table>
</body>
</html>
