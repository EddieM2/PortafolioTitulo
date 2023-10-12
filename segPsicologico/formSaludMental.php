
<?php include("../includes/header.php") ?>
<?php include("../models/db.php") ?>


<?php
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $alumno_rut = $_SESSION['rut'];
} else {
    // Maneja la falta de rut de la sesión como consideres necesario
}
?>
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

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #dddddd;
        border-radius: 5px;
    }

    .radio-label {
        display: inline-block;
        margin-right: 10px;
    }

    input[type="radio"] {
        margin-right: 5px;
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
    <form action="procesar_formulario_salud.php" method="POST">
    <input type="hidden" name="rut_alumno" value="<?php echo $alumno_rut; ?>">

        <label for="tristeza">¿Te has sentido triste, ansioso o deprimido recientemente?</label>
        <input type="radio" name="tristeza" value="si" required> Sí
        <input type="radio" name="tristeza" value="no"> No

        <label for="autolesiones">¿Has tenido pensamientos de autolesiones o dañar a otros?</label>
        <input type="radio" name="autolesiones" value="si" required> Sí
        <input type="radio" name="autolesiones" value="no"> No

        <label for="cambios-sueño">¿Has tenido cambios en tus patrones de sueño o apetito debido a preocupaciones o estrés?</label>
        <input type="radio" name="cambios-sueño" value="si" required> Sí
        <input type="radio" name="cambios-sueño" value="no"> No

        <label for="concentración">¿Has tenido dificultades para concentrarte en tus actividades?</label>
        <input type="radio" name="concentración" value="si" required> Sí
        <input type="radio" name="concentración" value="no"> No

        <label for="apoyo-amigos">¿Te sientes apoyado por tus amigos y familiares?</label>
        <input type="radio" name="apoyo-amigos" value="si" required> Sí
        <input type="radio" name="apoyo-amigos" value="no"> No

        <label for="conflictos">¿Has experimentado conflictos en tus relaciones personales?</label>
        <input type="radio" name="conflictos" value="si" required> Sí
        <input type="radio" name="conflictos" value="no"> No

        <label for="consumo-sustancias">¿Has consumido alcohol, tabaco, marihuana u otras drogas?</label>
        <input type="radio" name="consumo-sustancias" value="si" required> Sí
        <input type="radio" name="consumo-sustancias" value="no"> No

        <label for="autoestima">¿Cómo te sientes contigo mismo?</label>
        <input type="text" name="autoestima" required>

        <button type="submit" value="">Enviar formulario</button>
    </form>
</div>
<?php include('../includes/footer.php') ?>
