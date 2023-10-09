<?php include("../includes/header.php") ?>
<?php include("../models/db.php") ?>

<style>
        .container-form {
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

<div class="container-form">
        <h2>Salud Mental</h2>
        <form action=".insertApoderado.php" method="POST">
            <label for="">¿Te has sentido triste, ansioso o deprimido en las últimas semanas?</label>
            <input type="text" name="" required>

            <label for="nombre">¿Has tenido pensamientos de hacer daño a ti mismo/a o a otros?</label>
            <input type="text" name="nombre" required>

            <label for="apellidoM">¿Has experimentado cambios en tu apetito o patrones de sueño debido a preocupaciones o estrés?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoP">¿Has tenido dificultades para concentrarte en la escuela o en otras actividades?</label>
            <input type="text" name="apellidoP" required>

            <label for="apellidoM">¿Has sentido un aumento en la irritabilidad o en la preocupación?</label>
            <input type="text" name="apellidoM" required>

            <h2>Estres y Presión</h2>

            <label for="apellidoM">¿Sientes una presión excesiva por parte de la escuela, padres u otros para tener éxito académicamente?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has experimentado bullying o acoso en la escuela?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has tenido problemas para manejar el estrés?</label>
            <input type="text" name="apellidoM" required>

            <h2>Relaciones y apoyo social</h2>

            <label for="apellidoM">¿Te sientes apoyado/a por tus amigos y familiares?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has experimentado conflictos en tus relaciones personales?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Sientes que tienes alguien con quien hablar sobre tus preocupaciones?</label>
            <input type="text" name="apellidoM" required>

            <h2>Uso de sustancias</h2>

            <label for="apellidoM">¿Has consumido alcohol, tabaco, marihuana u otras drogas?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Con qué frecuencia consumes estas sustancias?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has sentido que necesitas estas sustancias para lidiar con el estrés o la ansiedad?</label>
            <input type="text" name="apellidoM" required>

            <h2>Autoestima y autoimagen</h2>

            <label for="apellidoM">¿Cómo te sientes contigo mismo/a?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Tienes una imagen positiva de ti mismo/a?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has experimentado problemas de autoestima o inseguridades?</label>
            <input type="text" name="apellidoM" required>

            <h2>Bienestar general</h2>

            <label for="apellidoM">¿Te sientes satisfecho/a con tu vida en general?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Tienes metas y aspiraciones para el futuro?</label>
            <input type="text" name="apellidoM" required>

            <h2>Acceso a recursos de apoyo</h2>

            <label for="apellidoM">¿Sabes a dónde acudir en caso de necesitar apoyo emocional o ayuda con problemas de salud mental?</label>
            <input type="text" name="apellidoM" required>

            <label for="apellidoM">¿Has utilizado servicios de salud mental o recursos de apoyo antes?</label>
            <input type="text" name="apellidoM" required>

            <button type="submit" value="">Enviar formulario</button>
        </form>
    </div>
<?php include('../includes/footer.php') ?>