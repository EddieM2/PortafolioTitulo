<?php include("models/db.php") ?>
<?php include("includes/headerlogin.php") ?>
<?php include("includes/personal.php");?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="src/css/nosotros.css">
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    
    <div class="container">
  <h3>Equipo Directivo</h3>
  <div class="team-card2">
    <?php
    $equipoDirectivo = $personas["Equipo Directivo"];
    foreach ($equipoDirectivo as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Área Administrativa</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Área Administrativa"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
  <div class="container">
  <h3>Asistentes de la Educación</h3>
  <div class="team-card2">
    <?php
    $equipoDirectivo = $personas["Asistentes de la Educación"];
    foreach ($equipoDirectivo as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>  
</div>
<div class="container">
  <h3>Educación Parvularia</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Educación Parvularia"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Asistentes de Educación Parvularia</h3>
  <div class="team-card2">
    <?php
    $areaAdministrativa = $personas["Asistentes de Educación Parvularia"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Profesoras de Primer Ciclo de Educación Básica</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Profesoras de Primer Ciclo de Educación Básica"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Asistentes de Aula de Educación Básica</h3>
  <div class="team-card2">
    <?php
    $areaAdministrativa = $personas["Asistentes de Aula de Educación Básica"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Departamento de Humanidades</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Departamento de Humanidades"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Departamento de Ciencias y Matemáticas</h3>
  <div class="team-card2">
    <?php
    $areaAdministrativa = $personas["Departamento de Ciencias y Matemáticas"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Departamento de Artes, Música y Educ. Física</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Departamento de Artes, Música y Educ. Física"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Centro de Recursos de Aprendizaje (Biblioteca)</h3>
  <div class="team-card2">
    <?php
    $areaAdministrativa = $personas["Centro de Recursos de Aprendizaje (Biblioteca)"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Departamento de Educación Diferencial</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Departamento de Educación Diferencial"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Departamento de Orientación</h3>
  <div class="team-card2">
    <?php
    $areaAdministrativa = $personas["Departamento de Orientación"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>
<div class="container">
  <h3>Inspectoría</h3>
  <div class="team-card">
    <?php
    $areaAdministrativa = $personas["Inspectoría"];
    foreach ($areaAdministrativa as $persona) {
    ?>
      <div class="person">
        <img src="<?php echo $persona['imagen']; ?>" alt="<?php echo $persona['nombre']; ?>">
        <h4><?php echo $persona['nombre']; ?></h4>
        <p><?php echo $persona['subtitulo']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</div>

    
    
    <button class="nosotros-accordion">Nuestra Historia</button>
    <div class="panel">
        <div class= panel-content>
            <p>
            El Colegio O’Higgins, fundado en el año 2001 como la Escuela Básica Particular Nº115, comenzó su trayectoria educativa con la aprobación del primer ciclo básico. En el año 2005, se trasladó a un nuevo local ubicado en Pardo 876, donde actualmente ofrece educación desde 1º hasta 8º básico en jornada escolar completa para el segundo ciclo.

            En 2006, obtuvimos el reconocimiento para impartir la educación pre-básica, y nació la escuela de párvulos O’Higgins, conocida como "Mi Pequeño O’Higgins". Inicialmente, funcionó en el antiguo local de Merced 996 y luego se trasladó definitivamente a Merced 983, donde opera en la actualidad.

            En 2010, dimos un paso importante al ampliar nuestra oferta educativa al nivel de enseñanza media. A partir de ese año, dejamos de utilizar la numeración y nos convertimos en el Colegio O’Higgins.

            Nos enorgullece ser un colegio particular subvencionado que se dedica a proporcionar una educación centrada en el aprendizaje de los niños, sin discriminación, basada en nuestro lema: "Todos los niños pueden aprender".

            Nuestra misión es formar individuos capaces de integrarse exitosamente en la sociedad desde el punto de vista afectivo e intelectual, enfatizando la disciplina, el respeto por las normas, el cuidado personal y del medio ambiente, y el amor a la familia y a los semejantes.
            </p>
        </div>   
    </div>
    
    <button class="nosotros-accordion">Misión y visión</button>
    <div class="panel">
        <div class= panel-content>
            <p>Misión

            Somos un colegio particular subvencionado dedicado a entregar una educación centrada en el aprendizaje de los niños, no discriminatoria sustentada en el lema “Todos los niños pueden aprender”.

            Formamos personas capaces de integrarse en la sociedad de manera exitosa desde el punto de vista afectivo e intelectual, con acento en la disciplina y el respeto de las normas, en el cuidado personal y del medio ambiente en el amor a la familia y a los semejantes.

            Visión

            Transformarnos en un colegio de preferencia para las familias de Melipilla, por nuestra capacidad para acoger a los niños y jóvenes en un ambiente de aprendizaje seguro, confiable justo y equitativo, y de extender estas experiencias de aprendizaje al entorno familiar.

            </p>
        </div>
    </div>
</div>
<script src="src/scripts/nosotros.js"></script>
<?php include("includes/footer.php") ?>


