<?php
include ("ConectarDB.php");
$idexamen = $_REQUEST["idexamen"];
$correcta = $_REQUEST["correcta"];
$modificacion = $_REQUEST["opcion"];
$respAnterior = $_REQUEST["respAnterior"];

$query = "UPDATE tabla_respuestas SET resp='$modificacion', respCorr='$correcta' WHERE resp='$respAnterior'";
$result = mysqli_query($conex, $query);
//Actualizo la tabla de respuestas y coloco la nueva respuesta y si es correcta o no en el lugar de la anterior
?>


?>