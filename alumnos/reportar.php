<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Denuncias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Formulario de Denuncias</h2>
                <form action="procesar_denuncia.php" method="POST">
                    <div class="form-group">
                        <label for="titulo">Título de la Denuncia:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción de la Denuncia:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo de Incidente:</label>
                        <select id="tipo" name="tipo" class="form-select" required>
                            <option value="acoso">Acoso</option>
                            <option value="discriminacion">Discriminación</option>
                            <option value="fraude">Fraude</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Denuncia</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
