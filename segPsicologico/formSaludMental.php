<?php include("../models/db.php"); ?>

<?php
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $alumno_rut = $_SESSION['rut'];
} else {

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario Salud Mental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <meta charset="utf-8">
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h2 class="card-title">Salud Mental</h2>
                <form action="procesar_formulario_salud.php" method="POST">
                    <input type="hidden" name="rut_alumno" value="<?php echo $alumno_rut; ?>">

                    <div class="form-group">
                        <div class="pregunta">
                            <label for="tristeza">¿Te has sentido triste, ansioso o deprimido recientemente?</label>
                        </div>
                        <div class="respuestas">
                            <input type="radio" name="tristeza" value="si" required> Sí
                            <input type="radio" name="tristeza" value="no"> No
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="pregunta">
                            <label for="autolesiones">¿Has tenido pensamientos de autolesiones o dañar a otros?</label>
                        </div>
                        <div class ="respuestas">
                            <input type="radio" name="autolesiones" value="si" required> Sí
                            <input type="radio" name="autolesiones" value="no"> No
                        </div>
                    </div>
                    <div class="form-group">
    <div class="pregunta">
        <label for="cambios-sueño">¿Has tenido cambios en tus patrones de sueño o apetito debido a preocupaciones o estrés?</label>
    </div>
    <div class="respuestas">
        <input type="radio" name="cambios-sueño" value="si" required> Sí
        <input type="radio" name="cambios-sueño" value="no"> No
    </div>
</div>

<div class="form-group">
    <div class="pregunta">
        <label for="concentración">¿Has tenido dificultades para concentrarte en tus actividades?</label>
    </div>
    <div class="respuestas">
        <input type="radio" name="concentración" value="si" required> Sí
        <input type="radio" name="concentración" value="no"> No
    </div>
</div>

<div class="form-group">
    <div class="pregunta">
        <label for="apoyo-amigos">¿Te sientes apoyado por tus amigos y familiares?</label>
    </div>
    <div class="respuestas">
        <input type="radio" name="apoyo-amigos" value="si" required> Sí
        <input type="radio" name="apoyo-amigos" value="no"> No
    </div>
</div>

<div class="form-group">
    <div class="pregunta">
        <label for="conflictos">¿Has experimentado conflictos en tus relaciones personales?</label>
    </div>
    <div class="respuestas">
        <input type="radio" name="conflictos" value="si" required> Sí
        <input type="radio" name="conflictos" value="no"> No
    </div>
</div>

<div class="form-group">
    <div class="pregunta">
        <label for="consumo-sustancias">¿Has consumido alcohol, tabaco, marihuana u otras drogas?</label>
    </div>
<div class="form-group">
    <div class="pregunta">
        <label for="autoestima">¿Cómo te sientes contigo mismo?</label>
        
    </div>
    <input type="text" name="autoestima" required>
</div>

<div class="form-group">
    <div class="pregunta">
        <label for="explicacion">Explica tu situación</label>
    </div>
    <div class="respuestas">
        <input type="text" name="explicacion" required>
    </div>
</div>


                    

                    <button type="submit" class="btn btn-primary">Enviar formulario</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>




