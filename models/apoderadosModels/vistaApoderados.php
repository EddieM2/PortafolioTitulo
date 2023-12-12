<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Apoderados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css"> 
    <meta charset="UTF-8">
    <style>
        body { padding-top: 20px; }
        .container { overflow: auto; max-height: 80vh; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Lista de Apoderados</h1>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo Electrónico</th>
                            <th>Dirección</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                        <?php
                        if (!$conexion) {
                            die("Error de conexión: " . mysqli_connect_error());
                        }

                        // Consulta para obtener la lista de apoderados
                        $query = "SELECT * FROM apoderado";
                        $result = mysqli_query($conexion, $query);

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
                                echo "<a href='../../apoderados/formEditarApoderado.php?rut=" . $row['rut'] . "' class='btn btn-primary'>Editar</a>";
                                echo "<a href='eliminarApoderados.php?rut=" . $row['rut'] . "' class='btn btn-danger'>Eliminar</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No hay apoderados registrados.</td></tr>";
                        }

                        // Cerrar la conexión
                        mysqli_close($conexion);
                        ?>
                    </table>
                </div>
                <a class="btn btn-primary" href="../../apoderados/formAgregarApoderado.php">Agregar Apoderado</a>
            </div>
        </div>
    </div>
</body>
</html>
