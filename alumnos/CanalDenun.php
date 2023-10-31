<?php include("../models/db.php") ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">

<?php include("../includes/header.php") ?>
<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canal de Denuncias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Canal de Denuncias</h1>
  
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="reportar.php">Reportar una Denuncia</a></li>
            <li><a href="mis_denuncias.php">Mis Denuncias</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
    <main>
        <h2>Bienvenido al Canal de Denuncias</h2>
        <p>
            En este canal, puedes reportar cualquier preocupación o incidente que necesite atención. Garantizamos la confidencialidad y la protección de tu identidad. Tu seguridad es nuestra prioridad.
        </p>
        <p>
            Por favor, utiliza este canal de manera responsable y honesta. Juntos, podemos mantener un entorno seguro y respetuoso.
        </p>
    </main>
    <footer>
    <?php include('../includes/footer.php') ?>
    </footer>
</body>
</html>
