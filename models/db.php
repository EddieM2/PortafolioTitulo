<?php 

session_start();

$conexion = mysqli_connect(
    'localhost',
    'root',
    '',
    'probando2'
);

$conexion2 = mysqli_connect(
    'localhost',
    'root',
    '',
    'login_user'
);
?>