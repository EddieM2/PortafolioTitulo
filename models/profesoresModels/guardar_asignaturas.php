<?php
include("../db.php");

if (isset($_POST['guardar_asignaturas'])) {
     $nombresAsignatura = $_POST['asignatura_nombre'];
     $profesoresAsignatura = $_POST['asignatura_profesor'];
     $idsAsignatura = $_POST['asignatura_id'];
 
     for ($i = 0; $i < count($nombresAsignatura); $i++) {
         $nombre = mysqli_real_escape_string($conexion, $nombresAsignatura[$i]);
         $profesor = mysqli_real_escape_string($conexion, $profesoresAsignatura[$i]);
         $idAsignatura = mysqli_real_escape_string($conexion, $idsAsignatura[$i]);
 
         $query = "UPDATE asignatura SET nombre = '$nombre', rutProfesor = '$profesor' WHERE idAsignatura = $idAsignatura";
         $result = mysqli_query($conexion, $query);
 
         if (!$result) {
             echo "Error al actualizar las asignaturas.";
             exit;
         }
     }
 
     // Redirige de vuelta a la página de administración con un mensaje de éxito
     header("Location: administrarCursosAsignaturas.php?success=true");
     exit();
 }
 
?>