<!DOCTYPE html>
<html>
<head>
    <title>Agregar Apoderado</title>
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="tel"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agregar Apoderado</h2>
        <form action="../models/apoderadosModels/insertApoderado.php" method="POST">
            <label for="rutApoderado">RUT:</label>
            <input type="text" name="rut" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="apellidoP">Apellido Paterno:</label>
            <input type="text" name="apellidoP" required>

            <label for="apellidoM">Apellido Materno:</label>
            <input type="text" name="apellidoM" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <label for="fechaNacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fechaNacimiento" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" required>

            <label for="idCargo">Cargo:</label>
            <input type="number" name="idCargo" required>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required>

            <button type="submit" value="insertApoderado">Guardar Apoderado</button>
        </form>
    </div>
</body>
</html>
