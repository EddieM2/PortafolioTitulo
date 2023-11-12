<?php 

session_start();

$conexion = mysqli_connect(
    'localhost',
    'root',
    '',
    'probando3'
);

$conexion2 = mysqli_connect(
    'localhost',
    'root',
    '',
    'login_user'
);
?>