<?php 

session_start();

$servername = "localhost";
$database = "cpr96079_login_user";
$username = "cpr96079_chrisq542";
$password = "Xiaomiredminote4x";
// Create connection
$conexion2 = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conexion2) {
    die("Connection failed: " . mysqli_connect_error());
}
//mysqli_close($conexion2);

?>
<?
$servername = "localhost";
$database = "cpr96079_probando2";
$username = "cpr96079_chrisq542";
$password = "Xiaomiredminote4x";
// Create connection
$conexion = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}
//mysqli_close($conexion);
?>