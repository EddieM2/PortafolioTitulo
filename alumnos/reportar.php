<?php include("../models/db.php") ?>
<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Denuncias</title>
</head>

<body>
    <h2>Formulario de Denuncias</h2>
    <form action="procesar_denuncia.php" method="POST">
        <label for="titulo">Título de la Denuncia:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descripcion">Descripción de la Denuncia:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

        <label for="tipo">Tipo de Incidente:</label>
        <select id="tipo" name="tipo" required>
            <option value="acoso">Acoso</option>
            <option value="discriminacion">Discriminación</option>
            <option value="fraude">Fraude</option>
            <option value="otro">Otro</option>
        </select>

        <button type="submit">Enviar Denuncia</button>
    </form>
</body>

</html>
