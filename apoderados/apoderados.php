<!DOCTYPE html>
<html>
<head>
    <title>Lista de Apoderados</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .add-button {
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        .action-button {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
        }

        .action-button.delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Lista de Apoderados</h1>
    <table>
        <tr>
            <th>RUT</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo Electrónico</th>
            <th>direccion</th>
            <th>Fecha de Nacimiento</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $conn = mysqli_connect('localhost', 'root', '123456', 'probando2');

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta para obtener la lista de apoderados
        $query = "SELECT * FROM apoderado";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['rut'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellidoP'] . "</td>";
                echo "<td>" . $row['apellidoM'] . "</td>";
                echo "<td>" . $row['correo'] . "</td>";
                echo "<td>" . $row['fechaNacimiento'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>" . $row['direccion'] . "</td>";
                echo "<td>";
                echo "<a href='editar_apoderado.php?rut=" . $row['rut'] . "' class='action-button'>Editar</a>";
                echo "<a href='eliminar_apoderado.php?rut=" . $row['rut'] . "' class='action-button delete'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay apoderados registrados.</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conn);
        ?>
    </table>

    <a class="add-button" href="agregar_apoderado.php">Agregar Apoderado</a>
</body>
</html>
