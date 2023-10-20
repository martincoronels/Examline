<?php
include ("ConectarDB.php");
$idexamen = $_REQUEST["idexamen"];
$pregunta = $_REQUEST["preg"];
$modificacion = $_REQUEST["mod"];
$query = "UPDATE tabla_preguntas SET preg='$modificacion' WHERE idexamen='$idexamen' and preg='$pregunta'";
$result = mysqli_query($conex, $query);

//Actualizo la tabla de preguntas donde el id del examen y el contenido es igual al tomado
?>