<?php include("models/db.php") ?>
<!DOCTYPE html>
<html lang="es">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio Ohiggins</title>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="src/css/index.css">


    
    <?php include("includes/header.php") ?>

    
    <div class="main-container">
    <div class="container mt-5">
        <div class="content-container">
            <div class="school-image">
                <img src="src/img/ohigginsf1.jpg" alt="Imagen del colegio" class="img-fluid" />
            </div>
        </div>
        <div class="latest-news">
            <h2>Últimas Noticias</h2>
            <div class="news-card">
                <img src="src/img/SAE-2024.jpg" alt="Noticia 1" class="news-image">
                <div class="news-content">
                    <h3>Sistema de Admisión Escolar</h3>
                    <p>Instrucciones para postular al sistema de admisión escolar.</p>
                    <a href="src/pdf/informativo-SAE-2024.pdf" class="btn btn-primary">PDF</a>
                </div>
            </div>

            <div class="news-card">
                <img src="src/img/inicio-clases-2023.jpg" alt="Noticia 2" class="news-image">
                <div class="news-content">
                    <h3>Inicio año escolar 2023</h3>
                    <p>Informamos a nuestra comunidad educativa que este viernes 03 de marzo será el retorno a clases del año escolar 2023. Los horarios serán los siguientes:</p>
                    <ul>
                        <li>Pre-kínder: 14:00 a 17:00 hrs.</li>
                        <li>Kínder: 09:00 a 12:00 hrs.</li>
                        <li>1° y 2° básico: 14:00 a 17:00 hrs.</li>
                        <li>3° y 4° básico: 08:15 a 12:00 hrs.</li>
                        <li>5° a 8° básico: 08:15 a 13:00 hrs.</li>
                        <li>I a IV medio: 08:15 a 13:00 hrs.</li>
                    </ul>
                </div>
            </div>

            <div class="news-card">
                <img src="src/img/matriculas-2023.jpg" alt="Noticia 3" class="news-image">
                <div class="news-content">
                    <h5>Periodo de regularización de matrículas</h5>
                    <p>
                        Informamos a nuestra comunidad educativa que el periodo de regularización de matrículas comenzará a partir del día 03 de enero del 2023.
                    </p>
                    <p>Horario:</p>
                    <ul>
                        <li>Mañana: 09:30 a 12:00 hrs.</li>
                        <li>Tarde: 14:30 a 16:30 hrs.</li>
                    </ul>
                    <p>
                        El ingreso se registrará por orden de llegada y se realizará solamente en nuestras dependencias de Pardo 876.
                    </p>
                    <p>
                        De generarse vacantes, el colegio se comunicará con los apoderados de estudiantes seleccionados.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

        
<?php include("includes/footer.php") ?>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>


</html>
